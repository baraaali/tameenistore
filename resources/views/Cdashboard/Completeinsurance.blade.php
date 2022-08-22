@extends('layouts.app')
@section('content')
    <?php
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
$renew_date=\App\SubscriptionUser::where('user_id',auth()->user()->id)->where('type','0')
    ->orderBy('id','desc')->first();
    $today=date('Y-m-d');
    //dd($renew_date);
    ?>
    <style>
        .form-body, .form-body2 {
            display: none;
        }


        .modelTablecom thead td:nth-child(2),
        .modelTablecom tbody tr td:nth-child(2) {
            background: #e5f1ff;
            opacity: 1;
            position: absolute;
        }
    </style>

    <marquee style="font-family:Book Antiqua; color: #FFFFFF" scrollamount="5" loop="100" onmouseover="this.stop();" onmouseleave="this.start();" direction="right" height="100%">
            <h5 class="text-danger mt-2 mark-font">
                @if(isset($renew_date))
                    @if($renew_date->end_date>$today)
                     {{__('site.will_ended')}} {{$renew_date->end_date}}
                    @else {{__('site.ended')}} : {{$renew_date->end_date}}
                        @endif
                @endif
            </h5>
    </marquee>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    @if(app()->getLocale() == 'ar')
                        <a class="nav-link" id="v-pills-home-tab" href="{{url('/')}}/cp/index/{{app()->getLocale()}}"
                           aria-controls="v-pills-home" aria-selected="false">معلومات رئيسية</a>
                        @if(auth()->user()->type !=4)
                            <a class="nav-link" id="v-pills-profile-tab"
                               href="{{url('/')}}/cp/ads/{{app()->getLocale()}}" aria-controls="v-pills-profile"
                               aria-selected="true">إعلانات</a>

                        <a class="nav-link " id="v-pills-accessories-tab"
                           href="{{url('/')}}/Cdashboard/accessories/{{app()->getLocale()}}"
                           aria-controls="v-pills-accessories" aria-selected="true">أقسام</a>
                        @endif

                        <a class="nav-link" id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">تأمين ضد الغير</a>
                        <a class="nav-link active " id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/complete/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">تأمين شامل </a>

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
                        <a class="nav-link " id="v-pills-accessories-tab"
                           href="{{url('/')}}/Cdashboard/accessories/{{app()->getLocale()}}"
                           aria-controls="v-pills-accessories" aria-selected="true"> Departments </a>

                        <a class="nav-link" id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Againt Other's Insurance</a>
                        <a class="nav-link active " id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/complete/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Complete Insurance </a>


                        @if(auth()->user()->type >= 1)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="{{url('/')}}/Cdashboard/branches/{{app()->getLocale()}}"
                               aria-controls="v-pills-messages" aria-selected="false">Branches</a>
                        @endif

                    @endif

                </div>
            </div>


            <div class="col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    @if(Session::has('success'))
                        <p class="alert alert-class btn btn-success">{{ Session::get('success') }}</p>
                    @endif
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">

                            <div class="card-header">

                                <h5 style="position: relative; display: inline-block;top: 6px;">
                                    @if(app()->getLocale() == 'ar')
                                        وثائق التأمين الشامل
                                    @else
                                        Complete Inusrance Documents
                                    @endif
                                </h5>
                                <a href="{{route('inDocument-Create-complete',app()->getLocale())}}"
                                   class="btn btn-light circle">
                                    <i class="fas fa-plus-circle"></i>
                                </a>


                                <a href="{{url('/')}}/insurance/requests/{{app()->getLocale()}}"
                                   class="btn btn-light circle">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        جميع الوثائق
                                    @else
                                        All Documents
                                    @endif
                                </label>

                                <br>

                                <!--why here and there in controller ?/////////////////////////////////////////////-->
                                <?php $countries = \App\country::where(['parent' => 0, 'status' => 1])->get();

                                //$complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
                                $lang = app()->getLocale();
                                $name = $lang == 'ar' ? 'name_ar' : 'name_en';
                                $messages = collect(\App\CompleteDoc::where('user_id', auth()->user()->id)->get());

                                $complete_insurance = $messages->unique('Insurance_Company_ar');

                                $complete_insurance->values()->all();

                                ?>
                                {{--                        {{dd($messagesUnique)}}--}}

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
                                            نوع الوثيقة
                                        </td>
                                        <td>
                                            النوع
                                        </td>
                                        <td>
                                            البراند
                                        </td>
                                        <td>
                                            الموديل
                                        </td>
                                        <td>
                                            الشركة
                                        </td>
                                        <td>
                                            العمليات
                                        </td>

                                    @else
                                        <td>
                                            Document's Type
                                        </td>
                                        <td>
                                            Type of Use
                                        </td>
                                        <td>
                                            Brand
                                        </td>
                                        <td>
                                            Model
                                        </td>

                                        <td>
                                            Company
                                        </td>

                                        <td>
                                            Operations
                                        </td>
                                    @endif

                                    </thead>
                                    <script
                                        src="https://www.paypal.com/sdk/js?client-id=AaV4L6oUQxO5xMj1IeFof4u-4R2ulRcG6MSeLOLVyIKfanSrbfl9eJYtdEH9gWHBiHOLpR14EBMJcfPr"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
                                    </script>
                                    @foreach($complete_insurance  as $document)
                                        <tbody>
                                        <tr>

                                            <td>
                                                @if(app()->getLocale() == 'ar')
                                                    {{$document->type == '0' ? 'ضد الغير' : 'تامين شامل'}}
                                                @else
                                                    {{$document->type == '0' ? 'Against Foriegn' : 'Full Inurance'}}
                                                @endif
                                            </td>
                                            <td>
                                                {{\App\Style::where('id',$document->type_of_use)->first()->$name}}
                                            </td>

                                            <td>
                                                {{$document->idbrand ? $document->idbrand->name  : ''}}
                                            </td>
                                            <td>
                                                {{$document->idmodel ? $document->idmodel->name : ''}}
                                            </td>
                                            <td>
                                                @if(app()->getLocale() == 'ar')
                                                    {{$document->Insurance_Company_ar}}
                                                @else
                                                    {{$document->Insurance_Company_en}}
                                                @endif

                                            </td>


                                            <td>
                                                <!--//////////////////////check///////////////////////////////-->
                                                <!-- 'ضد الغير' ||' Against Forieg)-->
                                                @if($document->type == '0')
                                                    <a href="{{route('cmDocument-edit',$document->id ,app()->getLocale())}}"
                                                       class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-success btn-xs" data-toggle="modal"
                                                       data-target="#exampleModal{{$document->id}}">
                                                        <i class="fas fa-sync"></i>
                                                    </a>

                                                @else
                                                    <a href="{{route('cmDocument-edit',$document->id ,app()->getLocale())}}"
                                                       class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   <a href="{{route('inDocument-Create-complete',app()->getLocale())}}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-sync"></i> تجديد
                                                </a>
                                                    <a onclick="return confirm('Are you sure?')"
                                                       href="{{route('delete_com_doc',$document->id)}}"
                                                       class="btn btn-danger">
                                                        <i class="fa fa-trash text-white"></i>
                                                    </a>
                                                    <a href="{{route('get_all_brands',$document->Insurance_Company_ar)}}"
                                                       class="btn btn-warning btn-xs">
                                                        <i class="fa fa-anchor"></i></a>
                                                @if($document->display==1)
                                                    <a href="{{route('add_Brand',$document->id)}}"
                                                       class="btn btn-secondary btn-xs">
                                                        <i class="fa fa-plus"></i></a>
                                                @endif
                                                @endif

                                            </td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <!--------- Branches  Edit Modal !---------->


                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!--</div>-->

    <script>
        $(document).ready(function () {
            $('.brandChangeedit').change(function () {
                $.ajax({
                    url: "{{url('/')}}/view/childerns/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    $('.modelChangeedit').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.modelChangeedit').append('<option value="' + item.id + '">' + item.name + '</optin>')
                    });

                });
            });
        });
    </script>



    <script>
        $('.type').change(function () {
            if ($(this).val() == '0') {
                $('.form-body').slideDown();
            } else {
                $('.form-body').slideUp();
            }
        });
        $('.type').change(function () {
            if ($(this).val() == '1') {
                $('.form-body2').slideDown();
            } else {
                $('.form-body2').slideUp();
            }
        });
    </script>
    <!--//////////////////////sondos////////////////////-->
    <script>
        var var1 = 0;
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '{{url("/all/brands/models")}}',
            success: function (rData) {

                $(".btn-new").on('click', function () {
                    var1++;
                    $("#cmbrandtable").append('<tr ><td>' + '<select id="mySelect' + var1 + '" class="SpecificInput brandChangecom select2" name="brand_id[]" style="width:150px;"></select></td><td><select id="modelChangetwo' + var1 + '" class="SpecificInput modelChangetwo select2" name="model_id[]" style="width:150px;"></select></td></tr><tr><td><input type="number" name="year[]" from="1980" to="2025" placeholder="e.g 2008"></td><td><input type="number" name="inmethodfrom[]"></td><td><input type="number" name="inmethodto[]"></td><td><input type="number" name="percentage[]"></td><td><input type="number" name="fileprice[]"></td><td><input type="number" name="minimum[]"></td></tr>');

                    $.each(rData, function (i, brand) {
                        //  .attr("brand", i)
                        $('#mySelect' + var1).append($('<option></option>').val(brand.id).text(brand.name));

                    });
                    $('#mySelect' + var1).change(function () {

                        var id = $(this).attr('id');
                        var idsliced = id.slice(8);
                        $.ajax({
                            url: "{{url('/')}}/view/childerns/" + $(this).val(),
                            context: document.body
                        }).done(function (data) {
                            $('#modelChangetwo' + idsliced).find('option').remove().end();
                            $.each(data, function (i, item) {
                                $('#modelChangetwo' + idsliced).append('<option value="' + item.id + '">' + item.name + '</option>')
                            });
                        });

                    });
                    $('.select2').select2();
                });
            }
        });


    </script>
    <script>
        var var2 = 0;
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '{{url("/all/brands/models")}}',
            success: function (rData) {

                $(".inbtn-new").on('click', function () {
                    var2++;

                    $("#inbrandtable tbody").append('<tr><td>' + '<select id="inmySelect' + var2 + '" class="SpecificInput brandChangein select2" name="brand_id[]" style="width:150px;"></select></td><td><select id="modelChangein' + var2 + '" class="SpecificInput modelChangein select2" name="model_id[]" style="width:150px;"></select></td><td><select  name="type_of_use[]" >' +
                        @if(app()->getLocale() == 'ar')  '<option value="private" >خاص</option><option value="rent"> أجرة</option>'
                    @else  '<option value="private">private</option><option value="rent">rent</option>' @endif


                    + '</select></td><td><input type="number" name="price[]"></td><td><input type="number" name="firstinterval[]"></td><td><input type="number" name="secondinterval[]"></td><td><input type="number" name="thirdinterval[]"></td></tr>'
                )
                    ;

                    $.each(rData, function (i, brand) {
                        //  .attr("brand", i)
                        $('#inmySelect' + var2).append($('<option></option>').val(brand.id).text(brand.name));

                    });
                    $('#inmySelect' + var2).change(function () {

                        var id1 = $(this).attr('id');
                        var idsliced1 = id1.slice(10);
                        $.ajax({
                            url: "{{url('/')}}/view/childerns/" + $(this).val(),
                            context: document.body
                        }).done(function (data) {
                            $('#modelChangein' + idsliced1).find('option').remove().end();
                            $.each(data, function (i, item) {
                                $('#modelChangein' + idsliced1).append('<option value="' + item.id + '">' + item.name + '</option>')
                            });
                        });

                    });

                    $('.select2').select2();
                });
            }
        });


    </script>
    <!--////////////////////////////////////-->

    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"/></script>
    <script > tinymce.init({selector: 'textarea'});</script>


@endsection

