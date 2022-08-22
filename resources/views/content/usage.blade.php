@extends('layouts.app')
@section('content')
<?php 
	use Carbon\Carbon;
	Carbon::setLocale(LC_TIME, $lang);;
	if($lang == 'ar' || $lang == 'en')
		{
			App::setlocale($lang);
		}
		else
		{
			App::setlocale('ar');
		}

?>
<div class="container-fluid">
	@if($lang == 'en') 
	
	<h4>
	    Privacy Policy
	</h4>
	<p>
	    Tameenistore.com.com is committed to protecting your privacy. Tameenistore.com.com collects various information from its visitors in order to better service your needs. By accessing our website, you are consenting to the information collection, use and sharing practices described in this Privacy Policy. If you do not agree to the terms of this Privacy Policy, please do not use the website.
        Tameenistore.com.com allows you to browse through our various sections and access the information available on the website without entering any personal information. However, in order to access certain information, services or features that may be available on the website, we may require you to provide personal information such as your name, email address, age, and phone number and other similar information that can be used to identify you (collectively, "Personal Information"). For example, we will collect certain Personal Information from you if you request more information about a vehicle you are interested in. Using the "Sell Your Car" service will also require that you provide Personal Information. In addition, we may collect certain Personal Information if you choose to register for an account on the website, join our email list, subscribe to our newsletter, participate in special offers, sign up for our chat rooms, message boards or other public venues or send questions or comments to us via email.
        We may also collect certain demographic information (such as gender or age) and information about your interests and preferences ("preferences information"). In many cases, such demographic and preferences information is optional. If we ever use any demographic or preferences information combined together with any Personal Information, then such combined information will be treated as Personal Information under this Privacy Policy. If you make a purchase, we may ask for your credit card number and billing information.
        We may collect information about your visits to our website, including the pages you view, the links and ads you click, search terms you enter, and other actions you take in connection with the Tameenistore.com website and services. We may also collect certain information from the browser you used to come to our website, such as your Internet Protocol (IP) address, browser type and language, access times, the Uniform Resource Locator (URL) of the website that referred you to our website and to which URL you browse away from our site if you click on a link on our site.
        In order to offer you a more consistent and personalized experience in your interactions with Tameenistore.com, information collected through one source may be combined with information obtained through other resources. We may also supplement the information we collect with information obtained from other parties.
        We may share your personal information with corporate affiliates to carry out transactions you request or to make our business or that of our corporate affiliates more responsive to your needs. We may also disclose your personal information in connection with law enforcement, fraud prevention, or other legal action; as required by law or regulation; or if Tameenistore.com reasonably believes it is necessary to protect Tameenistore.com, its customers, or the public. In addition, we may share your personal information with business partners that help Tameenistore.com carry out transactions you request or that help Tameenistore.com to customize, analyze, and/or improve our communication or relationship with you, and then only with business partners who share our commitment to protecting your personal information. Except as described above, we will not disclose your personal information to third parties for their own marketing purposes unless you have provided consent.
        From time to time, we may collect and share with others general, non-personal, statistical information about the use of the website, such as how many visitors visit a specific page on the website, how long they stay on that page, and which hyperlinks, if any, they "click" on.  We collect this information in order to determine which areas of the website are most popular and to enhance the website for visitors. We may also group this information into aggregate visitor data in order to describe the use of the website to our existing or potential business partners, clients or other third parties, or in response to a government request. However, please be assured that this aggregate data will in no way personally identify you or any other visitors to the website.
        Our website may contain links to other websites such as our affiliates and advertisers. Those websites may have different privacy policies. If you click on to another website, you may want to check the privacy policy of that site, which will usually (but not always) be posted on the web site. Tameenistore.com is not responsible for the content, security, or privacy practices employed by other websites.
        Tameenistore.com takes children's privacy seriously. We do not knowingly collect personal information from children under the age of 13 through our websites. If you are under 18 years of age, please do not submit any personal information through our websites without the express consent and participation of a parent or guardian.
        If you have questions regarding this Privacy Policy or our handling of your Personal Information, please Contact Us.

	</p>
	
	@else
	
  شروط الإستخدام العامة لموقع تامينى ستور 
توضح هذه الصفحة شروط الاستخدام التي تتيح لك استخدام الموقع سواء بصفة زائر أو مستخدم مسجل لذلك نرجو قراءة شروط الاستخدام هذه بعناية قبل أن تبدأ باستخدام الموقع.وبمجرد دخولك إلى الموقع واستخدامك إياه، تكون قد قبلت بشروط الاستخدام هذه ووافقت على الالتزام بها.وإذا لم توافق على هذه الشروط، فلا يسمح لك باستخدام الموقع.
1.	1. حقوق الملكيه الخاصه بالموقع⇑
o	- توافق بموجب هذه الشروط على أن الموقع هو المالك الوحيد لحقوق الملكية الفكرية المتواجده به وهو الجهه الوحيده المرخص لها باستخدام المحتوى ويتمتع الموقع بالحماية بموجب قوانين ومعاهدات حقوق النشر في مختلف أنحاء العالم.
o	- لا يحق لك نسخ أي شيء من الموقع أو المحتوى أو توزيعه أو إعادة إنتاجه أو بيعه أو تأجيره أو نقله أو ترخيص استخدامه للغير أو إعاقته.
o	- كما لا يجوز لك تعديل أي شيء في الموقع أو المحتوى أو تكوين مشتقات منه، إلا فيما يتعلق بالمحتوى الخاص بك .
o	- لا يجوز لك تفكيك أو تحليل أي شيفرة مصدرية يحتويها الموقع أو أية برمجية أو قاعدة بيانات ترتبط بالموقع، أو عكس هندسة هذه الشيفرة أو محاولة اكتشافها بطريقة أخرى.
2.	2. محتوى الموقع⇑
o	يعني "المحتوى" أي مادة مدرجة أو منتديات، أو قوائم فعاليات، أو مراجعات أو منشورات أو رسائل أو نصوص أو ملفات أو صور أو أي مواد أخرى تنشر على الموقع. ولدى نشرك لأي محتوى على الموقع، فإنك:
1.	تمنح الموقع حقاً شاملاً وعالمياً ودائماً لا رجعة فيه ومعفى من أي رسوم حقوق ملكية وقابلاً للمنح للغير، في استخدام ونسخ المحتوى أو إعادة إنتاجه أو توزيعه أو عرضه أو تعديله أو تكوين مشتقات منه على الدوام ولأي غرض نراه مناسباً ويسمح به القانون؛
2.	تؤكد بان المالك لأي حقوق في هذا المحتوى، بما فيها الحقوق المعنوية، قد تنازل كلية وبصورة نافذة عن كافة هذه الحقوق وقد منحه للموقع بصورة صحيحة لا رجعة فيها
3.	تسمح لأي مستخدم آخر للموقع بالوصول إلى هذا المحتوى وعرضه ومطالعته وتخزينه وإعادة إنتاجه.
4.	تمنح الموقع الحق في أن يمنع لاحقاً أي وصول لهذا المحتوى أو تخزينه أو إعادة إنتاجه أو استخدامه من قبل أي طرف وللمستوى الذي يراه الموقع مناسباً.
o	- 2 الابلاغ عن اى انتهاكات
	- يمنع نشر أي محتوى يخالف أية قوانين دولية أو اتحادية أو وطنية أو محلية أو خاصة بحقوق النشر أو براءات الاختراع أو العلامات التجارية أو حقوق الملكية الفكرية الأخرى .
	- لا يتحمل الموقع المسؤولية عن أي محتوى يقدمه أحد المستخدمين وينتهك به حقوق ملكية تعود لمستخدم آخر.
	- لإذا علمت بوجود أي محتوى تعتقد أنه ينتهك حقوق الملكية الخاصة بك أو بطرف إتصل بنا .
3.	3. الدخول الى الموقع والروابط الموصله اليه⇑
o	- إن الحق الذي يمنحه لك الموقع في الدخول اليه لا يقوم على أساس شامل ونهائي بل على أساس مؤقت وقابل للتراجع عنه، ويحتفظ الموقع بحقه في سحب حق الدخول إلى الموقع أو تعديله دون الحاجة لإعطاء إشعار بذلك.
o	- ولا يتحمل الموقع أي تبعة أو مسؤولية إذ توقفت إتاحة الموقع لأي سبب كان ولأي مدة كانت.
o	- ولا يجوز لك: استخدام برامج التصفح الأوتوماتيكي للشبكة الإلكترونية، كالبرامج المعروفة بالعنكبوت الآلي robot spider برنامج scraper وغيرها، للدخول إلى الموقع وتجميع المحتوى لأي غرض كان أو القيام بنسخ المحتوى أو تنزيله بطريقة أخرى. ويتم منح استثناء محدود من هذه القاعدة لمحركات البحث ومكتبات الأرشفة العامة غير التجارية، لكن ليس للمواقع الإلكترونية التي تضم أي شكل من أشكال القوائم المبوبة.
4.	4. إعلانات مميَّزة⇑
يقدم تامينى ستورخدمة تُعرف باسم «الإعلانات المميَّزة»، يمكن للمستخدمين من خلالها سداد رسم غير قابل للاسترداد لنشر إعلاناتهم في صفحات مختارة من الموقع، لزيادة احتمالية رؤية الإعلانات. ولشراء إعلان مميَّز وتكون مدة الأعلان 14 يوم أيضا فيما يخص سياسة أستخدام الاعلانات المميزة الرصيد يظل في الحساب مدة سنة فقط .
5.	5. سياسة الخصوصية⇑
هذا القسم الخاص بسياسة الخصوصية المعمول به في موقع تامينى ستوريعالج أمور مثل البيانات المأخوذة من العضو المسجل بموقع تامينى ستورو غيرها مما يتعلق بالزائرين و الأعضاء بشكل عام و يطبق كل ما فيه على أي خدمة بالموقع أو منتج من منتجاته .
- البيانات الشخصية
o	نحن ربما ما نقوم بتجميع بعض الملعومات و البيانات الشخصية من العضو أو الزائر بطرق مختلفة، فمثلا عندما يقوم بالتسجيل بالموقع أو تسجيل إعلانه للبيع أو الشراء أو التسجيل بالقائمة البريدية الخاصة بالموقع أو أن يقوم بالموافقة على جمع بعض البيانات عندما يسأل في ذلك من شأنها سؤاله عن تطوير خدمة معينة أو إستطلاع رأي و لربما ما نظهر تلك البيانات معروضة على موقعنا، بعض البيانات التي قد نجمعها من الأعضاء و الزائرين هي الإسم و السن و البريد الإلكتروني ورقم الهاتف و بيانات البطاقة الإتمانية إذا كان سيقوم بشراء شيء ما، يستطيع المستخدم أن يرفض من البداية بتزويدنا أي من تلك البيانات ما لم تكن مطلوبة لإمكانه من إستخدام خدمة بالموقع أو الموقع ككل .
- بيانات ليست شخصية
o	نحن ربما ما نقوم بتجميع بعض المعلومات و البيانات الغير شخصية من المستخدم العضو أو الزائر للموقع كي يقوموا بالتفاعل مع خدمات الموقع المختلفة كمثل نوع المتصفح الذي يقوم بإستخدامه لتصفح موقعنا و ما هو نظام التشغيل الخاص به و مزود خدمة الإنترنت، بالأحرى هي بيانات تقنية تساعدنا على إيجاد الطريقة الأمثل لتمكين المستخدم من إتصال أفضل بموقعنا و بخدماته المختلفة
- كعكات المتصفح الإلكتروني
o	موقعنا من الممكن أن يقوم بإستخدام الكعكات البرمجية الإلكترونية لكي تحسن من مدى إستخدام المستخدم لموقعنا و خدماته المختلفة، و تقوم تلك الكعكات بحفظ نفسها على الكمبيوتر الخاص بالمستخدم لكي تساعد الموقع على أداء أفضل لكل مستخدم له كعكه خاصة به بالموقع بالدخول السريع للموقع و تحميل بياناته و الصور بالسرعة الكافية .
- كيف نقوم بجمع البيانات و المعلومات ؟
o	يقوم موقع تامينى ستوربتجميع تلك البيانات و المعلومات عن طريق الطرق التالية : تشخيص البيانات : من الممكن أن نجمع بيانات و معلومات تفيدنا في كيف هو الموقع مفيد للمستخدم من ناحية سهولة الإستخدام و سرعة الوصول للمعلومات و الخدمات المختلفة . تحسين الموقع : نقوم بجمع بعض البيانات كالتغزيات المرتجعة عن أراء المستخدمين بالموقع و الخدمات المختلفة المقدمه لهم حتي نقوم بالتطوير المستمر و التحسين المستمر للموقع و خدماته. لإعلام المستخدم ببعض الخدمات الجديدة و المواضيع الجديدة و الإعلانات الجديدة : نقم بهذه الحملات لكي نبقى المستخدم على علم بما نقوم بالموقع من تحديثات جديدة أو تمرير بعض المستجدات من مواضيع و غيرها ليبقيه على علم
- كيف نقوم بحماية معلوماتك ؟
o	البيانات الشخصية و بيانات حساب الإتمان التي يتم تمريرها عن طريق بروتوكول SSL تكون مشفرة بالكامل ولا يتم نشرها أبداً ولا تخزينها بالموقع .
- نشر بياناتك
o	لا نقوم ببيع معلوماتك المسجله لدينا ولا الإتجار بها ولا نشر بياناتك الشخصية لأخرون، من الممكن أن نقوم بنشر بعض المعلومات العامة أو الإحصائيات التي قمت بالمشاركة بها مع علم أننا لا نشير بعين إلى أحد من من قاموا بالمشاركة في تلك الإحصائيات أو غيرها، من الممكن أن نقوم بإستخدام بياناتك المسجلة لدينا في حال إنشاء موقع أخر نقوم نحن عليه
- الإعلانات
o	نقوم بنشر الإعلانات على موقعنا و هذه الإعلانات من الممكن أن تستخدم الكعكات المخصصة لكل مستخدم أو لفئة معينة من المستخدمين كي تناسب الإعلانات الموجهه إليهم .
- التغييرات على سياسة الخصوصية
o	من الممكن أن نقوم بتغيير سياسة الخصوصية ككل أو تغيير جزء منها أو حذف جزء منها و ذلك بدون إعلام أحداً بهذا و كل ما نقوم بتمكينه لإعلام المستخدم هو أخر تحديث لهذه الوثيقة و المدون في أخرها بالتاريخ.
- التصديق على سياسة الخصوصية
o	بمجرد تسجيلك بالموقع و إستخدامك له فهذا تصديق منك على أنك موافق على كل ما ورد بسياسة الخصوصية بالبعضية و الكلية .
- الإتصال بنا
o	تستطيع الإتصال بنا دوما عن طريق بالضغط هنا
أخر تحرير لهذه الوثيقة – سياسة الخصوصية – كان في يوم الخميس الموافق 26 إبريل 2012
بموجب تلك القوانين الخاصه بالموقع فانت توافق على شروط الاستخدام الخاصه به واذا لم توافق فلا حق لك فى استخدام الموقع او ممارسه اى نشاط على علاقه به ومن حق الموقع أن يضع أي حدود يراها وفقاً لتقديره الخاص على استخدامك للموقع، وهذا يشمل، لكن لا يقتصر على، الحدود المفروضة على المدة التي يمكن أن يبقى فيها المحتوى على الموقع الإلكتروني، وحجم ملف كل مادة من مواد المحتوى، وعدد مواد المحتوى التي يمكن نشرهاويحتفظ الموقع بحقه في حجبك أو منعك من الدخول لقاء أي خرق لشروط الاستخدام هذه في أي وقت ودون الحاجة لإخطارك بذلك. يمكن أن تتعرض هذه الشروط للتحديث من وقت لآخر. وسوف نبلغك بأي تحديثات هامة تطرأ عليها من خلال توجيه تنبيه إليك يبين هذه التغييرات. ويعتبر استمرار استخدامك لخدماتنا موافقة منك على التغييرات الحاصلة. وستبقى هذه الشروط متاحة لجميع المستخدمين على هذه الصفحة لمطالعتها. كما يمكن أن تنسخ بعض الأحكام الواردة في شروط الاستخدام هذه أو تتمم بأحكام أو إخطارات تنشر في مكان آخر من الموقع ونرجو إبلاغنا إذا علمت بوجود أي مخالفات من الآخرين لشروط الاستخدام هذه.


	
	
	@endif
</div>




@endsection