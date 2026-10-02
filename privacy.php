<?php
declare(strict_types=1);
$lang = (($_GET['lang'] ?? getenv('INVOQLY_LANG') ?: 'en') === 'ar') ? 'ar' : 'en';
$rtl = $lang === 'ar';
$t = static fn(string $en, string $ar): string => htmlspecialchars($rtl ? $ar : $en, ENT_QUOTES, 'UTF-8');
$sections = [
  ['Information we collect','المعلومات التي نجمعها','We collect account details such as your name and email, business and invoice information you enter, basic device and usage information, and support messages.','نجمع بيانات الحساب مثل الاسم والبريد الإلكتروني، ومعلومات النشاط والفواتير التي تدخلها، ومعلومات أساسية عن الجهاز والاستخدام، ورسائل الدعم.'],
  ['How we use information','كيفية استخدام المعلومات','We use information to provide authentication, create and store invoices, operate and secure the service, respond to support, improve the product and meet legal obligations.','نستخدم المعلومات لتوفير تسجيل الدخول وإنشاء الفواتير وحفظها وتشغيل الخدمة وتأمينها والرد على الدعم وتحسين المنتج والوفاء بالالتزامات القانونية.'],
  ['Service providers','مزودو الخدمة','Cloudflare hosts and protects the website. Supabase provides authentication and may provide database storage. These providers process data under their own security and privacy commitments.','تستضيف Cloudflare الموقع وتحميه، وتوفر Supabase تسجيل الدخول وقد توفر تخزين قاعدة البيانات. يعالج هؤلاء المزودون البيانات وفق التزاماتهم الأمنية والخصوصية.'],
  ['Sharing','المشاركة','We do not sell personal information. We share data only with providers needed to run Invoqly, when you direct us to, during a business reorganization, or when required by law.','لا نبيع المعلومات الشخصية. نشارك البيانات فقط مع المزودين اللازمين لتشغيل إنفوكلي، أو بتوجيه منك، أو أثناء إعادة تنظيم النشاط، أو عندما يقتضي القانون.'],
  ['International processing','المعالجة الدولية','Information may be processed in countries where our providers operate, subject to appropriate contractual and technical safeguards.','قد تتم معالجة المعلومات في الدول التي يعمل فيها مزودونا، مع تطبيق ضمانات تعاقدية وتقنية مناسبة.'],
  ['Retention and security','الاحتفاظ والأمان','We retain information while your account is active and as reasonably needed for support, security and legal obligations. No online service can guarantee absolute security.','نحتفظ بالمعلومات أثناء نشاط حسابك وللمدة المعقولة اللازمة للدعم والأمان والالتزامات القانونية. لا يمكن لأي خدمة عبر الإنترنت ضمان الأمان المطلق.'],
  ['Your choices and rights','خياراتك وحقوقك','You may ask to access, correct or delete your personal information, subject to legal exceptions.','يمكنك طلب الوصول إلى معلوماتك الشخصية أو تصحيحها أو حذفها، مع مراعاة الاستثناءات القانونية.'],
  ['Cookies and local storage','ملفات تعريف الارتباط والتخزين المحلي','We use essential browser storage for language preferences and secure sign-in sessions. We do not currently use advertising cookies.','نستخدم تخزين المتصفح الضروري لتفضيلات اللغة وجلسات الدخول الآمنة. لا نستخدم حاليًا ملفات تعريف ارتباط إعلانية.'],
  ['Contact and updates','التواصل والتحديثات','For privacy requests, email hello@invoqly.ae. We may update this policy as the beta develops.','لطلبات الخصوصية، راسل hello@invoqly.ae. قد نحدّث هذه السياسة مع تطور النسخة التجريبية.'],
];
require __DIR__ . '/legal-view.php';
