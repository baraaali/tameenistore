@extends('layouts.app')

@section('content')
    <style>
        .no_back {
            background-color: #f3f3f3;
            border: 0px;
            width: 124px;
        }
    </style>

    <?php

    use Carbon\Carbon;

    $nespetEltahmol = 0;
    $differofyears = 0;
    $flag = false;
    $mini = -1;
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    ?>
    <style>
        .select2 {
            margin-top: 10px;
            width: 100% !important;
        }
    </style>

    <style>
        .borderless {
            border: none !important;
            border-color: transparent !important;
        }

        .complete_insuranc .form-group {
            border: solid 1px;
        }

        #price {
            display: none;
        }

        .complete_insuranc .form-group {
            border: #b8b7b7 solid 1px;
            padding: 15px;
            color: #868383;
            font-weight: 600;
        }
    </style>


    <div class="col-lg-12 cover-adv"
         style="background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
        @if(app()->getLocale() == 'ar')

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    مكاتب التأمين / وسطاء التأمين
                </h2><br>
                <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>
        @else

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    Insurance broker agent
                </h2>
                <br>
                <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>
        @endif
    </div>
    <div class="col-lg-12" style="padding:20px;">
        <div class="container">
            @foreach($complete_insurance as $complete_insuranc)
            <form method="POST" action="{{route('ComFilter',$lang)}}">
                @csrf
                <div class="form-row">

                    <div class=" form-group col-md-2">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block;">
                                نوع التأمين<small class="text-danger">*</small>
                                @else
                                    Insurance Type <small class="text-danger">*</small>
                            </label>
                        @endif
                        <select class="SpecificInput typeChange form-control" name="type" id="type"
                                style="margin-top:10px;">
                            <option value="1" selected>
                                @if(app()->getLocale() == 'ar')
                                    تأمين شامل
                                @else
                                    Complete Insurance
                                @endif
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label style="display:block">
                            @if(app()->getLocale() == 'ar')
                                نوع الاستخدام
                            @else
                                type of use
                            @endif
                        </label>
                        <?php
                        $lang=app()->getLocale();
                        $name=$lang=='ar'?'name_ar':'name_en';
                        $uses=\App\Style::all();
                        ?>
                        <select class="SpecificInput typeofuseChange form-control" name="type_of_use">
                          @foreach($uses as $use)
                            <option value="{{$use->id}}">{{$use->$name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" form-group col-md-2">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block">
                                البراند<small class="text-danger">*</small>
                                @else
                                    Brand <small class="text-danger">*</small>
                            </label>
                        @endif
                        <select class="SpecificInput brandChange form-control" name="brand_id" id="brand"
                                style="margin-top:10px;">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">
                                    {{$brand->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" form-group col-md-2">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block;">
                                موديل<small class="text-danger">*</small>
                                @else
                                    Model <small class="text-danger">*</small>
                            </label>
                        @endif
                        <select class="SpecificInput modelChange form-control" name="model_id" style="margin-top:10px;">
                            @foreach($models as $model)
                                <option value="{{$model->id}}">
                                    {{$model->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block">
                                سنة الصنع<small class="text-danger">*</small>
                                @else
                                    Year <small class="text-danger">*</small>
                            </label>
                        @endif
                        <select name="year" class="SpecificInput yearchange col-md-12 form-control"
                                style="width:100%;margin-top:10px;" id="year">
                            <?php
                            for ($i = -1; $i <= 35; ++$i) {
                                $time = strtotime(sprintf('-%d years', $i));
                                $value = date('Y', $time);
                                $label = date('Y ', $time);
                                printf('<option value="%s" selected="selected">%s</option>', $value, $label);
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block">
                                سعر السياره<small class="text-danger">*</small>
                                @else
                                    car price <small class="text-danger">*</small>
                            </label>
                        @endif
                        <input name="carprice" class="SpecificInput carprice col-md-12 form-control"
                               style="width:100%;margin-top:10px;">

                    </div>


                    <button class="btn btn-primary col-lg-4" type="submit" style="display:block;margin:auto"
                            id="submitbtn">
                        @if(app()->getLocale()== 'ar')
                            عرض
                        @else
                            Show
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        {{--        @if($type==1)--}}

        <div class="form-body form-body2 ">


                {{--                {{dd($complete_insurance)}}--}}
                {{--                    {{dd($complete_insuranc->insurance_id)}}--}}
                {{--                    {{dd(App\Insurance::where('id',$complete_insuranc->insurance_id)->first())}}--}}
                <?php
                $insurance = \App\Insurance::where('id', $complete_insuranc->insurance_id)->first();

                $country = \App\country::where('id', $insurance->country_id)->select('en_currency', 'ar_currency')->get()->toArray();
                $lang = app()->getLocale();
                $currance = $country[0][$lang . '_currency'];
                ?>
                {{--                {{$insurance}}--}}
                {{--                @if($insurance->status==1)--}}
                {{--                        {{dd(\App\country::where('id'))}}--}}
                <div class="container complete_insuranc">
                    <form method="POST" action="{{route('submitCompleteDoc')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="container">
                                    <div class="section-3"
                                         style="padding: 25px !important; margin-top:25px;background-color: #F3F3F3">

                                        <div class="container-fluid">
                                            <h4 style="display: inline-block;font-weight: 600;font-size:20px;">
                                                <input type="hidden" name="req_id" value="{{$complete_insuranc->id}}">
                                                <input type="hidden" name="complete_doc_id[]"
                                                       value="{{$complete_insuranc->id}}">
                                                <input type="hidden" name="price" value="{{$carprice}}">
                                                @if(app()->getLocale() == 'ar')
                                                    {{$complete_insuranc->Insurance_Company_ar}}
                                                @else
                                                    {{$complete_insuranc->Insurance_Company_en}}
                                                @endif
                                            </h4>
{{--                                            <button class="btn btn-light top"--}}
{{--                                                    style="font-size:12px; font-weight: 600;background-color: white">--}}
{{--                                                <i class="fas fa-phone"></i>--}}
{{--                                            @if($complete_insuranc->insurnace)--}}
{{--                                                {{$complete_insuranc->insurnace->phones}}--}}
{{--                                            @endif--}}
{{--                                            <!--//-->--}}
{{--                                            </button>--}}
                                            <hr>
                                            <div class="breakLineForDiv p-r">

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="{{url('/')}}/uploads/{{$complete_insuranc->logo}}"
                                                     style="width:100%;hight:100px;">

                                            </div>
                                            <div class="col-md-10" style="padding:20px;">
                                                @if(app()->getLocale() == 'ar')
                                                    {{$complete_insuranc->ar_term}}
                                                @else
                                                    {{$complete_insuranc->en_term}}
                                                @endif
                                            </div>
                                        </div>
                                        <hr>


                                        <div class="row">
                                            <h3 class="text-center" style="padding-bottom:20px;">
                                                @if(app()->getLocale()== 'ar')
                                                    الشروط</h3>
                                            @else
                                                Conditions
                                            @endif

                                        </div>
                                        @php

                                            $OpenSlide=0;
                                            $OpenFilePerecent=0;


                                            if($carprice >= 0 && $carprice <= $complete_insuranc->firstSlidePrice) {
                                                 $flag = true;
                                                 $OpenSlide = $complete_insuranc->OpenFileFirstSlide;
                                                    $OpenFilePerecent = $complete_insuranc->OpenFilePerecentFirstSlide;
                                            } elseif ($carprice > $complete_insuranc->firstSlidePrice && $carprice <= $complete_insuranc->SecondSlidePrice) {
                                                     $OpenSlide = $complete_insuranc->OpenFileSecondSlide;
                                                    $OpenFilePerecent = $complete_insuranc->OpenFilePerecentSecondSlide;
                                            } elseif ($carprice > $complete_insuranc->SecondSlidePrice && $carprice <= $complete_insuranc->thirdSlidePrice) {
                                                    $OpenSlide = $complete_insuranc->OpenFileThirdSlide;
                                                    $OpenFilePerecent = $complete_insuranc->OpenFilePerecentThirdSlide;
                                            } elseif ($carprice >= $complete_insuranc->OpenFilePerecentFourthSlide) {
                                                $OpenSlide = $complete_insuranc->OpenFileFourthSlide;
                                                    $OpenFilePerecent = $complete_insuranc->OpenFilePerecentFourthSlide;
                                            }



                                        @endphp
                                        <div class="row">

                                            @if($OpenSlide != 0)
                                                <div class="form-group col-2">
                                                    {{__('site.open_file_for_acc')}}
                                                </div>
                                            @endif
                                            <div class="form-group col-2">
{{--                                                {{$OpenSlide == 0 ? 'بدون فتح ملف' : $OpenSlide.' عن كل حادث'}}--}}
                                                {{$OpenSlide == 0 ? __('site.without_file') : $OpenSlide.__('site.every_accident')}}

                                            </div>

                                        </div>


                                        @foreach($complete_insuranc->conditions as $condition)

                                            @if($condition->ConsumptionRatio)

                                                @if(count($condition->condition_items) > 1)

                                                    @php $far2Elsnen = 0; @endphp
                                                    @foreach($condition->condition_items as $item)
                                                        @if($item->AddonMaxYear < 0)
                                                            @php  $far2Elsnen = $item->AddonMaxYear;  @endphp

                                                        @endif
                                                    @endforeach
                                                    @php
                                                        $startYear = (float) Date('Y') - abs ($far2Elsnen);
                                                        $differofyears = (float) Date('Y') - (float) $request_year;
                                                         $differofyears2 = (float) $startYear - (float) $request_year;
                                                         $nespetEltahmol = 0;


                                                    @endphp



                                                    @if($differofyears >= abs ($far2Elsnen))

                                                        @for($i = 0; $i <= $differofyears2; $i++)
                                                            @if($i == 0)
                                                                @php
                                                                    $nespetEltahmol =  $condition->ConsumptionFirstRatio ;
                                                                @endphp
                                                            @else

                                                                @php
                                                                    $nespetEltahmol = $nespetEltahmol +   $condition->YearPerecenteage;
                                                                @endphp
                                                            @endif
                                                        @endfor


                                                        @if($nespetEltahmol >= $condition->ConsumptionYearPerecenteage)
                                                            @php
                                                                print_r($far2Elsnen );
                                                                $nespetEltahmol = $condition->ConsumptionYearPerecenteage;
                                                            @endphp
                                                        @endif

                                                    @endif
                                                @endif
                                            @endif

                                            <div class="row">
                                                @if($condition->ToleranceratioCheck)
                                                    <div class="form-group col-md-3">
                                                        {{__('site.telerance_rate')}}
                                                    </div>

                                                    <div class="form-group col-3">
                                                        <?php



                                                        $ratio = $carprice * ($condition->Tolerance_ratio / 100);



                                                        ?>
                                                        {{$ratio > $condition->ToleranceYearPerecenteage ? $condition->ToleranceYearPerecenteage : $ratio}}
                                                    </div>

                                                    <div class="form-group col-4">

                                                        {{__('site.for_accident_rate')}}
                                                    </div>
                                                    <div class="form-group col-2">
                                                        {{$condition->last_percent}}
                                                    </div>

                                                @endif






                                                @if($nespetEltahmol != 0)
                                                    <div class="form-group col-2">
                                                        {{__('site.Consumption_ratio')}}
                                                    </div>
                                                    <div class="form-group col-4">
                                                       {{$nespetEltahmol}} %  {{__('site.replacement_parts')}}
                                                    </div>
                                                @else
                                                    <div class="form-group col-6">
                                                     {{__('site.without_percentage')}}
                                                    </div>
                                                @endif


                                            </div>


                                            @foreach($condition->condition_items as $condition_item)

                                                @if((float) $condition_item->AddonMaxYear > 0)
                                                    <ul>
                                                        @if((float) $differofyears < (float) $condition_item->AddonMaxYear)
                                                            <li>
                                                                @if(app()->getLocale()== 'ar')
                                                                    {{$condition_item->AddonNameAR}}
                                                                @else
                                                                    {{$condition_item->AddonNameEn}}
                                                                @endif
                                                            </li>
                                                        @endif
                                                        @else

                                                            @if((float) $differofyears >= abs ((float) $condition_item->AddonMaxYear))
                                                                <li>
                                                                    @if(app()->getLocale()== 'ar')
                                                                        {{$condition_item->AddonNameAR}}
                                                                    @else
                                                                        {{$condition_item->AddonNameEn}}
                                                                    @endif
                                                                </li>

                                                            @endif
                                                    </ul>
                                                @endif
                                            @endforeach

                                        @endforeach
                                        <hr>
                                      <div class="row">
                                          <div class=" ">
                                              <h5>{{__('site.date_start')}}</h5>
                                              <input type="date" name="start_date" required class="form-control">
                                              <hr>
                                              <h5>{{__('site.attach_file')}}</h5>
                                              <input type="file" name="file" class="form-control" required>
                                          </div>
                                      </div>

                                        <div class="row">
                                            <h3 style="padding-bottom:20px;padding-top:20px;">
                                                @if(app()->getLocale()== 'ar')
                                                    الاضافات
                                                @else
                                                    Additions
                                                @endif
                                            </h3>

                                        </div>
                                        <ul>


                                            @foreach($complete_insuranc->additions as $addition)

                                                <li>

                                                    <input type="checkbox" class="addons"
                                                           onchange="changeCost('{{$complete_insuranc->id}}')"
                                                           name="addition{{$complete_insuranc->id}}[]"
                                                           value="{{$addition->FeatureCost}}">
                                                    {{--                         <input type="checkbox" class="addons" onchange="changeCost('{{$complete_insuranc->id}}')" name="addition{{$complete_insuranc->id}}[]" value="{{$addition->id}}">--}}
                                                    @if(app()->getLocale()== 'ar')
                                                        {{$addition->FeatureNameAr}}
                                                    @else
                                                        {{$addition->FeatureNameEn}}
                                                    @endif

                                                    <input type="hidden" value="{{$addition->FeatureCost}}"
                                                           id="{{$addition->id}}"/>
                                                    ( <span class="text-danger"
                                                            style="font-size:22px">{{$addition->FeatureCost}}
                                                                <span class="text-primary">{{$currance}}</span>
                                                            </span>
                                                    )


                                                </li>

                                            @endforeach

                                        </ul>

                                        <div class="form-group col-2">
                                            السعر
                                        </div>
                                        <div class="form-group col-2">
                                            <?php

                                            $cost = ($OpenFilePerecent / 100) * $carprice;
                                            //   print_r($complete_insuranc->OpenFileMinimumFirstSlide);

                                            $min = $complete_insuranc->OpenFileMinimumFirstSlide;
                                            //{{dd($cost);}}
                                            if ($flag) {

                                                if ($min != null) {

                                                    if ($cost < $min) {
                                                        echo '<input type="text" class="start_price no_back" readonly value="' . $min . '" class="form-control total" />';
                                                        echo '<input type="hidden" class="original_price" value="' . $min . '"  name="net_price">';
                                                    } else {

                                                        echo '<input type="text" class="start_price no_back" readonly value="' . $cost . '" class="form-control total" />';
                                                        echo '<input type="hidden" class="original_price" value="' . $cost . '" name="net_price" >';
                                                    }
                                                }
                                            } else {
                                                echo '<input type="text" class="start_price no_back"  readonly value="' . $cost . '" class="form-control total"  />';
                                                echo '<input type="hidden" class="original_price" value="' . $cost . '" name="net_price" >';
                                            }
                                            echo '<span class="text-primary font-weight-bolder" ">' . $currance . '</span>';

                                            ?>
                                        </div>


                                        <button class="btn btn-primary col-lg-4" type="submit"
                                                style="display:block;margin:auto" id="submitbtn">
                                            @if(app()->getLocale()== 'ar')
                                                تسجيل
                                            @else
                                                Submit
                                            @endif
                                        </button>
                                    </div>


                                </div>


                            </div>
                        </div>
                </div>
                {{--                @endif--}}
        </div>
        </form>
    </div>
    @endforeach
    </div>

    </div>

    <script>
        $(document).ready(function () {


            $('.brandChange').change(function () {
                $.ajax({
                    url: "{{url('/')}}/view/childerns/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    $('.modelChange').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.modelChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                    });

                });
            });
        });

        function changeCost(id) {
            var amountToAdd = $('.original_price').val();
            $(':checkbox').each(function () {
                if ($(this).is(":checked")) {
                    amountToAdd = parseFloat(amountToAdd) + parseFloat($(this).attr('value'));
                }
            });
            $('.start_price').attr('value', amountToAdd);
            //alert(amountToAdd);
        }


    </script>


    <script>
        function insurance_durtaion(now_year, request_year, insurance) {
            first_interval = insurance['firstinterval'];
            second_interval = insurance['secondinterval'];
            third_interval = insurance['thirdinterval'];

            difference = parseInt(now_year) - parseInt(request_year);

            console.log(insurance['secondinterval']);

            if (parseInt(insurance['firstinterval']) > difference) {
                $('#induration_' + insurance['id']).find('option').remove();
                $('#induration_' + insurance['id']).append(new Option('', ''));
                console.log('first');
                for (i = parseInt(insurance['firstinterval']); i > 0; i--) {
                    $('#induration_' + insurance['id']).append(new Option(i, i));
                }
            } else if ((parseInt(insurance['secondinterval']) + parseInt(insurance['firstinterval'])) > difference) {
                $('#induration_' + insurance['id']).find('option').remove();
                $('#induration_' + insurance['id']).append(new Option('', ''));
                console.log('second');
                for (i = parseInt(insurance['secondinterval']); i > 0; i--) {
                    $('#induration_' + insurance['id']).append(new Option(i, i));
                }
            } else if ((parseInt(insurance['thirdinterval']) + parseInt(insurance['secondinterval']) + parseInt(insurance['firstinterval'])) > difference) {
                $('#induration_' + insurance['id']).find('option').remove();
                $('#induration_' + insurance['id']).append(new Option('', ''));
                console.log('third');
                for (i = parseInt(insurance['thirdinterval']); i > 0; i--) {
                    $('#induration_' + insurance['id']).append(new Option(i, i));
                }
            } else {
                $('#induration_' + insurance['id']).find('option').remove();
                $('#induration_' + insurance['id']).append(new Option('', ''));
                console.log('third');
                for (i = parseInt(insurance['thirdinterval']); i > 0; i--) {
                    $('#induration_' + insurance['id']).append(new Option(i, i));
                }
            }
        }

        function insurance_cost(id, price) {
            selected = $('#' + id).val();
            cost_id = id.split('_');
            $('#price_' + cost_id[1]).val(parseInt(price) * parseInt(selected));
        }

        // Price Of Complete Insurnace Script
        $('#type').change(function () {
            if ($(this).val() == 1) {
                $('#price').slideDown();
            } else {
                $('#price').slideUp();
            }
        });

    </script>

@endsection
