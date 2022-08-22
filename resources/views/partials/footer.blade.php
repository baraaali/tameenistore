<footer>
    <div class="footer-top bg-white  p-4">
        <p class="font-weight-bold text-center">حمل تطبيق تأميني ستور مجانا  </p>
    <div class="d-flex justify-content-center">
        <div class="mx-2">
            <a  href="#"
                target="_blank" title="التحميل من متجر ابل"
                alt="التحميل من متجر ابل">
                <img width="150" src="{{ asset('assets_web/images/apple_appstore_badge_en.svg') }}"
                    title="التحميل من متجر ابل" alt="التحميل من متجر ابل"
                    class="img-responsive " />
            </a>
        </div>
        <div class="mx-2">
            <a href="#"
            target="_blank" title="التحميل من متجر جوجل"
            alt="التحميل من متجر جوجل">
            <img  width="150" src="{{ asset('assets_web/images/google_play_badge_en_black.jpg') }}"
                title="التحميل من متجر جوجل" alt="التحميل من متجر جوجل"
                class="img-responsive" />
            </a>
        </div>
    </div>
    </div>


    <div class="footer-bottom row m-0 p-4">
        <div class="col-md-2">
            <ul class="list-unstyled">
                <li>
                    <a href="{{route('home')}}" title="الرئيسية" alt="الرئيسية">الرئيسية</a>
                </li>
                <li>
                    <a href="{{route('get-static','terms')}}"> شروط الإستخدام</a>
                </li>
                 <li>
                    <a href="{{route('get-static','privacy')}}">سياسة الخصوصية </a>
                </li>
               
            </ul>
         </div>
         <div class="col-md-2">
            <ul class="list-unstyled">
                <div class="footer_ul_div_two">
                                                                <li>
                        <a href="{{route('user-login')}}" title=" تسجيل دخول " alt=" تسجيل دخول "> تسجيل دخول </a>
                    </li>
                    <li>
                        <a href="{{route('user-register')}}" title="تسجيل" alt="تسجيل">تسجيل</a>
                    </li>
                    <li>
                        <a href="{{route('password.request')}}" title="استرجاع كلمة السر" alt="استرجاع كلمة السر">استرجاع كلمة السر</a>
                    </li>
                                                        </div>
            </ul>
         </div>
         <div class="col-md-2">
            <ul class="list-unstyled">
                <div class="footer_ul_div_three">
                    <div>
                        <li>
                            <a href="https://www.facebook.com" target="_blank" title="فيس بوك" alt="فيس بوك"><i class="fa fa-fw fa-facebook-square" aria-hidden="true"></i> فيس بوك</a>
                        </li>
                        <li>
                            <a href="https://twitter.com" target="_blank" title="تويتر" alt="تويتر"><i class="fa fa-fw fa-twitter" aria-hidden="true"></i> تويتر</a>
                        </li>



                        <li>
                            <a href="https://www.instagram.com/" target="_blank" title="انستغرام" alt="انستغرام"><i class="fa fa-fw fa-instagram" aria-hidden="true"></i> انستغرام</a>
                        </li>
                    </div>

                </div>
            </ul>
         </div>
         <div class="col-md-6">
            <div class="border-radius  p-2 text-right">
                <p>باستخدامك لهذا الموقع، فأنت توافق على سياسة الاستخدام، سياسة جمع المعلومات، سياسة الخصوصية، وسياسة المحتوى. جميع العلامات التجارية هي ملك لأصحابها، ©  2021 - تأميني ستور . جميع الحقوق محفوظة</p>
            </div>
         </div>       
    </div>
    <div class="pt-2 bg-white">
        <p class="text-center">  جميع الحقوق محفوظة {{Date('Y')}} </p>
    </div>
    <div class="w-100">
        @if($settings->whats==1)
        <div class="text-left ml-2 whats" style="bottom: 1px;top: 1p;background-color: transparent;
    position: fixed;
    left: 20px;
    bottom: 50px;
        ">
            <a href="https://api.whatsapp.com/send?phone={{$settings->phone}}">
                <i class="fab fa-whatsapp img-thumbnail" aria-hidden="true" style="font-size:48px;color:#ffffff;background-color: #01e675" ></i>
            </a>
        </div>
            @endif
    </div>
</footer>