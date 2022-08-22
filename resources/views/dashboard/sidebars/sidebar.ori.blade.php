<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">لوحة التحكم</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">

        <div class="user-info">
          <span class="user-name">
            <strong>{{auth()->user()->name}}</strong>
          </span>
          <span class="user-role">مدير مسئول</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>متصل</span>
          </span>
        </div>
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="{{url('/')}}/uploads/user.jpg"
            alt="User picture">
        </div>
      </div>

      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>متطلبات</span>
          </li>
          <li >
            <a href="{{route('users')}}">
                <span class="badge badge-pill badge-warning">{{App\User::count()}}</span>
              <i class="fa fa-users"></i>
              <span>الاعضاء</span>

            </a>
          </li>
        <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>الإشعارات</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
                <a class="mx-2" href="{{route('user-notifications.index')}}">الإشعارت الأوتوماتيكية</a>
              </li>
              <li>
                <a class="mx-2" href="{{route('user-notifications.send')}}">إرسال إشعار</a>
              </li>
              <li>
                <a class="mx-2" href="{{route('promotion-notifications')}}">الإشعارات الترويجية</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>الدول / المناطق / المدن</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
                <a class="mx-2" href="{{route('countries')}}">الدول</a>
              </li>
              <li>
                <a class="mx-2" href="{{route('governorates')}}">المناطق</a>
              </li>
              <li>
                <a class="mx-2" href="{{route('cities')}}">المدن</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>العربات </span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
                <a href="{{route('vehicles.index')}}">
                    <span>
                     أنواع العربات
                    <span class="badge badge-pill badge-primary">{{App\Vehicle::count()}}</span>
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('brands.index')}}">
                  الماركات  
                  <span class="badge badge-pill badge-warning">{{App\brands::count()}}</span> 
                </a>
              </li>
              <li>
                <a href="{{route('careshapes.index')}}">
                  شكل السيارة  
                  <span class="badge badge-pill badge-warning">{{App\CareShape::count()}}</span> 
                </a>
            </li>
            <li>
              <a href="{{route('models.index')}}">
                  <span>الموديلات<span class="badge badge-pill badge-danger">{{App\models::count()}}</span>
                </span>
              </a>
            </li>
              
            </ul>
          </div>
        </li>  
        <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>مراكز الصيانة</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
               <a href="{{route('mcentervehicles.index')}}">
                 <span>أنواع العربات </span>
                   <span class="badge badge-pill badge-primary">{{App\McenterVehicle::count()}}</span>
               </a>
              </li>
              <li>
                <a href="{{route('centers')}}">
                  <span>المراكز </span>
                    <span class="badge badge-pill badge-primary">{{App\Mcenters::count()}}</span>
                </a>
              </li>
              <li>
                <a href="{{route('centers-request')}}">
                  <span>الطلبات</span>
                    <span class="badge badge-pill badge-primary">{{App\MaintenanceRequest::count()}}</span>
                </a>
              </li>
              
            </ul>
          </div>
        </li>
{{--                            <li class="sidebar-dropdown">--}}
{{--                              <a href="#">--}}
{{--                                <i class="fa fa-flag"></i>--}}
{{--                                <span>الاعلانات الجديدة</span>--}}
{{--                              </a>--}}
        <li>
         <a href="{{url('dashboard/modules')}}">
          <i class="fa fa-flag"></i>
           <span>الاعلانات الجديدة </span>
             <span class="badge badge-pill badge-primary">{{App\NewServices::count()}}</span>
         </a>
        </li>

          <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>أصناف الخدمات</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
                <a href="{{route('service_categories.index')}}">
                    <span>
                    الأقسام الرئيسية 
                    <span class="badge badge-pill badge-primary">{{App\ServiceCategory::count()}}</span>
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('service_sub_categories.index')}}">
                  الأقسام الفرعية  
                  <span class="badge badge-pill badge-warning">{{App\ServiceSubCategory::count()}}</span> 
                </a>
              </li>
              <li>
                <a href="{{route('service_child_categories.index')}}">
                   الأقسام الفرع فرعية  
                  <span class="badge badge-pill badge-warning">{{App\ServiceChildCategory::count()}}</span> 
                </a>
            </li>
              
            </ul>
          </div>
        </li>
            {{--  --}}
            </li>
          <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-flag"></i>
            <span>الاقسام الجديدة</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
            <li>
            <a href="{{route('cats')}}">
                <span class="badge badge-pill badge-primary">{{App\Cat::count()}}</span>
              <i class="fa fa-flag"></i>
              <span>الانواع الرئيسيه</span>

            </a>
          </li>
           <li>
            <a href="{{route('sub_cats')}}">
                <span class="badge badge-pill badge-primary">{{App\SubCat::count()}}</span>
              <i class="fa fa-flag"></i>
              <span>الانواع الفرعيه</span>

            </a>
          </li>
           <li>
            <a href="{{route('mini_sub_cats')}}">
                <span class="badge badge-pill badge-primary">{{App\MiniSubCat::count()}}</span>
              <i class="fa fa-flag"></i>
              <span>الانواع الثانويه</span>

            </a>
          </li>
              
            </ul>
          </div>
        </li>

            <li>
                <a href="{{route('banners.index')}}">
                    <span class="badge badge-pill badge-secondary">{{App\Banner::count()}}</span>
                    <i class="fa fa-handshake"></i>
                    <span> اشتراكات البانرات </span>

                </a>
            </li>
            {{--  --}}
        <li>
          <a href="{{route('stores.index')}}">
              <span class="badge badge-pill badge-primary">{{App\Store::count()}}</span>
              <i class="fa fa-flag"></i>
              <span>المحلات</span>
          </a>
      </li>
      <!-- memberships -->
      <li class="sidebar-dropdown">
        <a href="#">
          <i class="fa fa-flag"></i>
          <span>العضويات</span>
        </a>
        <div class="sidebar-submenu">
          <ul>
           <li>
              <a href="{{route('service_member_ships.index')}}">
                الخدمات
                <span class="badge badge-pill badge-warning">{{App\ServiceMemberShip::count()}}</span> 
          
              </a>
            </li>
            <li>
              <a href="{{route('membership')}}">
                الإعلانات
                <span class="badge badge-pill badge-warning">{{App\membership::count()}}</span> 
          
              </a>
            </li>
                <li>
                  <a href="{{route('ads-memberships.index')}}">
                      السيارات
                      <span class="badge badge-pill badge-warning">{{App\AdsMembership::count()}}</span>
                  </a>
              </li>
              <li>
                <a href="{{route('dep-memberships.index')}}">
                   الاقسام الفرعيه
                    <span class="badge badge-pill badge-secondary">{{App\DepartmentMembership::count()}}</span>                                    
                    
                  </a>
                </li>
              <li>
                  <a href="{{route('member-insurance.index')}}">
                     التأمين
                      <span class="badge badge-pill badge-warning">{{App\MemberInsurance::count()}}</span>
                  </a>
              </li>

              <li>
                  <a href="{{route('new-service-memberships.index')}}">
                    عضويات الاقسام الجديدة
                      <span class="badge badge-pill badge-warning">{{App\NewServiceMembership::count()}}</span>
                  </a>
              </li>
            
          </ul>
        </div>
      </li>
      <!-- end memberships -->

            <li>
                <a href="{{route('uses.index')}}">
                    <span class="badge badge-pill badge-primary">{{App\Style::count()}}</span>
                    <i class="fa fa-flag"></i>
                    <span>انواع الاستخدام</span>

                </a>
            </li>

           

          <li>
            <a href="{{route('pages')}}">
                <span class="badge badge-pill badge-success">{{App\Categories::count()}}</span>
              <i class="fa fa-address-card"></i>
              <span>الاقسام</span>

            </a>
          </li>

{{--                              <li>--}}
{{--                                <a href="{{route('exhibitors')}}">--}}
{{--                                    <span class="badge badge-pill badge-success">{{App\Exhibition::count()}}</span>--}}
{{--                                  <i class="fa fa-address-card"></i>--}}
{{--                                  <span>المعارض</span>--}}
{{--                                  --}}
{{--                                </a>--}}
{{--                              </li>--}}

           <li>
            <a href="{{route('agents',['type'=> 0])}}">
                <span class="badge badge-pill badge-light">{{App\Agents::where('agent_type',0)->count()}}</span>
              <i class="fa fa-handshake"></i>
              <span>وكالات البيع</span>

            </a>
          </li>
          <li>
            <a href="{{route('agents',['type'=> 1])}}">
                <span class="badge badge-pill badge-warning">{{App\Agents::where('agent_type',1)->count()}}</span>
              <i class="fa fa-handshake"></i>
              <span>وكالات التأجير</span>

            </a>
          </li>
            <li>
                <a href="{{route('increase-date','shamel')}}">
                    <i class="fa fa-handshake"></i>
                    <span>تجديد اشتراك التأمين الشامل</span>
                </a>
            </li>
            <li>
                <a href="{{route('increase-date','other')}}">
                    <i class="fa fa-handshake"></i>
                    <span>تجديد اشتراك التأمين ضد الغير</span>
                </a>
            </li>
            <li>
                <a href="{{route('increase-price-user')}}">
                    <i class="fa fa-handshake"></i>
                    <span>شحن رصيد العملاء</span>
                </a>
            </li>
            <li>
                <a href="{{route('prices.index')}}">
                    <span class="badge badge-pill badge-secondary">{{App\Price::count()}}</span>
                    <i class="fa fa-handshake"></i>
                    <span> اسعار العضويات</span>

                </a>
            </li>
            
              <li>
                <a href="{{route('notification-price.index')}}">
                  <span class="badge badge-pill badge-secondary">{{App\NotificationPrice::count()}}</span>
                  <i class="fa fa-handshake"></i>
                  <span> أسعر الإشعارات </span>
                </a>
            </li>

            <li>
                <a href="{{route('dash.items')}}">
                    <span class="badge badge-pill badge-secondary">{{App\items::count()}}</span>
                    <i class="fa fa-handshake"></i>
                    <span> اعلانات الاقسام</span>

                </a>
            </li>
            <li>
                <a href="{{route('insurnaces.index')}}">
                    <span class="badge badge-pill badge-secondary">{{App\Insurance::count()}}</span>
                    <i class="fa fa-handshake"></i>
                    <span>وكالات التأمين </span>

                </a>
            </li>
          
          <li>
            <a href="{{route('edit-website')}}">
              <i class="fa fa-wrench"></i>
              <span>معلومات الويب سايت</span>
            </a>
          </li>
            <li>
                <a href="{{route('admin_notify')}}">
                    <i class="fa fa-eye"></i>
                    <span>البلاغات</span>

                </a>
            </li>
            <li>
                <a href="{{route('admin_notify',1)}}">
                    <i class="fa fa-eye"></i>
                    <span>بلاغات الاقسام الجديدة</span>

                </a>
            </li>
          <li>
            <a href="{{route('cars')}}">
                <span class="badge badge-pill badge-primary">{{App\Cars::count()}}</span>
              <i class="fa fa-car"></i>
              <span>الاعلانات</span>

            </a>
          </li>

           <li>
            <a href="{{route('Comp-insurnace-index')}}">
                <span class="badge badge-pill badge-primary">{{App\CompleteDoc::count()}}</span>
              <i class="fa fa-car"></i>
              <span>التأمينات الشاملة</span>

            </a>
          </li>
           <li>
            <a href="{{route('inc-insurnace-index')}}">
                <span class="badge badge-pill badge-primary">{{App\InsuranceDocument::count()}}</span>
              <i class="fa fa-car"></i>
              <span>تأمينات ضد الغير</span>

            </a>
          </li>

          <li>
            <a href="{{route('insurnace-companies')}}">
                <span class="badge badge-pill badge-primary">{{App\Insurance::count()}}</span>
              <i class="fa fa-car"></i>
              <span>شركات التأمين</span>

            </a>
          </li>
            <li>
                <a href="{{route('uses.docs')}}">
                    <span class="badge badge-pill badge-warning">{{App\DocumentsUser::count()}}</span>
                    <i class="fa fa-eye"></i>
                    <span>مستندات العملاء</span>

                </a>
            </li>
            <li>
                <a href="{{route('email.show')}}">
                    <i class="fa fa-car"></i>
                    <span>ارسال ايميل </span>
                </a>
            </li>
          <!-- <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li> -->
          <!--<li class="header-menu">-->
          <!--  <span>Extra</span>-->
          <!--</li>-->
          <!--<li>-->
          <!--  <a href="#">-->
          <!--    <i class="fa fa-book"></i>-->
          <!--    <span>Documentation</span>-->
          <!--    <span class="badge badge-pill badge-primary">Beta</span>-->
          <!--  </a>-->
          <!--</li>-->
          <!--<li>-->
          <!--  <a href="#">-->
          <!--    <i class="fa fa-calendar"></i>-->
          <!--    <span>Calendar</span>-->
          <!--  </a>-->
          <!--</li>-->
          <!--<li>-->
          <!--  <a href="#">-->
          <!--    <i class="fa fa-folder"></i>-->
          <!--    <span>Examples</span>-->
          <!--  </a>-->
          <!--</li>-->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
      </a>
      <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off"></i>
        <span class="badge-sonar"></span>
      </a>
    </div>
  </nav>