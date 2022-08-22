<header id="site-header">
    <div class="upper-section header_mobile_height">
        <div class="container">
            <div class="row">
                <!--<div class="col-lg-2 col-md-3 col-sm-3 header_one_div">
                    <p class="register-login pull-left header_div_two">
                        <a href="#" class="login-link f-size-12"
                            title=" تسجيل دخول " alt=" تسجيل دخول ">
                            تسجيل دخول
                        </a>
                    </p>
                </div>-->  
                <div class="col-lg-10 col-md-9 col-sm-9 header_two_div">
                    <ul class="links list-inline pull-right header_menu_ul">
                        <li class="mobil_header_news_li">
                            <img src="{{ asset('assets_v2/images/search_mobile.png') }}"
                                class="mobile_header_search" />
                        </li>
                        <li class="lang_buttons_old">
                            <a href="https://en.tameenistore.com/">English</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="lower-section">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <div class="one_two_three_divs header_logo_div">
                        <a href="http://localhost/game/website/mazad" alt="تأمييني ستور" title="تأمييني ستور">
                            <img src="{{ asset('assets_v2/imgs/logo.png') }}"
                                alt="تأمييني ستور" title="تأمييني ستور" class="image-responsive header_logo_img" />
                        </a>
                    </div>
                    <div class="one_two_three_divs two_header_div">
                        <ul class="nav navbar-nav navbar-left hidden-xs hidden-sm category_drop_down_ul   ">
                            <li class="dropdown mega-menu mobile_cat_menu" id="show_category_list">
                                <a class="
                  dropdown-toggle
                  header_cat_panel_mobile
                  fix-category-name
                " data-toggle="dropdown" role="button">
                                    الاقسام
                                    <span class="caret icon_open_sub_menu_header_span"></span>
                                </a>
                                <!-- start mega-menu.html-->
                                <!-- end mega-menu.html-->
                            </li>
                        </ul>
                    </div>
                    <div class="one_two_three_divs open_sub_menu_in_header">
                        <button type="button" class="navbar-toggle collapsed open_mobile_menus">
                            <!--data-toggle="collapse" data-target="#header-menu" aria-expanded="false"-->
                            <span class="sr-only">Toggle navigation</span>
                            <span class="fa fa-bars fa-2x"></span>
                        </button>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="header-menu">
                    <form method="POST" action="http://localhost/game/website/mazad/search_tags" id="head_form">
                        <div class="navbar-form navbar-left not_mobil_version_search">
                            <div class="form-group header_search_form_div">
                                <input type="text" class="form-control tag" name="tag" placeholder="ابحث هنا"
                                    maxlength="45" id="header_search_form_input" />
                                <input type="hidden" class="hidden-cat-id" name="key" value="" />
                                <div id="tags_div" hidden></div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-submit header_search_icon"
                                    style="z-index: 1">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        @if (!auth()->user())
                        <li class="sub_menu_one_two" style="overflow: hidden">
                            <a href="{{route('user-login')}}"
                                class="header_account_hide_if_logined post_free_add_link" data-href="Profile">
                                <i class="fas fa-user"></i> تسجيل دخول
                            </a>
                        </li>
                        @else
                        <li class="sub_menu_one_two" style="overflow: hidden">
                            <a href="#"
                                class="header_account_hide_if_logined post_free_add_link" data-href="Profile">
                                <i class="fas fa-user"></i> {{auth()->user()->name}}  
                            </a>
                        </li>
                        @endif
                        {{-- for mobile --}}
                       @if (!auth()->user())
                       <li class="show_only_width_500 js_png_color_mobile">
                           <a href="{{route('user-login')}}" title=" تسجيل دخول "
                               alt=" تسجيل دخول ">
                               <span class="sub_menu_trans_text_span"> تسجيل دخول </span>
                           </a>
                       </li>
                       @else
                       <li class="show_only_width_500 js_png_color_mobile">
                           <a href="{{route('user-login')}}" title="لوحة التحكم"
                               alt="لوحة التحكم">
                               <span class="sub_menu_trans_text_span">لوحة التحكم</span>
                           </a>
                       </li>
                       @endif
                       {{-- end for mobile --}}
                       @if (auth()->user())
                       <li class="hidden-xs js_png_color_mobile">
                        <a href="{{route('dashboard')}}"
                        class="post-ads post_free_add_link" >
                        <i class="fas fa-th-large"></i> 
                         لوحة التحكم
                        </a>
                       </li>
                       @else
                       <li class="hidden-xs js_png_color_mobile">
                        {{-- <a href="{{route('user-register')}} --}}
                        <a href="#"
                            class="post-ads post_free_add_link" >
                            حساب جديد
                        </a>
                       </li>                          
                       @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="only_height_header"></div>
</header>