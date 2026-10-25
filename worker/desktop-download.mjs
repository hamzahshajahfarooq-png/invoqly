// Immutable installer parts stay below the static asset size limit. The public
// endpoint streams them as one executable, including bounded HTTP byte ranges.
export async function desktopDownload(request,env){
 const url=new URL(request.url);
 if(url.pathname==='/download.exe'||url.pathname==='/downloads/Invoqly-Setup.exe')return Response.redirect(url.origin+'/downloads/windows/1.4.1/Invoqly-Setup.exe',302);
 if(!/^\/downloads\/windows\/\d+\.\d+\.\d+\/Invoqly-Setup\.exe$/.test(url.pathname))return null;
 if(!['GET','HEAD'].includes(request.method))return new Response('Method not allowed',{status:405});
 const base=url.pathname.replace('/Invoqly-Setup.exe','');
 const manifestResponse=await env.ASSETS.fetch(new Request(url.origin+base+'/manifest.json'));
 if(!manifestResponse.ok)return new Response('Download unavailable',{status:404});
 let m;try{m=await manifestResponse.json();}catch{return new Response('Download unavailable',{status:404});}
 if(!Number.isSafeInteger(m.size)||m.size<=0||!Array.isArray(m.parts)||!m.parts.length)return new Response('Download unavailable',{status:503});
 let start=0,end=m.size-1,status=200;
 const range=request.headers.get('range');
 const h={'Content-Type':'application/octet-stream','Content-Disposition':'attachment; filename="Invoqly-Setup.exe"','Accept-Ranges':'bytes','Cache-Control':'public, max-age=31536000, immutable','X-Content-Type-Options':'nosniff','ETag':'"'+m.sha256+'"'};
 if(range){const r=/^bytes=(\d*)-(\d*)$/.exec(range);if(!r||(!r[1]&&!r[2]))return new Response(null,{status:416,headers:{'Content-Range':'bytes */'+m.size}});
  if(!r[1])start=Math.max(0,m.size-Number(r[2]));else{start=Number(r[1]);if(r[2])end=Math.min(end,Number(r[2]));}
  if(!Number.isSafeInteger(start)||!Number.isSafeInteger(end)||start>end||start>=m.size)return new Response(null,{status:416,headers:{'Content-Range':'bytes */'+m.size}});
  status=206;h['Content-Range']=`bytes ${start}-${end}/${m.size}`;
 }
 h['Content-Length']=String(end-start+1);if(request.method==='HEAD')return new Response(null,{status,headers:h});
 let offset=0;const selected=[];
 for(let i=0;i<m.parts.length;i++){const size=m.parts[i];if(offset<=end&&offset+size>start)selected.push({i,start:Math.max(0,start-offset),end:Math.min(size-1,end-offset)});offset+=size;}
 // Workers Assets may ignore Range and return the complete part. Slice that
 // bounded 16 MiB part locally rather than treating its valid 200 as failure.
 const body=new ReadableStream({async pull(controller){try{
  const part=selected.shift();if(!part){controller.close();return;}
  const response=await env.ASSETS.fetch(new Request(url.origin+base+'/part-'+part.i+'.bin',{headers:{Range:`bytes=${part.start}-${part.end}`}}));
  if(response.status!==200&&response.status!==206)throw Error('Missing installer part');
  const bytes=new Uint8Array(await response.arrayBuffer());
  controller.enqueue(response.status===206?bytes:bytes.subarray(part.start,part.end+1));
 }catch(e){controller.error(e);}}});
 return new Response(body,{status,headers:h});
}
