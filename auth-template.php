<?php
declare(strict_types=1);

function renderAuth(string $mode): void
{
    $isSignup = $mode === 'signup';
    $lang = (($_GET['lang'] ?? getenv('INVOQLY_LANG') ?: 'en') === 'ar') ? 'ar' : 'en';
    $rtl = $lang === 'ar';
    $t = static fn(string $en, string $ar): string => htmlspecialchars($rtl ? $ar : $en, ENT_QUOTES, 'UTF-8');
    $switchUrl = ($isSignup ? 'signup.php' : 'login.php') . '?lang=' . ($rtl ? 'en' : 'ar');
    $alternateUrl = $isSignup ? 'login.php' : 'signup.php';
?>
<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $rtl ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#F3F2EC">
  <meta name="description" content="<?= $t($isSignup ? 'Create your Invoqly account.' : 'Sign in to Invoqly.', $isSignup ? 'أنشئ حسابك في إنفوكلي.' : 'سجّل الدخول إلى إنفوكلي.') ?>">
  <title><?= $t($isSignup ? 'Create account — Invoqly' : 'Sign in — Invoqly', $isSignup ? 'إنشاء حساب — إنفوكلي' : 'تسجيل الدخول — إنفوكلي') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,400;1,9..144,600&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--paper:#F3F2EC;--paper-deep:#E5E9DE;--ink:#111713;--muted:#667069;--line:rgba(17,23,19,.14);--mint:#A6F46B;--green:#246B37;--deep:#163D25;--white:#FCFCF8;--serif:'Fraunces','IBM Plex Sans Arabic',serif;--sans:'Inter','IBM Plex Sans Arabic',sans-serif}
    *{box-sizing:border-box}html{color-scheme:light}body{margin:0;min-width:320px;background:var(--paper);color:var(--ink);font-family:var(--sans);-webkit-font-smoothing:antialiased}button,input{font:inherit}a{color:inherit;text-decoration:none}::selection{background:var(--mint);color:var(--ink)}
    .skip{position:fixed;inset-inline-start:-999px;top:8px;z-index:100;background:var(--ink);color:#fff;padding:10px 16px;border-radius:999px}.skip:focus{inset-inline-start:8px}
    .nav{position:sticky;top:0;z-index:50;height:68px;border-bottom:1px solid var(--line);background:rgba(243,242,236,.86);backdrop-filter:blur(18px) saturate(150%)}
    .nav-in{width:min(1240px,100%);height:100%;margin:auto;padding-inline:clamp(20px,4vw,40px);display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:20px}
    .brand{display:flex;align-items:center;gap:10px;width:max-content;font-size:19px;font-weight:800;letter-spacing:-.05em}.brand-mark{width:35px;height:28px;display:block;flex:none;object-fit:contain}.brand-dot{color:var(--green)}
    .nav-links{display:flex;gap:28px;font-size:13px;font-weight:600;color:var(--muted)}.nav-links a{background:linear-gradient(var(--green),var(--green)) 0 100%/0 1px no-repeat;transition:color .2s,background-size .25s}.nav-links a:hover{color:var(--ink);background-size:100% 1px}
    .nav-end{display:flex;align-items:center;justify-content:flex-end;gap:10px}.lang{min-width:44px;min-height:38px;display:grid;place-items:center;border:1px solid var(--line);border-radius:999px;font-size:12px;font-weight:700}.nav-question{font-size:12px;color:var(--muted)}.outline{min-height:40px;display:inline-flex;align-items:center;padding-inline:17px;border:1px solid rgba(36,107,55,.35);border-radius:999px;color:var(--green);font-size:12px;font-weight:700;transition:.2s}.outline:hover{border-color:var(--green);background:rgba(166,244,107,.2)}
    .shell{width:min(1240px,100%);min-height:calc(100vh - 68px);margin:auto;padding:24px clamp(20px,4vw,40px) 40px;display:grid;grid-template-columns:1.05fr .95fr}
    .editorial{position:relative;isolation:isolate;overflow:hidden;min-height:720px;padding:clamp(36px,5vw,72px);display:flex;flex-direction:column;justify-content:space-between;border:1px solid var(--line);border-inline-end:0;border-radius:28px 0 0 28px;background:radial-gradient(circle at 15% 10%,rgba(166,244,107,.48),transparent 32%),radial-gradient(circle at 80% 70%,rgba(36,107,55,.14),transparent 42%),var(--paper-deep)}
    [dir=rtl] .editorial{border-radius:0 28px 28px 0;border-inline-start:0;border-inline-end:1px solid var(--line)}
    .editorial::after{content:"";position:absolute;inset:0;z-index:-1;opacity:.35;mix-blend-mode:multiply;background-image:radial-gradient(rgba(17,23,19,.16) .6px,transparent .7px);background-size:4px 4px;pointer-events:none}
    .kicker{display:flex;align-items:center;gap:10px;font-size:11px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--green)}.kicker::before{content:"";width:9px;height:2px;background:currentColor}
    .edition{margin-bottom:16px;font-size:10px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--muted)}
    .welcome{max-width:620px;margin:0;font-family:var(--serif);font-size:clamp(3.3rem,6.4vw,5.9rem);font-weight:300;line-height:.91;letter-spacing:-.055em}.welcome em{display:block;color:var(--green);font-weight:400}[dir=rtl] .welcome{line-height:1.12;letter-spacing:-.02em}.editorial-sub{max-width:520px;margin:24px 0 0;font-family:var(--serif);font-size:clamp(1.08rem,2vw,1.4rem);font-weight:300;line-height:1.5;color:#354139}
    .quote{max-width:520px;margin:0;padding-top:28px;border-top:1px solid transparent;border-image:linear-gradient(90deg,rgba(17,23,19,.25),transparent) 1}.quote blockquote{position:relative;margin:0;padding-inline-start:30px;font-family:var(--serif);font-size:17px;font-weight:300;line-height:1.55}.quote-mark{position:absolute;inset-inline-start:0;top:-10px;color:var(--green);font-family:var(--serif);font-size:48px;font-style:italic}.person{display:flex;align-items:center;gap:11px;margin-top:18px;font-size:11px;font-weight:600;color:var(--muted)}.person-avatar{width:36px;height:36px;display:grid;place-items:center;border-radius:50%;background:rgba(36,107,55,.14);color:var(--green);font-family:var(--serif);font-style:italic;font-size:16px}
    .form-panel{min-height:720px;padding:clamp(38px,6vw,76px);display:flex;align-items:center;border:1px solid var(--line);border-radius:0 28px 28px 0;background:rgba(252,252,248,.72)}[dir=rtl] .form-panel{border-radius:28px 0 0 28px}
    .form-wrap{width:min(400px,100%);margin:auto}.form-head{display:flex;align-items:flex-start;justify-content:space-between;gap:20px}.overline{font-size:10px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--green)}.form-head h1{margin:6px 0 0;font-family:var(--serif);font-size:34px;font-weight:400;letter-spacing:-.035em}.index{color:rgba(36,107,55,.22);font-family:var(--serif);font-size:42px;font-variant-numeric:tabular-nums;line-height:1}.trial-note{margin:10px 0 0;color:var(--muted);font-size:12px;line-height:1.5}
    .google{position:relative;isolation:isolate;overflow:hidden;width:100%;min-height:50px;margin-top:28px;display:flex;align-items:center;justify-content:center;gap:11px;border:1px solid var(--line);border-radius:14px;background:rgba(255,255,255,.64);color:var(--ink);font-weight:600;cursor:pointer;transition:transform .18s,border-color .2s,background .2s,box-shadow .2s}.google::before{content:"";position:absolute;inset:0;z-index:-1;background:rgba(166,244,107,.34);transform:translateX(-102%);transition:transform .22s ease}[dir=rtl] .google::before{transform:translateX(102%)}.google:hover::before,[dir=rtl] .google:hover::before{transform:none}.google:hover{transform:translateY(-2px);border-color:rgba(17,23,19,.3);box-shadow:0 12px 26px rgba(17,23,19,.08)}.google:active{transform:scale(.98)}
    .divider{display:flex;align-items:center;gap:12px;margin:24px 0;color:#828A84;font-size:9px;font-weight:700;letter-spacing:.17em;text-transform:uppercase}.divider::before,.divider::after{content:"";height:1px;flex:1;background:var(--line)}
    form{display:grid;gap:17px}.field label{display:flex;justify-content:space-between;margin-bottom:7px;font-size:12px;font-weight:700}.field a{color:var(--green);font-weight:600}.input-wrap{position:relative}.field input{width:100%;min-height:50px;padding:0 14px;border:1px solid var(--line);border-radius:14px;background:rgba(255,255,255,.64);color:var(--ink);outline:0;transition:.2s}.field input::placeholder{color:#979E99}.field input:focus{border-color:var(--green);background:#fff;box-shadow:0 0 0 4px rgba(36,107,55,.1)}.password input{padding-inline-end:48px}.eye{position:absolute;inset-inline-end:5px;top:5px;width:40px;height:40px;display:grid;place-items:center;border:0;border-radius:50%;background:transparent;color:var(--muted);cursor:pointer}.eye:hover{background:rgba(17,23,19,.06);color:var(--ink)}
    .check{display:flex;align-items:center;gap:10px;width:max-content;max-width:100%;font-size:12px;color:var(--muted);cursor:pointer}.check input{position:absolute;opacity:0}.check-box{width:19px;height:19px;display:grid;place-items:center;flex:none;border:1px solid rgba(36,107,55,.45);border-radius:6px;background:#fff;transition:.18s}.check input:checked+.check-box{background:var(--green);border-color:var(--green)}.check svg{opacity:0;color:#fff}.check input:checked+.check-box svg{opacity:1}.check input:focus-visible+.check-box{box-shadow:0 0 0 4px rgba(36,107,55,.13)}
    .submit{position:relative;isolation:isolate;overflow:hidden;width:100%;min-height:52px;border:0;border-radius:14px;background:var(--ink);color:#fff;font-weight:700;cursor:pointer;transition:transform .18s,color .2s,box-shadow .2s}.submit::before{content:"";position:absolute;inset:0;z-index:-1;background:var(--mint);transform:translateX(-102%);transition:transform .22s ease}[dir=rtl] .submit::before{transform:translateX(102%)}.submit:hover{transform:translateY(-2px);color:var(--ink);box-shadow:0 14px 28px rgba(17,23,19,.16)}.submit:hover::before,[dir=rtl] .submit:hover::before{transform:none}.submit:active{transform:scale(.98)}.submit:disabled,.google:disabled{cursor:wait;opacity:.65}
    .switch{text-align:center;margin-top:22px;font-size:12px;color:var(--muted)}.switch a,.legal a{color:var(--green);font-weight:700;background:linear-gradient(var(--green),var(--green)) 0 100%/0 1px no-repeat;transition:background-size .25s}.switch a:hover,.legal a:hover{background-size:100% 1px}.legal{margin-top:18px;text-align:center;font-size:10.5px;line-height:1.6;color:#8A918C}.status{min-height:20px;margin-top:12px;text-align:center;font-size:12px;color:var(--green)}
    :focus-visible{outline:2px solid var(--green);outline-offset:3px}
    @media(max-width:900px){.nav-in{grid-template-columns:1fr auto}.nav-links,.nav-question{display:none}.shell{grid-template-columns:1fr;max-width:720px}.form-panel{order:1;min-height:auto;border-radius:24px 24px 0 0;padding-block:58px}.editorial{order:2;min-height:600px;border-inline-end:1px solid var(--line);border-top:0;border-radius:0 0 24px 24px}[dir=rtl] .form-panel{border-radius:24px 24px 0 0}[dir=rtl] .editorial{border-inline-start:1px solid var(--line);border-radius:0 0 24px 24px}}
    @media(max-width:560px){.nav-end .outline{display:none}.shell{padding:0}.form-panel,.editorial{border-inline:0;border-radius:0!important}.form-panel{padding:44px 22px}.editorial{min-height:570px;padding:40px 24px}.welcome{font-size:clamp(3.1rem,16vw,4.6rem)}.quote blockquote{font-size:15px}}
    @media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition-duration:.01ms!important;animation-duration:.01ms!important}}
  </style>
</head>
<body>
  <a class="skip" href="#auth"><?= $t('Skip to sign in', 'انتقل إلى تسجيل الدخول') ?></a>
  <header class="nav">
    <div class="nav-in">
      <a class="brand" href="index.php?lang=<?= $lang ?>" aria-label="<?= $t('Invoqly home', 'الصفحة الرئيسية لإنفوكلي') ?>"><img class="brand-mark" src="assets/invoqly-mark.svg" alt=""><span><?= $t('Invoqly', 'إنفوكلي') ?><span class="brand-dot">.</span></span></a>
      <nav class="nav-links" aria-label="<?= $t('Main navigation', 'التنقل الرئيسي') ?>">
        <a href="index.php#how"><?= $t('How it works', 'كيف يعمل') ?></a><a href="index.php#pricing"><?= $t('Pricing', 'الأسعار') ?></a><a href="index.php#faq"><?= $t('FAQ', 'الأسئلة الشائعة') ?></a>
      </nav>
      <div class="nav-end">
        <a class="lang" href="<?= $switchUrl ?>" lang="<?= $rtl ? 'en' : 'ar' ?>"><?= $rtl ? 'EN' : 'عربي' ?></a>
        <span class="nav-question"><?= $t($isSignup ? 'Already a member?' : 'New here?', $isSignup ? 'لديك حساب؟' : 'مستخدم جديد؟') ?></span>
        <a class="outline" href="<?= $alternateUrl ?>?lang=<?= $lang ?>"><?= $t($isSignup ? 'Sign in' : 'Create account', $isSignup ? 'تسجيل الدخول' : 'إنشاء حساب') ?></a>
      </div>
    </div>
  </header>
  <main class="shell">
    <section class="editorial" aria-labelledby="editorial-title">
      <div class="kicker"><?= $t('Bilingual invoicing, made clear', 'فوترة ثنائية اللغة، بكل وضوح') ?></div>
      <div>
        <div class="edition"><?= $t($isSignup ? 'Free trial · No setup fee' : 'Your invoice workspace · Secure access', $isSignup ? 'تجربة مجانية · دون رسوم إعداد' : 'مساحة فواتيرك · دخول آمن') ?></div>
        <h2 class="welcome" id="editorial-title"><?= $t($isSignup ? 'Start with' : 'Welcome', $isSignup ? 'ابدأ' : 'مرحبًا') ?> <em><?= $t($isSignup ? 'clarity.' : 'back.', $isSignup ? 'بوضوح.' : 'بعودتك.') ?></em></h2>
        <p class="editorial-sub"><?= $t($isSignup ? 'One place to create bilingual invoices, bill international clients and follow every payment.' : 'Your invoices, clients and payment activity are waiting exactly where you left them.', $isSignup ? 'مكان واحد لإنشاء فواتير ثنائية اللغة وفوترة العملاء الدوليين ومتابعة كل دفعة.' : 'فواتيرك وعملاؤك ونشاط المدفوعات في انتظارك تمامًا حيث تركتها.') ?></p>
      </div>
      <figure class="quote">
        <blockquote><span class="quote-mark" aria-hidden="true">“</span><?= $t('Invoicing should feel like a clear conversation with your client, in the language and currency they understand.', 'يجب أن تبدو الفوترة كمحادثة واضحة مع عميلك، باللغة والعملة التي يفهمها.') ?></blockquote>
        <figcaption class="person"><span class="person-avatar">I</span><span><?= $t('The Invoqly product principle', 'مبدأ المنتج في إنفوكلي') ?></span></figcaption>
      </figure>
    </section>

    <section class="form-panel" id="auth" aria-labelledby="form-title">
      <div class="form-wrap">
        <div class="form-head"><div><div class="overline"><?= $t($isSignup ? 'Start your free trial' : 'Member sign in', $isSignup ? 'ابدأ تجربتك المجانية' : 'دخول الأعضاء') ?></div><h1 id="form-title"><?= $t($isSignup ? 'Create your trial account' : 'Sign in', $isSignup ? 'أنشئ حساب تجربتك' : 'تسجيل الدخول') ?></h1><?php if ($isSignup): ?><p class="trial-note"><?= $t('No payment card required. Set up your workspace in minutes.', 'لا تحتاج إلى بطاقة دفع. أنشئ مساحة عملك خلال دقائق.') ?></p><?php endif; ?></div><span class="index" aria-hidden="true"><?= $isSignup ? '02' : '01' ?></span></div>
        <button class="google" type="button" id="googleButton">
          <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path fill="#4285F4" d="M17.64 9.205c0-.638-.057-1.252-.164-1.841H9v3.482h4.844a4.14 4.14 0 0 1-1.797 2.715v2.258h2.909c1.702-1.567 2.684-3.875 2.684-6.614Z"/><path fill="#34A853" d="M9 18c2.43 0 4.468-.806 5.956-2.18l-2.91-2.26c-.806.54-1.835.86-3.046.86-2.344 0-4.328-1.585-5.037-3.714H.956v2.332A9 9 0 0 0 9 18Z"/><path fill="#FBBC05" d="M3.963 10.706A5.41 5.41 0 0 1 3.682 9c0-.592.102-1.168.281-1.706V4.962H.956A9 9 0 0 0 0 9c0 1.452.347 2.827.956 4.038l3.007-2.332Z"/><path fill="#EA4335" d="M9 3.58c1.322 0 2.508.454 3.441 1.345l2.582-2.582C13.464.891 11.426 0 9 0A9 9 0 0 0 .956 4.962l3.007 2.332C4.672 5.165 6.656 3.58 9 3.58Z"/></svg>
          <span><?= $t($isSignup ? 'Start free trial with Google' : 'Continue with Google', $isSignup ? 'ابدأ التجربة المجانية باستخدام Google' : 'المتابعة باستخدام Google') ?></span>
        </button>
        <div class="divider"><?= $t('or with email', 'أو بالبريد الإلكتروني') ?></div>
        <form id="authForm" novalidate>
          <?php if ($isSignup): ?><div class="field"><label for="name"><?= $t('Full name', 'الاسم الكامل') ?></label><input id="name" name="name" type="text" autocomplete="name" required placeholder="<?= $t('Your name', 'اسمك') ?>"></div><?php endif; ?>
          <div class="field"><label for="email"><?= $t('Work email', 'البريد الإلكتروني للعمل') ?></label><input id="email" name="email" type="email" autocomplete="email" required placeholder="you@company.ae"></div>
          <div class="field password"><label for="password"><span><?= $t('Password', 'كلمة المرور') ?></span><?php if (!$isSignup): ?><a href="#"><?= $t('Forgot?', 'نسيت؟') ?></a><?php endif; ?></label><div class="input-wrap"><input id="password" name="password" type="password" autocomplete="<?= $isSignup ? 'new-password' : 'current-password' ?>" minlength="8" required placeholder="<?= $t($isSignup ? 'At least 8 characters' : 'Enter your password', $isSignup ? '٨ أحرف على الأقل' : 'أدخل كلمة المرور') ?>"><button class="eye" type="button" id="togglePassword" aria-label="<?= $t('Show password', 'إظهار كلمة المرور') ?>"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg></button></div></div>
          <button class="submit" type="submit"><?= $t($isSignup ? 'Start my free trial' : 'Sign in to Invoqly', $isSignup ? 'ابدأ تجربتي المجانية' : 'تسجيل الدخول إلى إنفوكلي') ?></button>
        </form>
        <div class="status" id="status" role="status" aria-live="polite"></div>
        <p class="switch"><?= $t($isSignup ? 'Already have an account?' : "Don't have an account?", $isSignup ? 'لديك حساب بالفعل؟' : 'ليس لديك حساب؟') ?> <a href="<?= $alternateUrl ?>?lang=<?= $lang ?>"><?= $t($isSignup ? 'Sign in' : 'Create one free', $isSignup ? 'تسجيل الدخول' : 'أنشئ حسابًا مجانًا') ?></a></p>
        <p class="legal"><?= $t('By creating an account or continuing, you agree to our', 'بإنشاء حساب أو المتابعة، فإنك توافق على') ?> <a href="terms.php?lang=<?= $lang ?>"><?= $t('Terms', 'الشروط') ?></a> <?= $t('and', 'و') ?> <a href="privacy.php?lang=<?= $lang ?>"><?= $t('Privacy Policy', 'سياسة الخصوصية') ?></a>.</p>
      </div>
    </section>
  </main>
  <script src="assets/supabase-config.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2.117.2/dist/umd/supabase.min.js"></script>
  <script>
    (function(){
      var pass=document.getElementById('password'),toggle=document.getElementById('togglePassword'),status=document.getElementById('status'),form=document.getElementById('authForm'),google=document.getElementById('googleButton');
      var local=location.hostname==='localhost'||location.hostname==='127.0.0.1',suffix='<?= $rtl ? '-ar' : '' ?>',dashboardPath=local?'dashboard.php?lang=<?= $lang ?>':'dashboard'+suffix+'.php',loginPath=local?'login.php?lang=<?= $lang ?>':'login'+suffix+'.php';
      var config=window.INVOQLY_CONFIG||{},client=null,isSignup=<?= $isSignup ? 'true' : 'false' ?>;
      if(config.supabaseUrl&&config.supabasePublishableKey&&window.supabase){client=window.supabase.createClient(config.supabaseUrl,config.supabasePublishableKey)}
      function message(en,ar,isError){status.textContent='<?= $lang ?>'==='ar'?ar:en;status.style.color=isError?'#A1372A':'var(--green)'}
      function ready(){if(client)return true;message('Authentication setup is almost ready. Add the Supabase project URL and publishable key first.','إعداد تسجيل الدخول شبه جاهز. أضف رابط مشروع Supabase والمفتاح العام أولاً.',true);return false}
      toggle.addEventListener('click',function(){var showing=pass.type==='text';pass.type=showing?'password':'text';toggle.setAttribute('aria-label',showing?'<?= $t('Show password', 'إظهار كلمة المرور') ?>':'<?= $t('Hide password', 'إخفاء كلمة المرور') ?>');pass.focus()});
      form.addEventListener('submit',async function(e){e.preventDefault();if(!form.checkValidity()){form.reportValidity();return}if(!ready())return;var submit=form.querySelector('.submit');submit.disabled=true;message('Please wait…','يرجى الانتظار…');var email=form.email.value.trim(),password=form.password.value,result;if(isSignup){result=await client.auth.signUp({email:email,password:password,options:{data:{full_name:form.name.value.trim()},emailRedirectTo:location.origin+'/'+loginPath}})}else{result=await client.auth.signInWithPassword({email:email,password:password})}submit.disabled=false;if(result.error){message(result.error.message,result.error.message,true);return}if(isSignup&&!result.data.session){message('Check your email to confirm your account.','تحقق من بريدك الإلكتروني لتأكيد حسابك.');return}location.href=dashboardPath});
      google.addEventListener('click',async function(){if(!ready())return;google.disabled=true;message('Opening Google…','جارٍ فتح Google…');var result=await client.auth.signInWithOAuth({provider:'google',options:{redirectTo:location.origin+'/'+dashboardPath}});if(result.error){google.disabled=false;message(result.error.message,result.error.message,true)}});
    }());
  </script>
</body>
</html>
<?php
}
