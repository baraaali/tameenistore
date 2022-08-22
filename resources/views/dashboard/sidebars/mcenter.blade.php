<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="#">لوحة التحكم </a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">

            <div class="user-info">
                <span class="user-name">
                    <strong>{{auth()->user()->name}}</strong>
                </span>
                <span class="user-role">مركز صيانة </span>
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
               

                <li>
                    <a href="{{route('dashboard')}}">
                        <span
                            class="badge badge-pill badge-primary"></span>
                        <i class="fa fa-handshake"></i>
                        <span>  الرئيسية  </span>
  
                    </a>
                </li>

                <li>
                    <a href="{{route('account-info')}}">
                        <span
                            class="badge badge-pill badge-primary"></span>
                        <i class="fa fa-handshake"></i>
                        <span>  معلومات الحساب  </span>
  
                    </a>
                </li>


               
           
                 <li>
                    <a href="{{route('mcenterServices')}}">
                        <i class="fa fa-flag"></i>
                        <span>  خدمات الصيانة </span>
                        <span
                            class="badge badge-pill badge-primary">{{App\McenterService::where('mcenter_id',auth()->user()->mcenter->id)->count()}}</span>
                    </a>
                </li> 
                 <li>
                    <a href="{{route('mcenterAdditionalServices')}}">
                        <i class="fa fa-flag"></i>
                        <span>  خدمات الصيانة الإضافية </span>
                        @php $mcenter_services = App\McenterService::where('mcenter_id',auth()->user()->mcenter->id)->where('status','1')->get();$services_ids =  $mcenter_services->pluck('id');$services = App\McenterAdditionalService::whereIn('mcenter_service_id',$services_ids);  @endphp
                        <span
                            class="badge badge-pill badge-primary">{{$services->count()}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('cp-mcenter-requests')}}">
                        @php   if(auth()->user()->type == 0)$mc_requests   = App\MaintenanceRequest::where('user_id',auth()->user()->id);
                            if(auth()->user()->type == 5)  $mc_requests   = App\MaintenanceRequest::where('mcenter_id',auth()->user()->mcenter->id);        
                        @endphp
                        <i class="fa fa-flag"></i>
                        <span>  الطلبات الواردة   </span>
                        <span
                            class="badge badge-pill badge-primary">{{$mc_requests->count()}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('all_banners',app()->getLocale())}}">
                        <i class="fa fa-flag"></i>
                        <span>إعلانات  البنرات </span>
                        <span class="badge badge-pill badge-primary">{{App\UserBanner::where(userBannersConditions())->count()}}</span>
                    
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="fa fa-flag"></i>
                        <span>التأمين</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a class="mx-2" href="{{route('insurancerequestsuser')}}">
                                طلبات التأمين ضد الغير     
                                </a>
                            </li>
                            <li>
                                <a class="mx-2" href="{{route('insurancerequestscomplete')}}">
                                طلبات التأنين الشامل   
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{route('promotion')}}">
                        <i class="fa fa-flag"></i>
                        الإشعارات الترويجية
                    </a>
                  </li>
                <li>
                    <a href="{{route('payment_report_user')}}">
                        <i class="fa fa-flag"></i>
                        <span>تقارير المدفوعات</span>
      
                    </a>
                </li>

        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    
    @include('dashboard.sidebars.sidebar-footer')
</nav>