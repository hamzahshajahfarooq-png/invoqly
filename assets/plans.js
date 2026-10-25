/* Public plan presentation. Only database entitlements authorize capacity. */
(() => {
 'use strict';
 const esc=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
 const money=cents=>new Intl.NumberFormat('en-US',{style:'currency',currency:'USD',maximumFractionDigits:cents%100?2:0}).format(cents/100);
 const api=window.InvoqlyPlans={catalog:null,billing:'monthly'};
 api.requestLink=(id,cycle)=>id==='enterprise'?'/enterprise?billing='+encodeURIComponent(cycle):'mailto:hello@invoqly.top?subject='+encodeURIComponent('Invoqly '+id+' plan — '+cycle)+'&body='+encodeURIComponent('Hello, I would like to discuss the '+id+' plan with '+cycle+' billing. Please confirm pricing and activation details before any payment.');
 api.cards=(cycle='monthly',current=null)=>api.catalog.plans.map(p=>{
  const yearly=cycle==='yearly',custom=p.monthlyCents===null,free=p.id==='free';
  const amount=custom?'Let’s talk':money(yearly?p.annualCents:p.monthlyCents);
  return `<article class="plan ${p.id==='solo'?'plan-pop':''}"><div class="plan-topline"><h3>${esc(p.name)}</h3>${p.id==='solo'?'<span class="plan-recommendation">For freelancers</span>':''}</div><p class="plan-desc">${esc(p.description)}</p><div class="price"><span class="amount">${amount}</span>${!custom?'<span class="per">/ '+(yearly&&!free?'year':'month')+'</span>':''}</div><p class="plan-billing">${custom?'Pricing and capacity agreed with you.':free?'Free, with no payment card.':yearly?money(p.annualCents)+' billed yearly · save '+(api.catalog.annualSavingsLabel||api.catalog.annualSavingsPercent+'%'):'Billed monthly · switch to yearly to save '+(api.catalog.annualSavingsLabel||api.catalog.annualSavingsPercent+'%')}</p><ul class="plan-feat"><li><strong>${!custom&&p.invoiceLimit===null?'Unlimited invoices':(custom?'Agreed':Number(yearly&&!free?p.annualInvoiceLimit:p.invoiceLimit).toLocaleString('en-US'))+' new invoices / '+(yearly&&!free?'year':'month')}</strong></li><li><strong>${custom?'Agreed':p.clientLimit===null?'Unlimited':p.clientLimit} saved clients</strong></li>${api.catalog.features.map(f=>'<li><span aria-hidden="true">✓</span> '+esc(f)+'</li>').join('')}</ul><a data-checkout-plan="${free||custom?'':p.id}" data-checkout-cycle="${cycle}" class="btn ${p.id==='solo'?'btn-primary primary':''}" href="${free?(current?'#plans':'/signup?start=invoice'):custom?api.requestLink(p.id,cycle):'/dashboard#plans'}">${current?.id===p.id?'Current plan':free?'Start free':custom?'Discuss Enterprise':'Choose '+esc(p.name)}</a></article>`;
 }).join('');
 api.toggleMarkup=()=>`<div class="billing-switch" role="group" aria-label="Billing period"><button type="button" data-plan-cycle="monthly" aria-pressed="true">Monthly</button><button type="button" data-plan-cycle="yearly" aria-pressed="false">Yearly <span>Save ~20%</span></button></div>`;
 api.bind=(root=document,onChange)=>root.querySelectorAll('[data-plan-cycle]').forEach(button=>button.onclick=()=>{
  api.billing=button.dataset.planCycle;root.querySelectorAll('[data-plan-cycle]').forEach(b=>b.setAttribute('aria-pressed',String(b===button)));
  if(onChange)onChange(api.billing);else{const cards=root.querySelector('[data-plan-cards]');if(cards)cards.innerHTML=api.cards(api.billing);}
 });
 api.ready=fetch('/assets/plans.json').then(r=>{if(!r.ok)throw Error('Plans are unavailable.');return r.json();}).then(catalog=>{
  api.catalog=catalog;const host=document.querySelector('#pricing');if(host){host.querySelector('[data-plan-cards]').innerHTML=api.cards();api.bind(host);}return catalog;
 }).catch(error=>{const host=document.querySelector('[data-plan-cards]');if(host)host.innerHTML='<p>Plans could not load. <a href="mailto:hello@invoqly.top">Contact us for pricing.</a></p>';throw error;});
})();
