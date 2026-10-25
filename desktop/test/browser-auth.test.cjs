const {test}=require('node:test'),assert=require('node:assert/strict'),crypto=require('node:crypto');
const {BrowserAuth,browserCallback}=require('../src/browser-auth.cjs');
test('browser handoff binds verifier, state, expiry and a single exchange',async()=>{
 let now=1000,calls=0;const id='11111111-aaaa-4000-8000-111111111111';let start;
 const auth=new BrowserAuth({origin:'https://invoqly.top',clock:()=>now,request:async(url,options)=>{
  calls++;assert.equal(url,'https://invoqly.top/api/desktop-auth/exchange');assert.equal(options.redirect,'manual');
  const body=JSON.parse(options.body);assert.equal(crypto.createHash('sha256').update(body.verifier).digest('base64url'),start.get('challenge'));assert.equal(body.state,start.get('state'));
  return Response.json({token_hash:'a'.repeat(64),user_id:id});
 }});
 const link=auth.begin();start=new URLSearchParams(new URL(link).hash.slice(1));assert.ok(!link.includes(auth.pending.verifier));
 const callback='invoqly://auth/browser?id='+id+'&state='+start.get('state');
 assert.equal(await auth.exchange(callback.replace(start.get('state'),'b'.repeat(43))),null);assert.equal(calls,0);
 assert.equal((await auth.exchange(callback)).user_id,id);assert.equal(calls,1);assert.equal(await auth.exchange(callback),null);
 auth.begin();now+=600001;assert.equal(await auth.exchange(callback),null);
 for(const bad of ['https://auth/browser?id='+id,'invoqly://evil/browser?id='+id,'invoqly://auth/browser?id='+id+'&state='+start.get('state')+'#bad'])assert.equal(browserCallback(bad),null);
});
