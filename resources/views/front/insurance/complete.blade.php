@extends('layouts.app')
@section('content')


    <style>
        .form-body  p,.form-body  li{
            font-size: 18px 
        }
        .form-body  li{
            line-height: 35px;
        }
        .mark-font{
            font-size: 20px;
            font-style: oblique;
        }
        .width-110{
            width: 110px;
            font-size: 18px;
            text-align: center;
        }
        .no_back {
            background-color: #f3f3f3;
            border: 0px;
            width: 124px;
        }
        .cover-search{
            background-color: #fff;
            border: 1px solid #d5d5d5;
            margin-top: 40px;
            padding: 20px;
            border-radius: 15px;
        }
        .select2 {
            margin-top: 10px;
            width: 100% !important;
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
    $comp='Insurance_Company_'.$lang;
    $messages = \App\CompleteDoc::where('precent','>',0);
    if (getCountry()>0)  $messages=$messages->where('country_id',getCountry());
    $messages=collect($messages->get());
    $marks = $messages->unique('Insurance_Company_ar');

    $marks->values()->all();
    ?>

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

        @media only screen and (min-width: 1025px) {
            .vertical {
                border-left: 1px solid green;
            }
        }
    </style>


<div class="container">
    <section>
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('site.home')}}</a></li>
            <li class="breadcrumb-item"></li>
            <li class="breadcrumb-item active">{{__('site.full insurance')}}</li>
        </ol>

    </section>
    <!-- start  banner-->
<div style="direction: ltr" class="owl-carousel banners owl-theme">
  @foreach ($banners as $banner)
  <div class="item"><img src="{{asset('uploads/'.$banner->file)}}"></div>
  @endforeach
</div>         
<!-- end banner -->
</div>
    <div class="col-lg-12" style="padding:20px;">
        <div class="container-fluid">

            <form method="get" action="{{route('ComFilter',$lang)}}">
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
                        $lang = app()->getLocale();
                        $name = $lang == 'ar' ? 'name_ar' : 'name_en';
                        $uses = \App\Style::all();
                        ?>
                        <select class="SpecificInput typeofuseChange form-control" name="type_of_use">
                            @foreach($uses as $use)
                                <option
                                    value="{{$use->id}}"@if($_POST)@if($_POST['type_of_use'] == $use->id) {{ 'selected' }} @endif @endif>{{$use->$name}}</option>
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
                            <option value="0">{{__('site.select')}}</option>
                            @foreach($brands as $brand)
                                <option
                                    value="{{$brand->id}}" @if($_POST)@if($_POST['brand_id'] == $brand->id) {{ 'selected' }} @endif @endif>
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
                            @if($_POST)
                                @foreach($models as $model)
                                    <option
                                        value="{{$model->id}}" @if($_POST['model_id'] == $model->id) {{ 'selected' }} @endif>
                                        {{$model->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        @if(app()->getLocale() == 'ar')
                            <label style="display:block">
                                سنة الصنع<small class="text-danger">*</small>
                                @else
                                    Year <small class="text-danger">*</small>
                            </label>
                        @endif
                        <select name="year"
                        value="@if(session()->has('year')){{session()->get('year')}}@endif"
                         class="SpecificInput yearchange col-md-12 form-control"
                                style="width:100%;margin-top:10px;" id="year">
                                <?php
                                for ($i = -1; $i <= 35; ++$i) {
                                    $time = strtotime(sprintf('-%d years', $i));
                                    $value = date('Y', $time);
                                    $label = date('Y ', $time);
                                    $selected = session()->get('year') == $value ? 'selected' : '';
                                    printf('<option value="%s" %s >%s</option>', $value,$selected, $label);
                                }
                                ?>

                         
                        </select>

                    </div>
                    <div class="form-group col-md-2">
                        <label style="display:block">{{__('site.price')}}</label>

                        <input type="number" name="carprice" class="SpecificInput carprice col-md-12 form-control"
                               style="width:100%;margin-top:10px;" value="@if(session()->has('carprice')){{session()->get('carprice')}}@endif">

                    </div>
                    <div class="form-group col-md-1">
                        <label style="display:block">{{__('site.sort')}}</label>
                        <select class="SpecificInput typeofuseChange form-control" name="sort">
                            <option
                                value="asc"@if($_POST)@if($_POST['sort'] == 'asc') {{ 'selected' }} @endif @endif>{{__('site.asc')}}</option>
                            <option
                                value="desc"@if($_POST)@if($_POST['sort'] == 'desc') {{ 'selected' }} @endif @endif>{{__('site.desc')}}</option>
                        </select>
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
    <div class="col-lg-12 ">
        @if(count($complete_insurance)>0)
            @foreach($complete_insurance as $complete_insuranc)
                <div class="form-body form-body2 ">
                    <?php
                    $insurance = \App\Insurance::where('id', $complete_insuranc->insurance_id)->first();
                    $country = \App\country::where('id', $insurance->country_id)->select('en_currency', 'ar_currency')->get()->toArray();
                    $lang = app()->getLocale();
                    $currance = $country[0][$lang . '_currency'];
                    $row = \App\CompleteDoc::where('Insurance_Company_ar', $complete_insuranc->Insurance_Company_ar)
                        ->where('insurance_id', $complete_insuranc->insurance_id)->first();
                    $conRow = \App\Condition::where('insurance_document_id', $row->id)->get();
                    $rows = [];
                    if(isset($conRow[0]))
                    $rows = \App\ConditionItem::where('condition_id', $conRow[0]->id)->get();
                    $adds = \App\Addition::where('insurance_document_id', $row->id)->get();
                    ?>

                    <div class="container-fluid complete_insuranc cover-search">
                        <form method="POST" action="{{route('submitCompleteDoc')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-2 vertical">
                                                <span class="text-danger">{{__('site.company_name')}}</span>
                                                <p style="display: inline-block;font-weight: 600;font-size:20px;color: #0940c5">
                                                    <input type="hidden" name="req_id" value="{{$complete_insuranc->id}}">
                                                    <input type="hidden" name="complete_doc_id[]" value="{{$complete_insuranc->id}}">
                                                    <input type="hidden" name="price" value="{{$carprice}}">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{$complete_insuranc->Insurance_Company_ar}}
                                                    @else
                                                        {{$complete_insuranc->Insurance_Company_en}}
                                                    @endif
                                                </p>
                                                <span class="text-left">
                                                  @if($complete_insuranc->precent>0)
                                                        <span class="notify-badge mt-4">{{$complete_insuranc->precent}}%</span>
                                                    @endif
                                                <a data-fancybox="logo"
                                                   href="{{url('/')}}/uploads/{{$complete_insuranc->logo}}">
                                                    <img src="{{url('/')}}/uploads/{{$complete_insuranc->logo}}"
                                                         class="text-left img-thumbnail"
                                                         style="height: 100px;width: 200px">
                                                </a>
                                            </span>
                                            </div> <!-- end col-sm-2 -->
                                           <?php

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



                                            ?>
                                            <div class="col-sm-4 vertical direction">
                                                <p class="text-danger">{{__('site.condition')}}</p>
                                                <div class="col-sm-12">
                                                    <p >@if($OpenSlide != 0) - {{__('site.open_file_for_acc')}}@endif :
                                                        <span class="text-primary"> {{$OpenSlide == 0 ? __('site.without_file') : $OpenSlide.__('site.every_accident')}}</span>
                                                    </p>
                                                </div>
                                                @foreach($conRow as $condition)
                                                    @if($condition->ConsumptionRatio)
                                                        @if(count($rows) > 1)
                                                            <?php $far2Elsnen = 0; ?>
                                                            {{--                                                    @foreach($condition->condition_items as $item)--}}
                                                            @foreach($rows as $item)
                                                                @if($item->AddonMaxYear < 0)
                                                                    @php  $far2Elsnen = $item->AddonMaxYear;  @endphp
                                                                @endif

                                                            @endforeach
                                                            <?php
                                                                $startYear = (float) Date('Y') - abs ($far2Elsnen);
                                                                $differofyears = (float) Date('Y') - (float) $request_year;
                                                                 $differofyears2 = (float) $startYear - (float) $request_year;
                                                                 $nespetEltahmol = 0;

                                                          ?>
                                                            @if($differofyears >= abs ($far2Elsnen))

                                                                @for($i = 0; $i <= $differofyears2; $i++)
                                                                    @if($i == 0)
                                                                        <?php
                                                                            $nespetEltahmol =  $condition->ConsumptionFirstRatio ;
                                                                      ?>
                                                                    @else

                                                                        <?php
                                                                            $nespetEltahmol = $nespetEltahmol +   $condition->YearPerecenteage;
                                                                       ?>
                                                                    @endif
                                                                @endfor


                                                                @if($nespetEltahmol >= $condition->ConsumptionYearPerecenteage)
                                                                    <?php
                                                                        print_r($far2Elsnen );
                                                                        $nespetEltahmol = $condition->ConsumptionYearPerecenteage;
                                                                    ?>
                                                                @endif

                                                            @endif
                                                        @endif
                                                    @endif

                                                    <div class="row">
                                                        @if($condition->ToleranceratioCheck)
                                                            <?php
                                                            $ratio = $carprice * ($condition->Tolerance_ratio / 100);
                                                            ?>
                                                            <div class="col-sm-12">
                                                                <p style="font-weight: bold;font-size:20px"> - {{__('site.for_accident_rate')}} :
                                                                    <span
                                                                        class="text-primary"> {{$ratio > $condition->ToleranceYearPerecenteage ? $condition->ToleranceYearPerecenteage : $ratio}}  @if(app()->getLocale() == 'ar')
                                                                            {{$condition->last_percent}}
                                                                        @else
                                                                            {{$condition->last_percent_en}}
                                                                        @endif
                                                         </span>
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if($nespetEltahmol != 0)
                                                            <div class="col-sm-12">
                                                                <p>- {{__('site.Consumption_ratio')}} :
                                                                    <span class="text-primary">
                                                            {{$nespetEltahmol}} %  {{__('site.replacement_parts')}}
                                                        </span>
                                                                </p>
                                                            </div>
                                                        @else
                                                            <div class="col-sm-12">
                                                                <p>- {{__('site.without_percentage')}}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @foreach($condition->condition_items as $condition_item)

                                                        @if((float) $condition_item->AddonMaxYear > 0)
                                                            @if((float) $differofyears < (float) $condition_item->AddonMaxYear)
                                                                <p>-
                                                                    @if(app()->getLocale()== 'ar')
                                                                        {{$condition_item->AddonNameAR}}
                                                                    @else
                                                                        {{$condition_item->AddonNameEn}}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                        @else
                                                            @if((float) $differofyears >= abs ((float) $condition_item->AddonMaxYear))
                                                                <p> -
                                                                    @if(app()->getLocale()== 'ar')
                                                                        {{$condition_item->AddonNameAR}}
                                                                    @else
                                                                        {{$condition_item->AddonNameEn}}
                                                                    @endif
                                                                </p>
                                                            @endif

                                                        @endif
                                                    @endforeach

                                                @endforeach
                                            </div><!-- end col-sm-5 -->
                                            <div class="col-sm-4 vertical direction">
                                                <p class="text-danger">{{__('site.additions')}}</p>
                                                <ul class="list-unstyled">
                                                    @foreach($adds as $addition)
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
                                                                    style="font-size:16px">{{$addition->FeatureCost}}
                                                                <span class="text-primary">{{$currance}}</span>
                                                            </span>
                                                            )
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- end col-sm-5 -->
                                            <div class="col-sm-2">
                                                <p class="text-danger"> {{__('site.date_start')}}</p>
                                                <input type="date" name="start_date" required class="form-control SpecificInput btn-sm">
                                                <p class="text-danger">{{__('site.attach_file')}}</p>
                                                <input type="file" name="file" class="form-control SpecificInput btn-sm" required>
                                            </div><!--end col-sm-2 -->
                                            <!--end first row -->
                                            <div class="col-sm-12">
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" id="discount_fake{{$complete_insuranc->id}}" value="{{$complete_insuranc->fake_discount}}"  name="discount_fake">
                                                    <input type="hidden" id="discount_fake_value{{$complete_insuranc->id}}" value="{{$complete_insuranc->precent}}"  name="discount_fake_value">

                                                    <span class="my-2 cl-sm-3"> {{__('site.price_before_discount')}} :

                                                <?php
                                                        $cost = ($OpenFilePerecent / 100) * $carprice;
                                                        //   print_r($complete_insuranc->OpenFileMinimumFirstSlide);

                                                        $min = $complete_insuranc->OpenFileMinimumFirstSlide;
                                                        $discount=$cost*$complete_insuranc->precent/100;


                                                        if ($flag) {

                                                            if ($min != null) {

                                                                if ($cost < $min) {
                                                                    $price_value=$complete_insuranc->fake_discount==1?$min:($min+$discount);
                                                                    echo '<input type="text" class="text-danger " readonly value="' . $price_value . '" class="form-control " />';
                                                                    echo '<input type="hidden" class="text-danger start_price-' . $complete_insuranc->id . ' no_back" readonly value="' . $min . '" class="form-control total" />';
                                                                    echo '<input type="hidden" class="original_price-' . $complete_insuranc->id . '" value="' . $min . '"  >';
                                                                } else {
                                                                    $price_value=$complete_insuranc->fake_discount==1?$cost:($cost+$discount);
                                                                    echo '<input type="text" class="text-danger" readonly value="' . $price_value . '" class="form-control" />';
                                                                    echo '<input type="hidden" class="text-danger start_price-' . $complete_insuranc->id . ' no_back" readonly value="' . $cost . '" class="form-control total" />';
                                                                    echo '<input type="hidden" class="original_price-' . $complete_insuranc->id . '" value="' . $cost . '"  >';
                                                                }
                                                            }
                                                        } else {
                                                            $price_value=$complete_insuranc->fake_discount==1?$cost:($cost+$discount);
                                                            echo '<input type="text" class="text-danger"  readonly value="' . $price_value . '" class="form-control total"  />';
                                                            echo '<input type="hidden" class="text-danger start_price-' . $complete_insuranc->id . ' no_back"  readonly value="' . $cost . '" class="form-control total"  />';
                                                            echo '<input type="hidden" class="original_price-' . $complete_insuranc->id . '" value="' . $cost . '"  >';
                                                        }
                                                        echo '<span class="text-primary font-weight-bolder">' . $currance . '</span>';

                                                        ?>
                                              </span>
                                                    @if ($flag)

                                                        <?php if ($min != null) {

                                                            if ($cost < $min) {
                                                                if($complete_insuranc->fake_discount==1){
                                                                    $discount=$min*$complete_insuranc->precent/100;
                                                                    $price_value=$complete_insuranc->fake_discount==0?$min:($min-$discount);
                                                                }else{
                                                                    $price_value=$complete_insuranc->fake_discount==0?$min:($min-$discount);}
                                                                echo '  <span class=" col-sm-2">الخصم  : <div style="width: 124px" class="btn btn-success  ">'.$discount.'</div></span>';
                                                                echo '<input type="hidden" class="net_price' . $complete_insuranc->id . '" value="' . $price_value . '" name="net_price" >';
                                                                echo '  <span class=" col-sm-3">السعر بعد الخصم : <span class="btn btn-warning text-primary start_price-' . $complete_insuranc->id . '" >'.$price_value.'</span></span>';
                                                            } else {

                                                                $price_value=$complete_insuranc->fake_discount==0?$cost:($cost-$discount);

                                                                echo '  <span class=" col-sm-2">الخصم  : <div style="width: 124px" class="btn btn-success  ">'.$discount.'</div></span>';
                                                                echo '<input type="hidden" class="net_price' . $complete_insuranc->id . '" value="' . $price_value . '" name="net_price" >';
                                                                echo '  <span class=" col-sm-3">السعر بعد الخصم : <span class="btn btn-warning text-primary  start_price-' . $complete_insuranc->id . ' no_back" ">'.$price_value.'</span></span>';

                                                            }
                                                        }?>
                                                        <div class="col-sm-2">

                                                            <button class="btn btn-primary" type="submit" style="display:block;margin:auto" id="submitbtn">
                                                                {{__('site.book_now')}}
                                                            </button>
                                                        </div><!--end col-sm-6 -->

                                                    @else


                                                        <span class="  col-sm-2">{{__('site.discount')}} : <span class="btn btn-danger text-primary">{{$discount}}</span></span>
                                                        <input type="hidden" class="net_price{{$complete_insuranc->id}}" value="{{$complete_insuranc->fake_discount==0?$cost:$cost-$discount}}" name="net_price" >
                                                    <!--<span class=" col-sm-3">{{__('site.price_after_discount')}} : <span class="btn btn-warning text-primary">{{$complete_insuranc->fake_discount==0?$cost:($cost-$discount)}}</span></span>-->
                                                        <span class=" col-sm-3">السعر بعد الخصم : <span class="btn btn-warning text-primary  start_price-{{$complete_insuranc->id }} ">{{$complete_insuranc->fake_discount==0?$cost:($cost-$discount)}}</span></span>';

                                                        <div class="col-sm-2">

                                                            <button class="btn btn-primary" type="submit" style="display:block;margin:auto" id="submitbtn">
                                                                {{__('site.book_now')}}
                                                            </button>
                                                        </div>
                                                </div>
                                            @endif
                                            <!--end col-sm-6 -->
                                            </div><!--end col-sm-6 -->


                                        </div><!-- end row -->
                                    </div>
                                </div>
                            </div>
                    </div>
                    {{--                @endif--}}
                </div>
                </form>
            @endforeach
        @else
            @if($_POST)<h5 class="text-danger p-2 text-center">{{__('site.plz_contact_us')}}</h5>@endif
        @endif
    </div>

    </div>

    </div>

 

@endsection
@section('js')
<script>
    $(document).ready(function () {
        const selectedBrand = Number("{{session()->get('brand_id')}}")
        const selectedModel = Number("{{session()->get('model_id')}}")
   
        $('.brandChange').change(function () {
            $.ajax({
                url: "{{url('/')}}/view/childerns_models/" + $(this).val(),
                context: document.body
            }).done(function (data) {
                $('.modelChange').find('option').remove().end();
                $.each(data, function (i, item) {
                    $('.modelChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                });
                if(selectedModel)
                {
                    $('.modelChange').val(selectedModel); 
                }

            });
        });

        if(selectedBrand)
        {
            $('.brandChange').val(selectedBrand);
            $('.brandChange').trigger('change');
        }

    });

    function changeCost(id) {
        var fake=$('#discount_fake'+id).val();
        var fakeValue=$('#discount_fake_value'+id).val();
        if(fake==1&&fakeValue !=0){
            orginal=$('.original_price-' + id).val();
            disc=orginal*fakeValue/100;
            amountToAdd=orginal-disc;


        }
        else var amountToAdd = $('.original_price-' + id).val();
        //   alert(amountToAdd)
        $(':checkbox').each(function () {
            if ($(this).is(":checked")) {
                amountToAdd = parseFloat(amountToAdd) + parseFloat($(this).attr('value'));
            }
        });
        // alert(amountToAdd)
        // $('.start_price-' + id).attr('value', amountToAdd);
        //alert(amountToAdd);
        $('.start_price-' + id).text(amountToAdd);
        // $('.net_price' + id).attr('value', amountToAdd);
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
