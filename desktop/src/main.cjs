'use strict';
const {app,BrowserWindow,Menu,dialog,shell,session,ipcMain,safeStorage}=require('electron');
const path=require('node:path');
const fs=require('node:fs/promises');
const {pathToFileURL}=require('node:url');
const {createClient}=require('@supabase/supabase-js');
const config=require('./config.cjs');
const policy=require('./policy.cjs');
const {Vault}=require('./vault.cjs');
const {UpdateController}=require('./updates.cjs');
const {BrowserAuth,browserCallback}=require('./browser-auth.cjs');
let updates,desktopMenu;
const test=!app.isPackaged&&process.env.NODE_ENV==='test'&&process.env.INVOQLY_E2E==='1';
const origin=test?new URL(process.env.INVOQLY_TEST_ORIGIN).origin:config.origin;
const supabaseUrl=test?origin:config.supabaseUrl;
const offlineFile=path.join(__dirname,'offline.html'),offlineURL=pathToFileURL(offlineFile).href;
if(test&&process.env.INVOQLY_TEST_PROFILE)app.setPath('userData',path.resolve(process.env.INVOQLY_TEST_PROFILE));
app.setName('Invoqly');if(process.platform==='win32')app.setAppUserModelId(config.appId);
const gotLock=app.requestSingleInstanceLock();
if(!gotLock)app.quit();
let win,vault,lastRaw,restoreRaw,injecting=false,snapshotBusy=false,snapshotTask=Promise.resolve(),closing=false,googleAttempt=null,googleClient=null,lastPage=origin+'/dashboard',timer;
const browserAuth=new BrowserAuth({origin});let signInLink='';
const testEvents={external:[],downloads:[],prints:0,errors:[],callbackAccepted:0};
const isApp=url=>policy.trusted(url,origin);
const validSender=e=>win&&!win.isDestroyed()&&e.sender===win.webContents&&e.senderFrame===win.webContents.mainFrame&&isApp(e.senderFrame.url);
function notify(message){if(test){testEvents.errors.push(message);return;}dialog.showMessageBox(win,{type:'info',title:'Invoqly',message}).catch(()=>{});}
async function openExternal(url){if(test&&policy.trusted(url,origin)&&['/auth/v1/authorize','/desktop-signin'].includes(new URL(url).pathname)){testEvents.external.push(url);return true;}if(!policy.external(url))return false;if(test){testEvents.external.push(url);return true;}await shell.openExternal(url);return true;}
function showSignInLink(url){signInLink=url;win.webContents.send('invoqly:signin-link',url);}
async function startBrowser(){googleAttempt=null;googleClient=null;const url=browserAuth.begin();showSignInLink(url);try{await openExternal(url);}catch{notify('The browser did not open. Copy the sign-in link shown in Invoqly and paste it into your browser.');}}
async function captureSession(){
 if(snapshotBusy){await snapshotTask;return captureSession();}
 if(!win||win.isDestroyed()||!isApp(win.webContents.getURL())||injecting||restoreRaw)return;
 snapshotBusy=true;
 snapshotTask=(async()=>{try{const raw=await win.webContents.executeJavaScript(`location.origin===${JSON.stringify(origin)}?localStorage.getItem(${JSON.stringify(config.storageKey)}):null`);
 if(raw!==null&&!policy.sessionValue(raw))return;
 if(raw!==lastRaw){await vault.write(raw);lastRaw=raw;}
 }catch{}finally{snapshotBusy=false;}})();
 await snapshotTask;
}

async function importSession(){
 if(!restoreRaw||injecting||!isApp(win.webContents.getURL()))return false;
 const value=policy.sessionValue(restoreRaw);if(!value){restoreRaw=null;return false;}
 injecting=true;
 try{
  // No tokens in URLs, command-line arguments, IPC, or logs. The web client
  // receives only its own Supabase session, using the normal setSession API.
  const payload={access_token:value.access_token,refresh_token:value.refresh_token};
  const result=await win.webContents.executeJavaScript(`(async()=>{if(location.origin!==${JSON.stringify(origin)}||!window.supabase||!window.INVOQLY_CONFIG)return 'not-ready';const c=window.supabase.createClient(window.INVOQLY_CONFIG.supabaseUrl,window.INVOQLY_CONFIG.supabasePublishableKey);const r=await c.auth.setSession(${JSON.stringify(payload)});if(r.error)return 'invalid';const l=await c.auth.mfa.getAuthenticatorAssuranceLevel();if(l.error)return 'invalid';if(l.data.nextLevel==='aal2'&&l.data.currentLevel!=='aal2'){sessionStorage.setItem('invoqly.desktop.mfa','1');return 'mfa';}return 'ok';})()`);
  if(result==='not-ready'){if(!/\/login(?:\.html|\.php)?$/.test(new URL(win.webContents.getURL()).pathname))await win.loadURL(origin+'/login');return false;}
  restoreRaw=null;
  if(!['ok','mfa'].includes(result)){await vault.write(null);lastRaw=null;notify('Your saved sign-in has expired. Please sign in again.');return false;}
  await captureSessionAfterImport();
  // The existing dashboard enforces its own session/MFA checks; an AAL1 OAuth
  // session needing a second factor is routed to the existing authenticator UI.
  await win.loadURL(origin+(result==='mfa'?'/login':'/dashboard'));return true;
 }catch{restoreRaw=null;notify('Could not restore your sign-in. Please sign in again.');return false;}finally{injecting=false;}
}
async function captureSessionAfterImport(){const raw=await win.webContents.executeJavaScript(`localStorage.getItem(${JSON.stringify(config.storageKey)})`);if(policy.sessionValue(raw)){await vault.write(raw);lastRaw=raw;}}
async function showOffline(){if(!win||win.isDestroyed()||win.webContents.getURL()===offlineURL)return;await captureSession();await win.loadFile(offlineFile).catch(()=>{});}
async function retry(){if(!win||win.isDestroyed())return;await win.loadURL(lastPage).catch(()=>{});}
async function startGoogle(){
 if(googleAttempt&&Date.now()-googleAttempt.started<300000){notify('Google sign-in is already open in your browser. Complete it there, or try again in five minutes.');return;}
 const memory=new Map();
 browserAuth.pending=null;
 googleClient=createClient(supabaseUrl,config.publishableKey,{auth:{flowType:'pkce',autoRefreshToken:false,persistSession:true,detectSessionInUrl:false,storage:{getItem:k=>memory.get(k)??null,setItem:(k,v)=>memory.set(k,v),removeItem:k=>memory.delete(k)}}});
 try{const r=await googleClient.auth.signInWithOAuth({provider:'google',options:{redirectTo:config.callback,skipBrowserRedirect:true}});if(r.error||!r.data?.url)throw Error('oauth');
  const u=new URL(r.data.url);if(u.origin!==new URL(supabaseUrl).origin||u.pathname!=='/auth/v1/authorize'||u.searchParams.get('provider')!=='google')throw Error('oauth');
  googleAttempt={started:Date.now(),memory};showSignInLink(u.href);await openExternal(u.href).catch(()=>notify('Copy the Google sign-in link shown in Invoqly and paste it into your browser.'));
 }catch{googleAttempt=null;notify('Could not open Google sign-in. Check your connection and try again.');}
}
async function handleCallback(url){
 if(browserCallback(url)){try{const handoff=await browserAuth.exchange(url);if(!handoff)return false;const client=createClient(supabaseUrl,config.publishableKey,{auth:{persistSession:false,autoRefreshToken:false,detectSessionInUrl:false}});const r=await client.auth.verifyOtp({token_hash:handoff.token_hash,type:'magiclink'});if(r.error||!r.data.session||r.data.session.user.id!==handoff.user_id)throw Error('identity');restoreRaw=JSON.stringify(r.data.session);await vault.write(restoreRaw);lastRaw=restoreRaw;testEvents.callbackAccepted++;if(win.isMinimized())win.restore();win.focus();await win.loadURL(origin+'/login');return true;}catch{notify('Browser sign-in expired or could not be completed. Start again in Invoqly.');return false;}}
 const code=policy.callbackCode(url);if(!code||!googleAttempt||Date.now()-googleAttempt.started>300000)return false;
 const client=googleClient;googleAttempt=null;googleClient=null;
 try{const r=await client.auth.exchangeCodeForSession(code);if(r.error||!r.data.session)throw Error('exchange');restoreRaw=JSON.stringify(r.data.session);await vault.write(restoreRaw);lastRaw=restoreRaw;testEvents.callbackAccepted++;if(win.isMinimized())win.restore();win.focus();await win.loadURL(origin+'/login');return true;
 }catch{notify('Google sign-in could not be completed. Open sign-in again from Invoqly.');return false;}
}
async function savePDF(){
 if(!win||!isApp(win.webContents.getURL()))return false;
 const info=await win.webContents.executeJavaScript(`({hasInvoice:!!document.querySelector('.invoice-paper'),number:document.querySelector('.invoice-paper .invoice-top>div:last-child h2')?.textContent||'Invoqly-invoice'})`);
 if(!info.hasInvoice){notify('Open an invoice first, then choose Save invoice as PDF.');return false;}
 const target=test?{canceled:false,filePath:path.join(process.env.INVOQLY_TEST_OUTPUT,'invoice.pdf')}:await dialog.showSaveDialog(win,{title:'Save invoice as PDF',defaultPath:path.join(app.getPath('downloads'),policy.filename(info.number)+'.pdf'),filters:[{name:'PDF document',extensions:['pdf']}]});
 if(target.canceled||!target.filePath)return false;
 const pdf=await win.webContents.printToPDF({printBackground:true,preferCSSPageSize:true,pageSize:'A4'});await fs.writeFile(target.filePath,pdf);return true;
}
function print(){if(win&&isApp(win.webContents.getURL())){testEvents.prints++;win.webContents.print({silent:false,printBackground:true},success=>{if(!success&&!test)notify('Printing was canceled or the printer was unavailable.');});}}
function setupMenu(){
 Menu.setApplicationMenu(null);
 desktopMenu=Menu.buildFromTemplate([
 {label:'Open workspace',click:()=>win.loadURL(origin+'/dashboard').catch(()=>{})},
 {label:'Reload',click:retry},
 {label:'Check for updates…',click:()=>updates.check(true)},
 {type:'separator'},
 {label:'Print…',click:print},
 {label:'Save invoice as PDF…',click:()=>savePDF().catch(()=>notify('Could not save the PDF. Try again.'))},
 {type:'separator'},
 {label:'Contact support',click:()=>openExternal('mailto:hello@invoqly.top')},
 {label:'About Invoqly',click:()=>notify('Invoqly '+app.getVersion())},
 {role:'quit'}]);
 win.removeMenu();
}
async function createWindow(){
 Menu.setApplicationMenu(null);
 const ses=session.fromPartition('invoqly-memory',{cache:false});
 ses.setPermissionRequestHandler((wc,permission,callback,details)=>callback(wc===win?.webContents&&isApp(details.requestingUrl)&&permission==='clipboard-sanitized-write'));
 ses.setPermissionCheckHandler((wc,permission,requestingOrigin)=>wc===win?.webContents&&isApp(requestingOrigin)&&permission==='clipboard-sanitized-write');
 ses.on('will-download',(event,item,wc)=>{
  if(wc!==win?.webContents||!isApp(wc.getURL())){event.preventDefault();return;}
  const u=item.getURL();if(!(u.startsWith('blob:'+origin+'/')||isApp(u)||policy.trusted(u,supabaseUrl))){event.preventDefault();return;}
  const name=policy.filename(item.getFilename());
  if(/\.(exe|msi|bat|cmd|ps1|vbs|js|com|scr|lnk|dll|hta)$/i.test(name)){event.preventDefault();return;}
  if(test)item.setSavePath(path.join(process.env.INVOQLY_TEST_OUTPUT,name));else item.setSaveDialogOptions({title:'Save Invoqly download',defaultPath:path.join(app.getPath('downloads'),name)});
  item.on('done',(_e,state)=>{if(test)testEvents.downloads.push({name,state});else if(state==='interrupted')notify('The download was interrupted. Check your connection and try again.');});
 });
 win=new BrowserWindow({title:'Invoqly',width:1400,height:920,minWidth:760,minHeight:600,backgroundColor:'#f5f5ee',icon:path.join(__dirname,process.platform==='win32'?'../assets/invoqly.ico':'../assets/invoqly.png'),show:!test,webPreferences:{session:ses,preload:path.join(__dirname,'preload.cjs'),nodeIntegration:false,nodeIntegrationInWorker:false,nodeIntegrationInSubFrames:false,contextIsolation:true,sandbox:true,webSecurity:true,allowRunningInsecureContent:false,webviewTag:false,spellcheck:false,devTools:!app.isPackaged}});
 win.webContents.on('will-attach-webview',e=>e.preventDefault());
 const navigation=(event,url)=>{if(isApp(url)&&/^\/download(?:\/|$|\.exe)/.test(new URL(url).pathname)){event.preventDefault();openExternal(url).catch(()=>{});return;}if(isApp(url)||url===offlineURL)return;event.preventDefault();if(policy.callbackCode(url)||browserCallback(url))handleCallback(url);else openExternal(url).catch(()=>{});};
 win.webContents.on('will-navigate',navigation);win.webContents.on('will-redirect',navigation);
 win.webContents.setWindowOpenHandler(({url})=>{if(isApp(url))win.loadURL(url).catch(()=>{});else openExternal(url).catch(()=>{});return {action:'deny'};});
 win.webContents.on('did-fail-load',(_e,code,_description,url,main)=>{if(main&&code!==-3&&isApp(url))showOffline();});
 win.webContents.on('render-process-gone',()=>showOffline());
 win.webContents.on('did-navigate',(_e,url)=>{if(isApp(url))lastPage=url;});
 win.webContents.on('dom-ready',async()=>{if(isApp(win.webContents.getURL())||win.webContents.getURL()===offlineURL){const css=await fs.readFile(path.join(__dirname,'desktop.css'),'utf8');win.webContents.insertCSS(css).catch(()=>{});}});
 win.webContents.on('did-finish-load',()=>{if(restoreRaw)importSession();else captureSession();});
 win.on('close',e=>{if(closing)return;e.preventDefault();closing=true;captureSession().catch(()=>{}).then(()=>vault.queue.catch(()=>{})).finally(()=>{if(!win.isDestroyed())win.close();}).catch(()=>{});});
 win.webContents.on('will-prevent-unload',event=>{const response=dialog.showMessageBoxSync(win,{type:'question',title:'Unsaved invoice changes',message:'Keep editing your invoice?',detail:'Leaving now may discard changes that have not been saved.',buttons:['Keep editing','Leave without saving'],defaultId:0,cancelId:0});if(response===1)event.preventDefault();else closing=false;});
 updates=new UpdateController({app,dialog,Notification:require('electron').Notification,getWindow:()=>win,enabled:app.isPackaged});
 setupMenu();win.webContents.on('before-input-event',(event,input)=>{if(input.type!=='keyDown'||!(input.control||input.meta))return;const key=input.key.toLowerCase();if(key==='p'){event.preventDefault();print();}else if(key==='s'&&input.shift){event.preventDefault();savePDF().catch(()=>notify('Could not save the PDF. Try again.'));}else if(key==='r'){event.preventDefault();retry();}});updates.start();timer=setInterval(captureSession,2000);timer.unref();
 await win.loadURL(origin+'/login').catch(()=>{});
}
app.on('open-url',(event,url)=>{event.preventDefault();handleCallback(url);});
app.on('second-instance',(_event,argv)=>{if(win){if(win.isMinimized())win.restore();win.focus();}const url=argv.find(a=>a.startsWith('invoqly://'));if(url)handleCallback(url);});
ipcMain.on('invoqly:action',(e,action)=>{if(['menu','reload','updates'].includes(action)&&e.sender===win?.webContents&&e.senderFrame===win.webContents.mainFrame&&(isApp(e.senderFrame.url)||e.senderFrame.url===offlineURL)){if(action==='menu')desktopMenu.popup({window:win});else if(action==='reload')retry();else updates.check(true);return;}if(!validSender(e))return;if(action==='workspace')win.loadURL(origin+'/dashboard').catch(()=>{});else if(action==='reload')retry();else if(action==='updates')updates.check(true);});
ipcMain.on('invoqly:google',e=>{if(validSender(e))startGoogle();});
ipcMain.on('invoqly:browser',e=>{if(validSender(e))startBrowser();});
ipcMain.on('invoqly:open-signin',e=>{if(validSender(e)&&signInLink)openExternal(signInLink).catch(()=>notify('Copy the sign-in link and paste it into your browser.'));});
ipcMain.on('invoqly:offline',e=>{if(validSender(e))showOffline();});
ipcMain.on('invoqly:online',e=>{if(validSender(e)||e.sender===win?.webContents&&e.senderFrame===win.webContents.mainFrame&&e.senderFrame.url===offlineURL)retry();});
ipcMain.on('invoqly:retry',e=>{if(e.sender===win?.webContents&&e.senderFrame===win.webContents.mainFrame&&e.senderFrame.url===offlineURL)retry();});
app.on('window-all-closed',()=>{clearInterval(timer);updates?.stop();app.quit();});
if(gotLock)app.whenReady().then(async()=>{
 if(app.isPackaged)app.setAsDefaultProtocolClient('invoqly');
 vault=new Vault(path.join(app.getPath('userData'),process.platform==='win32'?'session.dpapi':'session.secure'),safeStorage);restoreRaw=await vault.read();lastRaw=restoreRaw;
 if(test)globalThis.__invoqlyTest={events:testEvents,origin,config,updates,getMenu:()=>desktopMenu,getUpdater:()=>require('electron-updater').autoUpdater,captureSession,handleCallback,savePDF,startGoogle,startBrowser,retry,showOffline,getWindow:()=>win,getVault:()=>vault};
 await createWindow();
 if(process.platform==='linux'&&!test&&!await vault.available().catch(()=>false))notify('Your system keyring is unavailable. You can sign in and work, but this session will not be remembered after you close Invoqly. Enable GNOME Keyring or KWallet to remember your sign-in securely.');
}).catch(()=>{dialog.showErrorBox('Invoqly could not start','Please restart Invoqly. If this continues, contact hello@invoqly.top.');app.quit();});
