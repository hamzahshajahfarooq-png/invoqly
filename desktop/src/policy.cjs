const path = require('node:path');
function trusted(url, origin) { try { const u=new URL(url);return u.origin===origin&&!u.username&&!u.password; } catch {return false;} }
function external(url) {try {const u=new URL(url);if(u.username||u.password||url.length>8192)return false;return ['https:','mailto:'].includes(u.protocol)&&!/[\r\n]/.test(url);}catch{return false;}}
function callbackCode(url) {try {const u=new URL(url);if(u.protocol!=='invoqly:'||u.hostname!=='auth'||u.pathname!=='/callback'||u.username||u.password||u.port||u.hash||url.length>4096)return null;const code=u.searchParams.get('code');return code&&code.length<=2048&&!/[\s\x00-\x1f]/.test(code)?code:null;}catch{return null;}}
function filename(name, fallback='Invoqly-download') {const clean=path.basename(String(name)).replace(/[<>:"/\\|?*\x00-\x1f]/g,'_').replace(/[. ]+$/,'').slice(0,150);return !clean||/^(CON|PRN|AUX|NUL|COM[1-9]|LPT[1-9])(?:\.|$)/i.test(clean)?fallback:clean;}
function sessionValue(raw) {try{if(typeof raw!=='string'||raw.length>150000)return null;const v=JSON.parse(raw);return v&&typeof v.access_token==='string'&&typeof v.refresh_token==='string'&&v.access_token.length<20000&&v.refresh_token.length<20000?v:null;}catch{return null;}}
module.exports={trusted,external,callbackCode,filename,sessionValue};
