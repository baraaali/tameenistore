@extends('layouts.app')
@section('content')
    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $name2=$lang=='ar'?'name_ar':'name_en';
    $check=checkUploadDocument();
    ?>

    <div class="col-lg-12">
                @include('dashboard.layout.message')
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">


                    @if(app()->getLocale() == 'ar')
                        <a class="nav-link" id="v-pills-home-tab" href="{{url('/')}}/cp/index/{{app()->getLocale()}}"
                           aria-controls="v-pills-home" aria-selected="false">معلومات رئيسية</a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ads/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">إعلانات</a>
                        <!--اhref-->
                        <a class="nav-link active" id="v-pills-accessories-tab" href=""
                           aria-controls="v-pills-accessories" aria-selected="true">أقسام</a>


                        <a class="nav-link " id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">تأمين</a>
                        @if(auth()->user()->type==3)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="{{route('my_orders',$lang)}}" aria-controls="v-pills-messages"
                               aria-selected="false">
                                <span
                                    class="badge badge-pill badge-danger m-1">{{\App\Booking::where('owner_id',auth()->user()->id)->count()}}</span>طلباتى
                            </a>
                        @endauth
                        @if(auth()->user()->type >= 1)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="/Cdashboard/branches/{{app()->getLocale()}}" aria-controls="v-pills-messages"
                               aria-selected="false">معلومات الفروع</a>
                        @endif



                    @else
                        <a class="nav-link" id="v-pills-home-tab" href="{{url('/')}}/cp/index/{{app()->getLocale()}}"
                           aria-controls="v-pills-home" aria-selected="false">Personal Information</a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ads/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Advertisment</a>

                        <!--aria control &href-->
                        <a class="nav-link active" id="v-pills-accessories-tab" href=""
                           aria-controls="v-pills-accessories" aria-selected="true"> Departments </a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ins/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Insurance</a>


                        @if(auth()->user()->type >= 1)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="{{url('/')}}/Cdashboard/branches/{{app()->getLocale()}}"
                               aria-controls="v-pills-messages" aria-selected="false">Branches</a>
                        @endif

                    @endif

                </div>
            </div>


            <div class="col-9">

                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative; display: inline-block;top: 6px;">
                                    @if(app()->getLocale() == 'ar')
                                        اعلانات الاقسام
                                    @else
                                        The Departments ads
                                    @endif
                                </h5>

                                <a href="#" class="btn btn-light circle" data-toggle="modal"
                                   @if ($check==1)
                                   onclick="return alert('من فضلك قم برفع المستندات المطلوبه اولا ');return false"
                                @else data-target="#exampleModal"
                                    @endif>
                                    <i class="fas fa-plus-circle"></i>
                                    {{__('site.add_new')}}
                                </a>
                                <!--<a href="#"  class="btn btn-light circle">-->
                                <!--	   <i class="fas fa-trash"></i> -->
                                <!--</a>-->
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        جميع  إعلانات الاقسام
                                    @else
                                        All Departments ads
                                    @endif
                                </label>

                                <br>


                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                    @if(app()->getLocale() == 'ar')
                                        <td>
                                            اسم الاعلان بالعربيه
                                        </td>
                                        <td>
                                            الدوله
                                        </td>

                                        <td>
                                            السعر
                                        </td>
                                        <td>الصورة الرئيسيه</td>
                                        <td></td>

                                    @else


                                        <td>
                                            Name In English
                                        </td>
                                        <td>
                                            Country
                                        </td>

                                        <td>
                                            Price
                                        </td>
                                        <td>
                                            image
                                        </td>
                                        <td></td>


                                    @endif
                                    </thead>

                                    <?php
                                    $name = $lang . '_name';
                                    ?>
                                    @foreach($items  as $item)
                                        <tbody>
                                        <tr>
                                            <td>
                                                {{$item->$name}}
                                            </td>
                                            <td>{{\App\country::where('id',$item->country_id)->first()->$name}}</td>
                                            <td>
                                                {{$item->price}}
                                            </td>
                                            <td>
                                                <img src="{{asset('uploads/'.$item->main_image)}}" alt=""
                                                     style="height:50px;width: 50px" class="img-thumbnail">
                                            </td>

                                            <td>
                                                <a href="" class="btn btn-primary btn-xs" data-toggle="modal"
                                                   data-target="#exampleModalLabel2{{$item->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-xs" data-toggle="modal"
                                                   data-target="#exampleModal{{$item->id}}">
                                                    <i class="fas fa-sync"></i> تجديد
                                                </a>
                                                <a onclick="return confirm('Are you sure?')"
                                                   href="{{route('items-delete',$item->id)}}"
                                                   class="btn btn-danger">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                                <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel{{$item->id}}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                @if(app()->getLocale() == 'ar')
                                                                    <h5 class="modal-title" id="exampleModalLabel">تجديد
                                                                        الاعلان</h5>
                                                                @else
                                                                    <h5 class="modal-title" id="exampleModalLabel">Ads
                                                                        Renew</h5>
                                                                @endif
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('renew_ads_member_from_balance')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" id="cash" value="" name="cash">
                                                                    <input type="hidden" id="ad" value="{{$item->id}}" name="ad">
                                                                    {{--                                                                    <div class="form-group col-md-12">--}}
                                                                    {{--                                                                        <label>{{__('site.number_days')}}</label>--}}
                                                                    {{--                                                                        <input type="number" step="1" min="1" value="1" class="SpecificInput" name="number_days" id="number_days" required>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    <div class="form-group col-md-12">
                                                                        <label>{{__('site.ads_type')}}
                                                                            {{--                                                                            <span class="text-danger" id="show_price"></span>--}}
                                                                        </label>
                                                                        <select name="special" class="SpecificInput change_member" id="special">
                                                                            <option>{{__('site.select')}}</option>
                                                                            @foreach(\App\DepartmentMembership::get() as $price)
                                                                                <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->$name2}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <input type="submit"  class="SpecificInput btn btn-primary" name="{{__('site.send')}}" >
                                                                    </div>

                                                                </form>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">{{__('site.close')}}
                                                                </button>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                        </tr>

                                        </tbody>
                                        <!--------- Branches  Edit Modal !---------->
                                        <div class="modal fade" id="exampleModalLabel2{{$item->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="#exampleModalLabel2{{$item->id}}"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel2">تعديل
                                                            البيانات </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card-body"
                                                             style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">


                                                            <div class="form-body">
                                                                <form method="POST"
                                                                      action="{{route('items-Update')}}"
                                                                      enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                           value="{{$item->id}}">
                                                                    @if(app()->getLocale() == 'ar')
                                                                        <style>
                                                                            .form-group {
                                                                                direction: rtl;
                                                                                text-align: right !important;
                                                                            }
                                                                        </style>

                                                                        <div class="form-group">
                                                                            <label style="display:block">
                                                                                النوع <small
                                                                                    class="text-danger">*</small>

                                                                            </label>
                                                                            <select
                                                                                class="SpecificInput catChange select2"
                                                                                name="category_id" style="width:100%;">
                                                                                @foreach($viewcategories as $categories)
                                                                                    <option value="{{$categories->id}}">

                                                                                        {{$categories->ar_name}} <small
                                                                                            class="text-danger">*</small>


                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label style="display:block">
                                                                                البلد <small
                                                                                    class="text-danger">*</small>

                                                                            </label>
                                                                            <select
                                                                                class="SpecificInput countChange select2"
                                                                                name="country_id" style="width:100%;">
                                                                                @foreach($countries as $country)
                                                                                    <option value="{{$country->id}}">
                                                                                        {{$country->ar_name}}
                                                                                    </option>


                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                إسم الاعلان بالعربية <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="ar_name" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->ar_name}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                إسم الاعلان بالانجليزيه <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="en_name" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->en_name}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                الوصف بالعربية <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="ar_desciption" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->ar_desciption}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                الوصف بالانجليزيه <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="en_description" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->en_description}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                الصورة الرئيسية <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <img
                                                                                src="{{asset('uploads/'.$item->main_image)}}"
                                                                                alt=""
                                                                                style="max-width: 100px;width:100px;height:50%">
                                                                            <label for="images">صورة الرئيسيه:</label>
                                                                            <input type="file"
                                                                                   name="main_image"><br><br>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                الصور <small
                                                                                    class="text-danger">*</small>
                                                                            </label></br>
                                                                            @foreach($item->images as $viewimage)
                                                                                <img
                                                                                    src="{{url('/')}}/uploads/{{$viewimage->image}}"
                                                                                    style="max-width: 100px;width:100px;height:50%">
                                                                                @endforeach
                                                                                </br>
                                                                                <label for="images">Select
                                                                                    Images:</label>
                                                                                <input type="file" id="images"
                                                                                       name="images[]" multiple><br><br>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                السعر <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="price" class="SpecificInput"
                                                                                   value="{{$item->price}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                نسبة الخصم % <small class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="discount" class="SpecificInput"
                                                                                   value="{{$item->discount}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                قيمة الخصم<small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="dicount_percent"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->dicount_percent}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                تاريخ بداية الخصم<small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="date" required="required"
                                                                                   name="start_date"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->start_date}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                تاريخ نهاية الخصم <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="date" required="required"
                                                                                   name="end_date" class="SpecificInput"
                                                                                   value="{{$item->end_date}}">
                                                                        </div>

                                                                    @else
                                                                        <style>
                                                                            .form-group {
                                                                                direction: ltr;
                                                                                text-align: left !important;
                                                                            }
                                                                        </style>



                                                                        <div class="form-group">
                                                                            <label style="display:block">

                                                                                Categories <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <select
                                                                                class="SpecificInput catChange select2"
                                                                                name="category_id" style="width:100%;">
                                                                                @foreach($viewcategories as $categories)
                                                                                    <option value="{{$categories->id}}">


                                                                                        {{$categories->en_name}} <small
                                                                                            class="text-danger">*</small>

                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label style="display:block">

                                                                                Countries <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <select
                                                                                class="SpecificInput countChange select2"
                                                                                name="country_id" style="width:100%;">
                                                                                @foreach($countries as $country)
                                                                                    <option value="{{$country->id}}">
                                                                                        {{$country->en_name}}
                                                                                    </option>

                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                department name in arabic <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="ar_name" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->ar_name}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                department name in english <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="en_name" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->en_name}}">
                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label>
                                                                                description in arabic <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="ar_desciption" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->ar_desciption}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                description in english <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="text" required="required"
                                                                                   name="en_description" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->en_description}}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>
                                                                                Images <small
                                                                                    class="text-danger">*</small>
                                                                            </label></br>
                                                                            @foreach($item->images as $viewimage)
                                                                                <img
                                                                                    src="{{url('/')}}/uploads/{{$viewimage->image}}"
                                                                                    style="max-width: 100%;width:50%;height:50%">
                                                                            @endforeach

                                                                            <label for="images">Select Images:</label>
                                                                            <input type="file" id="images"
                                                                                   name="images[]" multiple><br><br>
                                                                        </div>




                                                                        <div class="form-group">
                                                                            <label>
                                                                                price <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="price" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->price}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                discount percentage % <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="discount" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->discount}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                discount value <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="tel" required="required"
                                                                                   name="dicount_percent"
                                                                                   maxlength="191" class="SpecificInput"
                                                                                   value="{{$item->dicount_percent}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                discount start date<small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="date" required="required"
                                                                                   name="start_date" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->start_date}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                discount in date <small
                                                                                    class="text-danger">*</small>
                                                                            </label>
                                                                            <input type="date" required="required"
                                                                                   name="end_date" maxlength="191"
                                                                                   class="SpecificInput"
                                                                                   value="{{$item->end_date}}">
                                                                        </div>

                                                                    @endif
                                                                    <div class="modal-footer">

                                                                        @if(app()->getLocale() == 'ar')
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">اغلاق
                                                                            </button>
                                                                            <input type="submit" name="submit"
                                                                                   class="btn btn-primary"
                                                                                   value="تعديل">
                                                                        @else
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close
                                                                            </button>
                                                                            <input type="submit" name="submit"
                                                                                   class="btn btn-primary"
                                                                                   value="update">
                                                                        @endif
                                                                    </div>
                                                                </form>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </table>

                                <!--Branches create Modal -->

                                <div class="modal fade" id="exampleModal" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">إضافه قسم </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body"
                                                     style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">

                                                    <div class="form-body">
                                                        <form method="POST" action="{{route('items-Store')}}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            @if(app()->getLocale() == 'ar')
                                                                <style>
                                                                    .form-group {
                                                                        direction: rtl;
                                                                        text-align: right !important;
                                                                    }
                                                                </style>

                                                                <div class="form-group">
                                                                    <label style="display:block">
                                                                        النوع <small class="text-danger">*</small>

                                                                    </label>
                                                                    <select class="SpecificInput catChange select2"
                                                                            name="category_id" style="width:100%;">
                                                                        @foreach($viewcategories as $categories)
                                                                            <option value="{{$categories->id}}">

                                                                                {{$categories->ar_name}} <small
                                                                                    class="text-danger">*</small>


                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label style="display:block">
                                                                        البلد <small class="text-danger">*</small>

                                                                    </label>
                                                                    <select class="SpecificInput countChange select2"
                                                                            name="country_id" style="width:100%;">
                                                                        @foreach($countries as $country)
                                                                            <option value="{{$country->id}}" @if(old('country_id') != null){{ old('country_id') }}selected
                                                                             @endif @if (auth()->user()->country_id==$country->id)selected
                                                                                @endif>
                                                                                {{$country->$name}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>
                                                                        إسم الاعلان بالعربية <small class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="ar_name" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>
                                                                        إسم الاعلان بالانجليزيه <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="en_name" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>
                                                                        الوصف بالعربية <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <textarea required="required" name="ar_desciption"
                                                                              style="min-height: 100px"
                                                                              class="SpecificInput"></textarea>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>
                                                                        الوصف بالانجليزيه <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <textarea required="required" name="en_description"
                                                                              style="min-height: 100px"
                                                                              class="SpecificInput"></textarea>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        الصورة الرئيسية <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="file" name="main_image"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        السعر <small class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text"
                                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                                           required="required" name="price"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        نسبة الخصم % <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text"
                                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                                           required="required" name="discount" value="0"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        قيمة الخصم<small class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text"
                                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                                           required="required" name="dicount_percent"
                                                                           value="0" class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        تاريخ بداية الخصم<small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="date" required="required"
                                                                           name="start_date" class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        تاريخ نهاية الخصم <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="date" required="required"
                                                                           name="end_date" class="SpecificInput">
                                                                </div>

                                                            @else
                                                                <style>
                                                                    .form-group {
                                                                        direction: ltr;
                                                                        text-align: left !important;
                                                                    }
                                                                </style>
                                                                <div class="form-group">
                                                                    <label style="display:block">

                                                                        Categories <small class="text-danger">*</small>
                                                                    </label>
                                                                    <select class="SpecificInput catChange select2"
                                                                            name="category_id" style="width:100%;">
                                                                        @foreach($viewcategories as $categories)
                                                                            <option value="{{$categories->id}}">


                                                                                {{$categories->en_name}} <small
                                                                                    class="text-danger">*</small>

                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label style="display:block">

                                                                        Countries <small class="text-danger">*</small>
                                                                    </label>
                                                                    <select class="SpecificInput countChange select2"
                                                                            name="country_id" style="width:100%;">
                                                                        @foreach($countries as $country)
                                                                            <option value="{{$country->id}}">
                                                                                {{$country->en_name}}
                                                                            </option>

                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        department name in arabic <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="ar_name" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        department name in english <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="en_name" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        description in arabic <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="ar_desciption" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        description in english <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text" required="required"
                                                                           name="en_description" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        price <small class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="text"
                                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                                           required="required" name="price"
                                                                           maxlength="191" class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        discount percentage % <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="tel" required="required"
                                                                           name="discount" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        discount value <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="tel" required="required"
                                                                           name="dicount_percent" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        discount start date<small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="date" required="required"
                                                                           name="start_date" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        discount in date <small
                                                                            class="text-danger">*</small>
                                                                    </label>
                                                                    <input type="date" required="required"
                                                                           name="end_date" maxlength="191"
                                                                           class="SpecificInput">
                                                                </div>

                                                            @endif
{{--                                                            <div class="form-group">--}}
{{--                                                                <label>{{__('site.number_days')}}</label>--}}
{{--                                                                <input type="number" step="1" min="1" value="1" class="SpecificInput" name="number_days" id="number_days" required>--}}
{{--                                                            </div>--}}
                                                            <div class="form-group">
                                                                <label>{{__('site.ads_type')}}
                                                                    <span class="text-danger" id="show_price"></span>
                                                                </label>
                                                                <select name="special" class="SpecificInput change_member" id="special">
                                                                    <option>{{__('site.select')}}</option>
                                                                    @foreach(\App\DepartmentMembership::get() as $price)
                                                                        <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->$name2}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <label for="images">Select Images:</label>
                                                                <input type="file" id="images" name="images[]" multiple><br><br>
                                                            </div>

                                                            <div>
                                                                @if(app()->getLocale() == 'ar')
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">اغلاق
                                                                    </button>
                                                                    <input type="submit" name="submit"
                                                                           class="btn btn-primary"
                                                                           value="حفظ">
                                                                @else
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <input type="submit" name="submit"
                                                                           class="btn btn-primary"
                                                                           value="Save">
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!--////create end-->
                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>

    </div>







    </div>










    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        $(document).ready(function () {

            $('.change_member , #number_days').change(function () {
                var price=$('.change_member').children(':selected').data('url');
                var days=$('#number_days').val();
                if (days <1) {
                    alert('من فضلك ادخل عدد ايام صحيح');
                    return false;
                }
                total=days*price;
           //     $('#show_price').text("سيتم خصم مبلغ  " + total +"$ من رصيدك ");
                $('#cash').val(price);
            });

        });
    </script>
    {{--<script > tinymce.init({selector: 'textarea'});</script>--}}


@endsection
