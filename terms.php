<?php
declare(strict_types=1);
$lang = (($_GET['lang'] ?? getenv('INVOQLY_LANG') ?: 'en') === 'ar') ? 'ar' : 'en';
$rtl = $lang === 'ar';
$t = static fn(string $en, string $ar): string => htmlspecialchars($rtl ? $ar : $en, ENT_QUOTES, 'UTF-8');
$sections = [
  ['Using Invoqly','استخدام إنفوكلي','Invoqly is an early-stage invoicing service for creating, sending and tracking invoices. You must provide accurate information, protect your account and use the service lawfully.','إنفوكلي خدمة فوترة في مرحلة مبكرة لإنشاء الفواتير وإرسالها ومتابعتها. يجب تقديم معلومات دقيقة وحماية حسابك واستخدام الخدمة بصورة قانونية.'],
  ['Beta service','الخدمة التجريبية','The beta is free and may change as we learn from users. We will explain any paid plans before charging for anything.','النسخة التجريبية مجانية وقد تتغير استنادًا إلى ملاحظات المستخدمين. سنوضح أي خطط مدفوعة قبل فرض أي رسوم.'],
  ['Your responsibilities','مسؤولياتك','You own the content you enter. You are responsible for invoice accuracy, tax treatment, records and rules that apply where you operate. Invoqly does not provide legal, tax or accounting advice.','تملك المحتوى الذي تدخله. وتقع عليك مسؤولية دقة الفواتير والمعالجة الضريبية والسجلات والقواعد المطبقة حيث تعمل. لا تقدم إنفوكلي استشارات قانونية أو ضريبية أو محاسبية.'],
  ['Acceptable use','الاستخدام المقبول','Do not use Invoqly for fraud, unlawful activity, impersonation, malware, spam, infringement, harassment or unauthorized access.','لا تستخدم إنفوكلي في الاحتيال أو الأنشطة غير القانونية أو انتحال الهوية أو البرمجيات الضارة أو الرسائل المزعجة أو التعدي أو المضايقة أو الوصول غير المصرح به.'],
  ['Accounts and security','الحسابات والأمان','Keep your login details confidential and tell us promptly if you believe your account has been compromised.','حافظ على سرية بيانات الدخول وأبلغنا سريعًا إذا اعتقدت أن حسابك تعرض للاختراق.'],
  ['Availability and liability','التوفر والمسؤولية','The beta is provided as available and may experience interruptions. To the extent allowed by law, we are not liable for indirect loss, lost profit or decisions made solely from generated invoice content.','تُقدَّم النسخة التجريبية حسب التوفر وقد تتعرض لانقطاعات. وفي الحدود التي يسمح بها القانون، لا نتحمل الخسائر غير المباشرة أو الأرباح الفائتة أو القرارات المبنية فقط على محتوى الفواتير المُنشأ.'],
  ['Ending access','إنهاء الوصول','You may stop using the service at any time. We may suspend access where reasonably necessary to protect users, comply with law or address serious misuse.','يمكنك التوقف عن استخدام الخدمة في أي وقت. وقد نعلق الوصول عند الحاجة المعقولة لحماية المستخدمين أو الامتثال للقانون أو معالجة إساءة استخدام خطيرة.'],
  ['Changes and contact','التغييرات والتواصل','We may update these terms as the product develops. Material changes will be communicated through the service or by email. Questions: hello@invoqly.ae.','قد نحدّث هذه الشروط مع تطور المنتج. سنوضح التغييرات الجوهرية عبر الخدمة أو البريد الإلكتروني. للأسئلة: hello@invoqly.ae.'],
];
require __DIR__ . '/legal-view.php';
