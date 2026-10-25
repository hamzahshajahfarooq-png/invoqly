'use strict';
const crypto=require('node:crypto');
function callback(url){try{const u=new URL(url);if(u.protocol!=='invoqly:'||u.hostname!=='auth'||u.pathname!=='/browser'||u.hash||u.port||u.username||u.password||url.length>2048)return null;const id=u.searchParams.get('id'),state=u.searchParams.get('state');return /^[a-f0-9-]{36}$/i.test(id||'')&&/^[A-Za-z0-9_-]{43}$/.test(state||'')?{id,state}:null;}catch{return null;}}
class BrowserAuth{
 constructor({origin,request=fetch,clock=Date.now}){Object.assign(this,{origin,request,clock});this.pending=null;}
 begin(){const verifier=crypto.randomBytes(32).toString('base64url'),state=crypto.randomBytes(32).toString('base64url'),challenge=crypto.createHash('sha256').update(verifier).digest('base64url');this.pending={verifier,state,started:this.clock()};return this.origin+'/desktop-signin#'+new URLSearchParams({challenge,state});}
 async exchange(url){const data=callback(url),p=this.pending;if(!data||!p||this.clock()-p.started>10*60000||data.state!==p.state)return null;this.pending=null;
  const r=await this.request(this.origin+'/api/desktop-auth/exchange',{method:'POST',redirect:'manual',headers:{'Content-Type':'application/json',Origin:this.origin},body:JSON.stringify({...data,verifier:p.verifier}),signal:AbortSignal.timeout(20000)});if(!r.ok)throw Error('browser_handoff_failed');const d=await r.json();if(!/^[A-Za-z0-9_-]{20,512}$/.test(d.token_hash||'')||!/^[a-f0-9-]{36}$/i.test(d.user_id||''))throw Error('browser_handoff_invalid');return d;
 }
}
module.exports={BrowserAuth,browserCallback:callback};
