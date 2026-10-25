/* Isolated design fixture. No Supabase client, network writes, or real account data. */
(() => {
 const uid='preview-user',bid='preview-business';
 const date=offset=>{const d=new Date();d.setDate(d.getDate()+offset);return d.toISOString().slice(0,10);};
 const user={id:uid,email:'alex@example.com',user_metadata:{full_name:'Alex Morgan'}};
 const business={id:bid,user_id:uid,name:'Your Studio',email:'hello@example.com',currency:'USD',language:'en',address:{text:'Dubai, United Arab Emirates'},payment_methods:[]};
 const clients=['Luma Studio','Northline Co.','Forma Collective'].map((name,index)=>({id:'client-'+index,user_id:uid,business_id:bid,name,email:['accounts@luma.example','hello@northline.example','finance@forma.example'][index],address:{text:''},created_at:date(-30-index)}));
 const rows=[['paid',3250,0,-16,-2,'Brand identity & art direction'],['sent',2800,1,-3,14,'Website design — milestone 02'],['overdue',1200,2,-28,-7,'Monthly creative retainer'],['partially_paid',1800,0,-10,5,'Campaign design & production']];
 const invoices=rows.map(([status,total,client,issued,due,description],index)=>({id:'invoice-'+index,user_id:uid,business_id:bid,client_id:clients[client].id,invoice_number:'INV-2026-'+String(24-index).padStart(3,'0'),status,currency:'USD',language:'en',issue_date:date(issued),due_date:date(due),created_at:date(issued),updated_at:date(issued)+'T12:00:00Z',client_snapshot:{...clients[client]},seller_snapshot:{...business},invoice_items:[{id:'item-'+index,description,quantity:1,unit_price:total,tax_rate:0,discount_amount:0,line_subtotal:total,line_tax:0}],share_enabled:true,share_token:'preview-'+index,payment_options_enabled:false,payment_presentation:'standard',notes:'Thank you for working with us.',terms:'Payment due by the date shown.'}));
 const payments=[{id:'payment-1',user_id:uid,business_id:bid,invoice_id:invoices[0].id,amount:3250,paid_at:date(-2),method:'bank_transfer',note:'',reversed_at:null},{id:'payment-2',user_id:uid,business_id:bid,invoice_id:invoices[3].id,amount:600,paid_at:date(-1),method:'bank_transfer',note:'Deposit',reversed_at:null}];
 const tables={profiles:[{id:uid,full_name:'Alex Morgan',preferred_language:'en'}],businesses:[business],clients,invoices,payments,product_events:[{id:'event-1',event_name:'onboarding_completed',created_at:date(-30)}]};
 window.INVOQLY_DEMO_DATA={user,business,clients,invoices,payments};
 const previewError={message:'This sample is read-only. Create a free account to save your own work.'};
 function from(table){let filters=[],single=false,offset=0,end=249,write=false;const builder={
  select(){return builder;},eq(key,value){filters.push(row=>row[key]===value);return builder;},order(){return builder;},limit(limit){end=limit-1;return builder;},range(start,finish){offset=start;end=finish;return builder;},maybeSingle(){single=true;return builder;},single(){single=true;return builder;},insert(){write=true;return builder;},update(){write=true;return builder;},upsert(){write=true;return builder;},delete(){write=true;return builder;},
  then(resolve,reject){const selected=(tables[table]||[]).filter(row=>filters.every(filter=>filter(row))).slice(offset,end+1).map(row=>structuredClone(row));return Promise.resolve(write?{data:null,error:previewError}:{data:single?selected[0]||null:selected,error:null}).then(resolve,reject);}
 };return builder;}
 window.INVOQLY_CONFIG={supabaseUrl:'preview',supabasePublishableKey:'preview'};
 const auth={
  onAuthStateChange(){},getSession:async()=>({data:{session:{user}}}),getUser:async()=>({data:{user}}),
  signOut:async()=>({error:previewError}),updateUser:async()=>({error:previewError}),resetPasswordForEmail:async()=>({error:previewError}),
  mfa:{getAuthenticatorAssuranceLevel:async()=>({data:{currentLevel:'aal2',nextLevel:'aal2'}}),listFactors:async()=>({data:{all:[]}}),enroll:async()=>({error:previewError})}
 };
 window.supabase={createClient:()=>({from,auth,rpc:async name=>name==='track_product_event'?{data:null,error:null}:{data:null,error:previewError}})};
})();

// Public, fictional sample only. No Auth SDK, credentials, or provider requests.
(() => {
 const create=window.supabase.createClient;
 window.supabase.createClient=(...args)=>{const api=create(...args),rpc=api.rpc;api.rpc=async(name,args)=>name==='get_my_plan_usage'?{data:{id:'free',name:'Free',billing_cycle:'monthly',invoices_used:3,invoice_limit:5,clients_used:3,client_limit:3,period_end:'2026-11-01T00:00:00Z'},error:null}:rpc(name,args);return api;};
 const plans={
  "currency": "USD",
  "annualSavingsPercent": 20,
  "plans": [
    {
      "id": "free",
      "name": "Free",
      "description": "For your first independent projects.",
      "monthlyCents": 0,
      "annualCents": 0,
      "invoiceLimit": 5,
      "clientLimit": 3,
      "annualInvoiceLimit": null
    },
    {
      "id": "solo",
      "name": "Solo",
      "description": "For a steady flow of freelance work.",
      "monthlyCents": 999,
      "annualCents": 9599,
      "invoiceLimit": 50,
      "clientLimit": 25,
      "annualInvoiceLimit": 600
    },
    {
      "id": "pro",
      "name": "Pro",
      "description": "For an established independent business.",
      "monthlyCents": 1999,
      "annualCents": 19199,
      "invoiceLimit": 250,
      "clientLimit": 100,
      "annualInvoiceLimit": 3000
    },
    {
      "id": "unlimited",
      "name": "Scale",
      "description": "For a growing business without invoice or client caps.",
      "monthlyCents": 3999,
      "annualCents": 38399,
      "invoiceLimit": null,
      "clientLimit": null,
      "annualInvoiceLimit": null
    },
    {
      "id": "enterprise",
      "name": "Enterprise",
      "description": "For higher volumes and a tailored agreement.",
      "monthlyCents": null,
      "annualCents": null,
      "invoiceLimit": null,
      "clientLimit": null,
      "annualInvoiceLimit": null
    }
  ],
  "features": [
    "All 165 billing currencies",
    "Client links and link-view activity",
    "Your business logo",
    "Manual payment tracking",
    "Browser PDF and CSV export",
    "Reports and invoice history"
  ],
  "usageNote": "Solo and Pro monthly plans include a monthly invoice allowance. Their yearly plans include one annual invoice allowance for the subscription year. Unlimited has no invoice or saved-client cap, with all current features included. Drafts and duplicates count toward capped allowances; edits and issuance do not. Saved clients are a total capacity limit.",
  "billingNote": "Subscription prices are in USD; applicable taxes are shown at checkout. Yearly plans are billed once per year. Paid access starts after payment is confirmed. Your invoice currencies are independent of subscription billing.",
  "annualSavingsLabel": "about 20%"
}
;
 window.fetch=async input=>{const url=new URL(typeof input==='string'?input:input.url,location.href);if(url.pathname==='/assets/plans.json')return Response.json(plans);if(url.pathname==='/api/billing/config')return Response.json({enabled:false});throw new Error('This sample does not connect to an account.');};
 const routes=new Set(['overview','invoices','clients','payments','reports','plans','profile','settings']);
 const announce=()=>{if(parent!==window)parent.postMessage({type:'invoqly-demo:route',route:location.hash.slice(1).split('/')[0]||'overview'},location.origin);};
 window.addEventListener('message',event=>{if(event.source!==parent||event.origin!==location.origin||event.data?.type!=='invoqly-demo:navigate'||!routes.has(event.data.route))return;location.hash=event.data.route;});
 window.addEventListener('hashchange',announce);window.addEventListener('load',announce);
 document.addEventListener('click',event=>{const target=event.target.closest('a,button');if(!target)return;if(target.id==='signOut'){event.preventDefault();event.stopImmediatePropagation();location.hash='overview';return;}if(target.tagName==='A'&&!target.getAttribute('href')?.startsWith('#')){event.preventDefault();event.stopImmediatePropagation();}},true);
})();
