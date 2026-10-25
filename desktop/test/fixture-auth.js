// Test-only adapter around the existing fictional dashboard data. Never packaged.
(()=>{
const make=window.supabase.createClient,key='sb-gugiuxcjovynshxnquih-auth-token';
const get=()=>{try{return JSON.parse(localStorage.getItem(key));}catch{return null;}};
const call=async(url,body)=>{const r=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(body)});const data=await r.json();return r.ok?{data,error:null}:{data:null,error:{message:data.error||'Invalid code'}};};
const save=async tokens=>{const r=await call('/fixture/session',tokens);if(r.error)return r;localStorage.setItem(key,JSON.stringify(r.data));return{data:{session:r.data},error:null};};
window.INVOQLY_CONFIG={supabaseUrl:location.origin,supabasePublishableKey:'sb_publishable_fixture'};
window.supabase.createClient=()=>{
 const api=make(),callbacks=[];
 api.auth={onAuthStateChange:f=>callbacks.push(f),getSession:async()=>({data:{session:get()},error:null}),getUser:async()=>({data:{user:get()?.user},error:null}),signInWithOtp:body=>call('/fixture/otp',body),verifyOtp:async body=>{const r=await call('/fixture/verify',body);return r.error?r:save(r.data);},setSession:save,signOut:async()=>{localStorage.removeItem(key);callbacks.forEach(f=>f('SIGNED_OUT'));return{error:null};},mfa:{getAuthenticatorAssuranceLevel:async()=>({data:{currentLevel:get()?.aal||'aal1',nextLevel:get()?.needsMfa?'aal2':'aal1'},error:null}),listFactors:async()=>({data:{all:get()?.needsMfa?[{id:'totp-fixture',status:'verified',factor_type:'totp'}]:[]},error:null}),challenge:async()=>({data:{id:'challenge-fixture'},error:null}),verify:async body=>{const r=await call('/fixture/mfa',body);return r.error?r:save(r.data);}}};
 const rpc=api.rpc.bind(api);api.rpc=(name,args)=>name==='get_my_plan_usage'?Promise.resolve({data:{id:'free',name:'Free',billing_cycle:'monthly',invoices_used:2,invoice_limit:5,clients_used:1,client_limit:3,period_end:'2026-11-01T00:00:00Z',subscription:null,pending_checkout:null},error:null}):rpc(name,args);
 return api;
};
})();
