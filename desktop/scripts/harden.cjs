const path=require('node:path');
function binaryPath(context){const platform=context.electronPlatformName,name=context.packager.appInfo.productFilename;return path.join(context.appOutDir,platform==='darwin'?name+'.app':platform==='win32'?name+'.exe':context.packager.executableName||'invoqly');}
module.exports=async context=>{
 const {flipFuses,FuseVersion,FuseV1Options}=await import('@electron/fuses');
 const settings={version:FuseVersion.V1,resetAdHocDarwinSignature:context.electronPlatformName==='darwin',[FuseV1Options.RunAsNode]:false,[FuseV1Options.EnableNodeOptionsEnvironmentVariable]:false,[FuseV1Options.EnableNodeCliInspectArguments]:false,[FuseV1Options.OnlyLoadAppFromAsar]:true};
 if(context.electronPlatformName!=='linux')settings[FuseV1Options.EnableEmbeddedAsarIntegrityValidation]=true;
 await flipFuses(binaryPath(context),settings);
};
module.exports.binaryPath=binaryPath;
