const {test}=require('node:test');const assert=require('node:assert/strict');
test('Installer endpoint streams complete bytes and HTTP ranges across parts',async()=>{
 const {desktopDownload}=await import('../../worker/desktop-download.mjs');const bytes=Buffer.from('MZinvoqly-installer-bytes');const parts=[bytes.subarray(0,8),bytes.subarray(8,16),bytes.subarray(16)];let partCalls=0;
 const env={ASSETS:{fetch:async r=>{const p=new URL(r.url).pathname;if(p.endsWith('manifest.json'))return Response.json({size:bytes.length,sha256:'abc',parts:parts.map(b=>b.length)});const i=/part-(\d+)\.bin$/.exec(p)?.[1];if(i==null)return new Response(null,{status:404});partCalls++;const [,a,b]=/bytes=(\d+)-(\d+)/.exec(r.headers.get('range'));return new Response(parts[i].subarray(Number(a),Number(b)+1),{status:206});}}};
 const originalFetch=env.ASSETS.fetch;const fallback={ASSETS:{fetch:async r=>{const i=/part-(\d+)\.bin$/.exec(new URL(r.url).pathname)?.[1];return i==null?originalFetch(r):new Response(parts[i],{status:200});}}};
 const url='https://invoqly.top/downloads/windows/1.0.0/Invoqly-Setup.exe';
 let ignoredRange=await desktopDownload(new Request(url,{headers:{Range:'bytes=5-20'}}),fallback);assert.deepEqual(Buffer.from(await ignoredRange.arrayBuffer()),bytes.subarray(5,21));
 let r=await desktopDownload(new Request(url),env);assert.equal(r.status,200);assert.deepEqual(Buffer.from(await r.arrayBuffer()),bytes);
 r=await desktopDownload(new Request(url,{headers:{Range:'bytes=5-20'}}),env);assert.equal(r.status,206);assert.deepEqual(Buffer.from(await r.arrayBuffer()),bytes.subarray(5,21));
 r=await desktopDownload(new Request(url,{headers:{Range:'bytes=-4'}}),env);assert.deepEqual(Buffer.from(await r.arrayBuffer()),bytes.subarray(-4));
 r=await desktopDownload(new Request(url,{headers:{Range:'bytes=999-'}}),env);assert.equal(r.status,416);
 const n=partCalls;r=await desktopDownload(new Request(url,{method:'HEAD'}),env);assert.equal(partCalls,n);assert.equal(r.headers.get('content-length'),String(bytes.length));
 r=await desktopDownload(new Request('https://invoqly.top/download.exe'),env);assert.equal(r.status,302);
 assert.equal(await desktopDownload(new Request('https://invoqly.top/api/billing/portal'),env),null);
});
