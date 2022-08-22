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
	
	<h4>
	    سياسة الخصوصية لموقع تامينى ستور
	</h4>
	<p>
	    يلتزم تامينى ستور بالمحافظة على خصوصيتك، ويقوم تامينى ستور بجمع معلومات مختلفة من زواره ليتمكن من تقديم خدمات أفضل لاحتياجاتك. عند دخولك موقعنا الإلكتروني، فإنك توافق على ممارسات جمع المعلومات واستخدامها ومشاركتها مع الآخرين المدرجة في سياسة الخصوصية، وفي حالة عدم الموافقة على شروط سياسة الخصوصية، نرجو عدم استخدام الموقع.
يتيح تامينى ستور حرية التجول في أقسامنا المختلفة  ومعارضنا المختلفه والحصول على المعلومات المتوفرة عليه دون إدخال أي معلومات شخصية ، ومع ذلك، فللوصول إلى معلومات أو خدمات أو مزايا محددة قد تكون متاحة على الموقع، قد نطلب منك تزويدنا ببعض المعلومات الشخصية، مثل الاسم والبريد الإلكتروني والعمر ورقم الهاتف ومعلومات مماثلة للتعريف عن نفسك (بالإجمال "معلومات شخصية"). فمثلاً، سنقوم بجمع معلومات شخصية محددة منك إذا طلبت المزيد من المعلومات عن مركبة ما تهمك. او متجر للبيع خاص بك  وباستخدام خدمة "بع سيارتك" سيتطلب الأمر تزويد بعض المعلومات الشخصية، بالإضافة إلى أننا سنطلب معلومات شخصية محددة إذا اخترت أن تسجل حساباً على الموقع أو تنضم إلى قائمة البريد الإلكتروني الخاصة بنا أو استلام رسائلنا أو المشاركة في عروض خاصة أو تسجل في غرفنا للدردشة أو لوحة الإعلانات أو أي أماكن عامة أخرى أو إرسال أسئلة أو ملاحظات لنا عبر البريد الإلكتروني.
كما إننا قد نجمع بعض المعلومات الديموغرافية (مثل الجنس أو العمر) ومعلومات حوال اهتماماتك وأفضلياتك ("المعلومات المفضلة"). وفي كثير من الحالات تكون هذه المعلومات الديموغرافية والأفضليات اختيارية، وإذا ما استخدمنا أي من المعلومات الديموغرافية والأفضليات مجتمعة مع أي معلومات شخصية أخرى، فإن هذه المعلومات ستُعامل على أساس معلومات شخصية تحت سياسة الخصوصية هذه. وإذا قمت بالشراء، فقد نسألك عن رقم بطاقتك الائتمانية ومعلومات سداد الفواتير.
قد نقوم بجمع معلومات عن زياراتك لموقعنا، تتضمن الصفحات التي قمت بتصفحها والروابط والإعلانات التي اطلعت عليها وشروط البحث التي أدخلتها وأي نشاط قمت به ذو علاقة بموقع تامينى ستور وخدماته. وقد نجمع معلومات محددة من المتصفح الذي استخدمته للوصول إلى موقعنا، مثل عنوان برتوكول الإنترنت (IP address) ونوع المتصفح واللغة وأوقات الدخول و مُحدد المصدر المُنتظم (Uniform Resource Locator URL) للموقع الذي دلك على موقعنا وأي (URL) تتصفح إذا خرجت من موقعنا بالضغط على رابط على موقعنا.
وبغية توفير تجربة منتظمة وشخصية في تعاملك مع تامينى ستور، فإن المعلومات التي يتم جمعها من خلال مصدر واحد قد يتم دمجها مع معلومات تم الحصول عليها من مصادر أخرى. وقد نُلحق المعلومات التي نجمعها مع المعلومات التي تم الحصول عليها من أطراف أخرى كذلك.
وقد نتشارك معلوماتك الشخصية مع شركائنا لتمشية التعاملات التي تطلبها أو لإجراء أعمال أو إن شركائنا قد يكونون أكثر قدرة على تلبية طلبك. وإننا قد نكشف معلوماتك الشخصية بما يتعلق بفرض القانون أو منع التحايل أو أي إجراء قانوني آخر، وكما تتطلبه القوانين، أو أن تامينى ستور يعتقد أنه من الضروري حماية تامينى ستور أو الجمهور. إضافة لذلك، قد نشارك شركائنا الآخرين بمعلوماتك الشخصية التي تساعد تامينى ستور في تسهيل التعاملات التي تطلبها أو تفصيل وتحليل و/أو تحسين اتصالات وعلاقات تامينى ستور معك، وبعد ذلك فقط مع شركائنا الذين يتشاركون معنا في الالتزام بحماية معلوماتك الشخصية. عدا ما تم إدراجه أعلاه، فإننا لن نكشف معلوماتك الشخصية إلى طرف ثالث لأغراض تسويقية خاصة بهم إلا إذا وافقت على ذلك.
من وقت لآخر، قد نجمع معلومات عامة وغير شخصية وإحصائية ونُشرك بها الآخرون حول استخدام الموقع، مثل عدد زوار الموقع لصفحة معينة عليه والمدة التي قضوها على هذه الصفحة وأي الروابط ضغطوا عليها، إن وجدت. إننا نجمع هذه المعلومات لتحديد المجالات الأكثر شعبية في الموقع  وتعزيز الموقع للزوار. وإننا قد نُجمع المعلومات على شكل بيانات تجميعية للزوار لوصف طريقة استخدام الموقع لشركائنا الحاليين والمحتملين وعملائنا والأطراف الأخرى أو لتلبية طلبات الحكومة. ومع ذلك، نود أن نرجو الاطمئنان إلى أننا سنقوم بالتعريف عنك بصورة شخصية أو أي زائر آخر لموقعنا.
قد يحوي موقعنا روابط لمواقع أخرى كالشركات التابعة والمعلنين، وقد يكون لهذه المواقع سياسات خصوصية مختلفة، فإذا ضغطت على موقع آخر، قد يكون الأفضل مراجعة سياسة الخصوصية لذلك الموقع، وقد يكون عادة (وليس دائماً) مُعلناً على الموقع نفسه. إن تامينى ستور غير مسؤول عن محتوى المواقع الأخرى وأمنها وممارسات الخصوصية المعمول بها.
يأخذ تامينى ستور مسألة خصوصية الأطفال على محمل الجد، فإننا لا نجمع معلومات شخصية من الأطفال دون الثالثة عشر من العمر من خلال موقعنا. فإذا كان عمرك أقل من 18 سنة، يرجى عدم تقديم أي معلومات شخصية من خلال موقعنا دون تقديم الموافقة السريعة من أحد والديك أو الوصي عليك.
إذا كانت لديك أي استفسارات حول سياسة الخصوصية هذه أو تعاملنا مع معلوماتك الشخصية، يرجى الاتصال بنا.

	</p>
	
	
	@endif
</div>




@endsection