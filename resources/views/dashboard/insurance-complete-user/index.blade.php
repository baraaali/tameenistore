@extends('dashboard.layout.app')
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

{{--    <marquee style="font-family:Book Antiqua; color: #FFFFFF" scrollamount="5" loop="100" onmouseover="this.stop();" onmouseleave="this.start();" direction="right" height="100%">--}}
{{--            <h5 class="text-danger mt-2 mark-font">--}}
{{--                @if(isset($renew_date))--}}
{{--                    @if($renew_date->end_date>$today)--}}
{{--                     {{__('site.will_ended')}} {{$renew_date->end_date}}--}}
{{--                    @else {{__('site.ended')}} : {{$renew_date->end_date}}--}}
{{--                        @endif--}}
{{--                @endif--}}
{{--            </h5>--}}
{{--    </marquee>--}}
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    
                                <div>
                                    <h5 style="position: relative; display: inline-block;top: 6px;">
                                        @if(app()->getLocale() == 'ar')
                                            وثائق التأمين الشامل
                                        @else
                                            Complete Inusrance Documents
                                        @endif
                                    </h5>
                                </div>
                                <div>
                                    <a href="{{route('inDocument-Create-complete',app()->getLocale())}}"
                                        class="btn btn-light circle">
                                         <i class="fas fa-plus-circle"></i>
                                     </a>
     
     
                                     <a href="{{route('insurancerequestscomplete')}}"
                                        class="btn btn-light circle">
                                         <i class="fas fa-cart-plus"></i>
                                     </a>
                                </div>
                                </div>
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
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                 @include('dashboard.insurance-complete-user.table')
                               

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

