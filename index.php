<?php
/* ---------------------------------------------------------------------------
 * Invoqly — UAE E-Invoicing Compliance landing page (single-file PHP)
 * Drop this file on any PHP 7.4+ host. No build step, no database.
 * Language: server-side render via ?lang=ar — client toggle swaps instantly.
 * --------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=utf-8');

$LANG = (($_GET['lang'] ?? 'en') === 'ar') ? 'ar' : 'en';

$I18N = [
    'brand' => [
        'name' => ['en' => 'Invoqly', 'ar' => 'إنفوكلي'],
        'word' => ['en' => 'INVOQLY', 'ar' => 'إنفوكلي'],
        'home_aria' => ['en' => 'Invoqly home', 'ar' => 'الصفحة الرئيسية لإنفوكلي'],
    ],
    'meta' => [
        'title' => [
            'en' => 'Invoqly — UAE E-Invoicing Compliance, Live in 48 Hours',
            'ar' => 'إنفوكلي — توافق الفوترة الإلكترونية في الإمارات خلال ٤٨ ساعة',
        ],
        'desc' => [
            'en' => 'Invoqly sits on top of your existing accounting system and makes every invoice PINT AE compliant — FTA transmission, clearance responses, Arabic & English support. No migration required.',
            'ar' => 'تعمل إنفوكلي فوق نظام المحاسبة الحالي لديك وتجعل كل فاتورة متوافقة مع معيار PINT AE — إرسال إلى هيئة الضرائب، ومعالجة ردود القبول، ودعم بالعربية والإنجليزية. دون أي ترحيل.',
        ],
    ],
    'nav' => [
        'how'     => ['en' => 'How It Works', 'ar' => 'كيف يعمل'],
        'pricing' => ['en' => 'Pricing',      'ar' => 'الأسعار'],
        'faq'     => ['en' => 'FAQ',          'ar' => 'الأسئلة الشائعة'],
        'login'   => ['en' => 'Sign in',      'ar' => 'تسجيل الدخول'],
        'cta'     => ['en' => 'Start free trial', 'ar' => 'ابدأ التجربة المجانية'],
    ],
    'hero' => [
        'badge' => ['en' => 'Built for UAE SMEs', 'ar' => 'صُمم لشركات الإمارات الصغيرة والمتوسطة'],
        'title1' => ['en' => 'Make Your Invoices', 'ar' => 'اجعل فواتيرك جاهزة'],
        'title2' => ['en' => 'E-Invoicing Ready in 48 Hours.', 'ar' => 'للفوترة الإلكترونية خلال ٤٨ ساعة.'],
        'sub' => [
            'en' => 'Invoqly sits on top of your existing accounting system — Excel, QuickBooks, or anything else. We handle PINT AE XML, FTA transmission, and clearance responses. You stay compliant. You don\'t change a thing.',
            'ar' => 'تعمل إنفوكلي فوق نظام المحاسبة الحالي لديك — إكسل أو QuickBooks أو أي نظام آخر. نتولى عنك معيار PINT AE XML، والإرسال إلى هيئة الضرائب، وردود القبول. أنت متوافق، دون أن تغيّر أي شيء.',
        ],
        'cta1' => ['en' => 'Start your free trial →', 'ar' => 'ابدأ تجربتك المجانية ←'],
        'cta2' => ['en' => 'See How It Works', 'ar' => 'شاهد كيف يعمل'],
        'trust1' => ['en' => 'Arabic & English Support', 'ar' => 'دعم بالعربية والإنجليزية'],
        'trust2' => ['en' => 'PINT AE Ready', 'ar' => 'جاهز لمعيار PINT AE'],
        'trust3' => ['en' => 'No Migration Required', 'ar' => 'لا حاجة لأي ترحيل'],
        'proof' => ['en' => 'Designed for UAE finance teams', 'ar' => 'مصمم لفرق المالية في الإمارات'],
    ],
    'dash' => [
        'title' => ['en' => 'Compliance Overview', 'ar' => 'نظرة عامة على التوافق'],
        'sub'   => ['en' => 'Live · FTA-connected', 'ar' => 'مباشر · متصل بالهيئة'],
        'chart' => ['en' => 'Clearance rate — last 7 days', 'ar' => 'نسبة القبول — آخر ٧ أيام'],
        'cleared'   => ['en' => 'Cleared',   'ar' => 'مقبولة'],
        'pending'   => ['en' => 'Pending',   'ar' => 'قيد الانتظار'],
        'submitted' => ['en' => 'Submitted', 'ar' => 'مرسلة'],
        'chip'      => ['en' => 'FTA Connected', 'ar' => 'متصل بهيئة الضرائب'],
    ],
    'invoice' => [
        'preview_aria' => ['en' => 'Live sample tax invoice created with Invoqly', 'ar' => 'نموذج مباشر لفاتورة ضريبية أُنشئت باستخدام إنفوكلي'],
        'type' => ['en' => 'Tax invoice', 'ar' => 'فاتورة ضريبية'],
        'business' => ['en' => 'Noura Studio LLC', 'ar' => 'استوديو نور ذ.م.م'],
        'address' => ['en' => 'Dubai Design District · Dubai, UAE', 'ar' => 'حي دبي للتصميم · دبي، الإمارات'],
        'trn' => ['en' => 'TRN 100492837400003', 'ar' => 'الرقم الضريبي ١٠٠٤٩٢٨٣٧٤٠٠٠٠٣'],
        'invoice_no' => ['en' => 'Invoice number', 'ar' => 'رقم الفاتورة'],
        'issue_date' => ['en' => 'Issue date', 'ar' => 'تاريخ الإصدار'],
        'due_date' => ['en' => 'Due date', 'ar' => 'تاريخ الاستحقاق'],
        'issued' => ['en' => '01 Oct 2026', 'ar' => '٠١ أكتوبر ٢٠٢٦'],
        'due' => ['en' => '15 Oct 2026', 'ar' => '١٥ أكتوبر ٢٠٢٦'],
        'bill_to' => ['en' => 'Bill to', 'ar' => 'فاتورة إلى'],
        'customer' => ['en' => 'Al Seef Trading Co.', 'ar' => 'شركة السيف للتجارة'],
        'customer_address' => ['en' => 'Business Bay · Dubai, UAE', 'ar' => 'الخليج التجاري · دبي، الإمارات'],
        'description' => ['en' => 'Description', 'ar' => 'الوصف'],
        'qty' => ['en' => 'Qty', 'ar' => 'الكمية'],
        'rate' => ['en' => 'Rate', 'ar' => 'السعر'],
        'amount' => ['en' => 'Amount', 'ar' => 'المبلغ'],
        'item1' => ['en' => 'Brand identity design', 'ar' => 'تصميم الهوية التجارية'],
        'item2' => ['en' => 'Monthly content package', 'ar' => 'باقة المحتوى الشهرية'],
        'subtotal' => ['en' => 'Subtotal', 'ar' => 'المجموع الفرعي'],
        'vat' => ['en' => 'VAT 5%', 'ar' => 'ضريبة القيمة المضافة ٥٪'],
        'total' => ['en' => 'Total due', 'ar' => 'الإجمالي المستحق'],
        'note' => ['en' => 'Thank you for your business.', 'ar' => 'شكرًا لتعاملكم معنا.'],
        'powered' => ['en' => 'Invoice powered by', 'ar' => 'فاتورة مدعومة من'],
        'status' => ['en' => 'PINT AE validated', 'ar' => 'تم التحقق وفق PINT AE'],
    ],
    'journey' => [
        'eyebrow' => ['en' => 'From your tools to clearance', 'ar' => 'من أدواتك إلى قبول الفاتورة'],
        'title' => ['en' => 'Keep the tools you know. We handle what happens next.', 'ar' => 'احتفظ بأدواتك المعتادة. ونحن نتولى ما بعد ذلك.'],
        'sub' => ['en' => 'Invoice data flows into Invoqly, is checked against PINT AE requirements, and moves through one traceable compliance journey.', 'ar' => 'تنتقل بيانات الفاتورة إلى إنفوكلي، وتُراجع وفق متطلبات PINT AE، ثم تمر عبر مسار توافق واحد يمكنك تتبعه.'],
        'sources' => ['en' => 'Your existing systems', 'ar' => 'أنظمتك الحالية'],
        'excel' => ['en' => 'Excel', 'ar' => 'إكسل'],
        'quickbooks' => ['en' => 'QuickBooks', 'ar' => 'كويك بوكس'],
        'zoho' => ['en' => 'Zoho Books', 'ar' => 'زوهو بوكس'],
        'erp' => ['en' => 'ERP / API', 'ar' => 'نظام ERP / API'],
        'engine' => ['en' => 'Compliance engine', 'ar' => 'محرك التوافق'],
        'engine_sub' => ['en' => 'Mapping, validation and response tracking', 'ar' => 'مواءمة البيانات والتحقق وتتبع الردود'],
        's1' => ['en' => 'Imported', 'ar' => 'تم الاستيراد'],
        's1d' => ['en' => 'Invoice data received', 'ar' => 'تم استلام بيانات الفاتورة'],
        's2' => ['en' => 'PINT AE validated', 'ar' => 'تم التحقق وفق PINT AE'],
        's2d' => ['en' => 'Required fields checked', 'ar' => 'تم فحص الحقول المطلوبة'],
        's3' => ['en' => 'Transmitted', 'ar' => 'تم الإرسال'],
        's3d' => ['en' => 'Sent through the configured channel', 'ar' => 'أُرسلت عبر القناة المهيأة'],
        's4' => ['en' => 'Cleared', 'ar' => 'تم القبول'],
        's4d' => ['en' => 'Response recorded and visible', 'ar' => 'تم تسجيل الرد وإظهاره'],
        'aria' => ['en' => 'Invoice journey from connected systems through Invoqly to clearance', 'ar' => 'مسار الفاتورة من الأنظمة المتصلة عبر إنفوكلي حتى القبول'],
    ],
    'strip' => [
        'lead' => ['en' => 'Trusted by UAE SMEs in Dubai · Sharjah · Abu Dhabi', 'ar' => 'موثوق من الشركات الصغيرة والمتوسطة في دبي · الشارقة · أبوظبي'],
    ],
    'problem' => [
        'eyebrow' => ['en' => 'The Deadline', 'ar' => 'الموعد النهائي'],
        'title' => ['en' => 'The UAE E-Invoicing Deadline Is Coming. Most SMEs Aren\'t Ready.', 'ar' => 'الموعد النهائي للفوترة الإلكترونية في الإمارات يقترب. ومعظم الشركات غير جاهزة.'],
        's1n' => ['en' => '64%', 'ar' => '٦٤٪'],
        's1l' => ['en' => 'of UAE SMEs still run core finance on Excel', 'ar' => 'من الشركات الصغيرة والمتوسطة في الإمارات لا تزال تدير مالياتها على إكسل'],
        's2n' => ['en' => '70.4%', 'ar' => '٧٠٫٤٪'],
        's2l' => ['en' => 'cannot process FTA clearance responses today', 'ar' => 'غير قادرة اليوم على معالجة ردود القبول من هيئة الضرائب'],
        's3n' => ['en' => '38%', 'ar' => '٣٨٪'],
        's3l' => ['en' => 'of ERPs have zero native PINT AE support', 'ar' => 'من أنظمة تخطيط الموارد لا تدعم معيار PINT AE أصلًا'],
        's4n' => ['en' => '31 Mar 2027', 'ar' => '٣١ مارس ٢٠٢٧'],
        's4l' => ['en' => 'deadline to appoint an Accredited Service Provider', 'ar' => 'الموعد النهائي لتعيين مزوّد خدمة معتمد'],
        'p' => [
            'en' => 'Large ERPs are building compliance for enterprises — six-month implementations, five-figure annual licences, armies of consultants. SMEs need something that works this quarter, on top of the tools they already run. That gap is exactly where invoices go to die: rejected, uncleared, quietly non-compliant.',
            'ar' => 'أنظمة تخطيط الموارد الكبرى تبني حلول التوافق للشركات الضخمة — تنفيذ يمتد ستة أشهر، وتراخيص سنوية بخمس خانات، وجيوش من المستشارين. أما الشركات الصغيرة والمتوسطة فتحتاج حلًا يعمل هذا الربع، فوق الأدوات التي تستخدمها فعلًا. في هذه الفجوة تحديدًا تموت الفواتير: مرفوضة، وغير مقبولة، وغير متوافقة في صمت.',
        ],
    ],
    'solution' => [
        'eyebrow' => ['en' => 'The Solution', 'ar' => 'الحل'],
        'title' => ['en' => 'We Sit On Top of Your Existing System. You Stay Compliant.', 'ar' => 'نعمل فوق نظامك الحالي. وأنت تبقى متوافقًا.'],
        'b1' => ['en' => 'Convert your invoices to PINT AE XML automatically', 'ar' => 'تحويل فواتيرك تلقائيًا إلى صيغة PINT AE XML'],
        'b2' => ['en' => 'Transmit through an FTA-accredited ASP', 'ar' => 'الإرسال عبر مزوّد خدمة معتمد من هيئة الضرائب'],
        'b3' => ['en' => 'Handle clearance & rejection responses for you', 'ar' => 'معالجة ردود القبول والرفض نيابةً عنك'],
        'b4' => ['en' => 'WhatsApp + email alerts the moment something needs attention', 'ar' => 'تنبيهات واتساب وبريد إلكتروني فور وجود ما يستدعي انتباهك'],
        'flow1' => ['en' => 'Your System', 'ar' => 'نظامك'],
        'flow1d' => ['en' => 'Excel · QuickBooks · anything', 'ar' => 'إكسل · QuickBooks · أي نظام'],
        'flow2' => ['en' => 'Invoqly', 'ar' => 'إنفوكلي'],
        'flow2d' => ['en' => 'PINT AE conversion & transmission', 'ar' => 'تحويل وإرسال وفق PINT AE'],
        'flow3' => ['en' => 'FTA / ASP', 'ar' => 'هيئة الضرائب / مزوّد معتمد'],
        'flow3d' => ['en' => 'Clearance & reporting', 'ar' => 'القبول والتقارير'],
        'caption' => ['en' => 'No migration. No new accounting software. No 6-month integration.', 'ar' => 'لا ترحيل. لا نظام محاسبة جديد. لا تكامل يستغرق ستة أشهر.'],
    ],
    'how' => [
        'eyebrow' => ['en' => 'How It Works', 'ar' => 'آلية العمل'],
        'title' => ['en' => 'Live in 48 Hours. Three Steps.', 'ar' => 'جاهز خلال ٤٨ ساعة. بثلاث خطوات.'],
        't1' => ['en' => 'Connect Your Data', 'ar' => 'اربط بياناتك'],
        'd1' => ['en' => 'Plug in Excel, QuickBooks or your current tool in minutes — no IT project, no consultants.', 'ar' => 'اربط إكسل أو QuickBooks أو أداتك الحالية خلال دقائق — بدون مشروع تقني ولا مستشارين.'],
        't2' => ['en' => 'We Handle Compliance', 'ar' => 'نتولى التوافق'],
        'd2' => ['en' => 'We convert every invoice to PINT AE XML, transmit through an FTA-accredited ASP and track each response.', 'ar' => 'نحوّل كل فاتورة إلى صيغة PINT AE XML، ونرسلها عبر مزوّد معتمد من الهيئة، ونتتبع كل رد.'],
        't3' => ['en' => 'Stay Compliant', 'ar' => 'ابقَ متوافقًا'],
        'd3' => ['en' => 'A live dashboard plus WhatsApp & email alerts keeps you ahead of rejections, penalties and rule changes.', 'ar' => 'لوحة متابعة مباشرة وتنبيهات واتساب وبريد إلكتروني تبقيك متقدمًا على الرفض والغرامات وتغيّر اللوائح.'],
    ],
    'pricing' => [
        'eyebrow' => ['en' => 'Pricing', 'ar' => 'الأسعار'],
        'title' => ['en' => 'Simple Pricing. No Setup Fees.', 'ar' => 'تسعير بسيط. بدون رسوم إعداد.'],
        'sub' => ['en' => 'Cancel anytime. No migration required.', 'ar' => 'ألغِ في أي وقت. لا حاجة لأي ترحيل.'],
        'monthly' => ['en' => 'Monthly', 'ar' => 'شهري'],
        'annual'  => ['en' => 'Annual · 2 mo free', 'ar' => 'سنوي · شهران مجانًا'],
        'aed' => ['en' => 'AED', 'ar' => 'درهم'],
        'per_mo' => ['en' => '/mo', 'ar' => '/شهريًا'],
        'per_yr' => ['en' => '/yr', 'ar' => '/سنويًا'],
        'plan1' => ['en' => 'Starter', 'ar' => 'البداية'],
        'plan2' => ['en' => 'Growth',  'ar' => 'النمو'],
        'plan3' => ['en' => 'Pro',     'ar' => 'الاحترافية'],
        'popular' => ['en' => 'Most Popular', 'ar' => 'الأكثر شيوعًا'],
        'f1a' => ['en' => 'Up to 50 invoices/month', 'ar' => 'حتى ٥٠ فاتورة شهريًا'],
        'f1b' => ['en' => '1 user', 'ar' => 'مستخدم واحد'],
        'f1c' => ['en' => 'Email support', 'ar' => 'دعم بالبريد الإلكتروني'],
        'f1d' => ['en' => 'EN/AR interface', 'ar' => 'واجهة عربية وإنجليزية'],
        'f2a' => ['en' => 'Up to 250 invoices/month', 'ar' => 'حتى ٢٥٠ فاتورة شهريًا'],
        'f2b' => ['en' => '3 users', 'ar' => '٣ مستخدمين'],
        'f2c' => ['en' => 'WhatsApp alerts', 'ar' => 'تنبيهات واتساب'],
        'f2d' => ['en' => 'Priority Arabic support', 'ar' => 'دعم عربي ذو أولوية'],
        'f3a' => ['en' => 'Unlimited invoices', 'ar' => 'فواتير غير محدودة'],
        'f3b' => ['en' => '10 users', 'ar' => '١٠ مستخدمين'],
        'f3c' => ['en' => 'API access', 'ar' => 'وصول إلى API'],
        'f3d' => ['en' => 'Custom reports', 'ar' => 'تقارير مخصصة'],
        'f3e' => ['en' => 'Dedicated onboarding', 'ar' => 'مرافقة مخصصة للانطلاق'],
        'cta' => ['en' => 'Start free trial', 'ar' => 'ابدأ التجربة المجانية'],
        'anchor' => [
            'en' => 'Big accounting platforms charge AED 4,500–15,000/year just for compliance add-ons. Invoqly starts at a fraction of that.',
            'ar' => 'المنصات المحاسبية الكبرى تتقاضى ٤٥٠٠–١٥٠٠٠ درهم سنويًا مقابل إضافات التوافق وحدها. إنفوكلي يبدأ بجزء يسير من ذلك.',
        ],
    ],
    'faq' => [
        'eyebrow' => ['en' => 'Got questions?', 'ar' => 'عندك أسئلة؟'],
        'title' => ['en' => 'Frequently Asked Questions', 'ar' => 'الأسئلة الشائعة'],
        'q1' => ['en' => 'Do I need to change my accounting software?', 'ar' => 'هل أحتاج إلى تغيير برنامج المحاسبة لدي؟'],
        'a1' => [
            'en' => 'No. Invoqly sits on top of Excel, QuickBooks, Zoho or whatever you already use. We read your invoice data, handle the PINT AE conversion and FTA transmission, and send clearance results straight back to you. Your day-to-day workflow doesn\'t change.',
            'ar' => 'لا. تعمل إنفوكلي فوق إكسل أو QuickBooks أو Zoho أو أي أداة تستخدمها اليوم. نقرأ بيانات فواتيرك، ونتولى التحويل إلى معيار PINT AE والإرسال إلى الهيئة، ونعيد إليك نتائج القبول مباشرة. لا يتغير شيء في عملك اليومي.',
        ],
        'q2' => ['en' => 'What is PINT AE and why does it matter?', 'ar' => 'ما هو معيار PINT AE ولماذا يهم؟'],
        'a2' => [
            'en' => 'PINT AE is the UAE\'s standard format for electronic invoices, based on the global Peppol PINT standard. Under the FTA\'s E-Invoicing rollout, invoices must be issued and exchanged in this exact XML format through accredited channels. If your system can\'t produce valid PINT AE documents, your invoices are not compliant.',
            'ar' => '‏PINT AE هو صيغة الفواتير الإلكترونية المعتمدة في الإمارات، وهي مبنية على معيار Peppol PINT العالمي. وفق خطة هيئة الضرائب للفوترة الإلكترونية، يجب إصدار الفواتير وتبادلها بهذه الصيغة تحديدًا (XML) عبر قنوات معتمدة. إذا لم يتمكن نظامك من إنتاج مستندات PINT AE صحيحة، ففواتيرك غير متوافقة.',
        ],
        'q3' => ['en' => 'When is my deadline?', 'ar' => 'متى موعدي النهائي؟'],
        'a3' => [
            'en' => 'The UAE rollout is phased by annual turnover — the largest businesses go first, SMEs follow in later waves. The fixed date that applies to every registered business is 31 March 2027: by then you must have appointed an Accredited Service Provider. Start your free trial to begin mapping your business to the right readiness steps.',
            'ar' => 'التطبيق في الإمارات يتم على مراحل حسب حجم الإيرادات السنوية — الشركات الكبرى أولًا ثم الشركات الصغيرة والمتوسطة في مراحل لاحقة. التاريخ الثابت الذي يشمل كل منشأة مسجلة هو ٣١ مارس ٢٠٢٧: بحلوله يجب أن تكون قد عيّنت مزوّد خدمة معتمدًا. ابدأ تجربتك المجانية لتحديد خطوات الجاهزية المناسبة لمنشأتك.',
        ],
        'q4' => ['en' => 'Do you support Arabic?', 'ar' => 'هل تدعمون اللغة العربية؟'],
        'a4' => [
            'en' => 'Fully. The interface, invoice dashboards, alerts and support are all available in both Arabic and English — switch anytime with one click, exactly like the toggle on this page.',
            'ar' => 'بالكامل. الواجهة ولوحات الفواتير والتنبيهات والدعم متاحة بالعربية والإنجليزية معًا — بدّل متى شئت بنقرة واحدة، تمامًا كما في هذه الصفحة.',
        ],
        'q5' => ['en' => 'What happens if an invoice gets rejected?', 'ar' => 'ماذا يحدث إذا رُفضت فاتورة؟'],
        'a5' => [
            'en' => 'You\'ll know instantly. We send a WhatsApp and email alert with the exact rejection reason, pre-fill the correction for you, and re-transmit once you approve. Rejections are tracked on your dashboard until they\'re cleared — nothing silently fails.',
            'ar' => 'ستعرف فورًا. نرسل تنبيه واتساب وبريدًا إلكترونيًا مع سبب الرفض بدقة، ونجهّز لك التصحيح مسبقًا، ونعيد الإرسال فور موافقتك. تُتابَع الفواتير المرفوضة على لوحتك حتى قبولها — لا شيء يفشل بصمت.',
        ],
        'q6' => ['en' => 'Is there a setup fee?', 'ar' => 'هل توجد رسوم إعداد؟'],
        'a6' => [
            'en' => 'No. Every plan is a flat monthly subscription with zero setup fees, zero onboarding charges and no lock-in. Cancel anytime — your data exports back to your system in one click.',
            'ar' => 'لا. جميع خططنا اشتراك شهري ثابت بلا رسوم إعداد ولا رسوم بدء تشغيل ولا التزام طويل. ألغِ متى شئت — وتُصدَّر بياناتك إلى نظامك بنقرة واحدة.',
        ],
        'q7' => ['en' => 'How long does onboarding take?', 'ar' => 'كم يستغرق بدء التشغيل؟'],
        'a7' => [
            'en' => '48 hours for most SMEs. Day one we connect your data source and map your invoice fields; day two we run a live test transmission and you\'re operational. No IT team required — we do the heavy lifting.',
            'ar' => '٤٨ ساعة لمعظم الشركات الصغيرة والمتوسطة. في اليوم الأول نربط مصدر بياناتك ونطابق حقول فواتيرك؛ وفي الثاني نجري إرسالًا تجريبيًا فعليًا وتصبح جاهزًا للعمل. لا حاجة لفريق تقني — نحن نتولى العمل الثقيل.',
        ],
    ],
    'cta' => [
        'title' => ['en' => 'The Deadline Is Fixed. Your Preparation Isn\'t.', 'ar' => 'الموعد النهائي محدد. استعدادك لم يكتمل بعد.'],
        'body' => [
            'en' => '73% of UAE businesses have no operational plan for after their e-invoicing system goes live. Don\'t be one of them.',
            'ar' => '٧٣٪ من الشركات الإماراتية لا تملك خطة تشغيلية لما بعد انطلاق نظام الفوترة الإلكترونية لديها. لا تكن أحدها.',
        ],
        'btn' => ['en' => 'Book Your Free Compliance Check →', 'ar' => 'احجز فحص التوافق المجاني ←'],
        'sub' => ['en' => '15 minutes. No sales pitch. Just a clear answer on whether you\'re ready.', 'ar' => '١٥ دقيقة. بدون عرض بيع. فقط إجابة واضحة: هل أنت جاهز أم لا.'],
    ],
    'footer' => [
        'tag' => ['en' => 'Built for UAE SMEs', 'ar' => 'صُمم لشركات الإمارات الصغيرة والمتوسطة'],
        'contact' => ['en' => 'Contact', 'ar' => 'تواصل'],
        'eyebrow' => ['en' => 'Your next invoice can be ready', 'ar' => 'فاتورتك القادمة يمكن أن تكون جاهزة'],
        'title' => ['en' => 'Ready to make compliance feel simple?', 'ar' => 'هل أنت جاهز لتجعل التوافق أكثر بساطة؟'],
        'action' => ['en' => 'Start your free trial', 'ar' => 'ابدأ تجربتك المجانية'],
        'back' => ['en' => 'Back to top', 'ar' => 'العودة إلى الأعلى'],
        'marquee1' => ['en' => 'PINT AE ready', 'ar' => 'جاهز لمعيار PINT AE'],
        'marquee2' => ['en' => 'Built for UAE SMEs', 'ar' => 'مصمم للشركات الإماراتية'],
        'marquee3' => ['en' => 'Arabic + English', 'ar' => 'العربية + الإنجليزية'],
        'marquee4' => ['en' => 'No migration required', 'ar' => 'دون الحاجة إلى ترحيل'],
        'rights' => ['en' => '© 2026 Invoqly. All rights reserved.', 'ar' => '© ٢٠٢٦ إنفوكلي. جميع الحقوق محفوظة.'],
    ],
    'modal' => [
        'title' => ['en' => 'Book Your Free Compliance Check', 'ar' => 'احجز فحص التوافق المجاني'],
        'sub' => ['en' => '15 minutes, no sales pitch. We\'ll confirm your FTA deadline and where you stand.', 'ar' => '١٥ دقيقة بدون عرض بيع. نؤكد لك موعدك النهائي لدى الهيئة ومدى جاهزيتك.'],
        'f_name'    => ['en' => 'Full Name', 'ar' => 'الاسم الكامل'],
        'f_email'   => ['en' => 'Work Email', 'ar' => 'البريد الإلكتروني للعمل'],
        'f_phone'   => ['en' => 'Phone', 'ar' => 'رقم الهاتف'],
        'f_company' => ['en' => 'Company Name', 'ar' => 'اسم الشركة'],
        'f_volume'  => ['en' => 'Monthly Invoice Volume', 'ar' => 'حجم الفواتير الشهري'],
        'opt0' => ['en' => 'Select volume…', 'ar' => 'اختر الحجم…'],
        'opt1' => ['en' => 'Under 50', 'ar' => 'أقل من ٥٠'],
        'opt2' => ['en' => '50–250', 'ar' => '٥٠–٢٥٠'],
        'opt3' => ['en' => '250+', 'ar' => 'أكثر من ٢٥٠'],
        'submit' => ['en' => 'Book My Free Check', 'ar' => 'احجز فحصي المجاني'],
        'privacy' => ['en' => 'No spam. One confirmation email, that\'s it.', 'ar' => 'لا رسائل مزعجة — بريد تأكيد واحد فقط.'],
        'success_t' => ['en' => 'You\'re booked in.', 'ar' => 'تم استلام طلبك!'],
        'success_b' => ['en' => 'We\'ll be in touch within 24 hours to schedule your free check.', 'ar' => 'سنتواصل معك خلال ٢٤ ساعة لتحديد موعد فحصك المجاني.'],
        'close_aria' => ['en' => 'Close', 'ar' => 'إغلاق'],
        'menu_aria'  => ['en' => 'Open menu', 'ar' => 'فتح القائمة'],
    ],
];

function i18n_get(array $dict, string $key): ?array {
    $o = $dict;
    foreach (explode('.', $key) as $p) {
        if (!is_array($o) || !array_key_exists($p, $o)) return null;
        $o = $o[$p];
    }
    return (is_array($o) && isset($o['en'], $o['ar'])) ? $o : null;
}

function tx(string $key): string {
    global $I18N, $LANG;
    $v = i18n_get($I18N, $key);
    return htmlspecialchars($v ? ($v[$LANG] ?? $v['en']) : '', ENT_QUOTES, 'UTF-8');
}

/** Renders a translated string split into staggered word spans for the hero headline. */
function txWords(string $key, int $base = 0, array $marks = []): void {
    global $I18N, $LANG;
    $v = i18n_get($I18N, $key);
    $text = $v ? ($v[$LANG] ?? $v['en']) : '';
    $i = 0;
    foreach (explode(' ', $text) as $w) {
        if ($w === '') continue;
        $mark = in_array($i, $marks, true) ? ' mark' : '';
        echo '<span class="hw' . $mark . '" style="--i:' . ($base + $i) . '">' . htmlspecialchars($w, ENT_QUOTES, 'UTF-8') . '</span> ';
        $i++;
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $LANG ?>" dir="<?= $LANG === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= tx('meta.title') ?></title>
<meta name="description" content="<?= tx('meta.desc') ?>">
<meta property="og:title" content="<?= tx('meta.title') ?>">
<meta property="og:description" content="<?= tx('meta.desc') ?>">
<meta property="og:type" content="website">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%230A2540'/%3E%3Ccircle cx='32' cy='34' r='14' fill='%2300D4AA'/%3E%3C/svg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&family=Fraunces:ital,wght@0,600;0,700;1,600;1,700&family=IBM+Plex+Mono:wght@500;600&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ============ Tokens & base ============ */
:root{
  --navy:#0A2540; --navy-deep:#081E36;
  --teal:#00D4AA; --teal-bright:#2CE8C4; --teal-ink:#0B8A73;
  --violet:#7C5CFF;
  --bg:#FFFFFF; --bg-alt:#F7F9FC;
  --ink:#0A2540; --muted:#4A6076; --faint:#8CA0B3;
  --border:#E4EAF1;
  --r-card:16px; --r-btn:12px; --r-hero:24px;
  --font-display:'Fraunces','IBM Plex Sans Arabic',Georgia,serif;
  --font-mono:'IBM Plex Mono','Segoe UI Mono',monospace;
  --font-hand:'Caveat','IBM Plex Sans Arabic',cursive;
  --sh-1:0 4px 24px rgba(10,37,64,.08);
  --sh-2:0 16px 48px rgba(10,37,64,.14);
  --sp:64px;
}
@media (min-width:768px){ :root{ --sp:96px; } }

*,*::before,*::after{ box-sizing:border-box; }
html{ scroll-behavior:smooth; -webkit-text-size-adjust:100%; }
body{
  margin:0; background:var(--bg); color:var(--ink);
  font-family:'Inter',-apple-system,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;
  font-size:16px; line-height:1.6; overflow-x:hidden;
}
html[lang="ar"] body{ font-family:'IBM Plex Sans Arabic','Inter','Segoe UI',Tahoma,sans-serif; }
h1,h2,h3{ margin:0; }
p{ margin:0; }
a{ color:inherit; text-decoration:none; }
ul{ margin:0; padding:0; list-style:none; }
button{ font:inherit; color:inherit; }
[hidden]{ display:none !important; }
img,svg{ display:block; }
::selection{ background:rgba(0,212,170,.25); }
.no-scroll{ overflow:hidden; }

.container{ max-width:1140px; margin-inline:auto; padding-inline:24px; }
.section{ padding-block:var(--sp); scroll-margin-top:88px; }
.section-alt{ background:var(--bg-alt); }
.section-dark{ background:var(--navy); color:#fff; }

.display{ font-family:var(--font-display); font-weight:600; line-height:1.06; letter-spacing:-.02em; }
html[dir="rtl"] .display{ font-weight:700; letter-spacing:0; line-height:1.28; }
.h2{ font-size:clamp(1.9rem,4vw,3rem); }
.eyebrow{
  display:inline-flex; align-items:center; gap:12px;
  font-family:var(--font-mono); font-size:12.5px; font-weight:600; letter-spacing:.18em;
  text-transform:uppercase; color:var(--teal-ink); margin-bottom:14px;
}
.eyebrow::after{ content:""; width:52px; height:1.5px; background:currentColor; opacity:.5; }
html[dir="rtl"] .eyebrow{ letter-spacing:.06em; text-transform:none; font-size:13.5px; }
.section-dark .eyebrow{ color:var(--teal); }
.section-head{ max-width:760px; margin:0 auto 56px; text-align:center; }
.section-sub{ margin-top:16px; color:var(--muted); font-size:18px; }
.section-dark .section-sub, .section-dark .muted{ color:rgba(255,255,255,.72); }

.skip-link{ position:absolute; inset-inline-start:-9999px; top:8px; z-index:200; background:var(--navy); color:#fff; padding:10px 18px; border-radius:8px; }
.skip-link:focus{ inset-inline-start:8px; }

:focus-visible{ outline:2px solid var(--teal); outline-offset:2px; border-radius:4px; }

/* ============ Buttons ============ */
.btn{
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  font-family:var(--font-display); font-weight:600; font-size:16px; border-radius:var(--r-btn);
  padding:14px 26px; cursor:pointer; border:1px solid transparent;
  transition:transform .18s ease, box-shadow .18s ease, background-color .2s ease, border-color .2s ease, color .2s ease;
}
.btn-primary{ background:var(--teal); color:#04291F; box-shadow:3px 3px 0 var(--navy); }
.btn-primary:hover{ background:var(--teal-bright); transform:translate(-1px,-1px); box-shadow:5px 5px 0 var(--navy); }
.btn-ghost{ border-color:rgba(10,37,64,.25); color:var(--navy); background:transparent; box-shadow:3px 3px 0 rgba(10,37,64,.08); }
.btn-ghost:hover{ border-color:var(--navy); background:rgba(10,37,64,.04); transform:translate(-1px,-1px); box-shadow:5px 5px 0 rgba(10,37,64,.12); }
.btn-light{ background:#fff; color:var(--navy); }
.btn-light:hover{ transform:translate(-1px,-1px); box-shadow:5px 5px 0 rgba(0,0,0,.35); }
/* Instant press feedback — respond on pointer-down, not release */
.btn:active{ transform:scale(.97) translate(1px,1px); box-shadow:1px 1px 0 var(--navy); transition-duration:.1s; }
.btn-lg{ padding:17px 34px; font-size:17px; }
html[dir="rtl"] .btn-primary{ box-shadow:-3px 3px 0 var(--navy); }
html[dir="rtl"] .btn-primary:hover{ box-shadow:-5px 5px 0 var(--navy); }
html[dir="rtl"] .btn-ghost{ box-shadow:-3px 3px 0 rgba(10,37,64,.08); }
html[dir="rtl"] .btn-ghost:hover{ box-shadow:-5px 5px 0 rgba(10,37,64,.12); }
html[dir="rtl"] .btn:active{ transform:scale(.97) translate(-1px,1px); box-shadow:-1px 1px 0 var(--navy); }

/* ============ Navbar ============ */
.nav{ position:fixed; inset-inline:0; top:0; z-index:60; transition:background-color .3s ease, box-shadow .3s ease, border-color .3s ease; border-bottom:1px solid transparent; }
.nav.scrolled{
  background:rgba(255,255,255,.72);
  -webkit-backdrop-filter:blur(18px) saturate(180%);
  backdrop-filter:blur(18px) saturate(180%);
  border-bottom:1px solid rgba(10,37,64,.08);
}
.nav-inner{ display:grid; grid-template-columns:1fr auto 1fr; align-items:center; height:72px; gap:16px; }
.logo{ display:inline-flex; align-items:baseline; font-family:var(--font-display); font-weight:700; font-size:23px; letter-spacing:-.01em; color:var(--navy); }
.logo .dot{ color:var(--teal); }
html[dir="rtl"] .logo{ letter-spacing:0; }
.nav-links{ display:none; gap:30px; justify-content:center; }
.nav-link{ color:var(--muted); font-weight:500; font-size:15px; transition:color .2s; }
.nav-link:hover{ color:var(--navy); }
.nav-right{ display:flex; align-items:center; justify-content:flex-end; gap:12px; }
.nav-right .btn{ padding:10px 18px; font-size:14.5px; }
.nav-burger{ display:grid; place-items:center; width:40px; height:40px; border:1px solid var(--border); border-radius:10px; background:#fff; cursor:pointer; }
@media (min-width:961px){
  .nav-links{ display:flex; }
  .nav-burger{ display:none; }
}

.lang-switch{ display:inline-flex; border:1px solid var(--border); border-radius:999px; padding:3px; gap:2px; background:rgba(255,255,255,.7); }
.lang-btn{ border:0; background:transparent; padding:5px 13px; border-radius:999px; font-family:var(--font-mono); font-size:13px; font-weight:600; color:var(--muted); cursor:pointer; transition:background-color .2s, color .2s; }
.lang-btn.active{ background:var(--navy); color:#fff; }
.lang-switch.on-dark{ background:rgba(255,255,255,.08); border-color:rgba(255,255,255,.18); }
.lang-switch.on-dark .lang-btn{ color:rgba(255,255,255,.65); }
.lang-switch.on-dark .lang-btn.active{ background:var(--teal); color:#04291F; }

/* ============ Drawer ============ */
.drawer-backdrop{ position:fixed; inset:0; background:rgba(10,37,64,.45); opacity:0; pointer-events:none; transition:opacity .3s; z-index:80; }
.drawer-backdrop.open{ opacity:1; pointer-events:auto; }
.drawer{
  position:fixed; inset-block:0; inset-inline-end:0; width:min(320px,86vw); z-index:90;
  background:#fff; padding:24px; display:flex; flex-direction:column; gap:8px;
  box-shadow:-24px 0 64px rgba(10,37,64,.18);
  transition:transform .4s cubic-bezier(.3,1.08,.34,1);
}
.drawer:not(.open){ transform:translateX(105%); }
html[dir="rtl"] .drawer:not(.open){ transform:translateX(-105%); }
.drawer-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
.drawer-close{ width:38px; height:38px; border:1px solid var(--border); background:#fff; border-radius:10px; display:grid; place-items:center; cursor:pointer; }
.drawer a.d-link{ padding:13px 10px; font-weight:600; color:var(--navy); border-radius:10px; }
.drawer a.d-link:hover{ background:var(--bg-alt); }
.drawer .btn{ margin-top:14px; }

/* ============ Hero ============ */
.hero{ position:relative; overflow:hidden; padding:132px 0 var(--sp); }
@media (min-width:768px){ .hero{ padding-top:160px; } }
.mesh{
  position:absolute; inset:-12%; pointer-events:none; filter:blur(70px); opacity:.3; z-index:0;
  will-change:transform;
  background:
    radial-gradient(closest-side at 28% 30%, rgba(0,212,170,.6), transparent 70%),
    radial-gradient(closest-side at 72% 18%, rgba(124,92,255,.5), transparent 70%),
    radial-gradient(closest-side at 52% 85%, rgba(10,37,64,.4), transparent 70%);
}
.hero-grid{ position:relative; z-index:1; display:grid; gap:56px; align-items:center; }
@media (min-width:1000px){ .hero-grid{ grid-template-columns:1.05fr .95fr; gap:48px; } }

.hero-badge{
  display:inline-flex; align-items:center; gap:8px; font-family:var(--font-mono);
  font-size:12.5px; font-weight:600; letter-spacing:.04em;
  background:rgba(0,212,170,.12); color:var(--teal-ink);
  border:1px dashed rgba(0,212,170,.55); padding:7px 16px; border-radius:999px;
}
.hero h1{ font-size:clamp(2.6rem,6.2vw,4.75rem); margin-top:22px; }
.h-line{ display:block; }
.hw{ display:inline-block; }
/* Marker-highlight on key words (Fraunces italic + teal marker) */
.hw.mark{ font-style:italic; position:relative; z-index:0; }
.hw.mark::before{
  content:""; position:absolute; z-index:-1; inset:.16em -.14em 0em;
  background:linear-gradient(100deg, rgba(0,212,170,.42), rgba(0,212,170,.26));
  border-radius:.25em .5em .35em .5em; transform:rotate(-1.4deg);
}
.hero-sub{ margin-top:22px; max-width:640px; color:var(--muted); font-size:18px; line-height:1.65; }
.hero-ctas{ display:flex; flex-wrap:wrap; gap:14px; margin-top:34px; }
.hero-trust{ display:flex; flex-wrap:wrap; align-items:center; gap:10px 14px; margin-top:28px; color:var(--muted); font-family:var(--font-mono); font-size:12.5px; font-weight:500; letter-spacing:.02em; }
.trust-item{ display:inline-flex; align-items:center; gap:7px; }
.trust-item svg{ color:var(--teal-ink); flex:none; }
.dot-sep{ width:4px; height:4px; border-radius:50%; background:#B9C6D3; }

/* Dashboard mockup */
.hero-visual{ position:relative; }
.hero-visual::before{
  content:""; position:absolute; inset:-8% -4%; z-index:0; border-radius:36px;
  background:linear-gradient(135deg, rgba(0,212,170,.28), rgba(124,92,255,.24));
  filter:blur(42px);
}
.dash-card{
  position:relative; z-index:1; background:rgba(255,255,255,.86);
  -webkit-backdrop-filter:blur(12px); backdrop-filter:blur(12px);
  border:1px solid rgba(255,255,255,.9); border-radius:var(--r-hero);
  box-shadow:0 24px 64px rgba(10,37,64,.16); padding:20px;
  will-change:transform;
  transform:perspective(1200px) rotateX(var(--tx,0deg)) rotateY(var(--ty,0deg));
}
/* Float wrapper — float and tilt live on separate layers so they compose */
.dash-float{ transform-style:preserve-3d; rotate:-2deg; transition:rotate .45s cubic-bezier(.2,.7,.25,1); }
.hero-visual:hover .dash-float{ rotate:0deg; }
/* Paper tape + handwritten annotation (studexa-style craft details) */
.dash-tape{
  position:absolute; z-index:3; top:-13px; left:50%; width:118px; height:26px;
  transform:translateX(-50%) rotate(-3deg); pointer-events:none;
  background:rgba(0,212,170,.22); border-inline:1px dashed rgba(10,37,64,.18);
  box-shadow:0 2px 6px rgba(10,37,64,.06);
}
.dash-note{
  position:absolute; z-index:3; top:-40px; inset-inline-end:-6px;
  font-family:var(--font-hand); font-size:22px; line-height:1; color:var(--teal-ink);
  transform:rotate(5deg); pointer-events:none;
}
/* Contact shadow grounds the floating card — no shadow, no depth */
.dash-ground{
  position:absolute; z-index:0; bottom:-30px; inset-inline:8%; height:36px; border-radius:50%;
  background:radial-gradient(50% 50% at 50% 50%, rgba(10,37,64,.28), transparent 70%);
  filter:blur(9px); pointer-events:none;
}
.dash-head{ display:flex; align-items:center; gap:14px; padding-bottom:14px; border-bottom:1px solid var(--border); }
.dash-dots{ display:flex; gap:6px; }
.dash-dots span{ width:9px; height:9px; border-radius:50%; background:#E1E8F0; }
.dash-dots span:first-child{ background:#FF6B6B; opacity:.7; }
.dash-dots span:nth-child(2){ background:#FFC24B; opacity:.7; }
.dash-dots span:last-child{ background:var(--teal); }
.dash-title{ font-weight:700; font-size:15px; }
.dash-sub{ font-family:var(--font-mono); font-size:11px; color:var(--faint); display:flex; align-items:center; gap:6px; letter-spacing:.03em; }
.live-dot{ width:7px; height:7px; border-radius:50%; background:var(--teal); box-shadow:0 0 0 3px rgba(0,212,170,.18); }
.dash-rows{ padding:8px 0; }
.dash-row{ display:flex; align-items:center; justify-content:space-between; gap:10px; padding:9px 10px; border-radius:10px; }
.dash-row:nth-child(even){ background:var(--bg-alt); }
.inv-meta{ min-width:0; display:flex; align-items:baseline; gap:10px; }
.inv-id{ font-weight:700; font-size:13px; color:var(--navy); font-variant-numeric:tabular-nums; }
.inv-client{ font-size:12.5px; color:var(--faint); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.badge{ flex:none; font-size:11.5px; font-weight:700; padding:3px 10px; border-radius:999px; }
.badge-green{ background:rgba(34,197,94,.12); color:#0E9F6E; }
.badge-amber{ background:rgba(245,158,11,.15); color:#B45309; }
.badge-teal{ background:rgba(0,212,170,.16); color:var(--teal-ink); }
.dash-chart{ border-top:1px solid var(--border); padding-top:14px; }
.bars{ display:flex; gap:6px; height:60px; align-items:flex-end; }
.bars span{ flex:1; border-radius:4px 4px 0 0; height:var(--h); background:linear-gradient(180deg,var(--teal),#00A98B); }
.bars span:last-child{ background:linear-gradient(180deg,var(--violet),#5A3FE0); }
.chart-label{ margin-top:10px; font-family:var(--font-mono); font-size:11px; letter-spacing:.03em; color:var(--faint); }
.dash-chip{
  position:absolute; bottom:-18px; inset-inline-start:-14px; z-index:2;
  display:inline-flex; align-items:center; gap:8px;
  background:#fff; border:1px solid var(--border); border-radius:999px;
  box-shadow:var(--sh-1); padding:9px 16px; font-size:13px; font-weight:600; color:var(--navy);
}
.dash-chip svg{ color:var(--teal-ink); }

/* Live invoice preview */
.invoice-preview{padding:clamp(24px,4vw,42px);text-align:start;color:var(--ink)}
.invoice-top{display:flex;justify-content:space-between;gap:28px;padding-bottom:26px;border-bottom:1px solid var(--border)}
.invoice-business{display:flex;align-items:flex-start;gap:14px}.business-logo{width:48px;height:48px;display:grid;place-items:center;flex:none;border-radius:14px;background:var(--ink);color:var(--teal);font-family:var(--font-display);font-size:25px;font-style:italic;font-weight:700}.invoice-business div{display:grid}.invoice-business strong{font-size:16px}.invoice-business span{font-size:11px;line-height:1.55;color:var(--muted)}
.invoice-title{text-align:end}.invoice-title span{display:block;font-family:var(--font-mono);font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--teal-ink)}.invoice-title strong{display:block;margin-top:5px;font-size:21px;letter-spacing:-.03em}
.invoice-meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:34px;padding:25px 0}.invoice-client{display:flex;flex-direction:column}.invoice-label{margin-bottom:7px;font-family:var(--font-mono);font-size:9.5px;font-weight:700;letter-spacing:.13em;text-transform:uppercase;color:var(--faint)}.invoice-client strong{font-size:14px}.invoice-client small{margin-top:3px;color:var(--muted)}
.invoice-dates{margin:0;display:grid;gap:6px}.invoice-dates div{display:flex;justify-content:space-between;gap:16px}.invoice-dates dt,.invoice-dates dd{margin:0;font-size:11px}.invoice-dates dt{color:var(--muted)}.invoice-dates dd{font-weight:700;text-align:end}
.invoice-table{overflow:hidden;border:1px solid var(--border);border-radius:14px}.invoice-tr{display:grid;grid-template-columns:minmax(180px,1.7fr) .42fr .72fr .78fr;gap:12px;align-items:center;padding:12px 14px;border-top:1px solid var(--border);font-size:11.5px}.invoice-tr:first-child{border-top:0}.invoice-tr>*:not(:first-child){text-align:end;font-variant-numeric:tabular-nums}.invoice-tr strong{font-size:12px}.invoice-th{background:var(--ink);color:#fff;font-family:var(--font-mono);font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
.invoice-bottom{display:grid;grid-template-columns:1fr minmax(240px,.72fr);gap:38px;padding-top:24px}.invoice-note{display:flex;flex-direction:column;align-items:flex-start;gap:12px}.invoice-note p{font-family:var(--font-display);font-size:14px;color:var(--muted)}.invoice-totals{margin:0;display:grid;gap:7px}.invoice-totals div{display:flex;justify-content:space-between;gap:20px}.invoice-totals dt,.invoice-totals dd{margin:0;font-size:11.5px}.invoice-totals dt{color:var(--muted)}.invoice-totals dd{font-weight:700;font-variant-numeric:tabular-nums}.invoice-totals .grand-total{margin-top:5px;padding-top:11px;border-top:1px solid var(--ink)}.invoice-totals .grand-total dt,.invoice-totals .grand-total dd{color:var(--ink);font-size:15px;font-weight:800}
.invoice-powered{display:flex;align-items:baseline;justify-content:flex-end;gap:7px;margin-top:28px;padding-top:14px;border-top:1px solid var(--border);font-size:9.5px;color:var(--faint)}.invoice-powered strong{font-size:14px;color:var(--ink);letter-spacing:-.04em}.invoice-powered i{color:var(--teal-ink);font-style:normal}
html[dir="rtl"] .invoice-title{text-align:start}html[dir="rtl"] .invoice-tr>*:not(:first-child),html[dir="rtl"] .invoice-dates dd{text-align:start}
@media(max-width:620px){.invoice-preview{padding:20px}.invoice-top{gap:14px}.business-logo{width:42px;height:42px}.invoice-business span:last-child{display:none}.invoice-title strong{font-size:17px}.invoice-meta-grid{grid-template-columns:1fr;gap:18px}.invoice-tr{grid-template-columns:minmax(125px,1.4fr) .34fr .72fr}.invoice-tr>*:nth-child(3){display:none}.invoice-bottom{grid-template-columns:1fr;gap:20px}.invoice-note p{display:none}.invoice-powered{margin-top:20px}}

/* ============ Trust strip ============ */
.ticker{ overflow:hidden; background:var(--navy); border-block:1px solid rgba(255,255,255,.08); }
.ticker-track{ display:flex; width:max-content; animation:tickerScroll 30s linear infinite; }
.ticker-track:hover{ animation-play-state:paused; }
.ticker-track span{
  font-family:var(--font-mono); font-size:12px; font-weight:600; letter-spacing:.18em;
  text-transform:uppercase; color:rgba(255,255,255,.85); padding:12px 0 12px 28px; white-space:nowrap;
}
html[dir="rtl"] .ticker-track span{ padding:12px 28px 12px 0; letter-spacing:.04em; }
.ticker-track span::after{ content:"✳"; color:var(--teal); margin-inline-start:28px; font-size:13px; }
@keyframes tickerScroll{ to{ transform:translateX(-50%); } }
html[dir="rtl"] .ticker-track{ animation-direction:reverse; }
@media (prefers-reduced-motion: reduce){ .ticker-track{ animation:none; } }

.strip{ border-bottom:1px solid var(--border); padding:28px 0; background:#fff; }
.strip-inner{ display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:18px 36px; }
.strip-lead{ font-family:var(--font-mono); font-size:12px; font-weight:600; letter-spacing:.08em; color:var(--faint); text-transform:uppercase; }
html[dir="rtl"] .strip-lead{ letter-spacing:0; text-transform:none; font-size:13.5px; }
.strip-logos{ display:flex; flex-wrap:wrap; align-items:center; gap:26px; color:#93A5B8; }

/* ============ Stats ============ */
.stats-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:20px; }
@media (min-width:1024px){ .stats-grid{ grid-template-columns:repeat(4,1fr); } }
.stat{ background:#fff; border:1px solid var(--border); border-radius:var(--r-card); padding:28px 26px; box-shadow:6px 6px 0 rgba(10,37,64,.06); transition:transform .22s ease, box-shadow .22s ease; }
.stat:hover{ transform:translate(-2px,-3px); box-shadow:9px 10px 0 rgba(10,37,64,.1); }
html[dir="rtl"] .stat{ box-shadow:-6px 6px 0 rgba(10,37,64,.06); }
html[dir="rtl"] .stat:hover{ box-shadow:-9px 10px 0 rgba(10,37,64,.1); }
.stat .num{
  font-family:var(--font-display); font-weight:700;
  font-size:clamp(2.1rem,3.6vw,2.9rem); letter-spacing:-.01em;
  background:linear-gradient(115deg, var(--navy) 35%, #00A98B);
  -webkit-background-clip:text; background-clip:text; color:transparent;
}
html[dir="rtl"] .stat .num{ letter-spacing:0; }
.stat .lbl{ margin-top:8px; color:var(--muted); font-size:14.5px; line-height:1.5; }
.problem-p{ max-width:760px; margin:44px auto 0; text-align:center; color:var(--muted); font-size:17px; line-height:1.7; }

/* ============ Solution ============ */
.sol-grid{ display:grid; gap:56px; align-items:center; }
@media (min-width:1000px){ .sol-grid{ grid-template-columns:1fr 1fr; gap:72px; } }
.sol-item{ display:flex; gap:16px; }
.sol-item + .sol-item{ margin-top:26px; }
.sol-check{ flex:none; width:34px; height:34px; border-radius:10px; background:rgba(0,212,170,.15); display:grid; place-items:center; }
.sol-check svg{ color:var(--teal); }
.sol-item p{ font-size:17px; font-weight:500; color:rgba(255,255,255,.88); padding-top:3px; }

.flow-panel{
  position:relative; overflow:hidden; border-radius:var(--r-hero); padding:44px 28px;
  background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.12);
}
.flow-panel::before{
  content:""; position:absolute; inset:0; pointer-events:none;
  background:radial-gradient(60% 45% at 50% 0%, rgba(0,212,170,.14), transparent 70%);
}
.flow{ display:flex; flex-direction:column; align-items:center; position:relative; }
.flow-card{
  width:min(300px,100%); text-align:center; padding:16px 20px; border-radius:var(--r-card);
  background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.16);
  -webkit-backdrop-filter:blur(6px); backdrop-filter:blur(6px);
}
.flow-card .fc-title{ display:flex; align-items:center; justify-content:center; gap:9px; font-weight:700; font-size:15.5px; }
.flow-card .fc-title svg{ color:var(--teal); }
.flow-card .fc-sub{ font-size:12.5px; color:rgba(255,255,255,.55); margin-top:3px; }
.flow-link{ position:relative; width:2px; height:44px; background-image:linear-gradient(var(--teal) 55%, transparent 0); background-size:2px 11px; }
.flow-link::after{
  content:""; position:absolute; bottom:-4px; inset-inline-start:-3px; width:8px; height:8px;
  border-radius:50%; background:var(--teal); box-shadow:0 0 12px rgba(0,212,170,.9);
}
.sol-caption{ text-align:center; margin-top:52px; font-family:var(--font-mono); font-size:12.5px; font-weight:500; letter-spacing:.06em; color:rgba(255,255,255,.6); }
html[dir="rtl"] .sol-caption{ letter-spacing:0; font-size:14px; }

/* ============ How it works ============ */
.steps{ display:grid; gap:24px; }
@media (min-width:900px){ .steps{ grid-template-columns:repeat(3,1fr); gap:32px; } }
.step{ position:relative; background:#fff; border:1px solid var(--border); border-radius:var(--r-card); padding:30px 28px; box-shadow:6px 6px 0 rgba(10,37,64,.06); }
html[dir="rtl"] .step{ box-shadow:-6px 6px 0 rgba(10,37,64,.06); }
.step-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
.step-num{ font-family:var(--font-mono); width:44px; height:44px; border-radius:50%; background:rgba(0,212,170,.12); color:var(--teal-ink); font-weight:600; font-size:14px; display:grid; place-items:center; font-variant-numeric:tabular-nums; }
.step-icon{ color:var(--faint); }
.step h3{ font-family:var(--font-display); font-weight:700; font-size:20px; letter-spacing:-.01em; }
html[dir="rtl"] .step h3{ letter-spacing:0; }
.step p{ margin-top:10px; color:var(--muted); font-size:15px; line-height:1.65; }
.step::after{
  content:""; position:absolute; top:52px; inset-inline-end:-32px; width:32px;
  border-top:2px dashed rgba(0,212,170,.55);
}
.step:last-child::after{ display:none; }
@media (max-width:899px){ .step::after{ display:none; } }

/* ============ Pricing ============ */
.billing-toggle{
  position:relative; display:inline-flex; width:min(100%,380px);
  background:var(--bg-alt); border:1px solid var(--border); border-radius:999px; padding:4px; margin:26px auto 0;
}
.billing-toggle button{
  position:relative; z-index:1; flex:1; border:0; background:transparent; padding:10px 8px;
  border-radius:999px; font-family:var(--font-mono); font-weight:600; font-size:12.5px;
  letter-spacing:.06em; text-transform:uppercase; color:var(--muted);
  cursor:pointer; transition:color .25s; white-space:nowrap;
}
html[dir="rtl"] .billing-toggle button{ text-transform:none; font-size:14px; letter-spacing:0; }
.billing-toggle button.active{ color:var(--navy); }
.billing-thumb{
  position:absolute; top:4px; bottom:4px; inset-inline-start:4px; width:calc(50% - 4px);
  background:#fff; border-radius:999px; box-shadow:0 2px 10px rgba(10,37,64,.12);
  transition:inset-inline-start .32s cubic-bezier(.2,.7,.25,1);
}
.billing-toggle.annual .billing-thumb{ inset-inline-start:calc(50% + 0px); }
.billing-wrap{ text-align:center; }

.plans{ display:grid; gap:24px; margin-top:48px; }
@media (min-width:960px){ .plans{ grid-template-columns:repeat(3,1fr); gap:28px; align-items:start; } }
.plan{
  position:relative; background:#fff; border:1px solid var(--border); border-radius:var(--r-card);
  padding:32px 30px; box-shadow:6px 6px 0 rgba(10,37,64,.06);
  transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}
.plan:hover{ transform:translate(-2px,-4px); box-shadow:9px 10px 0 rgba(10,37,64,.1); border-color:rgba(0,212,170,.5); }
html[dir="rtl"] .plan{ box-shadow:-6px 6px 0 rgba(10,37,64,.06); }
html[dir="rtl"] .plan:hover{ box-shadow:-9px 10px 0 rgba(10,37,64,.1); }
.plan-pop{ border:2px solid var(--teal); }
@media (min-width:960px){ .plan-pop{ translate:0 -10px; } }
.badge-pop{
  position:absolute; top:-14px; inset-inline-start:50%; transform:translateX(-50%);
  background:var(--teal); color:#04291F; font-family:var(--font-mono); font-size:11px; font-weight:600;
  letter-spacing:.08em; text-transform:uppercase;
  padding:5px 15px; border-radius:999px; display:inline-flex; align-items:center; gap:6px;
  box-shadow:2px 2px 0 var(--navy); white-space:nowrap;
}
html[dir="rtl"] .badge-pop{ transform:translateX(50%); box-shadow:-2px 2px 0 var(--navy); }
.plan h3{ font-family:var(--font-display); font-weight:700; font-size:20px; }
.plan-desc{ margin-top:4px; font-size:13.5px; color:var(--faint); }
.price{ margin-top:18px; display:flex; align-items:baseline; gap:8px; flex-wrap:wrap; }
.price .cur{ font-family:var(--font-mono); font-size:13px; font-weight:600; color:var(--muted); }
.price .amount{ font-family:var(--font-display); font-weight:700; font-size:40px; letter-spacing:-.01em; color:var(--navy); font-variant-numeric:tabular-nums; }
html[dir="rtl"] .price .amount{ letter-spacing:0; }
.price .per{ font-family:var(--font-mono); font-size:13px; color:var(--faint); }
.plan-feat{ margin-top:22px; padding-top:22px; border-top:1px solid var(--border); display:grid; gap:12px; }
.plan-feat li{ display:flex; gap:10px; align-items:flex-start; font-size:14.5px; color:var(--muted); }
.plan-feat svg{ flex:none; margin-top:3px; color:var(--teal-ink); }
.plan .btn{ width:100%; margin-top:26px; }
.anchor-line{ margin:44px auto 0; max-width:680px; text-align:center; font-family:var(--font-hand); font-size:21px; line-height:1.45; color:var(--muted); }

/* ============ FAQ ============ */
.faq-list{ max-width:800px; margin:0 auto; display:grid; gap:14px; }
.faq-item{ background:#fff; border:1px solid var(--border); border-radius:14px; box-shadow:var(--sh-1); }
.faq-q{
  width:100%; display:flex; align-items:center; justify-content:space-between; gap:16px;
  padding:20px 24px; background:none; border:0; cursor:pointer;
  font-family:var(--font-display); font-size:18px; font-weight:600; color:var(--navy); text-align:start; border-radius:14px;
}
html[dir="rtl"] .faq-q{ font-weight:700; }
.chev{ flex:none; width:32px; height:32px; border-radius:50%; background:var(--bg-alt); display:grid; place-items:center; color:var(--muted); transition:transform .35s ease, background-color .25s, color .25s; }
.faq-item.open .chev{ transform:rotate(180deg); background:rgba(0,212,170,.14); color:var(--teal-ink); }
.faq-a{ display:grid; grid-template-rows:0fr; transition:grid-template-rows .38s cubic-bezier(.2,.7,.25,1); }
.faq-item.open .faq-a{ grid-template-rows:1fr; }
.faq-a-inner{ overflow:hidden; }
.faq-a-inner p{ padding:0 24px 22px; color:var(--muted); font-size:15.5px; line-height:1.7; }

/* ============ Cinematic footer ============ */
.footer{position:relative;min-height:min(860px,94vh);overflow:hidden;color:#fff;background:radial-gradient(circle at 50% 44%,rgba(0,212,170,.16),transparent 34%),linear-gradient(145deg,#061d1a 0%,#071522 54%,#050c13 100%);isolation:isolate}
.footer::before{content:"";position:absolute;inset:0;z-index:-1;opacity:.32;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:64px 64px;-webkit-mask-image:linear-gradient(transparent 2%,#000 30%,#000 68%,transparent 96%);mask-image:linear-gradient(transparent 2%,#000 30%,#000 68%,transparent 96%)}
.footer-orb{position:absolute;width:62vw;height:62vw;max-width:760px;max-height:760px;left:50%;top:48%;translate:-50% -50%;border-radius:50%;background:rgba(0,212,170,.08);filter:blur(70px);pointer-events:none}
.footer-word{position:absolute;left:50%;bottom:-.1em;translate:-50% 0;z-index:-1;font-family:var(--font-display);font-size:clamp(6rem,20vw,18rem);line-height:.72;font-weight:800;letter-spacing:-.075em;white-space:nowrap;color:transparent;-webkit-text-stroke:1px rgba(255,255,255,.09);user-select:none}
.footer-marquee{position:absolute;top:72px;inset-inline:-4%;rotate:-2deg;overflow:hidden;padding:14px 0;border-block:1px solid rgba(255,255,255,.11);background:rgba(5,20,28,.64);-webkit-backdrop-filter:blur(18px);backdrop-filter:blur(18px)}
.footer-marquee-track{display:flex;width:max-content;animation:footerMarquee 34s linear infinite}
.footer-marquee-group{display:flex;align-items:center;gap:28px;padding-inline:14px;text-transform:uppercase;letter-spacing:.22em;font-size:11px;font-weight:700;color:rgba(255,255,255,.64)}
.footer-marquee-group i{width:6px;height:6px;border-radius:50%;background:var(--teal);box-shadow:0 0 16px rgba(0,212,170,.9)}
html[dir="rtl"] .footer-marquee-track{animation-direction:reverse}
@keyframes footerMarquee{to{transform:translateX(-50%)}}
.footer-core{min-height:min(860px,94vh);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:180px 0 142px}
.footer-eyebrow{display:inline-flex;align-items:center;gap:9px;color:var(--teal);font-size:12px;font-weight:700;letter-spacing:.16em;text-transform:uppercase}
.footer-eyebrow::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor;box-shadow:0 0 14px currentColor}
.footer-title{max-width:920px;margin:26px auto 0;font-family:var(--font-display);font-size:clamp(2.7rem,7vw,6.2rem);line-height:.94;letter-spacing:-.055em;text-wrap:balance}
html[dir="rtl"] .footer-title{letter-spacing:-.025em;line-height:1.12}
.footer-actions{display:flex;flex-wrap:wrap;justify-content:center;gap:12px;margin-top:42px}
.footer-pill{min-height:52px;display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:0 24px;border:1px solid rgba(255,255,255,.14);border-radius:999px;color:rgba(255,255,255,.75);background:linear-gradient(145deg,rgba(255,255,255,.09),rgba(255,255,255,.025));box-shadow:inset 0 1px rgba(255,255,255,.1),0 18px 38px rgba(0,0,0,.18);-webkit-backdrop-filter:blur(16px);backdrop-filter:blur(16px);transition:border-color .25s ease,color .25s ease,background .25s ease;will-change:transform}
.footer-pill:hover,.footer-pill:focus-visible{color:#fff;border-color:rgba(0,212,170,.55);background:rgba(0,212,170,.12)}
.footer-pill.primary{color:#04221b;background:var(--teal);border-color:var(--teal);font-weight:800}
.footer-pill.primary:hover,.footer-pill.primary:focus-visible{color:#04221b;background:#42e4c3}
.footer-meta{position:absolute;inset-inline:0;bottom:0;padding:0 0 30px}
.footer-meta-row{display:flex;align-items:center;justify-content:space-between;gap:24px;padding-top:24px;border-top:1px solid rgba(255,255,255,.11)}
.footer-brand{display:flex;align-items:center;gap:14px;text-align:start}.footer .logo{color:#fff}
.foot-tag{margin-top:3px;font-size:12px;color:rgba(255,255,255,.47)}
.footer-links{display:flex;flex-wrap:wrap;justify-content:center;gap:10px 22px}.footer-links a,.footer-email{font-size:13px;color:rgba(255,255,255,.58)}.footer-links a:hover,.footer-email:hover{color:#fff}.footer-email{direction:ltr}
.back-top{width:48px;height:48px;padding:0;flex:0 0 auto}.back-top svg{transition:transform .25s ease}.back-top:hover svg{transform:translateY(-3px)}
.foot-bottom{font-size:12px;color:rgba(255,255,255,.35);white-space:nowrap}
@media(max-width:780px){.footer{min-height:780px}.footer-core{min-height:780px;padding:165px 0 220px}.footer-marquee{top:54px}.footer-title{font-size:clamp(2.65rem,13vw,4.3rem)}.footer-actions{flex-direction:column;width:min(100%,360px)}.footer-pill{width:100%}.footer-meta-row{flex-wrap:wrap;justify-content:center;text-align:center}.footer-brand{width:100%;justify-content:center;text-align:center}.footer-links{order:2;width:100%}.foot-bottom{order:3}.back-top{position:absolute;inset-inline-end:20px;top:18px}}

/* ============ Modal ============ */
.modal-wrap{
  position:fixed; inset:0; z-index:110; display:grid; place-items:center; padding:20px;
  background:rgba(10,37,64,.55); -webkit-backdrop-filter:blur(7px); backdrop-filter:blur(7px);
  opacity:0; visibility:hidden; pointer-events:none;
  transition:opacity .25s ease, visibility 0s .25s;
}
.modal-wrap.open{ opacity:1; visibility:visible; pointer-events:auto; transition:opacity .25s ease; }
.modal{
  width:min(540px,100%); max-height:calc(100vh - 40px); overflow:auto;
  background:#fff; border-radius:var(--r-card); padding:34px 32px 30px;
  box-shadow:0 32px 90px rgba(4,16,28,.4);
  transform:scale(.95); opacity:.6;
  transition:transform .34s cubic-bezier(.34,1.56,.64,1), opacity .25s ease;
}
.modal-wrap.open .modal{ transform:scale(1); opacity:1; }
.modal-head{ position:relative; margin-bottom:22px; }
.modal-head h2{ font-family:var(--font-display); font-weight:700; font-size:24px; letter-spacing:-.01em; padding-inline-end:44px; }
html[dir="rtl"] .modal-head h2{ letter-spacing:0; }
.modal-head p{ margin-top:8px; font-size:14px; color:var(--muted); line-height:1.55; }
.m-close{
  position:absolute; top:-6px; inset-inline-end:-8px; width:38px; height:38px;
  border:1px solid var(--border); background:#fff; border-radius:10px;
  display:grid; place-items:center; cursor:pointer; color:var(--muted);
}
.m-close:hover{ color:var(--navy); border-color:var(--navy); }
.mc-form{ display:grid; gap:16px; }
.mc-row{ display:grid; gap:16px; }
@media (min-width:540px){ .mc-row{ grid-template-columns:1fr 1fr; } }
.field label{ display:block; font-size:13.5px; font-weight:600; margin-bottom:7px; }
.field input, .field select{
  width:100%; padding:12px 14px; border:1px solid var(--border); border-radius:10px;
  font:inherit; background:#fff; color:var(--ink);
  transition:border-color .15s, box-shadow .15s;
}
.field input:focus, .field select:focus{ outline:none; border-color:var(--teal); box-shadow:0 0 0 3px rgba(0,212,170,.18); }
.phone-wrap{ display:flex; }
.phone-prefix{
  padding:12px 14px; background:var(--bg-alt); border:1px solid var(--border);
  border-inline-end:0; color:var(--muted); font-weight:600; font-size:14px;
  border-start-start-radius:10px; border-end-start-radius:10px; direction:ltr;
}
.phone-wrap input{ border-start-start-radius:0; border-end-start-radius:0; border-start-end-radius:10px; border-end-end-radius:10px; }
.mc-form .btn{ margin-top:6px; }
.mc-privacy{ text-align:center; font-size:12.5px; color:var(--faint); }
.mc-success{ text-align:center; padding:26px 6px 10px; }
.mc-success-ic{ width:68px; height:68px; margin:0 auto; border-radius:50%; background:rgba(0,212,170,.13); display:grid; place-items:center; }
.mc-success-ic svg{ color:var(--teal-ink); }
.mc-success h3{ margin-top:20px; font-family:var(--font-display); font-weight:700; font-size:22px; }
.mc-success p{ margin-top:10px; color:var(--muted); font-size:15px; line-height:1.6; }

/* ============ Scroll reveal ============ */
.reveal-scale{ }

@media (prefers-reduced-motion: no-preference){
  .reveal{ opacity:0; transform:translateY(24px); transition:opacity .65s ease, transform .65s cubic-bezier(.2,.7,.25,1); }
  .reveal.in{ opacity:1; transform:none; }
  .reveal-scale.reveal{ transform:translateY(20px) scale(.96); }

  .hw{ opacity:0; transform:translateY(28px); animation:wordUp .65s cubic-bezier(.2,.7,.25,1) forwards; animation-delay:calc(var(--i) * 80ms + 150ms); }
  .fade-1{ opacity:0; animation:fadeUp .7s ease .55s forwards; }
  .fade-2{ opacity:0; animation:popIn .55s cubic-bezier(.34,1.4,.64,1) .75s forwards; }
  .fade-3{ opacity:0; animation:fadeUp .7s ease 1s forwards; }

  .mesh{ animation:meshMove 16s ease-in-out infinite alternate; }
  .dash-float{ animation:floatY 6s ease-in-out infinite; will-change:transform; }
  .dash-ground{ animation:groundPulse 6s ease-in-out infinite; }
  .dash-chip{ animation:floatY 7s .6s ease-in-out infinite; }
  .bars span{ transform-origin:bottom; animation:barGrow .7s cubic-bezier(.2,.7,.3,1) forwards; animation-delay:calc(var(--i) * 70ms + 500ms); transform:scaleY(0); }
  .flow-link{ animation:flowDash 1.1s linear infinite; }
  .flow-link::after{ animation:dotPulse 1.6s ease-in-out infinite; }
  .glow{ animation:pulseGlow 4.2s ease-in-out infinite; }
  .live-dot{ animation:dotPulse 2s ease-in-out infinite; }
}

@keyframes wordUp{ from{ opacity:0; transform:translateY(28px); } to{ opacity:1; transform:none; } }
@keyframes fadeUp{ from{ opacity:0; transform:translateY(18px); } to{ opacity:1; transform:none; } }
@keyframes popIn{ from{ opacity:0; transform:scale(.95); } to{ opacity:1; transform:scale(1); } }
@keyframes meshMove{ 0%{ transform:translate(-3%,-2%) scale(1); } 50%{ transform:translate(3%,3%) scale(1.08); } 100%{ transform:translate(-2%,2%) scale(1.02); } }
@keyframes floatY{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-12px); } }
@keyframes groundPulse{ 0%,100%{ transform:scale(1); opacity:.8; } 50%{ transform:scale(.88); opacity:.5; } }
@keyframes barGrow{ from{ transform:scaleY(0); } to{ transform:scaleY(1); } }
@keyframes flowDash{ to{ background-position-y:11px; } }
@keyframes dotPulse{ 0%,100%{ opacity:1; } 50%{ opacity:.35; } }
@keyframes pulseGlow{ 0%,100%{ transform:translate(-50%,-50%) scale(1); opacity:.65; } 50%{ transform:translate(-50%,-50%) scale(1.14); opacity:1; } }

@media (prefers-reduced-motion: reduce){
  html{ scroll-behavior:auto; }
  *,*::before,*::after{ animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; transition-delay:0ms !important; }
  .reveal{ opacity:1 !important; transform:none !important; }
}
/* Frostier, solid surfaces for users who prefer less translucency */
@media (prefers-reduced-transparency: reduce){
  .nav.scrolled{ background:#fff; -webkit-backdrop-filter:none; backdrop-filter:none; }
  .dash-card{ background:#fff; -webkit-backdrop-filter:none; backdrop-filter:none; }
  .flow-card{ -webkit-backdrop-filter:none; backdrop-filter:none; }
  .modal-wrap{ background:rgba(10,37,64,.78); -webkit-backdrop-filter:none; backdrop-filter:none; }
}

/* ============ Agency-style landing page refresh ============ */
:root{
  --bg:#F3F2EC; --bg-alt:#E9E8E1; --ink:#111713; --navy:#111713; --navy-deep:#071915;
  --muted:#58615B; --faint:#7C857F; --border:#CFD2CB;
  --teal:#A6F46B; --teal-bright:#BDF985; --teal-ink:#246B37; --violet:#73B7A3;
  --r-card:28px; --r-btn:999px; --r-hero:34px;
  --sh-1:0 14px 40px rgba(17,23,19,.07); --sh-2:0 30px 80px rgba(17,23,19,.14);
}
body{background:var(--bg);color:var(--ink)}
.container{max-width:1240px;padding-inline:clamp(20px,4vw,54px)}
.section{padding-block:clamp(88px,11vw,150px)}
.display{letter-spacing:-.045em;line-height:.98}
html[dir="rtl"] .display{letter-spacing:-.015em}
.h2{font-size:clamp(2.65rem,6vw,5.2rem);text-wrap:balance}
.section-head{max-width:930px;margin-bottom:clamp(48px,7vw,86px)}
.eyebrow{margin-bottom:22px;padding:8px 14px;border:1px solid currentColor;border-radius:999px;letter-spacing:.12em}
.eyebrow::after{width:7px;height:7px;border-radius:50%;opacity:1}

.btn{min-height:52px;padding-inline:26px;font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-size:14px;font-weight:700;box-shadow:none!important}
.btn-primary{background:var(--ink);color:#fff}.btn-primary:hover{background:#27302A;transform:translateY(-2px)}
.btn-ghost{background:rgba(255,255,255,.56);border-color:rgba(17,23,19,.18);color:var(--ink)}
.btn-ghost:hover{background:#fff;border-color:var(--ink);transform:translateY(-2px)}

.nav{top:16px;inset-inline:16px;border:1px solid transparent;border-radius:999px}
.nav.scrolled{background:rgba(248,248,243,.84);border:1px solid rgba(17,23,19,.12);box-shadow:0 12px 44px rgba(17,23,19,.1)}
.nav-inner{height:66px;max-width:1180px;padding-inline:22px}
.logo{font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-size:21px;font-weight:800;letter-spacing:-.05em}
.nav-links{gap:6px;padding:5px;border:1px solid rgba(17,23,19,.1);border-radius:999px;background:rgba(255,255,255,.36)}
.nav-link{padding:7px 14px;border-radius:999px;color:#3E4941;font-size:13px;font-weight:600}.nav-link:hover{background:#fff;color:#111713}
.nav-right .btn{background:var(--ink);color:#fff;padding-inline:18px}.lang-switch{border-color:rgba(17,23,19,.14);background:rgba(255,255,255,.45)}
.lang-btn.active{background:var(--ink)}

.hero{padding:158px 0 112px;min-height:100vh;background:var(--bg)}
.hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(17,23,19,.045) 1px,transparent 1px),linear-gradient(90deg,rgba(17,23,19,.045) 1px,transparent 1px);background-size:44px 44px;-webkit-mask-image:linear-gradient(#000,transparent 72%);mask-image:linear-gradient(#000,transparent 72%)}
.mesh{inset:-25% -10% 35%;filter:blur(90px);opacity:.52;background:radial-gradient(closest-side at 50% 42%,rgba(166,244,107,.68),transparent 72%),radial-gradient(closest-side at 26% 20%,rgba(115,183,163,.3),transparent 70%)}
.hero-grid{display:block;text-align:center;max-width:1160px}
.hero-grid>div:first-child{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center}
.hero-badge{padding:8px 14px;background:rgba(255,255,255,.68);color:#2E5636;border:1px solid rgba(17,23,19,.15);box-shadow:0 8px 28px rgba(17,23,19,.06);letter-spacing:.08em;text-transform:uppercase}
.hero h1{max-width:1120px;margin-top:30px;font-size:clamp(3.65rem,8vw,7rem);line-height:.9;text-wrap:balance}
.hero .h-line{display:inline}.hero .h-line+ .h-line::before{content:" "}
.hw.mark{font-style:normal}.hw.mark::before{inset:auto -.07em .04em;height:.18em;border-radius:999px;background:var(--teal);transform:rotate(-1deg)}
.hero-sub{max-width:760px;margin-top:32px;font-size:clamp(1rem,1.7vw,1.25rem);line-height:1.65;color:#4B554E;text-wrap:balance}
.hero-ctas{justify-content:center;margin-top:34px}.hero-ctas .btn{min-height:58px;padding-inline:30px}
.hero-trust{justify-content:center;margin-top:26px;font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-size:12px}.trust-item{padding:7px 11px;border:1px solid rgba(17,23,19,.12);border-radius:999px;background:rgba(255,255,255,.42)}.dot-sep{display:none}
.hero-proof{display:flex;align-items:center;gap:12px;margin-top:26px;color:var(--muted);font-size:13px;font-weight:600}
.proof-avatars{display:flex;padding-inline-start:9px}.proof-avatars span{width:34px;height:34px;margin-inline-start:-9px;display:grid;place-items:center;border:2px solid var(--bg);border-radius:50%;background:var(--ink);color:#fff;font-size:9px;font-weight:800}.proof-avatars span:nth-child(2){background:#2E6F49}.proof-avatars span:nth-child(3){background:#6B7655}.proof-avatars span:nth-child(4){background:#497B72}
.hero-visual{width:min(100%,980px);margin:84px auto 0;perspective:1600px}
.hero-visual::before{inset:4% 8% -6%;border-radius:60px;background:linear-gradient(135deg,rgba(166,244,107,.48),rgba(115,183,163,.28));filter:blur(50px)}
.dash-float{rotate:0}.dash-card{padding:clamp(18px,3vw,34px);border:1px solid rgba(17,23,19,.14);border-radius:34px;background:rgba(253,253,249,.9);box-shadow:0 38px 100px rgba(17,23,19,.18)}
.dash-tape,.dash-note{display:none}.dash-head{padding-bottom:20px}.dash-row{padding:13px 14px}.dash-chart{padding-top:22px}.bars{height:90px}.dash-chip{bottom:-19px;inset-inline-start:36px;border-color:rgba(17,23,19,.15);box-shadow:0 12px 32px rgba(17,23,19,.12)}

.ticker{background:var(--ink);border:0}.ticker-track span{padding-block:15px;color:rgba(255,255,255,.72)}.ticker-track span::after{color:var(--teal);content:"●"}
.strip{padding:34px 0;background:var(--bg);border-color:var(--border)}.strip-inner{justify-content:space-between}.strip-logos{color:#535D56;opacity:.62}

#problem{position:relative;background:#F9F8F3}
#problem::before{content:"";position:absolute;inset:20px;border:1px solid rgba(17,23,19,.1);border-radius:44px;pointer-events:none}
.stats-grid{gap:16px}.stat{min-height:230px;display:flex;flex-direction:column;justify-content:space-between;padding:30px;border-color:rgba(17,23,19,.14);border-radius:28px;background:var(--bg);box-shadow:none}.stat:hover{transform:translateY(-6px);box-shadow:0 24px 50px rgba(17,23,19,.1)}
.stat .num{font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-size:clamp(2.8rem,5vw,5.5rem);font-weight:800;letter-spacing:-.07em;background:none;color:var(--ink)}.stat .lbl{max-width:220px;font-size:14px}.problem-p{max-width:860px;margin-top:54px;font-size:19px}

#solution{width:calc(100% - 32px);margin:16px;border-radius:44px;background:#101713;overflow:hidden}
#solution .container{position:relative}#solution .container::before{content:"";position:absolute;width:600px;height:600px;inset-inline-end:-260px;top:-200px;border-radius:50%;background:rgba(166,244,107,.12);filter:blur(20px)}
.sol-item{padding:18px 0;border-bottom:1px solid rgba(255,255,255,.1)}.sol-item+.sol-item{margin-top:0}.sol-check{border-radius:50%;background:var(--teal);color:var(--ink)}.sol-check svg{color:var(--ink)}
.flow-panel{border-radius:34px;background:rgba(255,255,255,.055)}.flow-card{border-radius:18px}.sol-caption{font-family:'Inter','IBM Plex Sans Arabic',sans-serif}

#how{background:var(--bg)}.steps{gap:16px}.step{min-height:330px;padding:34px;border:1px solid rgba(17,23,19,.14);border-radius:28px;background:#FAFAF6;box-shadow:none;overflow:hidden}.step::before{content:"";position:absolute;width:170px;height:170px;right:-70px;bottom:-70px;border-radius:50%;background:rgba(166,244,107,.18)}.step::after{display:none}.step-num{width:auto;height:auto;background:transparent;color:rgba(17,23,19,.24);font-family:'Inter',sans-serif;font-size:54px;font-weight:800;letter-spacing:-.08em}.step-icon{color:var(--ink)}.step h3{font-size:26px}.step p{font-size:16px}

#pricing{background:#E5E5DD}.billing-toggle{background:rgba(17,23,19,.07);border-color:rgba(17,23,19,.12)}.billing-thumb{background:#fff}.plans{gap:16px}.plan{padding:34px;border:1px solid rgba(17,23,19,.14);border-radius:30px;background:#F8F8F3;box-shadow:none}.plan:hover{transform:translateY(-6px);box-shadow:0 22px 50px rgba(17,23,19,.1)}.plan-pop{background:var(--ink);color:#fff;border-color:var(--ink)}.plan-pop h3,.plan-pop .price .amount{color:#fff}.plan-pop .price .cur,.plan-pop .price .per,.plan-pop .plan-feat li{color:rgba(255,255,255,.65)}.plan-pop .plan-feat{border-color:rgba(255,255,255,.14)}.plan-pop .btn-primary{background:var(--teal);color:var(--ink)}.badge-pop{background:var(--teal);color:var(--ink);box-shadow:none}.price .amount{font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-size:48px;font-weight:800;letter-spacing:-.06em}

#faq{background:#F9F8F3}.faq-list{max-width:980px;gap:10px}.faq-item{border-color:rgba(17,23,19,.13);border-radius:22px;box-shadow:none;background:var(--bg)}.faq-q{padding:24px 26px;border-radius:22px;font-family:'Inter','IBM Plex Sans Arabic',sans-serif;font-weight:650}.chev{background:rgba(17,23,19,.07)}.faq-item.open{background:#fff}.faq-item.open .chev{background:var(--teal);color:var(--ink)}

.modal{border-radius:28px}.field input,.field select{min-height:48px;border-radius:14px}.m-close{border-radius:50%}
@media(max-width:960px){.nav{top:10px;inset-inline:10px}.nav-inner{grid-template-columns:1fr auto}.nav-right>.btn,.nav-right>.lang-switch{display:none}.hero{padding-top:132px}.hero h1{font-size:clamp(3.4rem,13vw,6.5rem)}.strip-inner{justify-content:center}.section-head{margin-bottom:48px}}
@media(max-width:620px){.hero{padding-bottom:78px}.hero h1{font-size:clamp(3.15rem,16vw,4.7rem)}.hero-sub{font-size:16px}.hero-ctas{width:100%;flex-direction:column}.hero-ctas .btn{width:100%}.hero-trust{gap:7px}.trust-item{font-size:10.5px}.hero-proof{flex-direction:column}.hero-visual{margin-top:62px}.dash-row:nth-child(n+4){display:none}.inv-client{max-width:112px}.strip-logos{gap:17px}.stats-grid{grid-template-columns:1fr}.stat{min-height:190px}.step{min-height:280px}#solution{width:calc(100% - 16px);margin:8px;border-radius:30px}.h2{font-size:clamp(2.5rem,12vw,3.8rem)}}

/* Hero invoice + connected clearance journey */
.hero .hero-grid{max-width:1320px;display:grid;grid-template-columns:minmax(0,1.3fr) minmax(430px,.9fr);gap:clamp(40px,5vw,76px);align-items:center;text-align:start}
.hero .hero-grid>div:first-child{min-width:0;align-items:flex-start}
.hero .hero-grid h1{max-width:760px;font-size:clamp(3.4rem,4.8vw,5.6rem);line-height:.93;text-wrap:balance}
.hero .hero-grid .hero-sub{max-width:650px}
.hero .hero-grid .hero-ctas,.hero .hero-grid .hero-trust{justify-content:flex-start}
.hero .hero-grid .hero-visual{width:100%;max-width:550px;margin:0;justify-self:end;perspective:1600px}
.hero .hero-grid .invoice-preview{padding:clamp(20px,2.3vw,34px)}
.hero .hero-grid .dash-card{border-radius:28px;box-shadow:0 34px 90px rgba(17,23,19,.17)}
[dir="rtl"] .hero .hero-grid{text-align:right}
.journey-section{position:relative;padding:clamp(82px,10vw,138px) 0;background:#10261f;color:#f7f8f4;overflow:hidden}
.journey-section::before{content:"";position:absolute;width:620px;height:620px;inset-inline-end:-230px;top:-310px;border-radius:50%;background:rgba(0,212,170,.12);pointer-events:none}
.journey-head{position:relative;max-width:850px;margin-bottom:48px}.journey-head .eyebrow{color:#73e7c7;border-color:rgba(115,231,199,.28)}
.journey-title{margin-top:18px;font-size:clamp(2.25rem,5vw,4.9rem);line-height:.98;letter-spacing:-.055em;color:#fff}.journey-sub{max-width:690px;margin-top:24px;color:rgba(247,248,244,.68);font-size:clamp(1rem,1.5vw,1.18rem);line-height:1.7}
.journey-map{position:relative;display:grid;grid-template-columns:280px 52px 240px 52px minmax(0,1fr);align-items:stretch;padding:20px;border:1px solid rgba(255,255,255,.13);border-radius:34px;background:rgba(255,255,255,.045);box-shadow:0 35px 90px rgba(0,0,0,.18)}
.journey-sources,.journey-engine,.journey-stages{border:1px solid rgba(255,255,255,.12);border-radius:24px;background:rgba(7,26,21,.58)}.journey-sources{padding:22px}.journey-kicker{display:block;margin-bottom:16px;color:rgba(255,255,255,.52);font-size:11px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
.source-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.source-pill{min-height:56px;display:flex;align-items:center;gap:6px;padding:9px 8px;border:1px solid rgba(255,255,255,.11);border-radius:14px;background:rgba(255,255,255,.055);min-width:0;font-size:11px;font-weight:750}.source-pill>span:last-child{min-width:0;overflow-wrap:anywhere;line-height:1.2}.source-mark{width:24px;height:24px;display:grid;place-items:center;flex:0 0 auto;border-radius:8px;background:#f6f8f2;color:#17392f;font-size:10px;font-weight:900}
.journey-link{position:relative;align-self:center;height:2px;background:linear-gradient(90deg,rgba(115,231,199,.18),#73e7c7)}.journey-link::after{content:"";position:absolute;inset-inline-end:-1px;top:50%;width:8px;height:8px;border-block-start:2px solid #73e7c7;border-inline-end:2px solid #73e7c7;transform:translateY(-50%) rotate(45deg)}[dir="rtl"] .journey-link{background:linear-gradient(270deg,rgba(115,231,199,.18),#73e7c7)}[dir="rtl"] .journey-link::after{transform:translateY(-50%) rotate(-135deg)}
.journey-engine{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:28px 20px;text-align:center;border-color:rgba(115,231,199,.38);background:linear-gradient(155deg,rgba(0,212,170,.18),rgba(7,26,21,.75))}.engine-seal{width:62px;height:62px;display:grid;place-items:center;margin-bottom:18px;border:1px solid rgba(115,231,199,.4);border-radius:20px;background:#73e7c7;color:#10261f}.journey-engine strong{font-family:'DM Serif Display','Noto Kufi Arabic',serif;font-size:25px}.journey-engine p{margin-top:8px;color:rgba(255,255,255,.57);font-size:12px;line-height:1.5}
.journey-stages{display:grid;grid-template-columns:repeat(4,1fr);padding:16px}.journey-stage{position:relative;padding:17px 14px}.journey-stage:not(:last-child){border-inline-end:1px solid rgba(255,255,255,.1)}.stage-num{width:31px;height:31px;display:grid;place-items:center;margin-bottom:26px;border-radius:50%;background:#73e7c7;color:#10261f;font-size:11px;font-weight:900}.journey-stage strong{display:block;font-size:13px;line-height:1.25}.journey-stage p{margin-top:8px;color:rgba(255,255,255,.48);font-size:11px;line-height:1.45}.journey-stage:last-child .stage-num{box-shadow:0 0 0 7px rgba(115,231,199,.11)}
@media(max-width:1100px){.hero .hero-grid{grid-template-columns:1fr;max-width:850px;text-align:center}.hero .hero-grid>div:first-child{align-items:center}.hero .hero-grid h1{max-width:820px;font-size:clamp(3.4rem,8vw,5.6rem)}.hero .hero-grid .hero-ctas,.hero .hero-grid .hero-trust{justify-content:center}.hero .hero-grid .hero-visual{max-width:700px;margin-top:18px;justify-self:center}.journey-map{grid-template-columns:1fr 36px 1fr}.journey-stages{grid-column:1/-1;margin-top:18px}.journey-map>.journey-link:nth-of-type(2){display:none}}
@media(max-width:680px){.hero .hero-grid{text-align:start}.hero .hero-grid>div:first-child{align-items:flex-start}.hero .hero-grid .hero-trust{justify-content:flex-start}.hero .hero-grid .hero-proof{align-items:flex-start}.hero .hero-grid .invoice-preview{padding:18px}.journey-map{display:block;padding:12px;border-radius:24px}.journey-sources,.journey-engine,.journey-stages{border-radius:18px}.journey-link{width:2px;height:34px;margin:0 auto;background:linear-gradient(180deg,rgba(115,231,199,.18),#73e7c7)}.journey-link::after,[dir="rtl"] .journey-link::after{inset-inline-end:auto;left:50%;top:auto;bottom:-1px;transform:translateX(-50%) rotate(135deg)}.journey-map>.journey-link:nth-of-type(2){display:block}.journey-stages{grid-template-columns:1fr 1fr}.journey-stage:nth-child(2){border-inline-end:0}.journey-stage:nth-child(-n+2){border-bottom:1px solid rgba(255,255,255,.1)}.source-list{grid-template-columns:1fr 1fr}}
/* Keep the invoice journey aligned in narrower desktop and split-screen layouts. */
@media(max-width:1180px){
  .journey-map{display:block;padding:16px}
  .journey-sources,.journey-engine,.journey-stages{width:100%;min-height:0}
  .journey-link{display:block!important;width:2px;height:38px;margin:0 auto;background:linear-gradient(180deg,rgba(115,231,199,.18),#73e7c7)}
  .journey-link::after,[dir="rtl"] .journey-link::after{inset-inline-end:auto;left:50%;top:auto;bottom:-1px;transform:translateX(-50%) rotate(135deg)}
  .journey-stages{margin-top:0;grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media(max-width:720px){
  .source-list{grid-template-columns:1fr}
  .journey-stages{grid-template-columns:1fr 1fr}
  .journey-stage{min-width:0}
}
</style>
<noscript><style>.reveal{opacity:1;transform:none;}/* Keep the invoice journey aligned in narrower desktop and split-screen layouts. */
@media(max-width:1180px){
  .journey-map{display:block;padding:16px}
  .journey-sources,.journey-engine,.journey-stages{width:100%;min-height:0}
  .journey-link{display:block!important;width:2px;height:38px;margin:0 auto;background:linear-gradient(180deg,rgba(115,231,199,.18),#73e7c7)}
  .journey-link::after,[dir="rtl"] .journey-link::after{inset-inline-end:auto;left:50%;top:auto;bottom:-1px;transform:translateX(-50%) rotate(135deg)}
  .journey-stages{margin-top:0;grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media(max-width:720px){
  .source-list{grid-template-columns:1fr}
  .journey-stages{grid-template-columns:1fr 1fr}
  .journey-stage{min-width:0}
}
</style></noscript>
</head>
<body>

<a class="skip-link" href="#main">Skip to content</a>

<!-- ============ NAVBAR ============ -->
<header class="nav" id="navbar">
  <div class="container nav-inner">
    <a class="logo" href="#" data-i18n-aria="brand.home_aria" aria-label="<?= tx('brand.home_aria') ?>"><span data-i18n="brand.name"><?= tx('brand.name') ?></span><span class="dot" translate="no">.</span></a>
    <nav class="nav-links" aria-label="Main">
      <a class="nav-link" href="#how" data-i18n="nav.how"><?= tx('nav.how') ?></a>
      <a class="nav-link" href="#pricing" data-i18n="nav.pricing"><?= tx('nav.pricing') ?></a>
      <a class="nav-link" href="#faq" data-i18n="nav.faq"><?= tx('nav.faq') ?></a>
    </nav>
    <div class="nav-right">
      <a class="nav-link auth-link" href="login.php?lang=<?= $LANG ?>" data-i18n="nav.login"><?= tx('nav.login') ?></a>
      <div class="lang-switch" role="group" aria-label="Language">
        <button class="lang-btn" type="button" data-lang="en">EN</button>
        <button class="lang-btn" type="button" data-lang="ar" aria-label="العربية">عربي</button>
      </div>
      <a class="btn btn-primary" href="signup.php?lang=<?= $LANG ?>" data-i18n="nav.cta"><?= tx('nav.cta') ?></a>
      <button class="nav-burger" type="button" id="drawerOpen" aria-expanded="false" aria-controls="drawer" data-i18n-aria="modal.menu_aria" aria-label="<?= tx('modal.menu_aria') ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile drawer -->
<div class="drawer-backdrop" id="drawerBackdrop" hidden></div>
<aside class="drawer" id="drawer" aria-label="Mobile menu">
  <div class="drawer-head">
    <span class="logo"><span data-i18n="brand.name"><?= tx('brand.name') ?></span><span class="dot" translate="no">.</span></span>
    <button class="drawer-close" type="button" id="drawerClose" data-i18n-aria="modal.close_aria" aria-label="<?= tx('modal.close_aria') ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <a class="d-link" href="#how" data-i18n="nav.how"><?= tx('nav.how') ?></a>
  <a class="d-link" href="#pricing" data-i18n="nav.pricing"><?= tx('nav.pricing') ?></a>
  <a class="d-link" href="#faq" data-i18n="nav.faq"><?= tx('nav.faq') ?></a>
  <a class="d-link" href="login.php?lang=<?= $LANG ?>" data-i18n="nav.login"><?= tx('nav.login') ?></a>
  <div class="lang-switch" role="group" aria-label="Language" style="margin-top:14px">
    <button class="lang-btn" type="button" data-lang="en">EN</button>
    <button class="lang-btn" type="button" data-lang="ar" aria-label="العربية">عربي</button>
  </div>
  <a class="btn btn-primary" href="signup.php?lang=<?= $LANG ?>" data-i18n="nav.cta"><?= tx('nav.cta') ?></a>
</aside>

<main id="main">

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="mesh" aria-hidden="true"></div>
  <div class="container hero-grid">
    <div>
      <span class="hero-badge fade-1">
        <svg width="18" height="13" viewBox="0 0 18 13" aria-hidden="true" style="border-radius:2px; box-shadow:0 0 0 1px rgba(10,37,64,.15)"><rect width="18" height="13" fill="#F5F7F8"/><rect width="18" height="4.34" fill="#00843D"/><rect y="8.66" width="18" height="4.34" fill="#101820"/><rect width="4.5" height="13" fill="#EF3340"/></svg>
        <span data-i18n="hero.badge"><?= tx('hero.badge') ?></span>
      </span>
      <h1 class="display">
        <span class="h-line" data-i18n-words="hero.title1" data-base="0"><?php txWords('hero.title1', 0); ?></span>
        <span class="h-line" data-i18n-words="hero.title2" data-base="3" data-marks="0,3"><?php txWords('hero.title2', 3, [0, 3]); ?></span>
      </h1>
      <p class="hero-sub fade-1" data-i18n="hero.sub"><?= tx('hero.sub') ?></p>
      <div class="hero-ctas fade-2">
        <a class="btn btn-primary btn-lg" href="signup.php?lang=<?= $LANG ?>" data-i18n="hero.cta1"><?= tx('hero.cta1') ?></a>
        <a class="btn btn-ghost btn-lg" href="#how" data-i18n="hero.cta2"><?= tx('hero.cta2') ?></a>
      </div>
      <div class="hero-trust fade-3">
        <span class="trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          <span data-i18n="hero.trust1"><?= tx('hero.trust1') ?></span>
        </span>
        <span class="dot-sep" aria-hidden="true"></span>
        <span class="trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          <span data-i18n="hero.trust2"><?= tx('hero.trust2') ?></span>
        </span>
        <span class="dot-sep" aria-hidden="true"></span>
        <span class="trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          <span data-i18n="hero.trust3"><?= tx('hero.trust3') ?></span>
        </span>
      </div>
      <div class="hero-proof fade-3">
        <span class="proof-avatars" aria-hidden="true">
          <span>AN</span><span>GL</span><span>MC</span><span>SM</span>
        </span>
        <span data-i18n="hero.proof"><?= tx('hero.proof') ?></span>
      </div>
    </div>

    <div class="hero-visual">
      <div class="dash-float">
      <div class="dash-card invoice-preview" role="img" data-i18n-aria="invoice.preview_aria" aria-label="<?= tx('invoice.preview_aria') ?>">
        <div class="invoice-top">
          <div class="invoice-business">
            <span class="business-logo" aria-hidden="true">N</span>
            <div><strong data-i18n="invoice.business"><?= tx('invoice.business') ?></strong><span data-i18n="invoice.address"><?= tx('invoice.address') ?></span><span data-i18n="invoice.trn"><?= tx('invoice.trn') ?></span></div>
          </div>
          <div class="invoice-title"><span data-i18n="invoice.type"><?= tx('invoice.type') ?></span><strong>INV-1048</strong></div>
        </div>
        <div class="invoice-meta-grid">
          <div class="invoice-client"><span class="invoice-label" data-i18n="invoice.bill_to"><?= tx('invoice.bill_to') ?></span><strong data-i18n="invoice.customer"><?= tx('invoice.customer') ?></strong><small data-i18n="invoice.customer_address"><?= tx('invoice.customer_address') ?></small></div>
          <dl class="invoice-dates">
            <div><dt data-i18n="invoice.invoice_no"><?= tx('invoice.invoice_no') ?></dt><dd>INV-1048</dd></div>
            <div><dt data-i18n="invoice.issue_date"><?= tx('invoice.issue_date') ?></dt><dd data-i18n="invoice.issued"><?= tx('invoice.issued') ?></dd></div>
            <div><dt data-i18n="invoice.due_date"><?= tx('invoice.due_date') ?></dt><dd data-i18n="invoice.due"><?= tx('invoice.due') ?></dd></div>
          </dl>
        </div>
        <div class="invoice-table" role="table">
          <div class="invoice-tr invoice-th" role="row"><span data-i18n="invoice.description"><?= tx('invoice.description') ?></span><span data-i18n="invoice.qty"><?= tx('invoice.qty') ?></span><span data-i18n="invoice.rate"><?= tx('invoice.rate') ?></span><span data-i18n="invoice.amount"><?= tx('invoice.amount') ?></span></div>
          <div class="invoice-tr" role="row"><strong data-i18n="invoice.item1"><?= tx('invoice.item1') ?></strong><span>1</span><span>AED 3,200</span><span>AED 3,200</span></div>
          <div class="invoice-tr" role="row"><strong data-i18n="invoice.item2"><?= tx('invoice.item2') ?></strong><span>1</span><span>AED 1,800</span><span>AED 1,800</span></div>
        </div>
        <div class="invoice-bottom">
          <div class="invoice-note"><span class="badge badge-green" data-i18n="invoice.status"><?= tx('invoice.status') ?></span><p data-i18n="invoice.note"><?= tx('invoice.note') ?></p></div>
          <dl class="invoice-totals"><div><dt data-i18n="invoice.subtotal"><?= tx('invoice.subtotal') ?></dt><dd>AED 5,000</dd></div><div><dt data-i18n="invoice.vat"><?= tx('invoice.vat') ?></dt><dd>AED 250</dd></div><div class="grand-total"><dt data-i18n="invoice.total"><?= tx('invoice.total') ?></dt><dd>AED 5,250</dd></div></dl>
        </div>
        <div class="invoice-powered"><span data-i18n="invoice.powered"><?= tx('invoice.powered') ?></span><strong><span data-i18n="brand.name"><?= tx('brand.name') ?></span><i translate="no">.</i></strong></div>
      </div>
      </div>
      <span class="dash-ground" aria-hidden="true"></span>
    </div>
  </div>
</section>

<!-- ============ CONNECTED INVOICE JOURNEY ============ -->
<section class="journey-section" aria-labelledby="journey-title">
  <div class="container">
    <div class="journey-head reveal">
      <span class="eyebrow" data-i18n="journey.eyebrow"><?= tx('journey.eyebrow') ?></span>
      <h2 class="display journey-title" id="journey-title" data-i18n="journey.title"><?= tx('journey.title') ?></h2>
      <p class="journey-sub" data-i18n="journey.sub"><?= tx('journey.sub') ?></p>
    </div>
    <div class="journey-map reveal" data-delay="100" role="img" data-i18n-aria="journey.aria" aria-label="<?= tx('journey.aria') ?>">
      <div class="journey-sources">
        <span class="journey-kicker" data-i18n="journey.sources"><?= tx('journey.sources') ?></span>
        <div class="source-list">
          <div class="source-pill"><span class="source-mark">X</span><span data-i18n="journey.excel"><?= tx('journey.excel') ?></span></div>
          <div class="source-pill"><span class="source-mark">QB</span><span data-i18n="journey.quickbooks"><?= tx('journey.quickbooks') ?></span></div>
          <div class="source-pill"><span class="source-mark">Z</span><span data-i18n="journey.zoho"><?= tx('journey.zoho') ?></span></div>
          <div class="source-pill"><span class="source-mark">{ }</span><span data-i18n="journey.erp"><?= tx('journey.erp') ?></span></div>
        </div>
      </div>
      <span class="journey-link" aria-hidden="true"></span>
      <div class="journey-engine">
        <span class="engine-seal" aria-hidden="true"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
        <strong data-i18n="brand.name"><?= tx('brand.name') ?></strong>
        <span class="journey-kicker" style="margin:7px 0 0" data-i18n="journey.engine"><?= tx('journey.engine') ?></span>
        <p data-i18n="journey.engine_sub"><?= tx('journey.engine_sub') ?></p>
      </div>
      <span class="journey-link" aria-hidden="true"></span>
      <div class="journey-stages">
        <div class="journey-stage"><span class="stage-num">01</span><strong data-i18n="journey.s1"><?= tx('journey.s1') ?></strong><p data-i18n="journey.s1d"><?= tx('journey.s1d') ?></p></div>
        <div class="journey-stage"><span class="stage-num">02</span><strong data-i18n="journey.s2"><?= tx('journey.s2') ?></strong><p data-i18n="journey.s2d"><?= tx('journey.s2d') ?></p></div>
        <div class="journey-stage"><span class="stage-num">03</span><strong data-i18n="journey.s3"><?= tx('journey.s3') ?></strong><p data-i18n="journey.s3d"><?= tx('journey.s3d') ?></p></div>
        <div class="journey-stage"><span class="stage-num">04</span><strong data-i18n="journey.s4"><?= tx('journey.s4') ?></strong><p data-i18n="journey.s4d"><?= tx('journey.s4d') ?></p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ TICKER ============ -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <?php for ($r = 0; $r < 2; $r++): ?>
    <span>PINT AE Ready</span><span>FTA-Accredited Channels</span><span>Excel · QuickBooks · Any System</span><span>48-Hour Onboarding</span><span>Arabic &amp; English</span><span>UAE E-Invoicing 2027</span>
    <?php endfor; ?>
  </div>
</div>

<!-- ============ TRUST STRIP ============ -->
<section class="strip" aria-label="Trust">
  <div class="container strip-inner">
    <span class="strip-lead" data-i18n="strip.lead"><?= tx('strip.lead') ?></span>
    <div class="strip-logos" aria-hidden="true">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2l8 4.5v9L12 20l-8-4.5v-9z"/></svg>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M5 20V10M12 20V4M19 20v-7"/></svg>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="5"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(-30 12 12)"/></svg>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"><path d="M3 19 9 7l4 7 3-4 5 9z"/></svg>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><circle cx="6" cy="6" r="2.2"/><circle cx="18" cy="6" r="2.2"/><circle cx="6" cy="18" r="2.2"/><circle cx="18" cy="18" r="2.2"/></svg>
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"><path d="M12 3l7 9-7 9-7-9z"/></svg>
    </div>
  </div>
</section>

<!-- ============ PROBLEM ============ -->
<section class="section" id="problem">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" data-i18n="problem.eyebrow"><?= tx('problem.eyebrow') ?></span>
      <h2 class="display h2" data-i18n="problem.title"><?= tx('problem.title') ?></h2>
    </div>
    <div class="stats-grid">
      <div class="stat reveal reveal-scale" data-delay="0">
        <div class="num" data-i18n="problem.s1n"><?= tx('problem.s1n') ?></div>
        <div class="lbl" data-i18n="problem.s1l"><?= tx('problem.s1l') ?></div>
      </div>
      <div class="stat reveal reveal-scale" data-delay="100">
        <div class="num" data-i18n="problem.s2n"><?= tx('problem.s2n') ?></div>
        <div class="lbl" data-i18n="problem.s2l"><?= tx('problem.s2l') ?></div>
      </div>
      <div class="stat reveal reveal-scale" data-delay="200">
        <div class="num" data-i18n="problem.s3n"><?= tx('problem.s3n') ?></div>
        <div class="lbl" data-i18n="problem.s3l"><?= tx('problem.s3l') ?></div>
      </div>
      <div class="stat reveal reveal-scale" data-delay="300">
        <div class="num" data-i18n="problem.s4n"><?= tx('problem.s4n') ?></div>
        <div class="lbl" data-i18n="problem.s4l"><?= tx('problem.s4l') ?></div>
      </div>
    </div>
    <p class="problem-p reveal" data-delay="150" data-i18n="problem.p"><?= tx('problem.p') ?></p>
  </div>
</section>

<!-- ============ SOLUTION ============ -->
<section class="section section-dark" id="solution">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" data-i18n="solution.eyebrow"><?= tx('solution.eyebrow') ?></span>
      <h2 class="display h2" data-i18n="solution.title"><?= tx('solution.title') ?></h2>
    </div>
    <div class="sol-grid">
      <div class="reveal">
        <div class="sol-item">
          <span class="sol-check"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg></span>
          <p data-i18n="solution.b1"><?= tx('solution.b1') ?></p>
        </div>
        <div class="sol-item">
          <span class="sol-check"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg></span>
          <p data-i18n="solution.b2"><?= tx('solution.b2') ?></p>
        </div>
        <div class="sol-item">
          <span class="sol-check"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg></span>
          <p data-i18n="solution.b3"><?= tx('solution.b3') ?></p>
        </div>
        <div class="sol-item">
          <span class="sol-check"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg></span>
          <p data-i18n="solution.b4"><?= tx('solution.b4') ?></p>
        </div>
      </div>
      <div class="flow-panel reveal" data-delay="120" aria-hidden="true">
        <div class="flow">
          <div class="flow-card">
            <div class="fc-title">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/></svg>
              <span data-i18n="solution.flow1"><?= tx('solution.flow1') ?></span>
            </div>
            <div class="fc-sub" data-i18n="solution.flow1d"><?= tx('solution.flow1d') ?></div>
          </div>
          <div class="flow-link"></div>
          <div class="flow-card" style="border-color:rgba(0,212,170,.45); background:rgba(0,212,170,.08)">
            <div class="fc-title">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
              <span data-i18n="solution.flow2"><?= tx('solution.flow2') ?></span>
            </div>
            <div class="fc-sub" data-i18n="solution.flow2d"><?= tx('solution.flow2d') ?></div>
          </div>
          <div class="flow-link"></div>
          <div class="flow-card">
            <div class="fc-title">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
              <span data-i18n="solution.flow3"><?= tx('solution.flow3') ?></span>
            </div>
            <div class="fc-sub" data-i18n="solution.flow3d"><?= tx('solution.flow3d') ?></div>
          </div>
        </div>
      </div>
    </div>
    <p class="sol-caption reveal" data-i18n="solution.caption"><?= tx('solution.caption') ?></p>
  </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="section" id="how">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" data-i18n="how.eyebrow"><?= tx('how.eyebrow') ?></span>
      <h2 class="display h2" data-i18n="how.title"><?= tx('how.title') ?></h2>
    </div>
    <div class="steps">
      <div class="step reveal" data-delay="0">
        <div class="step-head">
          <span class="step-num">01</span>
          <span class="step-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22v-5"/><path d="M9 8V2"/><path d="M15 8V2"/><path d="M18 8v5a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V8Z"/></svg></span>
        </div>
        <h3 data-i18n="how.t1"><?= tx('how.t1') ?></h3>
        <p data-i18n="how.d1"><?= tx('how.d1') ?></p>
      </div>
      <div class="step reveal" data-delay="120">
        <div class="step-head">
          <span class="step-num">02</span>
          <span class="step-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
        </div>
        <h3 data-i18n="how.t2"><?= tx('how.t2') ?></h3>
        <p data-i18n="how.d2"><?= tx('how.d2') ?></p>
      </div>
      <div class="step reveal" data-delay="240">
        <div class="step-head">
          <span class="step-num">03</span>
          <span class="step-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg></span>
        </div>
        <h3 data-i18n="how.t3"><?= tx('how.t3') ?></h3>
        <p data-i18n="how.d3"><?= tx('how.d3') ?></p>
      </div>
    </div>
  </div>
</section>

<!-- ============ PRICING ============ -->
<section class="section section-alt" id="pricing">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" data-i18n="pricing.eyebrow"><?= tx('pricing.eyebrow') ?></span>
      <h2 class="display h2" data-i18n="pricing.title"><?= tx('pricing.title') ?></h2>
      <p class="section-sub" data-i18n="pricing.sub"><?= tx('pricing.sub') ?></p>
      <div class="billing-toggle" id="billingToggle" role="group" aria-label="Billing period">
        <span class="billing-thumb" aria-hidden="true"></span>
        <button type="button" data-billing="monthly" class="active" aria-pressed="true" data-i18n="pricing.monthly"><?= tx('pricing.monthly') ?></button>
        <button type="button" data-billing="annual" aria-pressed="false" data-i18n="pricing.annual"><?= tx('pricing.annual') ?></button>
      </div>
    </div>

    <div class="plans">
      <div class="plan reveal" data-delay="0">
        <h3 data-i18n="pricing.plan1"><?= tx('pricing.plan1') ?></h3>
        <div class="price">
          <span class="cur" data-i18n="pricing.aed"><?= tx('pricing.aed') ?></span>
          <span class="amount" data-m="299" data-a="2,990">299</span>
          <span class="per js-per" data-i18n="pricing.per_mo"><?= tx('pricing.per_mo') ?></span>
        </div>
        <ul class="plan-feat">
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f1a"><?= tx('pricing.f1a') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f1b"><?= tx('pricing.f1b') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f1c"><?= tx('pricing.f1c') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f1d"><?= tx('pricing.f1d') ?></span></li>
        </ul>
        <a class="btn btn-ghost" href="signup.php?lang=<?= $LANG ?>" data-i18n="pricing.cta"><?= tx('pricing.cta') ?></a>
      </div>

      <div class="plan plan-pop reveal" data-delay="120">
        <span class="badge-pop">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
          <span data-i18n="pricing.popular"><?= tx('pricing.popular') ?></span>
        </span>
        <h3 data-i18n="pricing.plan2"><?= tx('pricing.plan2') ?></h3>
        <div class="price">
          <span class="cur" data-i18n="pricing.aed"><?= tx('pricing.aed') ?></span>
          <span class="amount" data-m="599" data-a="5,990">599</span>
          <span class="per js-per" data-i18n="pricing.per_mo"><?= tx('pricing.per_mo') ?></span>
        </div>
        <ul class="plan-feat">
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f2a"><?= tx('pricing.f2a') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f2b"><?= tx('pricing.f2b') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f2c"><?= tx('pricing.f2c') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f2d"><?= tx('pricing.f2d') ?></span></li>
        </ul>
        <a class="btn btn-primary" href="signup.php?lang=<?= $LANG ?>" data-i18n="pricing.cta"><?= tx('pricing.cta') ?></a>
      </div>

      <div class="plan reveal" data-delay="240">
        <h3 data-i18n="pricing.plan3"><?= tx('pricing.plan3') ?></h3>
        <div class="price">
          <span class="cur" data-i18n="pricing.aed"><?= tx('pricing.aed') ?></span>
          <span class="amount" data-m="999" data-a="9,990">999</span>
          <span class="per js-per" data-i18n="pricing.per_mo"><?= tx('pricing.per_mo') ?></span>
        </div>
        <ul class="plan-feat">
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f3a"><?= tx('pricing.f3a') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f3b"><?= tx('pricing.f3b') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f3c"><?= tx('pricing.f3c') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f3d"><?= tx('pricing.f3d') ?></span></li>
          <li><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span data-i18n="pricing.f3e"><?= tx('pricing.f3e') ?></span></li>
        </ul>
        <a class="btn btn-ghost" href="signup.php?lang=<?= $LANG ?>" data-i18n="pricing.cta"><?= tx('pricing.cta') ?></a>
      </div>
    </div>

    <p class="anchor-line reveal" data-i18n="pricing.anchor"><?= tx('pricing.anchor') ?></p>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" id="faq">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" data-i18n="faq.eyebrow"><?= tx('faq.eyebrow') ?></span>
      <h2 class="display h2" data-i18n="faq.title"><?= tx('faq.title') ?></h2>
    </div>
    <div class="faq-list reveal">
      <?php for ($i = 1; $i <= 7; $i++): ?>
      <div class="faq-item">
        <h3 style="margin:0">
          <button class="faq-q" type="button" id="faq-q-<?= $i ?>" aria-controls="faq-a-<?= $i ?>" aria-expanded="false">
            <span data-i18n="faq.q<?= $i ?>"><?= tx("faq.q$i") ?></span>
            <span class="chev" aria-hidden="true">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </span>
          </button>
        </h3>
        <div class="faq-a" id="faq-a-<?= $i ?>" role="region" aria-labelledby="faq-q-<?= $i ?>">
          <div class="faq-a-inner"><p data-i18n="faq.a<?= $i ?>"><?= tx("faq.a$i") ?></p></div>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

</main>

<!-- ============ CINEMATIC FOOTER ============ -->
<footer class="footer" id="footer">
  <div class="footer-orb" aria-hidden="true"></div>
  <div class="footer-word" aria-hidden="true" data-i18n="brand.word"><?= tx('brand.word') ?></div>
  <div class="footer-marquee" aria-hidden="true">
    <div class="footer-marquee-track">
      <?php for ($g = 0; $g < 2; $g++): ?>
      <div class="footer-marquee-group">
        <span data-i18n="footer.marquee1"><?= tx('footer.marquee1') ?></span><i></i>
        <span data-i18n="footer.marquee2"><?= tx('footer.marquee2') ?></span><i></i>
        <span data-i18n="footer.marquee3"><?= tx('footer.marquee3') ?></span><i></i>
        <span data-i18n="footer.marquee4"><?= tx('footer.marquee4') ?></span><i></i>
      </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="container footer-core">
    <p class="footer-eyebrow" data-i18n="footer.eyebrow"><?= tx('footer.eyebrow') ?></p>
    <h2 class="footer-title" data-i18n="footer.title"><?= tx('footer.title') ?></h2>
    <div class="footer-actions">
      <a class="footer-pill primary magnetic" href="signup.php?lang=<?= $LANG ?>">
        <span data-i18n="footer.action"><?= tx('footer.action') ?></span>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <a class="footer-pill magnetic footer-email" href="mailto:hello@invoqly.ae">hello@invoqly.ae</a>
    </div>
  </div>
  <div class="footer-meta">
    <div class="container footer-meta-row">
      <div class="footer-brand">
        <span class="logo"><span data-i18n="brand.name"><?= tx('brand.name') ?></span><span class="dot" translate="no">.</span></span>
        <p class="foot-tag" data-i18n="footer.tag"><?= tx('footer.tag') ?></p>
      </div>
      <nav class="footer-links" aria-label="Footer">
        <a href="#how" data-i18n="nav.how"><?= tx('nav.how') ?></a>
        <a href="#pricing" data-i18n="nav.pricing"><?= tx('nav.pricing') ?></a>
        <a href="#faq" data-i18n="nav.faq"><?= tx('nav.faq') ?></a>
        <span class="foot-bottom" data-i18n="footer.rights"><?= tx('footer.rights') ?></span>
      </nav>
      <button class="footer-pill back-top magnetic" id="backToTop" type="button" data-i18n-aria="footer.back" aria-label="<?= tx('footer.back') ?>">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m18 15-6-6-6 6"/></svg>
      </button>
    </div>
  </div>
</footer>

<!-- ============ CTA MODAL ============ -->
<div class="modal-wrap" id="ctaModal" aria-hidden="true">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="mcTitle">
    <div class="modal-head">
      <h2 id="mcTitle" data-i18n="modal.title"><?= tx('modal.title') ?></h2>
      <p data-i18n="modal.sub"><?= tx('modal.sub') ?></p>
      <button class="m-close" type="button" id="modalClose" data-i18n-aria="modal.close_aria" aria-label="<?= tx('modal.close_aria') ?>">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>

    <form class="mc-form" id="mcForm" novalidate>
      <div class="mc-row">
        <div class="field">
          <label for="mcName" data-i18n="modal.f_name"><?= tx('modal.f_name') ?></label>
          <input id="mcName" name="name" type="text" required autocomplete="name"
                 data-i18n-placeholder="modal.f_name" placeholder="<?= tx('modal.f_name') ?>">
        </div>
        <div class="field">
          <label for="mcEmail" data-i18n="modal.f_email"><?= tx('modal.f_email') ?></label>
          <input id="mcEmail" name="email" type="email" required autocomplete="email"
                 data-i18n-placeholder="modal.f_email" placeholder="<?= tx('modal.f_email') ?>">
        </div>
      </div>
      <div class="mc-row">
        <div class="field">
          <label for="mcPhone" data-i18n="modal.f_phone"><?= tx('modal.f_phone') ?></label>
          <div class="phone-wrap">
            <span class="phone-prefix">+971</span>
            <input id="mcPhone" name="phone" type="tel" required dir="ltr"
                   pattern="[0-9\s\-]{6,15}" placeholder="50 123 4567">
          </div>
        </div>
        <div class="field">
          <label for="mcCompany" data-i18n="modal.f_company"><?= tx('modal.f_company') ?></label>
          <input id="mcCompany" name="company" type="text" required autocomplete="organization"
                 data-i18n-placeholder="modal.f_company" placeholder="<?= tx('modal.f_company') ?>">
        </div>
      </div>
      <div class="field">
        <label for="mcVolume" data-i18n="modal.f_volume"><?= tx('modal.f_volume') ?></label>
        <select id="mcVolume" name="volume" required>
          <option value="" selected data-i18n="modal.opt0"><?= tx('modal.opt0') ?></option>
          <option value="under-50" data-i18n="modal.opt1"><?= tx('modal.opt1') ?></option>
          <option value="50-250" data-i18n="modal.opt2"><?= tx('modal.opt2') ?></option>
          <option value="250+" data-i18n="modal.opt3"><?= tx('modal.opt3') ?></option>
        </select>
      </div>
      <button class="btn btn-primary btn-lg" type="submit" data-i18n="modal.submit"><?= tx('modal.submit') ?></button>
      <p class="mc-privacy" data-i18n="modal.privacy"><?= tx('modal.privacy') ?></p>
    </form>

    <div class="mc-success" id="mcSuccess" hidden>
      <div class="mc-success-ic">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <h3 data-i18n="modal.success_t"><?= tx('modal.success_t') ?></h3>
      <p data-i18n="modal.success_b"><?= tx('modal.success_b') ?></p>
    </div>
  </div>
</div>

<script id="i18n-data" type="application/json"><?php echo json_encode($I18N, JSON_UNESCAPED_UNICODE); ?></script>
<script>
(function () {
  'use strict';

  /* ---------- i18n ---------- */
  var dict = {};
  try { dict = JSON.parse(document.getElementById('i18n-data').textContent); } catch (e) {}
  var lang = document.documentElement.lang === 'ar' ? 'ar' : 'en';
  var billing = 'monthly';

  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }
  function resolve(key) {
    return key.split('.').reduce(function (o, p) { return o ? o[p] : undefined; }, dict);
  }

  function splitWords(el, text) {
    el.textContent = '';
    var base = parseInt(el.dataset.base || '0', 10);
    var marks = (el.dataset.marks || '').split(',').filter(Boolean);
    text.split(' ').forEach(function (w, i) {
      if (!w) return;
      var s = document.createElement('span');
      s.className = 'hw' + (marks.indexOf(String(i)) !== -1 ? ' mark' : '');
      s.style.setProperty('--i', base + i);
      s.textContent = w;
      el.appendChild(s);
      el.appendChild(document.createTextNode(' '));
    });
  }

  function applyBilling(mode) {
    billing = mode;
    $$('.amount').forEach(function (el) {
      el.textContent = mode === 'annual' ? el.dataset.a : el.dataset.m;
    });
    var k = mode === 'annual' ? 'pricing.per_yr' : 'pricing.per_mo';
    var v = resolve(k);
    $$('.js-per').forEach(function (el) { if (v) el.textContent = v[lang]; });
    var t = $('#billingToggle');
    if (t) t.classList.toggle('annual', mode === 'annual');
    $$('#billingToggle button').forEach(function (b) {
      var on = b.dataset.billing === mode;
      b.classList.toggle('active', on);
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function applyLang(l) {
    lang = l;
    document.documentElement.lang = l;
    document.documentElement.dir = l === 'ar' ? 'rtl' : 'ltr';
    $$('[data-i18n]').forEach(function (el) {
      var v = resolve(el.dataset.i18n);
      if (v) el.textContent = v[l];
    });
    $$('[data-i18n-placeholder]').forEach(function (el) {
      var v = resolve(el.dataset.i18nPlaceholder);
      if (v) el.placeholder = v[l];
    });
    $$('[data-i18n-aria]').forEach(function (el) {
      var v = resolve(el.dataset.i18nAria);
      if (v) el.setAttribute('aria-label', v[l]);
    });
    $$('[data-i18n-words]').forEach(function (el) {
      var v = resolve(el.dataset.i18nWords);
      if (v) splitWords(el, v[l]);
    });
    var t = resolve('meta.title');
    if (t) document.title = t[l];
    applyBilling(billing);
    $$('.lang-btn').forEach(function (b) { b.classList.toggle('active', b.dataset.lang === l); });
    try { localStorage.setItem('invoqly-lang', l); } catch (e) {}
  }

  $$('.lang-btn').forEach(function (b) {
    b.addEventListener('click', function () { applyLang(b.dataset.lang); });
    b.classList.toggle('active', b.dataset.lang === lang);
  });
  var saved = null;
  try { saved = localStorage.getItem('invoqly-lang'); } catch (e) {}
  if (saved && saved !== lang) applyLang(saved);

  /* ---------- Navbar ---------- */
  var nav = $('#navbar');
  function onScroll() { nav.classList.toggle('scrolled', window.scrollY > 40); }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Drawer ---------- */
  var drawer = $('#drawer'), backdrop = $('#drawerBackdrop');
  function setDrawer(open) {
    drawer.classList.toggle('open', open);
    backdrop.hidden = false;
    backdrop.classList.toggle('open', open);
    $('#drawerOpen').setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('no-scroll', open);
  }
  $('#drawerOpen').addEventListener('click', function () { setDrawer(true); });
  $('#drawerClose').addEventListener('click', function () { setDrawer(false); });
  backdrop.addEventListener('click', function () { setDrawer(false); });
  $$('#drawer a').forEach(function (a) { a.addEventListener('click', function () { setDrawer(false); }); });

  /* ---------- Scroll reveal ---------- */
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          var d = en.target.dataset.delay;
          if (d) en.target.style.transitionDelay = d + 'ms';
          en.target.classList.add('in');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -36px 0px' });
    $$('.reveal').forEach(function (el) { io.observe(el); });
  } else {
    $$('.reveal').forEach(function (el) { el.classList.add('in'); });
  }

  /* ---------- FAQ ---------- */
  $$('.faq-item').forEach(function (item) {
    var btn = $('.faq-q', item);
    btn.addEventListener('click', function () {
      var wasOpen = item.classList.contains('open');
      $$('.faq-item.open').forEach(function (i) {
        i.classList.remove('open');
        $('.faq-q', i).setAttribute('aria-expanded', 'false');
      });
      if (!wasOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  /* ---------- Billing toggle ---------- */
  $$('#billingToggle button').forEach(function (b) {
    b.addEventListener('click', function () { applyBilling(b.dataset.billing); });
  });

  /* ---------- Modal ---------- */
  var modal = $('#ctaModal'), form = $('#mcForm'), success = $('#mcSuccess'), lastFocus = null;
  function openModal() {
    lastFocus = document.activeElement;
    form.hidden = false;
    success.hidden = true;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('no-scroll');
    setDrawer(false);
    setTimeout(function () { var f = $('#mcName'); if (f) f.focus(); }, 120);
  }
  function closeModal() {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('no-scroll');
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }
  $$('[data-open-modal]').forEach(function (b) {
    b.addEventListener('click', function (e) { e.preventDefault(); openModal(); });
  });
  $('#modalClose').addEventListener('click', closeModal);
  modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      if (modal.classList.contains('open')) closeModal();
      if (drawer.classList.contains('open')) setDrawer(false);
    }
  });

  /* ---------- Dashboard 3D tilt — damped mouse-parallax (CSS 3D, desktop only) ---------- */
  var heroVisual = $('.hero-visual'), dashCard = $('.dash-card');
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  var finePointer = window.matchMedia('(pointer: fine)');
  if (heroVisual && dashCard && 'IntersectionObserver' in window
      && !reduceMotion.matches && finePointer.matches) {
    var tX = 0, tY = 0, cX = 0, cY = 0, raf = null, inView = true;
    new IntersectionObserver(function (entries) {
      inView = entries[0].isIntersecting;
      if (!inView && raf) { cancelAnimationFrame(raf); raf = null; }
    }).observe(heroVisual);
    function tiltLoop() {
      cX += (tX - cX) * 0.08;
      cY += (tY - cY) * 0.08;
      dashCard.style.setProperty('--ty', cX.toFixed(2) + 'deg');
      dashCard.style.setProperty('--tx', cY.toFixed(2) + 'deg');
      if (Math.abs(tX - cX) < 0.01 && Math.abs(tY - cY) < 0.01) { raf = null; return; }
      raf = requestAnimationFrame(tiltLoop);
    }
    heroVisual.addEventListener('pointermove', function (e) {
      var r = heroVisual.getBoundingClientRect();
      tX = ((e.clientX - r.left) / r.width - 0.5) * -5;   /* ±2.5deg — subtle, invites */
      tY = ((e.clientY - r.top) / r.height - 0.5) * 5;
      if (!raf) raf = requestAnimationFrame(tiltLoop);
    });
    heroVisual.addEventListener('pointerleave', function () {
      tX = 0; tY = 0;
      if (!raf) raf = requestAnimationFrame(tiltLoop);
    });
  }

  /* ---------- Cinematic footer: parallax + magnetic controls ---------- */
  var footer = $('#footer'), footerWord = $('.footer-word'), footerOrb = $('.footer-orb');
  if (footer && footerWord && footerOrb && !reduceMotion.matches) {
    var footerRaf = null;
    function paintFooter() {
      var r = footer.getBoundingClientRect();
      var progress = Math.max(0, Math.min(1, (window.innerHeight - r.top) / (window.innerHeight + r.height)));
      footerWord.style.transform = 'translateY(' + ((1 - progress) * 54).toFixed(1) + 'px) scale(' + (0.92 + progress * 0.08).toFixed(3) + ')';
      footerOrb.style.transform = 'scale(' + (0.86 + progress * 0.18).toFixed(3) + ')';
      footerRaf = null;
    }
    window.addEventListener('scroll', function () {
      if (!footerRaf) footerRaf = requestAnimationFrame(paintFooter);
    }, { passive:true });
    paintFooter();

    if (finePointer.matches) {
      $$('.magnetic', footer).forEach(function (el) {
        el.addEventListener('pointermove', function (e) {
          var r = el.getBoundingClientRect();
          var x = (e.clientX - r.left - r.width / 2) * .18;
          var y = (e.clientY - r.top - r.height / 2) * .18;
          el.style.transform = 'translate3d(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px,0)';
        });
        el.addEventListener('pointerleave', function () {
          el.animate([{ transform:el.style.transform },{ transform:'translate3d(0,0,0)' }], { duration:420, easing:'cubic-bezier(.2,.8,.2,1)' });
          el.style.transform = '';
        });
      });
    }
  }
  $('#backToTop').addEventListener('click', function () {
    window.scrollTo({ top:0, behavior:reduceMotion.matches ? 'auto' : 'smooth' });
  });

  /* ---------- Lead form (demo submit — wire to your endpoint/CRM here) ---------- */
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!form.checkValidity()) { form.reportValidity(); return; }
    form.hidden = true;
    success.hidden = false;
  });
})();
</script>
</body>
</html>
