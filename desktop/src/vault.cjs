const fs=require('node:fs/promises');
const path=require('node:path');
class Vault {
  constructor(file,crypto,platform=process.platform){this.file=file;this.crypto=crypto;this.platform=platform;this.queue=Promise.resolve();}
  async available(){if(!await this.crypto.isAsyncEncryptionAvailable())return false;if(this.platform!=='linux')return true;this.crypto.isEncryptionAvailable?.();return ['gnome_libsecret','kwallet','kwallet5','kwallet6'].includes(this.crypto.getSelectedStorageBackend?.());}
  async read(){try {if(!await this.available())return null;const v=await this.crypto.decryptStringAsync(await fs.readFile(this.file));if(v.shouldReEncrypt)await this.write(v.result);return v.result;}catch{return null;}}
  write(value){this.queue=this.queue.catch(()=>{}).then(async()=>{if(value===null){await fs.rm(this.file,{force:true});return;}if(!await this.available())return;await fs.mkdir(path.dirname(this.file),{recursive:true});const encrypted=await this.crypto.encryptStringAsync(value);await fs.writeFile(this.file+'.tmp',encrypted,{mode:0o600});await fs.rename(this.file+'.tmp',this.file);});return this.queue;}
}
module.exports={Vault};
