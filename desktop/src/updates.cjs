'use strict';
class UpdateController {
 constructor({app,dialog,Notification,getWindow,enabled,updater}) {
  Object.assign(this,{app,dialog,Notification,getWindow,enabled});
  this.updater=updater||(enabled?require('electron-updater').autoUpdater:null);
  this.busy=false;this.manual=false;this.available=null;this.downloaded=false;
  if(!this.updater)return;
  const u=this.updater;u.autoDownload=false;u.autoInstallOnAppQuit=false;u.allowDowngrade=false;u.disableDifferentialDownload=true;u.logger=null;
  u.on('update-available',info=>{this.available=info;this.toast(info.version);});
  u.on('update-downloaded',()=>{this.downloaded=true;this.toast(this.available?.version,true);});
  u.on('error',()=>{}); // check/download promises report failures without leaking URLs or filesystem paths.
 }
 async message(options){const w=this.getWindow();return w&&!w.isDestroyed()?this.dialog.showMessageBox(w,options):this.dialog.showMessageBox(options);}
 toast(version,ready=false){
  if(!this.Notification.isSupported())return;
  const n=new this.Notification({title:ready?'Invoqly update ready':'New Invoqly update',body:ready?'Restart when you are ready to install.':`Version ${version} is available. Click to review the update.`,icon:require('node:path').join(__dirname,'../assets/invoqly.png')});
  n.on('click',()=>{const w=this.getWindow();if(w){w.restore();w.focus();}this.offer().catch(()=>{});});n.show();this.notification=n;
 }
 async offer(){
  if(this.downloading)return this.message({type:'info',title:'Invoqly updates',message:'Your update is downloading. You can keep working.'});
  if(this.downloaded){const r=await this.message({type:'info',title:'Invoqly update ready',message:'Save your work before restarting.',buttons:['Restart and install','Later'],defaultId:1,cancelId:1});if(r.response===0)this.updater.quitAndInstall(false,true);return;}
  if(!this.available)return;
  const r=await this.message({type:'info',title:'Invoqly updates',message:`Invoqly ${this.available.version} is available.`,detail:'Download the update now, then restart when you are ready.',buttons:['Download update','Later'],defaultId:1,cancelId:1});
  if(r.response!==0)return;this.downloading=true;
  try{await this.updater.downloadUpdate();await this.offerReady();}catch{await this.message({type:'warning',title:'Invoqly updates',message:'The update could not be downloaded. Check your connection and try again.'});}finally{this.downloading=false;}
 }
 async offerReady(){this.downloading=false;return this.offer();}
 async check(manual=false){
  if(!this.enabled)return manual?this.message({type:'info',title:'Invoqly updates',message:'Update checks are available in the installed desktop application.'}):undefined;
  if(this.busy)return;
  if(this.available&&manual)return this.offer();
  this.busy=true;
  try{const result=await this.updater.checkForUpdates();if(manual){if(this.available)await this.offer();else await this.message({type:'info',title:'Invoqly updates',message:`You are up to date. Invoqly ${this.app.getVersion()}`});}return result;}
  catch{if(manual)await this.message({type:'warning',title:'Invoqly updates',message:'Could not check for updates. Check your connection and try again.'});}
  finally{this.busy=false;}
 }
 start(){if(!this.enabled)return;this.initial=setTimeout(()=>this.check(),15000);this.interval=setInterval(()=>this.check(),4*60*60*1000);this.initial.unref();this.interval.unref();}
 stop(){clearTimeout(this.initial);clearInterval(this.interval);}
}
module.exports={UpdateController};

