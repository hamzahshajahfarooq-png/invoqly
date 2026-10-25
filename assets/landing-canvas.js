(() => {
 'use strict';
 const reduced=matchMedia('(prefers-reduced-motion: reduce)'),clamp=x=>Math.max(0,Math.min(1,x)),ease=x=>x*x*(3-2*x),mix=(a,b,p)=>a+(b-a)*p;
 function scene(kind){
  const hero=kind==='hero',track=document.querySelector(hero?'.orchestration-scroll':'.resolution-story');if(!track)return;
  const section=hero?document.querySelector('.demo-hero'):track;section.classList.add('canvas-'+kind);
  const stage=track.querySelector(hero?'.orchestration-stage':'.resolution-stage'),copy=stage.querySelector(hero?'.hero-center':'.resolution-heading'),main=[...stage.querySelectorAll(hero?'.orbit-card':'.resolve-card')],extras=[...stage.querySelectorAll(hero?'.hero-detail,.scene-slip':'.scene-scrap')],svg=stage.querySelector(hero?'.orbit-wires svg':'.resolution-wires'),base=svg.querySelector(hero?'.wire-tracks':'.resolution-wire-base'),fill=svg.querySelector(hero?'.wire-progress':'.resolution-wire-fill');
  let geometry,distance=1400,pending=false;const ns='http://www.w3.org/2000/svg',lines=main.map(()=>{const a=document.createElementNS(ns,'path'),b=document.createElementNS(ns,'path');b.setAttribute('pathLength','1');base.append(a);fill.append(b);return {a,b};});
  const placements=[[.04,.2,-13],[.76,.17,12],[.37,.37,-9],[.65,.58,9],[.06,.64,8],[.52,.24,-10],[.82,.7,-7],[.22,.52,12],[.53,.74,-5],[.12,.1,9],[.73,.4,-12],[.29,.75,6],[.86,.48,10],[.43,.12,-7]];
  function measure(){
   const w=stage.clientWidth,h=innerHeight,mobile=w<=1000;stage.style.height=h+'px';distance=Math.max(1300,h*1.7);track.style.height=(h+(reduced.matches?0:distance+220))+'px';
   const cardW=main[0].offsetWidth,cardH=main[0].offsetHeight,gap=mobile?12:18,cols=hero?(mobile?2:4):(mobile?2:4),rows=Math.ceil(main.length/cols),dock=hero?(mobile?74:155):70;
   const totalW=cols*cardW+(cols-1)*gap,left=(w-totalW)/2,top=h-dock-rows*cardH-(rows-1)*gap;
   const targets=main.map((el,i)=>({x:left+i%cols*(cardW+gap),y:top+Math.floor(i/cols)*(cardH+gap)}));
   const extraTargets=extras.map((el,i)=>{const columns=hero?5:4,ew=el.offsetWidth;return {x:(w-(columns*ew+(columns-1)*12))/2+i%columns*(ew+12),y:hero?h-126+Math.floor(i/columns)*47:h-145};});
   const all=[...main,...extras],starts=all.map((el,i)=>{const pos=placements[(i+(hero?0:3))%placements.length];return {x:Math.min(w-el.offsetWidth-12,Math.max(12,pos[0]*w)),y:Math.min(h-el.offsetHeight-40,Math.max(105,pos[1]*h)),r:pos[2]};});
   // Fit the settled copy above its dock at normal browser zoom. Measure its
   // real contents: headings can wrap and subtitles may exceed their wrapper.
   stage.style.setProperty('--assembled','1');
   copy.style.transform='translateX(-50%)';
   const copyEnd=hero?(mobile?94:100):(mobile?100:105),copyBox=copy.getBoundingClientRect();
   const copyParts=hero?[...copy.querySelectorAll('.canvas-copy-after,.hero-ctas,.hero-trust')]:[...copy.querySelectorAll('.resolution-after h2,.resolution-after p')];
   const rawHeight=Math.max(copy.offsetHeight,...copyParts.filter(el=>getComputedStyle(el).display!=='none').map(el=>el.getBoundingClientRect().bottom-copyBox.top));
   const copyScale=Math.min(1,(top-copyEnd-26)/Math.max(rawHeight,1));
   geometry={w,h,mobile,targets,extraTargets,starts,copyScale,copyStart:hero?Math.max(135,(h-copy.offsetHeight)*.43):Math.max(130,h*.3),copyEnd};
   if(hero){const hub=stage.querySelector('.workflow-hub');hub.style.top=(top-54)+'px';hub.style.bottom='auto';}
   svg.setAttribute('viewBox','0 0 '+w+' '+h);targets.forEach((t,i)=>{const x=t.x+cardW/2,y=hero?t.y:t.y+cardH,m=w/2,end=hero?top-25:h-45,bend=hero?end+12:Math.max(y+8,end-20);const d='M'+x+' '+y+' V'+bend+' H'+m+' V'+end;lines[i].a.setAttribute('d',d);lines[i].b.setAttribute('d',d);});render();
  }
  function render(){pending=false;if(!geometry)return;const g=geometry,p=reduced.matches?1:clamp(-track.getBoundingClientRect().top/distance),settle=ease(clamp((p-.1)/.62)),wire=ease(clamp((p-.62)/.3));stage.dataset.sceneProgress=p.toFixed(3);track.dataset.storyState=p>.48?'solution':'problem';
   stage.style.setProperty('--assembled',settle);stage.style.setProperty('--connected',wire);track.style.setProperty('--resolved',hero?0:ease(clamp((p-.3)/.45)));track.style.setProperty('--wired',wire);track.style.setProperty('--before-opacity',String(clamp(1-(p-.27)/.19)));track.style.setProperty('--after-opacity',String(clamp((p-.49)/.19)));
   copy.style.top=mix(g.copyStart,g.copyEnd,ease(p))+'px';
   copy.style.transform='translateX(-50%) scale('+mix(1,g.copyScale,settle)+')';
   copy.style.transformOrigin='top center';
   [...main,...extras].forEach((el,i)=>{const extra=i>=main.length,idx=i-main.length,a=g.starts[i],b=extra?g.extraTargets[idx]:g.targets[i],fade=extra&&g.mobile?1-settle:1;el.style.opacity=String(fade);el.style.transform='translate('+mix(a.x,b.x,settle)+'px,'+mix(a.y,b.y,settle)+'px) rotate('+(a.r*(1-settle))+'deg)';});
   lines.forEach((line,i)=>{line.b.style.strokeDashoffset=String(1-clamp((wire-i*.035)/.75));});
   if(hero){track.querySelectorAll('.canvas-copy-before').forEach(el=>el.setAttribute('aria-hidden',String(p>.48)));track.querySelectorAll('.canvas-copy-after').forEach(el=>el.setAttribute('aria-hidden',String(p<=.48)));track.querySelectorAll('.hero-ctas a').forEach(el=>{el.tabIndex=p>.6?0:-1;el.style.pointerEvents=p>.6?'auto':'none';});}
   if(!hero){track.querySelectorAll('.resolve-before,.resolution-before').forEach(el=>el.setAttribute('aria-hidden',String(p>.48)));track.querySelectorAll('.resolve-after,.resolution-after').forEach(el=>el.setAttribute('aria-hidden',String(p<=.48)));}
  }
  function queue(){if(!pending){pending=true;requestAnimationFrame(render);}}addEventListener('scroll',queue,{passive:true});addEventListener('resize',measure);reduced.addEventListener('change',measure);document.fonts.ready.then(measure);measure();
 }
 scene('hero');scene('problem');
})();
