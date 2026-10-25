const {ipcRenderer}=require('electron');
// Decorative shader runs in the isolated preload, with no page or Node API bridge.
function signinShader(){
 const canvas=document.createElement('canvas');canvas.id='desktopSigninShader';canvas.setAttribute('aria-hidden','true');canvas.dataset.renderer='fallback';document.body.prepend(canvas);
 const gl=canvas.getContext('webgl',{alpha:false,antialias:false,depth:false,stencil:false,powerPreference:'low-power'});if(!gl)return;
 const vertex=gl.createShader(gl.VERTEX_SHADER),fragment=gl.createShader(gl.FRAGMENT_SHADER),program=gl.createProgram(),buffer=gl.createBuffer();let frame=0,last=-100,elapsed=0,previous=0,disposed=false;
 const motion=matchMedia('(prefers-reduced-motion: reduce)');
 gl.shaderSource(vertex,'attribute vec2 position;void main(){gl_Position=vec4(position,0.,1.);}');gl.compileShader(vertex);
 gl.shaderSource(fragment,`precision mediump float;
 uniform vec2 resolution;uniform float time;
 float wave(vec2 p){return sin(p.x*2.1+sin(p.y*1.8))*.5+sin(p.y*2.7-p.x*.8)*.25;}
 void main(){
  vec2 uv=gl_FragCoord.xy/resolution;vec2 p=(uv-.5)*vec2(resolution.x/resolution.y,1.);
  float t=time*.075;vec2 flow=p+vec2(wave(p*1.7+t),wave(p.yx*1.4-t))*.15;
  vec2 a=flow-vec2(-.50+sin(t)*.13,-.24+cos(t*.8)*.12);
  vec2 b=flow-vec2(.56+cos(t*.7)*.16,.28+sin(t)*.12);
  float emerald=exp(-dot(a*vec2(.95,1.35),a*vec2(.95,1.35))*3.1);
  float sage=exp(-dot(b*vec2(1.1,1.0),b*vec2(1.1,1.0))*4.2);
  float ribbon=exp(-pow(flow.y+.22*sin(flow.x*2.5+t)-.05,2.)*28.)*.22;
  vec3 color=vec3(.055,.082,.065)+vec3(.045,.21,.115)*emerald+vec3(.16,.20,.095)*sage;
  color+=vec3(.055,.095,.05)*ribbon;
  float vignette=1.-smoothstep(.25,1.15,length(uv-.5));color*=.68+.32*vignette;
  float grain=fract(sin(dot(gl_FragCoord.xy,vec2(12.9898,78.233)))*43758.5453);color+=(grain-.5)*.009;
  gl_FragColor=vec4(color,1.);
 }`);gl.compileShader(fragment);gl.attachShader(program,vertex);gl.attachShader(program,fragment);gl.linkProgram(program);
 if(!gl.getShaderParameter(vertex,gl.COMPILE_STATUS)||!gl.getShaderParameter(fragment,gl.COMPILE_STATUS)||!gl.getProgramParameter(program,gl.LINK_STATUS)){gl.deleteShader(vertex);gl.deleteShader(fragment);gl.deleteProgram(program);gl.deleteBuffer(buffer);return;}
 gl.useProgram(program);gl.bindBuffer(gl.ARRAY_BUFFER,buffer);gl.bufferData(gl.ARRAY_BUFFER,new Float32Array([-1,-1,1,-1,-1,1,-1,1,1,-1,1,1]),gl.STATIC_DRAW);const position=gl.getAttribLocation(program,'position');gl.enableVertexAttribArray(position);gl.vertexAttribPointer(position,2,gl.FLOAT,false,0,0);const size=gl.getUniformLocation(program,'resolution'),time=gl.getUniformLocation(program,'time');
 function paint(){if(disposed||gl.isContextLost())return;gl.uniform2f(size,canvas.width,canvas.height);gl.uniform1f(time,elapsed/1000);gl.drawArrays(gl.TRIANGLES,0,6);canvas.dataset.renderer='webgl';canvas.dataset.frame=String(Number(canvas.dataset.frame||0)+1);}
 function tick(stamp){if(disposed)return;if(document.hidden||motion.matches){sync();return;}frame=requestAnimationFrame(tick);if(stamp-last<33)return;if(previous)elapsed+=Math.min(stamp-previous,100);previous=stamp;last=stamp;paint();}
 function sync(){cancelAnimationFrame(frame);previous=0;canvas.dataset.motion=motion.matches?'reduced':'animated';paint();if(!document.hidden&&!motion.matches)frame=requestAnimationFrame(tick);}
 function resize(){const scale=Math.min(1,960/innerWidth,600/innerHeight);canvas.width=Math.max(1,Math.round(innerWidth*scale));canvas.height=Math.max(1,Math.round(innerHeight*scale));gl.viewport(0,0,canvas.width,canvas.height);paint();}
 function dispose(){disposed=true;cancelAnimationFrame(frame);removeEventListener('resize',resize);document.removeEventListener('visibilitychange',sync);motion.removeEventListener('change',sync);gl.deleteBuffer(buffer);gl.deleteProgram(program);gl.deleteShader(vertex);gl.deleteShader(fragment);}
 canvas.addEventListener('webglcontextlost',e=>{e.preventDefault();cancelAnimationFrame(frame);canvas.dataset.renderer='fallback';});
 addEventListener('resize',resize);document.addEventListener('visibilitychange',sync);motion.addEventListener('change',sync);addEventListener('pagehide',dispose,{once:true});resize();sync();
}
// No Node, filesystem, arbitrary IPC, or token API is exposed to page scripts.
// All messages are checked again against the top-level sender in main.
if(process.isMainFrame){
 window.addEventListener('DOMContentLoaded',()=>{if(/^\/login(?:\.php|\.html)?$/.test(location.pathname))signinShader();});
 ipcRenderer.on('invoqly:signin-link',(_event,url)=>{let u;try{u=new URL(url);}catch{return;}if(!(u.protocol==='https:'&&['invoqly.top','gugiuxcjovynshxnquih.supabase.co'].includes(u.hostname)||u.origin===location.origin&&['localhost','127.0.0.1'].includes(u.hostname)))return;let box=document.getElementById('desktopSigninLink');if(!box){box=document.createElement('section');box.id='desktopSigninLink';box.innerHTML='<p>Browser not opening? Copy this sign-in link.</p><input id="desktopSigninURL" readonly aria-label="Browser sign-in link"><div><button type="button" id="copyDesktopSignin">Copy sign-in link</button><button type="button" id="openDesktopSignin">Open browser again</button></div><p id="desktopCopyStatus" role="status"></p>';const anchor=document.getElementById('desktopBrowserSignin');if(anchor)anchor.after(box);else(document.querySelector('.form-wrap')||document.body).append(box);box.querySelector('#copyDesktopSignin').onclick=async()=>{const input=box.querySelector('input'),status=box.querySelector('#desktopCopyStatus');try{await navigator.clipboard.writeText(input.value);status.textContent='Sign-in link copied.';}catch{input.select();status.textContent='Select the link and press Ctrl+C to copy it.';}};box.querySelector('#openDesktopSignin').onclick=()=>ipcRenderer.send('invoqly:open-signin');}box.querySelector('input').value=u.href;});
 window.addEventListener('DOMContentLoaded',()=>{if(!/^\/login(?:\.php|\.html)?$/.test(location.pathname))return;document.body.dataset.desktopAuth='true';const title=document.getElementById('form-title');if(title)title.textContent='Sign in to access your workspace';const heading=document.querySelector('.form-head');if(heading){const logo=document.createElement('img');logo.src='/assets/invoqly-mark.svg';logo.alt='Invoqly';logo.className='desktop-auth-logo';heading.prepend(logo);}const google=document.getElementById('googleButton');if(google){const b=document.createElement('button');b.type='button';b.className='google';b.id='desktopBrowserSignin';b.textContent='Sign in through browser';google.after(b);const email=document.createElement('button');email.type='button';email.className='google';email.id='desktopEmailSignin';email.textContent='Sign in with email';email.onclick=()=>{document.body.classList.add('desktop-email-open');email.hidden=true;document.querySelector('input[name="email"]')?.focus();};b.after(email);}const label=document.getElementById('submitLabel');if(label)label.textContent='Send sign-in code';});
 window.addEventListener('DOMContentLoaded',()=>{const controls=document.createElement('div');controls.id='invoqly-app-controls';controls.setAttribute('role','group');controls.setAttribute('aria-label','App controls');controls.innerHTML='<button type="button" data-desktop-action="reload">Refresh</button><button type="button" data-desktop-action="updates">Updates</button><button type="button" id="invoqly-app-options" data-desktop-action="menu" aria-label="App options" title="App options · printing and support">•••</button>';const dock=document.querySelector('.nav-end,.header-right,.nav-actions');if(dock){controls.dataset.docked='true';dock.append(controls);}else document.body.append(controls);});
 document.addEventListener('click',event=>{
  const action=event.target.closest?.('[data-desktop-action]')?.dataset.desktopAction;if(action){event.preventDefault();ipcRenderer.send('invoqly:action',action);return;}
  const el=event.target.closest?.('#googleButton,#googleSwitch,[data-desktop-google]');
  if(el){event.preventDefault();event.stopImmediatePropagation();ipcRenderer.send('invoqly:google');}
  if(event.target.closest?.('#desktopBrowserSignin')){event.preventDefault();event.stopImmediatePropagation();ipcRenderer.send('invoqly:browser');}
  if(event.target.closest?.('#desktopRetry'))ipcRenderer.send('invoqly:retry');
 },true);
 window.addEventListener('offline',()=>ipcRenderer.send('invoqly:offline'));
 window.addEventListener('online',()=>ipcRenderer.send('invoqly:online'));
}


