@extends('Cdashboard.layout.app')
@section('css')
    <style>
    .select2-container{
     display:block;
     width: 190px !important;
        }
    </style>
@endsection
@section('controlPanel')


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $type=auth()->user()->type;
    ?>


    @if(app()->getLocale() == 'ar')

        <style>
            .form-group {
                direction: rtl;
                text-align: right !important;
            }
        </style>

    @else
        <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
        </style>
    @endif

    <div class="col-lg-12">
        @include('dashboard.layout.message')

        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="v-pills-tabContent" style="padding-top:0px">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;
		    display: inline-block;
		    top: 6px;">
                                    @if(app()->getLocale() == 'ar')
                                    
                                        معلومات شخصية
                                    @else
                                        Personal Infromation
                                    @endif
                                </h5>

                            </div>
                            <div class="card-body"
                                 style="background-color: white;color:#31353D;text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left'}}">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                           href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"
                                           style="border-bottom:none;border-left: 1px solid #d3d3d3;">
                                            <i class="fa fa-edit"></i>
                                            @if(app()->getLocale() == 'ar')
                                                تعديل بيانات المستخدم
                                            @else
                                                Edit User Information
                                            @endif
                                        </a>
                                    </li>
                                    @if($type == 2 || $type == 3 )
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tap" data-toggle="pill"
                                               href="#pills-profile" role="tab" aria-controls="pills-profile"
                                               aria-selected="false"
                                               style="border-bottom:none;border-left: 1px solid #d3d3d3;">
                                                <i class="fa fa-edit"></i>
                                                @if(app()->getLocale() == 'ar')
                                                    تعديل بيانات الوكالة
                                                @else
                                                    Edit Agency Information
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                    @if($type == 1)
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                                               href="#pills-contact" role="tab" aria-controls="pills-contact"
                                               aria-selected="false"
                                               style="border-bottom:none;border-left: 1px solid #d3d3d3;">
                                                <i class="fa fa-edit"></i>
                                                @if(app()->getLocale() == 'ar')
                                                    تعديل بيانات المعرض
                                                @else
                                                    Edit Exhibitor Information
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                    @if($type != 0 && $type !=6 )
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill"
                                           href="#pills-document" role="tab" aria-controls="pills-document"
                                           aria-selected="false"
                                           style="border-bottom:none;border-left: 1px solid #d3d3d3;">
                                            <i class="fa fa-edit"></i>
                                            {{__('site.Document-user')}}
                                        </a>
                                    </li>
                                    @endif
                                    @if($type ==5 )
                                    <li class="nav-item">
                                        <a class="nav-link"  data-toggle="pill"
                                           href="#edit-mcenter" role="tab" aria-controls="edit-mcenter"
                                           aria-selected="false"
                                           style="border-bottom:none;border-left: 1px solid #d3d3d3;">
                                            <i class="fa fa-edit"></i>
                                           مركز الصيانة
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                <hr>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                         aria-labelledby="pills-home-tab"
                                         style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left'}};">
                                            <span style="font-size:14px;font-weight:600">
                                               @if(app()->getLocale() == 'ar')
                                                    تعديل بيانات المستخدم
                                                @else
                                                    Edit User Information
                                                @endif
                                            </span>
                                            <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;">
                                            </div>
                                            <form method="POST" action="{{route('user-update')}}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{auth()->user()->id}}">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        @if(app()->getLocale() == 'ar')
                                                            <label>
                                                                الأسم <small class="text-danger">*</small>
                                                                @else
                                                                    Name <small class="text-danger">*</small>
                                                            </label>
                                                        @endif
                                                        <input type="text" value="{{auth()->user()->name}}" name="name"
                                                               max="191" class="SpecificInput">
                                                    </div>


                                                    <div class="form-group col-md-4">
                                                        @if(app()->getLocale() == 'ar')
                                                            <label>
                                                                التيليفون <small class="text-danger">*</small>
                                                                @else
                                                                    Mobil No. <small class="text-danger">*</small>
                                                            </label>
                                                        @endif
                                                        <input type="tel" required value="{{auth()->user()->phones}}"
                                                               name="phone" max="191" class="SpecificInput">


                                                    </div>
                                                    <div class=" form-group col-md-4">

                                                        @if(app()->getLocale() == 'ar')
                                                            <label>
                                                                البريد الألكتروني <small class="text-danger">*</small>
                                                                @else
                                                                    Email Address <small class="text-danger">*</small>
                                                            </label>
                                                        @endif
                                                        <input type="email" value="{{auth()->user()->email}}"
                                                               name="email" max="191" class="SpecificInput">

                                                    </div>
                                                    <div class=" form-group col-md-4">

                                                        @if(app()->getLocale() == 'ar')
                                                            <label>
                                                                الصورة<small class="text-danger">*</small>
                                                                @else
                                                                    Image <small class="text-danger">*</small>
                                                            </label>
                                                        @endif
                                                        <input type="file" name="img" class="">
                                                        <img src="{{url('/')}}/uploads/{{auth()->user()->image}}"
                                                             style="width:100px;height:50px !important;">

                                                    </div>

                                                    <div class="col-md-4 form-group">

                                                        @if(app()->getLocale() == 'ar')
                                                            <label>
                                                                كلمة المرور<small class="text-danger">*</small>
                                                                @else
                                                                    Password <small class="text-danger">*</small>
                                                            </label>
                                                        @endif
                                                        <input type="password" name="password" class="SpecificInput">

                                                    </div>

                                                    <div class="col-md-8"></div>
                                                    <div class="col-md-4">
                                                        <input type="submit" class="btn btn-primary btn-block"
                                                               value="{{app()->getLocale() == 'ar' ? 'تعديل' : 'update'}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="edit-mcenter" role="tabpanel">

                                        @if (auth()->user()->type  == 5)
                                       <div>
                                           
                                        <span style="font-size:14px;font-weight:600">
                                            @if(app()->getLocale() == 'ar')
                                                     تاريخ إنتهاء الإشتراك
                                             @else
                                              subscription expiration date  
                                             @endif
                                         </span>
                                         <div class="p-3 text-danger font-weight-bold d-inline">
                                            {{ auth()->user()->mcenter->renewal_at}}
                                          </div>
                                         <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;">
                                         </div>
                                       </div>
                                        <span style="font-size:14px;font-weight:600">
                                            @if(app()->getLocale() == 'ar')
                                                 تعديل  بيانات مركز الصيانة
                                             @else
                                                 Edit User Information
                                             @endif
                                         </span>
                                         <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;">
                                         </div>
                                       <form method="POST" action="{{route('mcenter-update')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$center->id}}">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>
                                                                إسم الدولة أو المنطقة <small class="text-danger">*</small>
                                                            </label>
                                                            <select class="SpecificInput select2" name="country_id">
                                                                @foreach($countries as $country)
                                                                    <option value="{{$country->id}}" {{$center->country_id == $country->id ? 'selected' : ''}}>
                                                                        {{$country->ar_name}} - {{$country->en_name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                إسم المركز بالعربية <small class="text-danger">*</small>
                                                            </label>
                                                            <input type="text"   value="{{$center->ar_name}}" required="required" name="ar_name" maxlength="191" class="SpecificInput">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                 أرقام الهاتف
                                                            </label>
                                                            <input type="text" value="{{$center->phones}}" name="phones" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                وصف المركز بالعربية <small class="text-danger">*</small>
                                                            </label>
                                                            <textarea name="ar_address"  class="SpecificInput" rows="3" required="required">{{$center->ar_address}}</textarea>
                                                        </div>
                                    
                                                        <div class="form-group">
                                                            <label>
                                                                 صورة المركز <small class="text-danger">*</small>
                                                            </label>
                                                            <input type="file" name="image" class="SpecificInput">
                                                            <img src="{{url('/')}}/uploads/{{$center->image}}" style="width: auto;height: 100px;">
                                                        </div>
                                    
                                                    </div>
                                    
                                                    <div class="col-md-2">
                                    
                                                    </div>
                                    
                                                    <div class="col-md-5">
                                    
                                                        <div class="form-group">
                                                            <label>
                                                                إسم المركز   بالانجليزية <small class="text-danger">*</small>
                                                            </label>
                                                            <input type="text" value="{{$center->en_name}}"  required="required" name="en_name" maxlength="191" class="SpecificInput">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                وصف المركز   بالانجليزية <small class="text-danger">*</small>
                                                            </label>
                                                            <textarea name="en_address" class="SpecificInput" rows="3" required="required">{{$center->en_address}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                 تضمين الخريطة - Google Map
                                                            </label>
                                                            <input type="text" name="google_map" value="{{$center->google_map}}"  class="SpecificInput">
                                                        </div>
                                    
                                                        
                                                        <div class="form-group">
                                                            <label>
                                                                 مواعيد العمل
                                                            </label>
                                                            <button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-times">
                                                                تعديل مواعيد العمل
                                                              </button>
                                                              <div class="div-times">
                                                                  @foreach ($times as $time)
                                                                  <div class="d-flex justify-content-between mt-3">
                                                                    <div class="p-2 ml-1 bg-info text-white col-md-4">{{__('site.'.$time->day)}}</div>
                                                                    <div class="p-2  ml-1  bg-info text-white col-md-4">{{$time->start_time}}</div>
                                                                    <div class="p-2   ml-1 bg-info text-white col-md-4">{{$time->end_time}}</div>
                                                                    </div>
                                                                  @endforeach
                                                              </div>
                                                            
                                                        </div>
                                     
                                                        <div class="form-group">
                                                            <label>
                                                                 الخدمات المقدمة 
                                                            </label>
                                                            <button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-services">
                                                                تعديل الخدمات المقدمة 
                                                              </button>
                                                              <div class="div-services">
                                                                  @if ($center->getCategory())
                                                                  <div class="w-100  mt-3">
                                                                    <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   :{{$center->getCategory()}}</div>
                                                                   </div>
                                                                  @endif
                                                                  @if ($center->getStore)
                                                                  <div class="w-100  mt-3">
                                                                    <div class="p-2 ml-1 bg-info text-white">  {{__('site.store name')}}   : {{$center->getStore->ar_name}}</div>
                                                                 </div>
                                                                  @endif
                                                              </div>
                                                            
                                                        </div>
                                    
                                    
                                    
                                                        <div class="form-group">
                                                            <label>
                                                                   الحالة
                                                            </label>
                                                            <select class="SpecificInput" name="status" >
                                                                <option value="1" {{$center->status == 1 ? 'selected' : ''}}> نشط  </option>
                                                                <option value="0" {{$center->status == 0 ? 'selected' : ''}}> غير نشط </option>
                                                            </select>
                                                        </div>
                                    
                                                        <div class="form-group">
                                                            <label>
                                                                نوع العضوية
                                                            </label>
                                                            <select class="SpecificInput select3" value="{{$center->special}}"  name="special"  id="special">
                                                                @foreach ($center->getServiceMemberShips() as $ms)
                                                                <option value="{{$ms->id}}">{{$ms->ar_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                    
                                                        <div class="form-group">
                                                            <input type="submit" name="submit" value="حفظ " class="btn btn-primary w-25 " style="float: left;">
                                                        </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                                    </div>
                                                </div>
                                        <div class="col-md-12">
                                          {{-- range time modal --}}
                                      <div class="modal fade" id="modal-times" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h5 class="modal-title">أوقات وأيام العمل</h5>
                                                </div>
                                                <div class="modal-body">
                                                   <div class="row position-relative new-time">
                                                       <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>اليوم</label>
                                                          <select name="day[]" class="form-control" >
                                                            <option value="">{{__('site.choose')}}</option>
                                                            <option value="all_days">{{__('site.all_days')}}</option>
                                                            <option value="sunday">{{__('site.sunday')}}</option>
                                                            <option value="monday">{{__('site.monday')}}</option>
                                                            <option value="tuesday">{{__('site.tuesday')}}</option>
                                                            <option value="wednesday">{{__('site.wednesday')}}</option>
                                                            <option value="thursday">{{__('site.thursday')}}</option>
                                                            <option value="friday">{{__('site.friday')}}</option>
                                                            <option value="saturday">{{__('site.saturday')}}</option>
                                                          </select>
                                                        </div>
                                                       </div>
                                                       <div class="col-md-4">
                                                        <label>من</label>
                                                        <div class="form-group">
                                                            <input name="start_time[]"  type="time" class="form-control" >
                                                          </div>
                                                       </div>
                                                       <div class="col-md-4">
                                                        <label>إلى</label>
                                                        <div class="form-group">
                                                            <input name="end_time[]"  type="time" class="form-control" >
                                                          </div>
                                                       </div>
                                                   </div>
                                                </div>
                                                <button type="button" id="add-new-time" class="btn btn-primary">{{__('site.add new time')}}</button>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                                                    <button type="button" class="btn btn-primary save-times">{{__('site.save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                      {{-- range time modal --}}
                                      <div class="modal fade" id="modal-services" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h5 class="modal-title"> تعديل مجال العمل</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                         <div class="form-group">
                                                             <label for="category">  القسم  </label>
                                                             <select value="" class="form-control select2" name="category" id="category"> 
                                                               @foreach($categories as $category)
                                                                   <option value="{{$category->id}}">
                                                                       {{$category->ar_name}}
                                                                   </option>
                                                               @endforeach
                                                             </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                         <div class="form-group">
                                                             <label for="sub_category">  القسم الفرعي  </label>
                                                             <select disabled value="" class="form-control select2"    name="sub_category" id="sub_category"> 
                                                                 <option value="">{{__('site.choose')}}</option>
                                                             </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                         <div class="form-group">
                                                             <label for="child_category">  القسم الفرع فرعي   </label>
                                                             <select disabled value="" class="form-control select2" name="child_category" id="child_category"> 
                                                               <option value="">{{__('site.choose')}}</option>
                                                             </select>
                                                          </div>
                                                        </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="store">   إسم المحل   </label>
                                                                <select disabled value="" class="form-control select2" name="store" id="store"> 
                                                                  <option value="">{{__('site.choose')}}</option>
                                                                </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                                                    <button type="button" class="btn btn-primary save-services">{{__('site.save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                    
                                          </form>
                                         
                                    @endif
                                    </div>
                                   @if(auth()->user()->type == 2 || auth()->user()->type == 3 )
                                     <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                         aria-labelledby="pills-profile-tab">
                                             <span style="font-size:14px;font-weight:600">
                                                @if(app()->getLocale() == 'ar')
                                                     تعديل البيانات الرئيسية للوكالة
                                                 @else
                                                     Edit Agency Main Information
                                                 @endif
                                            </span>
                                            <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                            <form method="POST" action="{{route('agent-update')}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <input type="hidden" value="{{auth()->user()->id}}">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>
                                                                    @if(app()->getLocale() == 'ar')
                                                                        البلد
                                                                    @else
                                                                        Country
                                                                    @endif
                                                                </label>
                                                                <?php
                                                                $countries = \App\country::where(['parent' => 0])->get();
                                                                $agent = \App\Agents::where('user_id', auth()->user()->id)->first();
                                                                ?>
                                                                <input type="hidden" name="agent_id" value="{{$agent->id}}"/>
                                                                <select class="form-control select2" name="country_id">
                                                                    @if(app()->getlocale() == 'ar')
                                                                        <option selected disabled>
                                                                            اختر البلد
                                                                        </option>
                                                                        @foreach($countries as $country)
                                                                            <option
                                                                                value="{{$country->id}}" {{$country->id == $agent->country_id ? 'selected' : ''}}>
                                                                                {{$country->ar_name}}
                                                                            </option>
                                                                        @endforeach
                                                                    @else
                                                                        <option selected disabled>
                                                                            Choose Country
                                                                        </option>
                                                                        @foreach($countries as $country)
                                                                            <option
                                                                                value="{{$country->id}}" {{$country->id == $agent->country_id ? 'selected' : ''}}>
                                                                                {{$country->en_name}}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>
                                                                @if(app()->getlocale() == 'ar')

                                                                    الاسم بالعربية

                                                                @else
                                                                    Name Ar
                                                                @endif
                                                            </label>
                                                            <input class="SpecificInput" value="{{$agent->ar_name}}" name="ar_name" max="191">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>
                                                                @if(app()->getlocale() == 'ar')

                                                                    الاسم بالانجليزية

                                                                @else
                                                                    Name En
                                                                @endif
                                                            </label>
                                                            <input class="SpecificInput" value="{{$agent->en_name}}"
                                                                   name="en_name" max="191">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                @if(app()->getlocale() == 'ar')

                                                                    العنوان بالعربية

                                                                @else
                                                                    Address AR
                                                                @endif
                                                            </label>
                                                            <input class="SpecificInput" value="{{$agent->ar_address}}"
                                                                   name="ar_address">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>
                                                                    @if(app()->getLocale() == 'ar')

                                                                        العنوان بالانجليزية

                                                                    @else
                                                                        Address En
                                                                    @endif
                                                                </label>
                                                                <input class="SpecificInput"
                                                                       value="{{$agent->en_address}}" name="en_address">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label style="display:inline-block">
                                                                    @if(app()->getLocale() == 'ar')

                                                                        ارقام الهاتف

                                                                    @else
                                                                        Phones
                                                                    @endif
                                                                </label>
                                                                <small style="color:red;position: relative;top: -7px;">
                                                                    01XXXXXXXX,02XXXXXXXXXXX
                                                                </small>
                                                                <input class="SpecificInput" value="{{$agent->phones}}"
                                                                       name="phones">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>
                                                                    @if(app()->getLocale() == 'ar')
                                                                        نوع العربيات <small
                                                                            class="text-danger">*</small>
                                                                    @else
                                                                        Cars Type <small class="text-danger">*</small>
                                                                    @endif
                                                                </label>
                                                                <select class="SpecificInput" name="car_type">
                                                                    <option
                                                                        value="0" {{$agent->car_type == 0 ? 'selected' : ''}}>
                                                                        Used
                                                                    </option>
                                                                    <option
                                                                        value="1" {{$agent->car_type == 1 ? 'selected' : ''}}>
                                                                        New
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>
                                                                    @if(app()->getLocale() == 'ar')
                                                                        صور الوكالة<small class="text-danger">*</small>
                                                                    @else
                                                                        Agent Image <small class="text-danger">*</small>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="image" class="SpecificInput">
                                                                <img src="{{url('/')}}/uploads/{{$agent->image}}"
                                                                     style="width:100px;height:100px !important;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <span style="font-size:14px;font-weight:600"> @if(app()->getLocale() == 'ar')
                                                        تعديل بيانات التواصل الاجتماعي
                                                    @else
                                                        Edit Agency  Social Links
                                                    @endif
                                                </span>
                                                <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    فيسبوك

                                                                @else
                                                                    Facebook
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput" value="{{$agent->fb_page}}"
                                                                   name="fb_page">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    تويتر

                                                                @else
                                                                    Twitter
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput"
                                                                   value="{{$agent->twitter_page}}" name="twitter_page">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    إنستجرام

                                                                @else
                                                                    Instgram
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput" value="{{$agent->instagram}}"
                                                                   name="instagram">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    الموقع الالكتروني

                                                                @else
                                                                    Website
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput" value="{{$agent->website}}"
                                                                   name="website">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    البريد الالكتروني

                                                                @else
                                                                    Email
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput" value="{{$agent->email}}"
                                                                   name="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    جوجل ماب

                                                                @else
                                                                    Google Map
                                                                @endif
                                                            </label>

                                                            <input class="SpecificInput" value="{{$agent->google_map}}"
                                                                   name="google_map">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <span style="font-size:14px;font-weight:600">   @if(app()->getLocale() == 'ar')
                                                        مواعيد العمل
                                                    @else
                                                        Works Time
                                                    @endif
                                                </span>
                                                <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')
                                                                    ايام العمل
                                                                @else
                                                                    Work Days
                                                                @endif
                                                            </label>

                                                            <input type="text" class="SpecificInput"
                                                                   value="{{$agent->days_on}}" name="days_on"
                                                                   placeholder="Sun to Tue" max="191">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')
                                                                    مواعيد العمل
                                                                @else
                                                                    Time of Work
                                                                @endif
                                                            </label>

                                                            <input type="text" class="SpecificInput"
                                                                   value="{{$agent->times_on}}" name="times_on"
                                                                   placeholder="9 AM : 5 PM" max="191">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="submit" class="btn btn-primary btn-block"
                                                               value="{{app()->getLocale() == 'ar' ? 'حفظ' : 'Save'}}"/>
                                                    </div>
                                            </form>
                                        </div>
                                           @endif
                                           @if(auth()->user()->type == 1)
                                               <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                                   aria-labelledby="pills-contact-tab">
                                         <span style="font-size:14px;font-weight:600">
                                            @if(app()->getLocale() == 'ar')
                                                 تعديل البيانات الرئيسية للمعرض
                                             @else
                                                 Edit Exhibitors Information
                                             @endif
    			        </span>
                                        <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                        <form method="POST" action="{{route('exhi-update')}}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')
                                                                    البلد
                                                                @else
                                                                    Country
                                                                @endif
                                                            </label>
                                                            <?php $countries = \App\country::where(['parent' => 0, 'status' => 1])->get();

                                                            $Exhibition = \App\Exhibition::where('user_id', auth()->user()->id)->first();
                                                            ?>

                                                            <input type="hidden" name="agent_id"
                                                                   value="{{$Exhibition->id}}"/>
                                                            <select class="form-control select2" name="country_id">
                                                                @if(app()->getlocale() == 'ar')

                                                                    @foreach($countries as $country)
                                                                        <option
                                                                            value="{{$country->id}}" {{$Exhibition->country_id == $country->id ? 'selected' : ''}}>
                                                                            {{$country->ar_name}}
                                                                        </option>
                                                                    @endforeach
                                                                @else

                                                                    @foreach($countries as $country)
                                                                        <option
                                                                            value="{{$country->id}}" {{$Exhibition->country_id == $country->id ? 'selected' : ''}}>
                                                                            {{$country->en_name}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>
                                                            @if(app()->getlocale() == 'ar')

                                                                الاسم بالعربية

                                                            @else
                                                                Name Ar
                                                            @endif
                                                        </label>
                                                        <input class="SpecificInput" value="{{$Exhibition->ar_name}}"
                                                               name="ar_name" max="191">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>
                                                            @if(app()->getlocale() == 'ar')

                                                                الاسم بالانجليزية

                                                            @else
                                                                Name En
                                                            @endif
                                                        </label>
                                                        <input class="SpecificInput" value="{{$Exhibition->en_name}}"
                                                               name="en_name" max="191">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>
                                                            @if(app()->getlocale() == 'ar')

                                                                الوصف بالعربية

                                                            @else
                                                                Description AR
                                                            @endif
                                                        </label>
                                                        <input class="SpecificInput"
                                                               value="{{$Exhibition->ar_description}}"
                                                               name="ar_description">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')

                                                                    الوصف بالانجليزية

                                                                @else
                                                                    Description En
                                                                @endif
                                                            </label>
                                                            <input class="SpecificInput"
                                                                   value="{{$Exhibition->en_description}}"
                                                                   name="en_description">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')
                                                                    نوع العربيات <small class="text-danger">*</small>
                                                                @else
                                                                    Cars Type <small class="text-danger">*</small>
                                                                @endif
                                                            </label>
                                                            <select class="SpecificInput" name="car_type">
                                                                <option
                                                                    value="0" {{$Exhibition->car_type == 0 ? 'selected' : ''}}>
                                                                    Used
                                                                </option>
                                                                <option
                                                                    value="1" {{$Exhibition->car_type == 1 ? 'selected' : ''}}>
                                                                    New
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                @if(app()->getLocale() == 'ar')
                                                                    صور المعرض<small class="text-danger">*</small>
                                                                @else
                                                                    Exhibitors Image <small
                                                                        class="text-danger">*</small>
                                                                @endif
                                                            </label>
                                                            <input type="file" name="image" class="SpecificInput"
                                                                   required="required">
                                                            <input type="file" name="img" class="">
                                                            <img src="{{url('/')}}/uploads/{{$Exhibition->image}}"
                                                                 style="width:100px;height:100px !important;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <span style="font-size:14px;font-weight:600">
    			            @if(app()->getLocale() == 'ar')
                                                    تعديل بيانات التواصل الاجتماعي
                                                @else
                                                    Edit Agency  Social Links
                                                @endif
    			        </span>
                                            <div
                                                style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                فيسبوك

                                                            @else
                                                                Facebook
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput" value="{{$Exhibition->fb_bage}}"
                                                               name="fb_page">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                تويتر

                                                            @else
                                                                Twitter
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput"
                                                               value="{{$Exhibition->twitter_page}}"
                                                               name="twitter_page">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                إنستجرام

                                                            @else
                                                                Instgram
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput" value="{{$Exhibition->instagram}}"
                                                               name="instagram">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                الموقع الالكتروني

                                                            @else
                                                                Website
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput" value="{{$Exhibition->website}}"
                                                               name="website">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                البريد الالكتروني

                                                            @else
                                                                Email
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput" value="{{$Exhibition->email}}"
                                                               name="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')

                                                                جوجل ماب

                                                            @else
                                                                Google Map
                                                            @endif
                                                        </label>

                                                        <input class="SpecificInput" value="{{$Exhibition->google_map}}"
                                                               name="google_map">
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <span style="font-size:14px;font-weight:600">
    			            @if(app()->getLocale() == 'ar')
                                                    مواعيد العمل
                                                @else
                                                    Works Time
                                                @endif
    			        </span>
                                            <div
                                                style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                ايام العمل
                                                            @else
                                                                Work Days
                                                            @endif
                                                        </label>

                                                        <input type="text" class="SpecificInput"
                                                               value="{{$Exhibition->days_on}}" name="days_on"
                                                               placeholder="Sun to Tue" max="191">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                مواعيد العمل
                                                            @else
                                                                Time of Work
                                                            @endif
                                                        </label>

                                                        <input type="text" class="SpecificInput"
                                                               value="{{$Exhibition->times_on}}" name="times_on"
                                                               placeholder="9 AM : 5 PM" max="191">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">

                                                </div>
                                                <div class="col-md-4">
                                                    <input type="submit" class="btn btn-primary btn-block"
                                                           value="{{app()->getLocale() == 'ar' ? 'حفظ' : 'Save'}}"/>
                                                </div>
                                        </form>
                                    </div>
                                          @endif
                                          @if(auth()->user()->type != 0)
                                          <?php $doc=\App\DocumentsUser::where('user_id',auth()->user()->id)->first() ?>
                                          <div class="tab-pane fade" id="pills-document" role="tabpanel" >
                                              <div style="background-color:#007BFF;height:2px;width:50px;margin-top:5px;margin-bottom:15px;"></div>
                                              <form method="POST" action="{{route('upload-user-documents')}}" enctype="multipart/form-data">
                                                  @csrf
                                                  <div class="col-lg-12">
                                                      <div class="row">
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                  <label>{{__('site.license_image')}}</label>
                                                                  <input type="file" name="license_image" required class="SpecificInput">
                                                                  @isset($doc)
                                                                  <img src="{{asset('uploads/'.$doc->license_image)}}" alt="" style="width: 50px;height: 50px">
                                                                  @endisset
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                  <label>{{__('site.id_image')}}</label>
                                                                  <input type="file" required name="id_image" class="SpecificInput">
                                                                  @isset($doc)
                                                                      <img src="{{asset('uploads/'.$doc->id_image)}}" alt="" style="width: 50px;height: 50px">
                                                                  @endisset
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                  <label>{{__('site.company_name')}}</label>
                                                                  <input type="text" required name="company_name" class="SpecificInput" value="@isset($doc){{$doc->company_name}}@endisset">
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <div class="form-group">
                                                                  <label>{{__('site.license_number')}}</label>
                                                                  <input type="text" required name="license_number" value="@isset($doc){{$doc->license_number}}@endisset" class="SpecificInput" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <label>{{__('site.start_date')}} </label>
                                                              <div class="form-group">
                                                                  <input class="SpecificInput" required value="" name="start_date" type="date" value="@isset($doc){{$doc->start_date}}@endisset">
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                              <label>{{__('site.end_date')}} </label>
                                                              <div class="form-group">
                                                                  <input class="SpecificInput" required value="" name="end_date" type="date" value="@isset($doc){{$doc->end_date}}@endisset">
                                                              </div>
                                                          </div>
                                                          @if(!$doc)
                                                          <div class="col-sm-4 mt-5">
                                                              <div class="form-group">
                                                                  <input class="SpecificInput btn btn-primary" value="{{__('site.save')}}"  type="submit">
                                                              </div>
                                                          </div>
                                                          @endif
                                                      </div>
                                                  </div>
      
                                              </form>
                                          </div>
                                          @endif
                                </div>
                         
                           
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!--------- Personal Infromattion  Edit Modal !---------->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if(app()->getLocale() == 'ar')
                        <h5 class="modal-title" id="exampleModalLabel2">تعديل البيانات الشخصية</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel2">Update Personal Information</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body"
                         style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                        <div class="form">

                            <form method="POST" action="{{route('user-update')}}" enctype="multipart/form-data">
                                @csrf
                                <nav>
                                    @if(app()->getLocale() == 'ar')
                                        <div class="nav nav-tabs" id="nav-tab1" role="tablist">

                                            <a class="nav-item nav-link active" id="nav-home-tab1" data-toggle="tab"
                                               href="#nav-home1" role="tab" aria-controls="nav-home1"
                                               aria-selected="true">معلومات شخصية</a>
                                            @if(auth()->user()->type > 0)
                                                <a class="nav-item nav-link active" id="nav-home-tab1" data-toggle="tab"
                                                   href="#nav-home1" role="tab" aria-controls="nav-home1"
                                                   aria-selected="true">معلومات شخصية</a>
                                                <a class="nav-item nav-link" id="nav-profile-tab1" data-toggle="tab"
                                                   href="#nav-profile1" role="tab" aria-controls="nav-profile1"
                                                   aria-selected="false">وسائل التواصل</a>

                                                <a class="nav-item nav-link" id="nav-contact-tab1" data-toggle="tab"
                                                   href="#nav-contact1" role="tab" aria-controls="nav-contact1"
                                                   aria-selected="false">خريطة جوجل</a>

                                                <a class="nav-item nav-link" id="nav-price-tab1" data-toggle="tab"
                                                   href="#nav-price1" role="tab" aria-controls="nav-price"
                                                   aria-selected="false">طرق الدفع</a>
                                        </div>
                                    @endif
                                    @else
                                        <div class="nav nav-tabs" id="nav-tab1" role="tablist">

                                            <a class="nav-item nav-link active" id="nav-home-tab1" data-toggle="tab"
                                               href="#nav-home1" role="tab" aria-controls="nav-home1"
                                               aria-selected="true">Personal Information</a>
                                            @if(auth()->user()->type > 0)
                                                <a class="nav-item nav-link active" id="nav-home-tab1" data-toggle="tab"
                                                   href="#nav-home1" role="tab" aria-controls="nav-home1"
                                                   aria-selected="true">Personal Information</a>
                                                <a class="nav-item nav-link" id="nav-profile-tab1" data-toggle="tab"
                                                   href="#nav-profile1" role="tab" aria-controls="nav-profile1"
                                                   aria-selected="false">Social Media</a>

                                                <a class="nav-item nav-link" id="nav-contact-tab1" data-toggle="tab"
                                                   href="#nav-contact1" role="tab" aria-controls="nav-contact1"
                                                   aria-selected="false">Google Map</a>

                                                <a class="nav-item nav-link" id="nav-price-tab1" data-toggle="tab"
                                                   href="#nav-price1" role="tab" aria-controls="nav-price"
                                                   aria-selected="false">Online Payment</a>
                                        </div>
                                    @endif
                                    @endif
                                </nav>

                                <div class="tab-content" id="nav-tabContent1">
                                    <div class="tab-pane fade show active" id="nav-home1" role="tabpanel"
                                         aria-labelledby="nav-home-tab1">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            الأسم <small class="text-danger">*</small>
                                                            @else
                                                                Name <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="text" value="{{auth()->user()->name}}" required
                                                           name="ar_name" max="191" class="SpecificInput">
                                                </div>


                                                <div class="form-group col-md-6">
                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            التيليفون <small class="text-danger">*</small>
                                                            @else
                                                                Mobil No. <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="tel" value="{{auth()->user()->phone}}" name="mobil"
                                                           max="191" class="SpecificInput">


                                                </div>
                                                <div class=" form-group col-md-6">

                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            البريد الألكتروني <small class="text-danger">*</small>
                                                            @else
                                                                Email Address <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="email" value="{{auth()->user()->email}}" name="Email"
                                                           max="191" required class="SpecificInput">

                                                </div>
                                                <div class=" form-group col-md-6">

                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            الصورة<small class="text-danger">*</small>
                                                            @else
                                                                Image <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="file" name="img" class="SpecificInput">
                                                    <img src="{{url('/')}}/uploads/{{auth()->user()->image}}"
                                                         style="width:100px;height:100px !important;">
                                                </div>

                                                <div class="col-md-6 form-group">

                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            كلمة المرور<small class="text-danger">*</small>
                                                            @else
                                                                Password <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="password" name="password" class="SpecificInput">

                                                </div>

                                                <div class="form-group col-md-6">

                                                    @if(app()->getLocale() == 'ar')
                                                        <label>
                                                            إعادة كلمة المرور<small class="text-danger">*</small>
                                                            @else
                                                                Re Password <small class="text-danger">*</small>
                                                        </label>
                                                    @endif
                                                    <input type="password" name="re_password" class="SpecificInput">

                                                </div>
                                            </div>
                                        </div>
                                        @if(auth()->user()->type > 0)
                                            <div class="tab-pane fade" id="nav-profile1" role="tabpanel"
                                                 aria-labelledby="nav-profile-tab1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group col-lg-12">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    فيس بوك
                                                                    @else
                                                                        Facebook
                                                                </label>
                                                            @endif
                                                            <input type="text" name="facebook" max="191"
                                                                   class="SpecificInput">
                                                        </div>
                                                        <div class="form-group col-lg-12">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    تويتر
                                                                    @else
                                                                        Twitter
                                                                </label>
                                                            @endif
                                                            <input type="text" name="twitter" max="191"
                                                                   class="SpecificInput">
                                                        </div>
                                                        <div class="form-group col-lg-12">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    أنستجرام
                                                                    @else
                                                                        Instagram
                                                                </label>
                                                            @endif
                                                            <input type="text" name="instagram" max="191"
                                                                   class="SpecificInput">

                                                        </div>

                                                        <div class="form-group col-lg-12">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    البريد الألكتروني
                                                                    @else
                                                                        Email Address
                                                                </label>
                                                            @endif
                                                            <input type="text" name="youtube" max="191"
                                                                   class="SpecificInput">
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-contact1" role="tabpanel"
                                                 aria-labelledby="nav-contact-tab1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    خريطة جوجل<small class="text-danger">*</small>
                                                                    @else
                                                                        Google Map <small class="text-danger">*</small>
                                                                </label>
                                                            @endif
                                                            <textarea class="SpecificInput"
                                                                      name="ar_description"></textarea>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="nav-price1" role="tabpanel"
                                                 aria-labelledby="nav-price-tab1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            @if(app()->getLocale() == 'ar')
                                                                <label>
                                                                    طريقة الدفع أونلاين
                                                                    <small class="text-danger">*</small>
                                                                    @else
                                                                        Online Payment <small
                                                                            class="text-danger">*</small>
                                                                </label>
                                                            @endif
                                                            <select name="" id=""
                                                                    style="width: 100%;border:1px solid #d3d3d3;border-radius: 5px;padding: 10px;">
                                                                <option value="">PAYPAL</option>
                                                                <option value="">CASH</option>
                                                                <option value="">VISA</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                    @endif


                                    <div class="modal-footer">
                                        @if(app()->getLocale() == 'ar')
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق
                                            </button>
                                            <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                                        @else
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <input type="submit" name="submit" class="btn btn-primary" value="save">
                                        @endif
                                    </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script > tinymce.init({selector: 'textarea'});</script>
    {{-- start maintenance center scipt --}}
    <script>
        var csrf =  $('meta[name="csrf-token"]').attr('content');
        
        var getSubCategories = function(){
         $('#category').on('change',function(){
          var id = $(this).val()
         $.ajax({
             type: "get",
             dataType: "json",
             url: "/dashboard/service_categories/get-childrens/"+id,
             success: function(data){
                 $('#sub_category').html('');
                if(data.length)
                {
                  data.forEach(e => {
                      $('#sub_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                  });
                  $("#sub_category").prop('disabled',false)
                }else
                  $("#sub_category").prop('disabled',true)
                  $('#sub_category').trigger('change')
                  getStores()
    
             },error :function(error){
                 console.log(error)
             }
             
         })
         })
         $('#category').trigger('change')
     }
     var saveTimes = function(){
             $days  = $('select[name="day[]"]')
             $start_times  = $('input[name="start_time[]"]')
             $end_times  = $('input[name="end_time[]"]')
             var html = ''
             var errors = {}
             for (let i = 0; i < $days.length; i++) {
                 const day = $($days[i]).find('option:selected').html();
                 const start_time = $($start_times[i]).val();
                 const end_time = $($end_times[i]).val();
                 $($start_times[i]).parent().find('.error').remove()
                 $($end_times[i]).parent().find('.error').remove()
                 if(!start_time) {
                  $($start_times[i]).after('<div class="text-danger error">{{__("site.required")}}</div>')
                  errors['start_time'] = true
                 }
                 if(!end_time) {
                  $($end_times[i]).after('<div class="text-danger error">{{__("site.required")}}</div>')
                   errors['end_time'] = true
                 }
                 if(start_time && end_time)
                 html += `<div class="d-flex justify-content-between mt-3">
                 <div class="p-2 ml-1 bg-info text-white col-md-4">`+day +`</div>
                 <div class="p-2  ml-1  bg-info text-white col-md-4">`+start_time+`</div>
                 <div class="p-2   ml-1 bg-info text-white col-md-4">`+end_time+`</div>
                 </div>`
             }
             if(!Object.keys(errors).length) {
             $('.div-times').html(html)
             $('.modal .close').click()
             }
         }
         var removeRowTime = function()
         {
             $(this).parent().remove()
         }
         var clearElement = function($e)
         {
             $($e).find('input').val('')
         }
         var addNewTime = function()
         {
             $new = $('.new-time').clone()[0]
             $($new).removeClass('new-time')
             clearElement($new)
             $($new).append('<div class="remove text-danger mr-2"></div>')
             $('.new-time').parent().append($new)
         }
     var getChildCategories = function(){
         $('#sub_category').on('change',function(){
          var id = $(this).val()
         $.ajax({
             type: "get",
             dataType: "json",
             url: "/dashboard/service_sub_categories/get-childrens/"+id,
             success: function(data){
                 $('#child_category').html('');
                if(data.length)
                {
                  data.forEach(e => {
                      $('#child_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                  });
                  $("#child_category").prop('disabled',false)
                }else
                  $("#child_category").prop('disabled',true)
                  getStores()
    
             }
         })
         })
         $('#sub_category').trigger('change')
     }
     var getStores = function(){
         $("#store").prop('disabled',true)
           var data = {}
           data['category'] = !$('#category').is(':disabled') ? $('#category').val() : null
           data['sub_category'] =  !$('#sub_category').is(':disabled') ? $('#sub_category').val() : null
           data['child_category'] =  !$('#child_category').is(':disabled') ? $('#child_category').val() : null
            var name = "{{app()->getLocale()}}"+"_name"
           $.ajax({
             type: "post",
             dataType: "json",
             data:data,
             headers: {'X-CSRF-TOKEN': csrf},
             url: "/dashboard/store/get",
             success: function(data){
                 $('#store').html('');
                if(data.length)
                {
                  data.forEach(e => {
                      $('#store').append('<option value="'+e.id+'">'+e[name]+'</option>')
                  });
                  $("#store").prop('disabled',false)
                }else
                  $("#store").prop('disabled',true)
             },
          
         })
     }
     var saveServices = function()
     {
         var category = !$('#category').is(':disabled') ? $('#category').find('option:selected').html() : null
         var sub_category =  !$('#sub_category').is(':disabled') ? $('#sub_category').find('option:selected').html() : null
         var child_category =  !$('#child_category').is(':disabled') ? $('#child_category').find('option:selected').html() : null
         var store =  !$('#store').is(':disabled') ? $('#store').find('option:selected').html() : null
         var name = "{{app()->getLocale()}}"+"_name"
         var html = ''
         if(child_category)
         html = `<div class="w-100 mt-3">
                 <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+child_category +`</div>
                 </div>`
         else  if(sub_category)
         html = `<div class="w-100  mt-3">
                 <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+sub_category +`</div>
          </div>`
         else
         html = `<div class="w-100  mt-3">
                 <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+category +`</div>
          </div>`
          if(store)
          html += `<div class="w-100  mt-3">
                 <div class="p-2 ml-1 bg-info text-white">  {{__('site.store name')}}   : `+store +`</div>
          </div>`
          if(html.length){
         $('.div-services').html(html)
         $('.modal .close').click()
         getServiceMemberShip()
          }
     }
     var getServiceMemberShip = function(){
         $("#store").prop('disabled',true)
           var data = {}
           data['category'] = !$('#category').is(':disabled') ? $('#category').val() : null
           data['sub_category'] =  !$('#sub_category').is(':disabled') ? $('#sub_category').val() : null
           data['child_category'] =  !$('#child_category').is(':disabled') ? $('#child_category').val() : null
            var name = "{{app()->getLocale()}}"+"_name"
           $.ajax({
             type: "post",
             dataType: "json",
             data:data,
             headers: {'X-CSRF-TOKEN': csrf},
             url: "/dashboard/service_member_ships/get",
             success: function(data){
                 $('#special').html('');
                 console.log(data);
                 console.log(name);
                if(data.length)
                {
                  data.forEach(e => {
                      $('#special').append('<option value="'+e.id+'">'+e[name]+'</option>')
                  });
                 //  $("#special").prop('disabled',false)
                }
                 //  $("#store").prop('disabled',true)
             },
          
         })
     }
     $(document).ready(function(){
         // events
         $('#add-new-time').on('click',addNewTime)
         $(document).on('click','.remove',removeRowTime)
         $('.save-times').on('click',saveTimes)
         $('.save-services').on('click',saveServices)
         getSubCategories()
         getChildCategories()
         getStores()
    
     
     })
    </script>
    {{-- end maintenance center scipt --}}

    


@endsection


