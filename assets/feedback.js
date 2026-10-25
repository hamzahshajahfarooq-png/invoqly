(()=>{'use strict';
function mount({api,email}){
 if(document.getElementById('workspaceFeedback'))return;
 const button=document.createElement('button');button.id='workspaceFeedback';button.type='button';button.className='btn feedback-trigger';button.textContent='Feedback';button.setAttribute('aria-label','Send feedback or report a problem');
 const target=document.getElementById('signOut');if(!target)return;target.before(button);
 const dialog=document.createElement('dialog');dialog.className='feedback-dialog';dialog.setAttribute('aria-labelledby','feedbackTitle');dialog.innerHTML='<form id="feedbackForm"><div class="feedback-heading"><h2 id="feedbackTitle">How can we help?</h2><button type="button" class="feedback-close" aria-label="Close feedback">×</button></div><label class="field">I’d like to<select name="category"><option value="problem">Report a problem</option><option value="feedback">Share feedback</option></select></label><label class="field">Your message<textarea name="message" rows="6" minlength="10" maxlength="4000" required placeholder="What happened, or what would make Invoqly better?"></textarea></label><p class="muted feedback-privacy">Includes your account email and current workspace section. No invoices, client records or AI chats are attached. Please don’t include passwords or payment details.</p><p class="muted feedback-reply"></p><p class="feedback-status" role="status" aria-live="polite"></p><div class="actions"><button class="btn primary" type="submit">Send message</button><button class="btn feedback-close" type="button">Cancel</button></div></form>';
 document.body.append(dialog);dialog.querySelector('.feedback-reply').textContent='We can reply to '+email+'.';
 let requestId=crypto.randomUUID(),busy=false,section='overview';const form=dialog.querySelector('form'),status=dialog.querySelector('.feedback-status');
 button.onclick=()=>{const route=location.hash.slice(1).split('/')[0];section=['overview','invoices','clients','payments','reports','plans','profile','settings','help','editor','invoice','client','start'].includes(route)?route:'overview';dialog.showModal();form.elements.category.focus();};
 for(const close of dialog.querySelectorAll('.feedback-close'))close.onclick=()=>{if(!busy)dialog.close();};dialog.addEventListener('cancel',e=>{if(busy)e.preventDefault();});
 form.onsubmit=async e=>{e.preventDefault();if(busy||!form.reportValidity())return;busy=true;status.textContent='Sending your message…';for(const b of form.querySelectorAll('button'))b.disabled=true;
 try{const {data,error}=await api.rpc('submit_workspace_feedback',{p_request_id:requestId,p_category:form.elements.category.value,p_message:form.elements.message.value.trim(),p_section:section,p_platform:document.getElementById('invoqly-app-controls')?'windows':'web'});if(error)throw error;if(!/^[a-f0-9-]{36}$/i.test(data||''))throw Error('Could not confirm your report.');status.textContent='Message received. Reference: '+data.slice(0,8)+'. We’ll reply by email if we need more information.';form.reset();requestId=crypto.randomUUID();}
 catch(err){status.textContent=err?.message?.includes('3 reports per day')?err.message:'Could not send your message. Your text is still here—please try again, or email hello@invoqly.top.';}
 finally{busy=false;for(const b of form.querySelectorAll('button'))b.disabled=false;}
 };
}
window.InvoqlyFeedback={mount};})();
