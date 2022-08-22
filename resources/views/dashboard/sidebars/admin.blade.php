<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">لوحة التحكم</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">

        <a href="{{route('account-info')}}">
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
      </a>
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
          
          <li>
            <a href="{{route('dashboard')}}">
                <span
                    class="badge badge-pill badge-primary"></span>
                <i class="fa fa-handshake"></i>
                <span>  الرئيسية  </span>

            </a>
        </li>
        
          <li >
            <a href="{{route('users')}}">
                <span class="badge badge-pill badge-warning">{{App\User::count()}}</span>
              <i class="fa fa-users"></i>
              <span>الاعضاء</span>

            </a>
          </li>
          
          <li>
            <a href="{{route('dash.items')}}">
                <span class="badge badge-pill badge-secondary">{{App\items::count()}}</span>
                <i class="fa fa-handshake"></i>
                <span> الإعلانات التجارية </span>

            </a>
        </li>
        <li>
          <a href="{{route('cars')}}">
              <span class="badge badge-pill badge-primary">{{App\Cars::where('sell',1)->count()}}</span>
            <i class="fa fa-car"></i>
            <span>مركبات للبيع</span>

          </a>
        </li>
        <li>
          <a href="{{route('my-ads')}}">
              <span
                  class="badge badge-pill badge-primary">{{App\Cars::where('sell',0)->count()}}</span>
              <i class="fa fa-handshake"></i>
              <span>   مركبات للإيجار </span>

          </a>
      </li>
        <li>
          <a href="{{url('dashboard/modules')}}">
           <i class="fa fa-flag"></i>
            <span>إعلانات الأقسام </span>
            <span  class="badge badge-pill badge-primary">{{App\NewServices::where(getNewServicesConditions())->count()}}</span>
          </a>
         </li>
         <li>
          <a href="{{route('advertisements-show')}}">
              <i class="fa fa-flag"></i>
              <span> إعلانات البنرات </span>
              <span class="badge badge-pill badge-primary">{{App\Banner::count()}}</span>

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
                    <span class="badge badge-pill badge-primary">{{App\MaintenanceRequest::whereHas('mcenter',function($q){
                      $q->where('id','>',0);
                  })->count()}}
                  </span>
                </a>
              </li> 
               <li>
                <a href="{{route('stores.index')}}">
                  <span>المحلات</span>
                    <span class="badge badge-pill badge-primary">{{App\Store::count()}}</span>
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
  <a style="font-size: 13px;" href="{{route('pages')}}">
    <i class="fa fa-flag"></i>
    أصناف الإعلانات التجارية  
      <span class="badge badge-pill badge-success">{{App\Categories::count()}}
      </span>
  
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
            <span>أصناف إعلانات الأقسام</span>
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
            {{-- <li>
              <a href="{{route('membership')}}">
                الإعلانات التجارية
                <span class="badge badge-pill badge-warning">{{App\membership::count()}}</span> 
          
              </a>
            </li> --}}
                <li>
                  <a href="{{route('ads-memberships.index')}}">
                      السيارات
                      <span class="badge badge-pill badge-warning">{{App\AdsMembership::count()}}</span>
                  </a>
              </li>
              <li>
                <a href="{{route('dep-memberships.index')}}">
                     الإعلانات التجارية 
                    <span class="badge badge-pill badge-secondary">{{App\DepartmentMembership::count()}}</span>                                    
                    
                  </a>
                </li>
                
              <li>
                  <a href="{{route('new-service-memberships.index')}}">
                    إعلانات الأقسام  
                      <span class="badge badge-pill badge-warning">{{App\NewServiceMembership::count()}}</span>
                  </a>
              </li>
              <li>
                  <a href="{{route('member-insurance.index')}}">
                     التأمين
                      <span class="badge badge-pill badge-warning">{{App\MemberInsurance::count()}}</span>
                  </a>
              </li>
              <li>
                <a href="{{route('banners.index')}}">
                   البنرات
                    <span class="badge badge-pill badge-warning">{{App\Banner::count()}}</span>
                </a>
              </li>
              <li>
                <a href="{{route('notification-price.index')}}">
                   الإشعارات
                    <span class="badge badge-pill badge-warning">{{App\NotificationPrice::count()}}</span>
                </a>
              </li>

            
          </ul>
        </div>
      </li>
      <!-- end memberships -->

           

         

{{--                              <li>--}}
{{--                                <a href="{{route('exhibitors')}}">--}}
{{--                                    <span class="badge badge-pill badge-success">{{App\Exhibition::count()}}</span>--}}
{{--                                  <i class="fa fa-address-card"></i>--}}
{{--                                  <span>المعارض</span>--}}
{{--                                  --}}
{{--                                </a>--}}
{{--                              </li>--}}

           <li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-flag"></i>
                <span>الوكالات</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="{{route('agents',['type'=> 0])}}">
                        <span>
                          وكالات البيع  
                        <span class="badge badge-pill badge-primary">{{App\Agents::where('agent_type',0)->count()}}</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('agents',['type'=> 1])}}">
                        <span>
                          وكالات التأجير   
                        <span class="badge badge-pill badge-primary">{{App\Agents::where('agent_type',1)->count()}}</span>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-flag"></i>
                <span>التأمين</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="{{route('insurnaces.index')}}">
                        <span>
                          وكالات التأمين   
                        <span class="badge badge-pill badge-primary">{{App\Insurance::count()}}</span>
                      </span>
                    </a>
                  </li> 
                   <li>
                    <a href="{{route('Comp-insurnace-index')}}">
                        <span>
                          التأمينات الشاملة    
                        <span class="badge badge-pill badge-primary">{{App\CompleteDoc::count()}}</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('inc-insurnace-index')}}">
                        <span>
                          تأمينات ضد الغير     
                        <span class="badge badge-pill badge-primary">{{App\InsuranceDocument::count()}}</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('insurnace-companies')}}">
                        <span>
                          شركات التأمين     
                        <span class="badge badge-pill badge-primary">{{App\Insurance::count()}}</span>
                      </span>
                    </a>
                  </li>
                   <li>
                    <a href="{{route('increase-date','shamel')}}">
                        <span>
                          تجديد اشتراك التأمين الشامل    
                      </span>
                    </a>
                  </li>  
                     <li>
                    <a href="{{route('increase-date','other')}}">
                        <span>
                          تجديد اشتراك التأمين ضد الغير
                      </span>
                    </a>
                  </li> 
                    <li>
                    <a href="{{route('increase-date','other')}}">
                        <span>
                          تجديد اشتراك التأمين ضد الغير
                      </span>
                    </a>
                  </li>
               
                </ul>
              </div>
            </li>
          
          
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-flag"></i>
                <span>البلاغات</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="{{route('admin_notify')}}">
                        <span>
                          البلاغات    
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('admin_notify',1)}}">
                        <span>بلاغات الاقسام الجديدة</span>
                    </a>
                </li>
              
                </ul>
              </div>
            </li>
      

            <li>
              <a href="{{route('admin.report.index')}}">
                  <i class="fa fa-flag"></i>
                  <span>تقارير المدفوعات</span>

              </a>
          </li>
            <li>
              <a href="{{route('uses.index')}}">
                  <span class="badge badge-pill badge-primary">{{App\Style::count()}}</span>
                  <i class="fa fa-flag"></i>
                  <span>انواع الاستخدام</span>

              </a>
          </li>
       
            <li>
                <a href="{{route('increase-price-user')}}">
                    <i class="fa fa-handshake"></i>
                    <span>شحن رصيد العملاء</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{route('prices.index')}}">
                    <span class="badge badge-pill badge-secondary">{{App\Price::count()}}</span>
                    <i class="fa fa-handshake"></i>
                    <span> اسعار العضويات</span>

                </a>
            </li> --}}
            
            

          
          
          <li>
            <a href="{{route('edit-website')}}">
              <i class="fa fa-wrench"></i>
              <span>معلومات الويب سايت</span>
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
    @include('dashboard.sidebars.sidebar-footer')

  </nav>