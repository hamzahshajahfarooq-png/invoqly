/* The server and database authorize every entitlement. Checkout callbacks only refresh. */
(() => {
 'use strict';
 const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
 let client, paddleReady, cycle='monthly', provider='paddle', subscriptionProvider='paddle', checkoutProvider='paddle', activeButton=null, billingBusy=false;
 const date = value => value ? new Date(value).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'}) : '—';
 async function request(action, body={}) {
  let timer;
  const session = await Promise.race([client.auth.getSession(),new Promise((_,reject)=>{timer=setTimeout(()=>reject(Error('Your sign-in check took too long. Refresh the app and try again.')),15000);})]).finally(()=>clearTimeout(timer));
  if (!session.data.session) throw Error('Sign in to manage billing.');
  const response = await fetch('/api/'+((action==='checkout'?checkoutProvider:['portal','manage','receipts','cancel-subscription'].includes(action)?subscriptionProvider:provider)==='paypal'?'paypal':'billing')+'/'+action,{method:'POST',headers:{'Content-Type':'application/json',Authorization:'Bearer '+session.data.session.access_token},body:JSON.stringify(body),signal:AbortSignal.timeout(45000)});
  const data = await response.json(); if (!response.ok) throw Error(data.error || 'Billing is unavailable.');return data;
 }
 function message(text,error=false) {
  const target=document.querySelector('#billingMessage');if(target){target.textContent=text;target.setAttribute('role',error?'alert':'status');target.hidden=false;}
  const card=activeButton?.isConnected?activeButton.closest('.plan'):null;
  if(card){let local=card.querySelector('[data-checkout-status]');if(!local){local=document.createElement('p');local.dataset.checkoutStatus='true';local.style.cssText='font-size:13px;line-height:1.5;overflow-wrap:anywhere;margin-top:12px';activeButton.after(local);}local.textContent=text;local.setAttribute('role',error?'alert':'status');}
 }
 function openBilling(url){
  const target=activeButton?.isConnected?(activeButton.closest('.plan')?.querySelector('[data-checkout-status]')||document.querySelector('#billingMessage')):document.querySelector('#billingMessage');
  if(target){const link=document.createElement('a');link.href=url;link.target='_blank';link.rel='noopener noreferrer';link.textContent='Open secure payment page';link.style.display='block';link.dataset.billingContinue='true';target.append(link);}
  location.assign(url);
 }
 async function paddle() {
  if (!paddleReady) paddleReady=(async()=>{
   const response=await fetch('/api/billing/config');const config=await response.json();
   if (!(config.paddleEnabled ?? config.enabled)) throw Error('Checkout is temporarily unavailable.');
   if (!window.Paddle) await new Promise((resolve,reject)=>{const script=document.createElement('script');script.src='https://cdn.paddle.com/paddle/v2/paddle.js';script.onload=resolve;script.onerror=()=>reject(Error('Could not load secure checkout.'));document.head.append(script);});
   window.Paddle.Initialize({token:config.clientToken,eventCallback:event=>{if(event.name==='checkout.completed'){
    message('Payment received. Confirming your plan…');refreshAfterPayment();
   }}});return window.Paddle;
  })().catch(error=>{paddleReady=null;throw error;});
  return paddleReady;
 }
 async function refreshAfterPayment() {
  for(let n=0;n<6;n++) {try {const usage=await request('refresh');if(usage.id!=='free'){await mount(client);message('Your paid plan is active.');return;}}catch{}await new Promise(resolve=>setTimeout(resolve,2000));}
  await mount(client);message('Your payment is still being confirmed. Use Refresh billing status in a moment.');
 }
 async function mount(api) {
  client=api;const host=document.querySelector('#billingPanel');if(!host)return;
  try {
   await window.InvoqlyPlans.ready;
   const result=await client.rpc('get_my_plan_usage');if(result.error)throw result.error;
   const usage=result.data, plans=window.InvoqlyPlans;
   const billingConfig=await (await fetch('/api/billing/config')).json();
   subscriptionProvider=usage.subscription?.provider||(billingConfig.paypalEnabled?'paypal':'paddle');
   provider=usage.subscription?.provider||(billingConfig.paypalEnabled?'paypal':usage.pending_checkout?.provider||'paddle');
   checkoutProvider=billingConfig.paypalEnabled?'paypal':usage.pending_checkout?.provider||'paddle';
   host.innerHTML=`<section class="panel"><h2>${esc(usage.name)} plan</h2><p>${Number(usage.invoices_used).toLocaleString()} / ${usage.invoice_limit===null?'Unlimited':Number(usage.invoice_limit).toLocaleString()} new invoices in this ${usage.billing_cycle==='yearly'?'subscription year':'period'} · resets ${date(usage.period_end)}</p><p>${Number(usage.clients_used)} / ${usage.client_limit===null?'Unlimited':Number(usage.client_limit)} saved clients</p><p class="muted">${esc(plans.catalog.usageNote)}</p>${usage.subscription?`<p>Subscription status: ${esc(usage.subscription.status)}${usage.valid_until?' · paid access through '+date(usage.valid_until):''}</p>`:''}<p class="muted">${subscriptionProvider==='paypal'?'View billing opens your latest paid PayPal invoice when available. Manage subscription opens PayPal for your payment method and renewal settings. View receipts opens your PayPal payment history. Your client invoices remain available in Invoices in this app. Cancel renewal here to stop future charges; your paid period remains available.':'View billing opens Paddle to view or download your subscription invoices, update payment details, or cancel.'}</p><div class="actions">${usage.subscription?.can_manage?'<button type="button" class="btn" data-billing-action="portal">View billing</button>':''}${usage.subscription?.provider==='paypal'?'<button type="button" class="btn" data-billing-action="manage">Manage subscription</button><button type="button" class="btn" data-billing-action="receipts">View receipts</button>':''}${usage.subscription?.provider==='paypal'&&usage.subscription.status!=='canceled'?'<button type="button" class="btn" data-billing-action="cancel-subscription">Cancel renewal</button>':''}<button type="button" class="btn" data-billing-action="refresh">Refresh billing status</button>${usage.pending_checkout&&usage.pending_checkout.provider!=='paypal'?'<button type="button" class="btn" data-billing-action="cancel-checkout">Cancel pending checkout</button>':''}</div></section><p id="billingMessage" role="status" hidden></p>${plans.toggleMarkup()}<div class="plans pricing-plans" data-plan-cards>${plans.cards(cycle,usage)}</div><p class="muted">${checkoutProvider==='paypal'?'Subscriptions renew automatically until canceled. Secure checkout is provided by PayPal. ':''}${esc(plans.catalog.billingNote)} <a href="/refund">Read our refund policy</a>.</p>`;
   const showAvailability=()=>{if(usage.subscription?.can_manage&&(usage.subscription.status!=='canceled'||Date.parse(usage.valid_until)>Date.now())){host.querySelectorAll('[data-checkout-plan]').forEach(button=>{if(button.dataset.checkoutPlan){button.textContent='Manage subscription';button.dataset.billingAction='portal';button.removeAttribute('data-checkout-plan');button.setAttribute('href','#plans');}});}if(billingConfig.paypalEnabled&&checkoutProvider==='paypal'){host.querySelectorAll('[data-checkout-plan]').forEach(button=>{if(button.dataset.checkoutPlan)button.textContent='Subscribe with PayPal';});}if(!billingConfig.enabled){host.querySelectorAll('[data-checkout-plan]').forEach(button=>{if(button.dataset.checkoutPlan){button.textContent='Checkout unavailable';button.setAttribute('aria-disabled','true');button.removeAttribute('href');button.removeAttribute('data-checkout-plan');}});message('Paid checkout is currently unavailable. You can continue using the Free plan.');}};
   showAvailability();
   host.querySelectorAll('[data-plan-cycle]').forEach(b=>b.setAttribute('aria-pressed',String(b.dataset.planCycle===cycle)));
   plans.bind(host,value=>{cycle=value;host.querySelector('[data-plan-cards]').innerHTML=plans.cards(value,usage);showAvailability();});
   window.dispatchEvent(new Event('invoqly-billing-ready'));
   host.onclick=async event=>{
    const button=event.target.closest('[data-billing-action],[data-checkout-plan]');if(!button||!host.contains(button))return;
    const plan=button.dataset.checkoutPlan,action=button.dataset.billingAction;if(!plan&&!action)return;
    event.preventDefault();if(button.dataset.busy||billingBusy)return;host.querySelectorAll('[data-checkout-status]').forEach(el=>el.remove());billingBusy=true;activeButton=button;const originalLabel=button.textContent;button.dataset.busy='true';button.setAttribute('aria-disabled','true');if(plan){button.textContent='Opening secure checkout…';message('Opening secure checkout…');}
    try {
     if(plan&&checkoutProvider==='paypal'){const data=await request('checkout',{plan,cycle:button.dataset.checkoutCycle});const url=new URL(data.url);if(url.protocol!=='https:'||url.hostname!=='www.paypal.com'||url.username||url.password)throw Error('Invalid PayPal checkout.');message('Complete checkout securely on PayPal. If it did not open, use the link below. Return here and refresh billing status after paying.');openBilling(url.href);}
     else if(plan){const checkout=await paddle();const transaction=await request('checkout',{plan,cycle:button.dataset.checkoutCycle});checkout.Checkout.open({transactionId:transaction.transactionId,settings:{displayMode:'overlay',theme:'light',locale:'en',allowLogout:false,showAddDiscounts:false}});}
     else {if(action==='cancel-subscription'&&!window.confirm('Cancel automatic renewal? Your already paid period stays available.'))return;const data=await request(action);if(['portal','manage','receipts'].includes(action)){const url=new URL(data.url);if(url.protocol!=='https:'||url.username||url.password||!(url.hostname==='paddle.com'||url.hostname.endsWith('.paddle.com')||url.hostname==='www.paypal.com'))throw Error('Invalid billing portal.');openBilling(url.href);}else {await mount(client);message(action==='refresh'?'Billing status refreshed.':action==='cancel-subscription'?'Renewal canceled. Your paid period remains available.':'Pending checkout canceled.');}}
    }catch(error){message(error.name==='TimeoutError'?'Checkout took too long. Please try again; a pending checkout will be reused safely.':error.message,true);}finally{delete button.dataset.busy;button.removeAttribute('aria-disabled');button.textContent=originalLabel;billingBusy=false;activeButton=null;}
   };
  }catch(error){host.innerHTML=`<section class="panel"><h2>Could not load billing</h2><p>${esc(error.message)}</p><a class="btn" href="mailto:hello@invoqly.top">Contact support</a></section>`;}
 }
 if(new URLSearchParams(location.search).get('paypal')==='return'){window.addEventListener('invoqly-billing-ready',()=>refreshAfterPayment(),{once:true});}
 window.InvoqlyBilling={mount};
})();
