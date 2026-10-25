const {test}=require('node:test');const assert=require('node:assert/strict');const {EventEmitter}=require('node:events');const {UpdateController}=require('../src/updates.cjs');
test('Update checks, Windows notifications, download and explicit restart',async()=>{
 const u=new EventEmitter();let state='none',installed=0,checks=0;const notices=[],dialogs=[],choices=[];
 u.checkForUpdates=async()=>{checks++;if(state==='error')throw Error('network');if(state==='new')u.emit('update-available',{version:'1.1.0'});return {};};u.downloadUpdate=async()=>{u.emit('update-downloaded');};u.quitAndInstall=()=>installed++;
 class Notification extends EventEmitter{static isSupported(){return true;}constructor(options){super();notices.push(this);this.options=options;}show(){this.shown=true;}}
 const c=new UpdateController({enabled:true,updater:u,app:{getVersion:()=> '1.0.0'},getWindow:()=>null,Notification,dialog:{showMessageBox:async options=>{dialogs.push(options);return {response:choices.shift()??1};}}});
 assert.equal(u.autoDownload,false);assert.equal(u.autoInstallOnAppQuit,false);await c.check(true);assert.match(dialogs.at(-1).message,/up to date/);
 state='error';await c.check(true);assert.match(dialogs.at(-1).message,/Could not check/);
 state='new';await c.check(false);assert.equal(notices.length,1);assert.match(notices[0].options.body,/1.1.0/);assert.equal(installed,0);
 choices.push(0,1);await c.check(true);assert.equal(c.downloaded,true);assert.equal(notices.length,2);assert.equal(installed,0);
 choices.push(0);await c.offer();assert.equal(installed,1);assert.equal(checks,3);c.stop();
});
