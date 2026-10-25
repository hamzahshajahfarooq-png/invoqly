/* Shared, dependency-free invoice helpers. No invoice contents are sent to analytics. */
(function(root){
 'use strict';
 const prefix='invoqly-draft:',sourceKey='invoqly-acquisition';
 function digits(code){return (root.INVOQLY_CURRENCIES||[]).find(c=>c.code===code)?.digits??2;}
 // Match PostgreSQL numeric(…,4) line calculations, including half-cent ties.
 function lineAmounts(item,code){
  const scaled=value=>{const n=Number(value??0);if(!Number.isFinite(n))throw Error('Invalid amount');const text=n.toFixed(4);if(!/^-?\d+\.\d{4}$/.test(text))throw Error('Invalid amount');return BigInt(text.replace('.',''));};
  const rounded=(n,d)=>{const sign=n<0n?-1n:1n;return sign*((sign*n+d/2n)/d);};
  try{const base=scaled(item.quantity)*scaled(item.unit_price)-scaled(item.discount_amount)*10000n,precision=digits(code),scale=10**precision;
   return {subtotal:Number(rounded(base,10n**BigInt(8-precision)))/scale,tax:Number(rounded(base*scaled(item.tax_rate),10n**BigInt(14-precision)))/scale};
  }catch{return {subtotal:NaN,tax:NaN};}
 }
 function timeZone(){try{return Intl.DateTimeFormat().resolvedOptions().timeZone||'UTC';}catch{return 'UTC';}}
 function browserStorage(name){try{return root[name];}catch{return null;}}
 function preference(key,value){try{const storage=browserStorage('localStorage');if(value!==undefined)storage?.setItem(key,value);return storage?.getItem(key)??null;}catch{return null;}}
 function csvCell(value){return '"'+String(value??'').replace(/^[\s\uFEFF]*[=+@\-\t\r\n]/,"'$&").replace(/"/g,'""')+'"';}
 function formatMoney(value,code){const precision=digits(code);try{return new Intl.NumberFormat('en-US',{style:'currency',currency:code,minimumFractionDigits:precision,maximumFractionDigits:precision}).format(Number(value)||0);}catch(_){return code+' '+(Number(value)||0).toFixed(precision);}}
 function draftStore(storage,account){
  const accountPrefix=prefix+account+':';
  return {
   read(route){try{const value=JSON.parse(storage.getItem(accountPrefix+route));if(!value||value.version!==1||Date.now()-value.savedAt>7*86400000)return null;return value;}catch(_){return null;}},
   write(route,value){try{storage.setItem(accountPrefix+route,JSON.stringify({...value,version:1,savedAt:Date.now()}));return true;}catch(_){return false;}},
   remove(route){try{storage.removeItem(accountPrefix+route);}catch(_){}},
   clear(){try{for(let i=storage.length-1;i>=0;i--){const key=storage.key(i);if(key?.startsWith(accountPrefix))storage.removeItem(key);}}catch(_){}},
  };
 }
 function sourceCode(value){return /^[a-zA-Z0-9_-]{1,64}$/.test(value||'')?value.toLowerCase():null;}
 function captureStart(storage,search=root.location?.search||''){
  const intent=new URLSearchParams(search).get('start');if(intent!=='invoice')return false;
  try{(storage||root.sessionStorage).setItem('invoqly-start',JSON.stringify({intent,at:Date.now()}));}catch(_){}return true;
 }
 function takeStart(storage){
  try{storage=storage||root.sessionStorage;const intent=JSON.parse(storage.getItem('invoqly-start'));storage.removeItem('invoqly-start');return intent?.intent==='invoice'&&Date.now()-intent.at<86400000;}catch(_){return false;}
 }
 function firstInvoiceStep(hasBusiness,clientCount,invoiceCount){return !hasBusiness?'seller':!clientCount?'client':!invoiceCount?'invoice':'share';}
 function captureSource(storage,search=root.location?.search||''){
  try{storage=storage||root.sessionStorage;const existing=JSON.parse(storage.getItem(sourceKey));if(existing&&Date.now()-existing.at<86400000)return sourceCode(existing.code);const code=sourceCode(new URLSearchParams(search).get('utm_source'));if(code)storage.setItem(sourceKey,JSON.stringify({code,at:Date.now()}));return code;}catch(_){return null;}
 }
 function duplicateInvoice(invoice,today){return {...invoice,id:null,invoice_number:'',status:'draft',issue_date:today,due_date:'',share_enabled:false,share_token:null,first_viewed_at:null,view_count:0,client_request_id:null,updated_at:null,voided_at:null,void_reason:null,payment_presentation:invoice.payment_presentation||'standard',invoice_items:(invoice.invoice_items||[]).map(x=>({description:x.description,quantity:x.quantity,unit_price:x.unit_price,tax_rate:x.tax_rate,discount_amount:x.discount_amount||0}))};}
 function reminder(invoice,remaining,link){return 'Hi '+(invoice.client_snapshot?.name||'there')+',\n\nA reminder about invoice '+invoice.invoice_number+(invoice.due_date?' due '+invoice.due_date:'')+'. The recorded outstanding balance is '+formatMoney(remaining,invoice.currency)+'.\n'+(link?'\nInvoice: '+link+'\n':'')+'\nPlease use the payment instructions on the invoice. If you have already paid, please let me know so I can update my records.\n\nThank you,\n'+(invoice.seller_snapshot?.name||'');}
 function invoiceEmail(invoice,link){
  if(['draft','void'].includes(invoice.status))throw new Error('Only an issued invoice can be emailed.');
  const to=String(invoice.client_snapshot?.email||'').trim();
  if(!/^[^\s@<>?,;:]+@[^\s@<>?,;:]+\.[^\s@<>?,;:]+$/.test(to))throw new Error('Save a valid client email before preparing the email.');
  const seller=invoice.seller_snapshot?.name||'the issuing business';
  const subject='Invoice '+invoice.invoice_number+' from '+seller;
  const body='Hi '+(invoice.client_snapshot?.name||'there')+',\n\n'+seller+' has prepared invoice '+invoice.invoice_number+' for you using Invoqly.\n\nView your invoice: '+link+'\n\nOpen this link to check the current recorded payment status and remaining balance. If a balance remains, please pay using the business’s existing bank or payment instructions on the invoice.\n\nPayments are recorded manually by the business. Invoqly does not process payments or verify bank transfers. If you have already paid or have any questions, contact '+seller+(invoice.seller_snapshot?.email?' at '+invoice.seller_snapshot.email:' directly')+'.\n\nAnyone with this enabled link can open the invoice.\n\nThank you,\n'+seller;
  return {to,subject,body,href:'mailto:'+encodeURIComponent(to)+'?subject='+encodeURIComponent(subject)+'&body='+encodeURIComponent(body)};
 }
 root.InvoqlyWorkflow={digits,lineAmounts,timeZone,browserStorage,preference,csvCell,formatMoney,draftStore,sourceCode,captureSource,captureStart,takeStart,firstInvoiceStep,duplicateInvoice,reminder,invoiceEmail};
 captureSource();
 captureStart();
})(globalThis);
