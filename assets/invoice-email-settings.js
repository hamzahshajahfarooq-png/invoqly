(() => {
 'use strict';
 const today=()=>{const d=new Date();return [d.getFullYear(),String(d.getMonth()+1).padStart(2,'0'),String(d.getDate()).padStart(2,'0')].join('-');};
 function nextRun(issue,frequency){
  const [year,month,day]=String(issue||today()).split('-').map(Number);let date=new Date(Date.UTC(year,month-1,day));
  do{if(frequency==='weekly')date.setUTCDate(date.getUTCDate()+7);else{const months=frequency==='yearly'?12:frequency==='quarterly'?3:1;date.setUTCDate(1);date.setUTCMonth(date.getUTCMonth()+months);const last=new Date(Date.UTC(date.getUTCFullYear(),date.getUTCMonth()+1,0)).getUTCDate();date.setUTCDate(Math.min(day,last));}}while(date.toISOString().slice(0,10)<=today());
  return date.toISOString().slice(0,10);
 }
 const apiResult=async p=>{const r=await p;if(r.error)throw r.error;return r.data;};
 const timezone=()=>Intl.DateTimeFormat().resolvedOptions().timeZone||'UTC';
 const view=standalone=>`<section class="panel no-print" id="invoiceEmailSettings"><h2>Send to your client</h2><p class="muted">Choose what to send. Saving these settings does not send an email.</p><section class="invoice-email-group"><h3>Send invoice</h3><p class="muted">The first invoice email is queued when you issue it. Send it again whenever needed.</p>${standalone?'<button type="button" class="btn" id="sendInvoiceNow">Send invoice now</button>':''}<label class="field">Send another invoice<select id="invoiceRepeat"><option value="none">Only when I send it</option><option value="weekly">Every week</option><option value="monthly">Every month</option><option value="quarterly">Every 3 months</option><option value="yearly">Every year</option></select></label><p class="muted">Repeating creates and emails a new invoice for the next billing period.</p></section><section class="invoice-email-group"><h3>Remind about payment</h3><p class="muted">A reminder links to this invoice and shows the amount still outstanding.</p>${standalone?'<button type="button" class="btn" id="sendReminderNow">Send reminder now</button>':''}<label class="invoice-email-choice"><input type="checkbox" id="enableInvoiceReminder"> Send payment reminders automatically</label><div id="invoiceReminderControls"><label class="field">First reminder<select id="invoiceReminderStart"><option value="due">After the due date</option><option value="date">Choose a calendar date</option></select></label><label class="field" id="invoiceReminderDaysField">Days after the due date<input type="number" id="invoiceReminderDays" value="7" min="1" max="90" disabled></label><label class="field" id="invoiceReminderDateField" hidden>Reminder date<input type="date" id="invoiceReminderDate" disabled></label><label class="field">Then remind again<select id="invoiceReminderRepeat"><option value="none">Don’t repeat</option><option value="1">Every day</option><option value="2">Every 2 days</option><option value="3">Every 3 days</option><option value="custom">Custom number of days</option></select></label><label class="field" id="invoiceReminderCustomField" hidden>Repeat every this many days<input type="number" id="invoiceReminderCustom" min="1" max="365" value="7" disabled></label><p class="muted" id="invoiceReminderSummary"></p></div><p class="muted">Reminders stop when the invoice is paid or voided. Record payments received outside Invoqly.</p></section><p id="invoiceEmailSettingsStatus" role="status" class="muted"></p>${standalone?'<button type="button" class="btn primary" id="saveInvoiceEmailSettings">Save email settings</button>':''}</section>`;
 let active=null;
 async function mount({api,invoice,standalone,notify}){
  const root=document.getElementById('invoiceEmailSettings');if(!root)return;
  const state={root,api,invoice,rule:null,ready:!invoice?.id,requestIds:{invoice:crypto.randomUUID(),reminder:crypto.randomUUID()}};active=state;
  const el=id=>root.querySelector('#'+id),enable=el('enableInvoiceReminder'),days=el('invoiceReminderDays'),repeat=el('invoiceRepeat'),status=el('invoiceEmailSettingsStatus'),start=el('invoiceReminderStart'),date=el('invoiceReminderDate'),interval=el('invoiceReminderRepeat'),custom=el('invoiceReminderCustom');
  date.min=today();const max=new Date(today()+'T12:00:00Z');max.setUTCDate(max.getUTCDate()+1827);date.max=max.toISOString().slice(0,10);
  const canSend=invoice?.id&&!['draft','void'].includes(invoice.status)&&invoice.payment_presentation!=='personal';
  const sync=()=>{
   const on=state.ready&&enable.checked,calendar=start.value==='date',customRepeat=interval.value==='custom';
   start.disabled=interval.disabled=!on;days.disabled=!on||calendar;date.disabled=!on||!calendar;custom.disabled=!on||!customRepeat;
   el('invoiceReminderDaysField').hidden=calendar;el('invoiceReminderDateField').hidden=!calendar;el('invoiceReminderCustomField').hidden=!customRepeat;
   el('invoiceReminderControls').hidden=!enable.checked;
   const zone=state.rule?.reminder_timezone||timezone();el('invoiceReminderSummary').textContent=on?`Dates follow ${zone.replaceAll('_',' ')}. No time selection is needed. Delivery is queued on the chosen date; reminders wait if an invoice email was already sent that day.`:'';
   for(const id of ['sendInvoiceNow','sendReminderNow'])if(el(id)){el(id).disabled=!state.ready||!canSend||(id==='sendReminderNow'&&invoice.status==='paid');el(id).title=!canSend?'Review and issue the invoice first.':'';}
  };
  for(const input of [enable,start,interval])input.onchange=sync;
  if(invoice?.id){enable.disabled=repeat.disabled=true;status.textContent='Loading email settings…';try{
   state.rule=await apiResult(api.from('invoice_automation').select('*').eq('source_invoice_id',invoice.id).maybeSingle());if(!root.isConnected)return;
   enable.checked=!!state.rule?.reminders_enabled;days.value=state.rule?.reminder_days||7;repeat.value=state.rule?.recurring_enabled?state.rule.frequency:'none';
   start.value=state.rule?.reminder_start_date?'date':'due';date.value=state.rule?.reminder_start_date||'';
   const n=state.rule?.reminder_repeat_days;interval.value=n?[1,2,3].includes(n)?String(n):'custom':'none';custom.value=n||7;
   if(date.value&&date.value<today())date.min=date.value;
   status.textContent=state.rule?.last_error?'Repeat invoices are paused. Check the client email and your plan allowance, then save again.':'';state.ready=true;
  }catch{status.textContent='Could not load email settings. Refresh before changing them.';}finally{if(root.isConnected){enable.disabled=repeat.disabled=!state.ready;sync();}}}else sync();
  if(standalone){
   el('saveInvoiceEmailSettings').onclick=async e=>{const b=e.target;b.disabled=true;try{await persist(api,invoice.id,read(),invoice);status.textContent='Email settings saved. Your calendar will be followed automatically.';notify('Email settings saved.');}catch(err){status.textContent=err.message;notify(err.message,true);}finally{b.disabled=false;}};
   for(const [id,kind] of [['sendInvoiceNow','invoice'],['sendReminderNow','reminder']])el(id).onclick=async()=>{
    const b=el(id);if(b.disabled)return;
    try{
     const settings=read(),recipient=invoice.client_snapshot?.email;if(!recipient)throw Error('Add a client email before sending.');
     if(!window.confirm(`Send ${kind==='invoice'?'this invoice':'a payment reminder'} to ${recipient} now? Your saved schedule will continue afterwards.`))return;
     b.disabled=true;
     await apiResult(api.rpc('send_invoice_message',{p_invoice_id:invoice.id,p_request_id:state.requestIds[kind],p_kind:kind,p_settings:payload(settings,invoice)}));
     remember(settings,invoice);
     state.requestIds[kind]=crypto.randomUUID();status.textContent=`${kind==='invoice'?'Invoice email':'Payment reminder'} queued. Delivery normally starts within a minute. Your schedule remains in place. Recently sent or pending copies are reused to prevent duplicates.`;notify('Email queued.');
    }catch(err){status.textContent=err.message;notify(err.message,true);}finally{sync();}
   };
  }
 }
 function read(){
  const s=active;if(!s?.root.isConnected)return null;if(!s.ready)throw Error('Email settings are still loading. Please try again.');
  const el=id=>s.root.querySelector('#'+id),enabled=el('enableInvoiceReminder').checked,days=Number(el('invoiceReminderDays').value),frequency=el('invoiceRepeat').value;
  const calendar=el('invoiceReminderStart').value==='date',startDate=calendar?el('invoiceReminderDate').value:null,choice=el('invoiceReminderRepeat').value,repeatDays=choice==='none'?null:Number(choice==='custom'?el('invoiceReminderCustom').value:choice);
  if(enabled&&!calendar&&(!Number.isInteger(days)||days<1||days>90))throw Error('Choose a reminder delay from 1 to 90 days.');
  if(enabled&&calendar&&(!startDate||startDate>el('invoiceReminderDate').max||(startDate<today()&&startDate!==s.rule?.reminder_start_date)))throw Error('Choose today or a future reminder date (within five years).');
  if(enabled&&repeatDays!==null&&(!Number.isInteger(repeatDays)||repeatDays<1||repeatDays>365))throw Error('Repeat reminders every 1 to 365 days.');
  return{enabled,days:enabled&&!calendar?days:7,startDate:enabled?startDate:null,repeatDays:enabled?repeatDays:null,timezone:s.rule?.reminder_timezone||timezone(),frequency,previous:s.rule};
 }
 function payload(settings,invoice){
  if(!settings)return;const personal=invoice.payment_presentation==='personal'||invoice.payment_state==='personal';
  const reminder=!!settings.enabled&&!personal,recurring=settings.frequency!=='none'&&!personal;
  const old=settings.previous,unchanged=old?.recurring_enabled&&old.frequency===settings.frequency;
  const date=unchanged&&old.next_run>=today()?old.next_run:recurring?nextRun(invoice.issue_date,settings.frequency):null;
  const diff=invoice.due_date?(Date.parse(invoice.due_date)-Date.parse(invoice.issue_date))/86400000:NaN;
  const due=Number.isFinite(diff)?Math.max(0,Math.min(365,Math.round(diff))):14;
  return{p_reminders:reminder,p_recurring:recurring,p_frequency:recurring?settings.frequency:'monthly',p_next_run:date,p_due_days:due,p_auto_issue:recurring,p_end_date:null,p_reminder_days:settings.days,p_anchor_day:Number(String(invoice.issue_date).slice(-2))||null,p_reminder_start_date:settings.startDate||null,p_reminder_repeat_days:settings.repeatDays||null,p_reminder_timezone:settings.timezone||timezone()};
 }
 function remember(settings,invoice){if(!active||active.invoice?.id!==invoice.id)return;const p=payload(settings,invoice);active.rule={...(settings.previous||{}),reminders_enabled:p.p_reminders,reminder_days:p.p_reminder_days,reminder_start_date:p.p_reminder_start_date,reminder_repeat_days:p.p_reminder_repeat_days,reminder_timezone:p.p_reminder_timezone,recurring_enabled:p.p_recurring,frequency:p.p_frequency,next_run:p.p_next_run};}
 async function persist(api,id,settings,invoice){if(!settings||(!settings.enabled&&settings.frequency==='none'&&!settings.previous))return;await apiResult(api.rpc('save_invoice_email_schedule',{p_source_invoice_id:id,p_settings:payload(settings,invoice)}));remember(settings,invoice);}
 window.InvoqlyInvoiceEmails={view,mount,read,persist,payload,nextRun};
})();
