@extends('layouts.app')

@section('content')

<?php

use Carbon\Carbon;

$nespetEltahmol = 0;
$differofyears= 0;
$flag = false;
$mini = -1;
if($lang == 'ar' || $lang == 'en')
	{
		App::setlocale($lang);
	}
	else
	{
		App::setlocale('ar');
	}
?>
<style>
    .select2{
        margin-top:10px;
        width:100% !important;
    }
</style>

<style>
    .borderless {
    border: none !important;
    border-color: transparent !important;
}
 .complete_insuranc .form-group{
    border:solid 1px;
}
#price{
    display:none;
}
.complete_insuranc  .form-group {
    border: #b8b7b7 solid 1px;
    padding: 15px;
    color: #868383;
    font-weight: 600;
}
</style>


<div class="col-lg-12 cover-adv" style="height:200px;background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
        <div class="upper">
            <h2 class="place" style="margin: 0px auto;">
                {{__('site.price_comparison')}}
            </h2><br>
            <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
        </div>
</div>
<div class="col-lg-12" style="padding:20px;">
    <div class="container">
    <form method="get" action="{{route('dcFilter',$lang)}}" >
        @csrf
        <div class="form-row">

            <div class="form-group col-md-2">
				@if(app()->getLocale() == 'ar')
				<label style="display:block;">
				نوع التأمين<small  class="text-danger">*</small>
				@else
				Insurance Type <small  class="text-danger">*</small>
				</label>
				@endif
				<select class="SpecificInput typeChange form-control" name="type" id="type"style="margin-top:10px;">
						<option value="0" selected>
						@if(app()->getLocale() == 'ar')
						تأمين ضد الغير
						@else
					        Against Other Insurance
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
			    <select class="SpecificInput typeofuseChange form-control" name="type_of_use" >

    			           <option value="private" @if($_POST)@if($_POST['type_of_use'] == 'private') {{ 'selected' }} @endif @endif>{{__('site.private')}}
    			           </option>
    			           <option value="rent" @if($_POST)@if($_POST['type_of_use'] == 'rent') {{ 'selected' }} @endif @endif> {{__('site.rent')}}</option>
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
                        <option value="{{$brand->id}}" @if($_POST)@if($_POST['brand_id'] == $brand->id) {{ 'selected' }} @endif @endif>
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
                            <option value="{{$model->id}}" @if($_POST['model_id'] == $model->id) {{ 'selected' }} @endif>
                                {{$model->name}}
                            </option>
                        @endforeach
                    @endif
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
                    @if($_POST)
                        <option value="{{$_POST['year']}}" selected>{{$_POST['year']}}</option>

                        <?php
                        for ($i = -1; $i <= 35; ++$i) {
                            $time = strtotime(sprintf('-%d years', $i));
                            $value = date('Y', $time);
                            $label = date('Y ', $time);
                            printf('<option value="%s"  >%s</option>', $value, $label);
                        }
                        ?>
                    @else
                        <?php
                        for ($i = -1; $i <= 35; ++$i) {
                            $time = strtotime(sprintf('-%d years', $i));
                            $value = date('Y', $time);
                            $label = date('Y ', $time);
                            printf('<option value="%s"  >%s</option>', $value, $label);
                        }
                        ?>

                    @endif
                </select>

            </div>
    	    <div class="form-group col-md-2" id="price">
				@if(app()->getLocale() == 'ar')
				<label style="display:block">
				سعر السياره<small  class="text-danger">*</small>
				@else
				car price <small  class="text-danger">*</small>
				</label>
				@endif
				<input name="carprice" class="SpecificInput carprice col-md-12 form-control" style="width:100%;margin-top:10px;" id="carprice">

			</div>


			<button class="btn btn-primary col-lg-4" type="submit" style="display:block;margin:auto" id="submitbtn">
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
@if($type==0)
    <div class="form-body">
@foreach($insurance_document as $insurance_document)

    <div class="container">
    <form method="post" action="{{url('/')}}/user/insurance/{{app()->getLocale()}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col-lg-12">
        <div class="container">
        <div class="section-3 search_result_box" >

            <div class="container-fluid">
                <span class="text-danger">{{__('site.company_name')}}</span>
               <h4 style="display: inline-block;font-weight: 600;font-size:20px;">
                   <input type="hidden" name="insurance_id" value="{{$insurance_document->insurance_id}}">
                   <input type="hidden" name="type1" value="{{$insurance_document->type}}">
                   <input type="hidden" name="typeofuse1" value="{{$insurance_document->type_of_use}}">
                   <input type="hidden" name="brand1" value="{{$insurance_document->brand_id}}">
                   <input type="hidden" name="model1" value="{{$insurance_document->model_id}}">
                   <input type="hidden" id="year1" name="year1" value="{{$insurance_document->specific_year}}">
                   <input type="hidden" id="companynamear" name="companynamear" value="{{$insurance_document->Insurance_Company_ar}}">
                   <input type="hidden" id="companynameen" name="companynameen" value="{{$insurance_document->Insurance_Company_en}}">


                   @if(app()->getLocale() == 'ar')
                    {{$insurance_document->Insurance_Company_ar	}}
                   @else
                    {{$insurance_document->Insurance_Company_en}}
                   @endif
               </h4>
               <hr>
               <div class="breakLineForDiv p-r">

               </div>

            </div>
             <div class="row">
                 <div class="col-sm-2"></div>
                 <div class="col-sm-8 com_logo">

                     @if($insurance_document->precent>0)
                         <span class="notify-badge">{{$insurance_document->precent}}%</span>
                     @endif
                     <a data-fancybox="logo" href="{{url('/')}}/uploads/{{$insurance_document->logo}}"  >
                         <img src="{{url('/')}}/uploads/{{$insurance_document->logo}}"
                              class="img-thumbnail">
                     </a>

                 </div>

                 <div class="col-sm-12 text-center py-2">
                     <span class="text-primary btn-sm">{{__('site.terms_document')}} : </span>
                 @if(app()->getLocale() == 'ar')
                            {{$insurance_document->ar_term}}
                      @else
                            {{$insurance_document->en_term}}
                      @endif
                 </div>
             </div>
             <hr>

                <div class="form-group row">
                    <div class="form-group col-md-2" style="text-align: center">
                        @if(app()->getLocale() == 'ar')
        					&nbsp;	&nbsp;<label style="display:block">
        				 <small  class="text-danger">*</small>
        				    <button type="button" class="show btn btn-outline-primary " onclick="insurance_durtaion({{$now_year}},{{$request_year}},{{$insurance_document}})"  style="margin-top:10px;">اختار مده التامين</button>
        				@else
        				 	&nbsp;	&nbsp; <small  class="text-danger">*</small>
        				</label>
        				<button type="button" class="show btn btn-primary " onclick="insurance_durtaion({{$now_year}},{{$request_year}},{{$insurance_document}})" style="margin-top:10px;margin-right: 8%;">Choose Isurance Duration</button>
        				@endif

                  </div>
                   <div class="form-group col-md-2">
               	<!--<div class="form-group col-md-2">-->
				@if(app()->getLocale() == 'ar')
				<label style="display:block">
				مده التامين<small  class="text-danger">*</small>
				@else
				 Insurance Duration <small  class="text-danger">*</small>
				</label>
				@endif
				<select class="SpecificInput select2" id="induration_{{$insurance_document->id}}" onchange="insurance_cost(this.id,{{$insurance_document->price}})" name="inDuration" style="margin-top:10px;">

				</select>
				</div>

				<div class="form-group col-md-2">
				    @if(app()->getLocale() == 'ar')
				<label style="display:block">
				السعر <small  class="text-danger">*</small>
				@else
				 Price <small  class="text-danger">*</small>
				</label>
				@endif
				<input type="hidden" name="year" value="{{$request_year}}">
                    <input type='text' name="price" value="{{$insurance_document->price}}" id="price_{{$insurance_document->id}}"  readonly class="SpecificInput borderless" style="margin-top: 10px;" >
                </div>

                <div class="form-group col-md-2">
				    @if(app()->getLocale() == 'ar')
				<label style="display:block">
				رسوم توصيل الوثيقة <small  class="text-danger">*</small>
				@else
				 Delivery Fee <small  class="text-danger">*</small>
				</label>
				@endif
                    <input type='text' value="{{$insurance_document->deliveryFee}}"  class="SpecificInput borderless"  style="margin-top: 10px;" readonly >
                </div>

                <div class="form-group col-md-2">
				    @if(app()->getLocale() == 'ar')
				<label style="display:block">
				بدأ التأمين   <small  class="text-danger">*</small>
				@else
				Insu.start <small  class="text-danger">*</small>
				</label>
				@endif
                    <input type='date' required  name="date"  class="SpecificInput borderless"  style="margin-top: 10px;" multiple >
                </div>

                 <div class="form-group col-md-2">
				    @if(app()->getLocale() == 'ar')
				<label style="display:block">
				الملفات   <small  class="text-danger">صورة الدفتر / البطاقة المدنية وجهين</small>
				@else
				Car Documents <small  class="text-danger">*</small>
				</label>
				@endif
                    <input type='file'  name="files[]" required  class="SpecificInput borderless"  style="margin-top: 10px;" multiple >
                </div>

			</div>

                <!-- @if(app()->getLocale() == 'ar')-->
                <!--   السعر : {{$insurance_document->price}}-->
                <!--@else-->
                <!--   Price: {{$insurance_document->price}}-->
                <!--@endif-->

                 <ul>
                     <!--sondos-->
            <!--//here need condition if not exist   so useles  -->
                  <li>
                @if(app()->getLocale() == 'ar')
                   قيمة الخصم  : {{$insurance_document->discount_q}}
                @else
                   Discount Quantity: {{$insurance_document->discount_q}}
                @endif
                 </li>
                  <li>
                @if(app()->getLocale() == 'ar')
                   نسبة الحصم : {{$insurance_document->precent}}
                @else
                   Discount Precnetatge: {{$insurance_document->precent}}
                @endif

                <button class="btn btn-primary" type="submit" style="float: left;">
			    @if(app()->getLocale()== 'ar')
			    ارسال
			    @else
			    Send
			    @endif
			    </button>
                 </li>

             </ul>

        </div>
        </div>
    </div>
    </div>
    </form>
    </div>
@endforeach
</div>
@else
<div class="form-body form-body2 ">
@foreach($complete_insurance as $complete_insuranc)
    <div class="container complete_insuranc">
        <form method="POST" action="{{route('submitCompleteDoc')}}">
         @csrf
        <div class="form-row">
            <div class="col-lg-12">
        <div class="container">
        <div class="section-3" style="padding: 25px !important; margin-top:25px;background-color: #F3F3F3">

            <div class="container-fluid">
               <h4 style="display: inline-block;font-weight: 600;font-size:20px;">
                 <input type="hidden" name="complete_doc_id[]" value="{{$complete_insuranc->id}}">
                 <input type="hidden" name="price" value="{{$carprice}}">
                   @if(app()->getLocale() == 'ar')
                    {{$complete_insuranc->Insurance_Company_ar}}
                   @else
                    {{$complete_insuranc->Insurance_Company_en}}
                   @endif
               </h4>
{{--               <button class="btn btn-light top" style="font-size:12px; font-weight: 600;background-color: white">--}}
{{--                <i class="fas fa-phone"></i>--}}
{{--                <!--sondos-->--}}
{{--                <!--error line-->--}}
{{--                    {{$complete_insuranc->insurnace->phones}}--}}
{{--                    <!--//-->--}}
{{--               </button>--}}
               <hr>
               <div class="breakLineForDiv p-r">

               </div>

            </div>
             <div class="row">
                 <div class="col-md-2">
                     <img src="{{url('/')}}/uploads/{{$complete_insuranc->logo}}" style="width:100%;hight:100px;">

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
                            فتح الملف عن كل حادث
                        </div>
                        @endif
                        <div class="form-group col-2">
                          {{$OpenSlide == 0 ? 'بدون فتح ملف' : $OpenSlide.' عن كل حادث'}}
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
                                                        نسبة التحمل
                                                    </div>

                                                    <div class="form-group col-3">
                                                        <?php



                                                            $ratio = $carprice *  ($condition->Tolerance_ratio / 100) ;



                                                        ?>
                                                        {{$ratio > $condition->ToleranceYearPerecenteage ? $condition->ToleranceYearPerecenteage : $ratio}}
                                                    </div>

                                                    <div class="form-group col-4">

                                                        من الحوادث ضد مجهول و ما زاد يتحمل المشترك
                                                    </div>
                                                    <div class="form-group col-2">
                                                        {{$condition->last_percent}}
                                                    </div>

                                                @endif






                                                @if($nespetEltahmol != 0)
                                                    <div class="form-group col-2">
                                                        نسبة الاستهلاك
                                                    </div>
                                                    <div class="form-group col-4">
                                                        {{$nespetEltahmol}} % علي قطع الغيار المستبدلة
                                                    </div>
                                                @else
                                                     <div class="form-group col-6">
                                                            بدون نسبة استهلاك علي قطع الغيار المستهلكة
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
                         <input type="checkbox" name="addition{{$complete_insuranc->id}}[]" value="{{$addition->id}}">
                                @if(app()->getLocale()== 'ar')
                                    {{$addition->FeatureNameAr}}
                                @else
                                    {{$addition->FeatureNameEn}}
                                @endif


                                 ( <span class="text-danger" style="font-size:22px">{{$addition->FeatureCost}}</span> )


                    </li>

                @endforeach

                </ul>

                 <div class="form-group col-2">
                          السعر
                        </div>
                        <div class="form-group col-2">
                          <?php

                            $cost = ($OpenFilePerecent / 100) * $carprice;
                            $min = $complete_insuranc->OpenFileMinimumFirstSlide;
                            if($flag) {

                                if($min != null) {

                                if($cost < $min) {
                                    echo $min;
                                }

                            } else {

                                echo $cost;
                            }
                            }

                          ?>
                        </div>


               <button class="btn btn-primary col-lg-4" type="submit" style="display:block;margin:auto" id="submitbtn">
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
    </div>
    </form>
    </div>
@endforeach
</div>

</div>
@endif


<script>
    $(document).ready(function(){
        $('.brandChange').change(function(){
           $.ajax({
              url: "{{url('/')}}/view/childerns/"+$(this).val(),
              context: document.body
            }).done(function(data) {
                $('.modelChange').find('option').remove().end();
                $.each(data,function(i,item){
                    $('.modelChange').append('<option value="'+item.id+'">'+item.name+'</optin>')
                });

            });
        });
    });
</script>


<script>
function insurance_durtaion(now_year,request_year,insurance){
    first_interval = insurance['firstinterval'];
    second_interval = insurance['secondinterval'];
    third_interval = insurance['thirdinterval'];

    difference = parseInt(now_year) - parseInt(request_year);

    console.log(insurance['secondinterval']);

    if (parseInt(insurance['firstinterval']) > difference) {
        $('#induration_'+insurance['id']).find('option').remove();
        $('#induration_'+insurance['id']).append(new Option('',''));
        console.log('first');
        for(i=parseInt(insurance['firstinterval']); i>0 ; i--)
        {
             $('#induration_'+insurance['id']).append(new Option(i,i));
        }
    } else if ((parseInt( insurance['secondinterval']) + parseInt(insurance['firstinterval'])) > difference ) {
       $('#induration_'+insurance['id']).find('option').remove();
        $('#induration_'+insurance['id']).append(new Option('',''));
        console.log('second');
        for(i=parseInt( insurance['secondinterval']); i>0 ; i--)
        {
             $('#induration_'+insurance['id']).append(new Option(i,i));
        }
    } else if ((parseInt(insurance['thirdinterval']) + parseInt( insurance['secondinterval']) + parseInt(insurance['firstinterval'])) > difference) {
        $('#induration_'+insurance['id']).find('option').remove();
        $('#induration_'+insurance['id']).append(new Option('',''));
        console.log('third');
        for(i=parseInt(insurance['thirdinterval']); i>0 ; i--)
        {
             $('#induration_'+insurance['id']).append(new Option(i,i));
        }
    } else
    {
        $('#induration_'+insurance['id']).find('option').remove();
        $('#induration_'+insurance['id']).append(new Option('',''));
        console.log('third');
        for(i=parseInt(insurance['thirdinterval']); i>0 ; i--)
        {
             $('#induration_'+insurance['id']).append(new Option(i,i));
        }
    }
}

function insurance_cost(id,price){
   selected = $('#'+id).val();
   cost_id = id.split('_');
   $('#price_'+cost_id[1]).val(parseInt(price) * parseInt(selected));
}

// Price Of Complete Insurnace Script
$('#type').change(function(){
  if($(this).val() == 1 ){
    $('#price').slideDown();
  }
  else{
       $('#price').slideUp();
  }
});

</script>

@endsection
