(() => {
 'use strict';
 const frame=document.querySelector('#heroDemoFrame'),viewport=document.querySelector('.computer-viewport');if(!frame||!viewport)return;
 function fit(){const width=viewport.clientWidth;if(width>=740){const scale=width/1280;frame.style.width='1280px';frame.style.height='830px';frame.style.transform=`scale(${scale})`;viewport.style.height=(830*scale)+'px';}else{frame.style.width='100%';frame.style.height='660px';frame.style.transform='none';viewport.style.height='660px';}}
 const controls=[...document.querySelectorAll('[data-demo-view]')];
 const select=route=>controls.forEach(button=>button.setAttribute('aria-pressed',String(button.dataset.demoView===route)));
 controls.forEach(button=>button.addEventListener('click',()=>{const route=button.dataset.demoView;frame.contentWindow.postMessage({type:'invoqly-demo:navigate',route},location.origin);select(route);}));
 window.addEventListener('message',event=>{if(event.source!==frame.contentWindow||event.origin!==location.origin||event.data?.type!=='invoqly-demo:route')return;select(event.data.route);});
 frame.addEventListener('load',fit);new ResizeObserver(fit).observe(viewport);fit();
})();

(() => {
 const section=document.querySelector('.process-section'),timeline=section?.querySelector('.process-timeline');if(!section||!timeline)return;
 const stage=section.querySelector('.process-stage'),rows=[...timeline.querySelectorAll('.process-step')],rail=timeline.querySelector('.process-rail'),reduce=matchMedia('(prefers-reduced-motion: reduce)');let pending=false,distance=1200;
 const clamp=x=>Math.max(0,Math.min(1,x));
 function measure(){const staticMode=reduce.matches||innerHeight<640;section.dataset.static=String(staticMode);distance=Math.max(1000,innerHeight*1.45);section.style.height=staticMode?'auto':(stage.offsetHeight+distance+220)+'px';render();}
 function render(){pending=false;const staticMode=section.dataset.static==='true',p=staticMode?1:clamp(-section.getBoundingClientRect().top/distance),index=p>=.999?3:Math.min(3,Math.floor(p*3));section.dataset.activeStep=String(index+1);section.style.setProperty('--process-progress',String(p));timeline.style.setProperty('--process-progress',String(p));
 const box=timeline.getBoundingClientRect(),centers=rows.map(row=>{const dot=row.querySelector('.process-number').getBoundingClientRect();return dot.top+dot.height/2;});rail.style.top=(centers[0]-box.top)+'px';rail.style.height=(centers.at(-1)-centers[0])+'px';
 rows.forEach((row,i)=>{row.classList.toggle('is-reached',staticMode||i<=index);row.classList.toggle('is-current',staticMode||i===index);row.style.setProperty('--step-reveal',staticMode||i===index?'1':'0');row.querySelector('.process-card').setAttribute('aria-hidden',String(!staticMode&&i!==index));if(!staticMode&&i===index)row.setAttribute('aria-current','step');else row.removeAttribute('aria-current');});section.classList.toggle('process-complete',p>=.999);
 }
 function queue(){if(!pending){pending=true;requestAnimationFrame(render);}}addEventListener('scroll',queue,{passive:true});addEventListener('resize',measure);reduce.addEventListener('change',measure);document.fonts.ready.then(measure);measure();
})();

(() => {
 const panel=document.querySelector('.closing-marquee-panel');if(!panel)return;panel.dataset.visible='true';
})();
