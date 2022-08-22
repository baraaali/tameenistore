@extends('Cdashboard.layout.app')
@section('controlPanel')


<?php 

    if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }

?>


 @if(app()->getLocale() == 'ar')
                                   
                                   <style>
                                       .form-group{
                                           direction:rtl;
                                           text-align:right !important;
                                       }
                                   </style>
                                   
                                   @else
                                   
                                    <style>
                                       .form-group{
                                           direction:ltr;
                                           text-align:left !important;
                                       }
                                   </style>
                                   
                                    @endif

<div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                            <h4>
                               @if(app()->getLocale() == 'ar')
                                 تعديل تأمين شامل
                               @else
                                Update Comprehensive Inurance
                               @endif
                            </h4>
                            <hr>
                            <div class="form-body">
                                <form method="POST" action="{{route('cmDocument-Update')}}" enctype="multipart/form-data">
                                    @csrf
                                   
                                  
                                   <div class="row">
                                        
                                   <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
                                             نوع الاستخدام
                                          @else
                                            type of use
                                          @endif
                                       </label> <small class="text-danger">
                                           عند إختيار نوع الاستخدام سيتم الاخيار علي جميع الموديلات 
                                       </small>
                                       
                                       <select class="SpecificInput" name="type_of_use" value="$document->type_of_use">
                                         @if(app()->getLocale() == 'ar')
                                                <option value="private" {{$document->type_of_use=='private' ? 'selected' : ''}}>
                        			               خاص
                        			               </option>
                        			           <option value="rent" {{$document->type_of_use=='rent' ? 'selected' : ''}}>
                        			                 أجرة
                        			           </option>
                			           @else
                    			               <option value="private" {{$document->type_of_use=='private' ? 'selected' : ''}}>
                    			              private
                    			               </option>
                    			             <option value="rent" {{$document->type_of_use=='rent' ? 'selected' : ''}}>
                    			                 rent
                    			             </option>
                			               @endif
                			           
                			           </select>
                                   </div>
                                   </div>
                                   <hr>
                                   <div class="row">
                                       <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
                                             الشعار
                                          @else
                                            LOGO
                                          @endif
                                       </label>
                                       <input type="file" name="logo" class="SpecificInput" >
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
                                            اسم شركه التامين بالعربيه
                                            @else
                                            Insurance Company Name In Arabic
                                          @endif
                                       </label>
                                       <input type="text" name="Insurance_Company_ar" class="SpecificInput" max="191" value="{{$document->Insurance_Company_ar}}">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
اسم شركه التامين بالانجليزيه        
                                          @else
                                            Insurance Company Name in English
                                          @endif
                                       </label>
                                       <input type="text" name="Insurance_Company_en" class="SpecificInput" max="191" value="{{$document->Insurance_Company_en}}">
                                   </div>
                                   </div>
                                   <hr>
                                   <div class="row">
                                   <div class="form-group col-md-2">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
رسوم توصيل الوثيفة
                                            @else
                                            Delivery Fee
                                          @endif
                                       </label>
                                       <input type="number" step=".0001" name="deliveryFee" class="SpecificInput" max="191" value="{{$document->deliveryFee}}">
                                   </div>
                                   </div>
                                   <hr>
                                   <div class="row">
                                    <div class="form-group col-md-6">
                                         <label>
                                          @if(app()->getLocale() == 'ar')
                                          شروط الوثيقه بالعربية<small class="text-danger">*</small>
                          
                                          @else
                                             Terms in Arabic  <small class="text-danger">*</small>
                                          @endif
                                       </label>
                                   
                                    <input type="text" required="required" name="ar_term" maxlength="191" class="SpecificInput" value="{{$document->ar_term}}">
                                    </div>
                                     <div class="form-group col-md-6">
                                         <label>
                                          @if(app()->getLocale() == 'ar')
                                              شروط الوثيقة بالانجليزية  <small class="text-danger">*</small>
                                          @else
                                             Terms in English  <small class="text-danger">*</small>
                                          @endif
                                       </label>
                                   
                                    <input type="text" required="required" name="en_term" maxlength="191" class="SpecificInput" value="{{$document->en_term}}">
                                    </div>
                                   </div>
                                   <hr>
                                   <div class="row">
                                    <div class="form-group col-md-3">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
                                          نسبة الخصم % <small class="text-danger">*</small>
                                          @else
                                             Discount's percentage  <small class="text-danger">*</small>
                                          @endif
                                       </label>  
                                    <label>
                                     
                                    </label>
                                    <input type="number" step=".0001"  name="precent" maxlength="191" class="SpecificInput" value="{{$document->precent}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                          <label>
                                          @if(app()->getLocale() == 'ar')
                                                                               قيمة الخصم<small class="text-danger">*</small>
                                          @else
                                             Discount's Value  <small class="text-danger">*</small>
                                          @endif
                                       </label>  
                                   
                                    <input type="number" step=".0001" name="discount_q" maxlength="191" class="SpecificInput" value="{{$document->discount_q}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        
                                    <label>
                                         @if(app()->getLocale() == 'ar')
                                        
                                    تاريخ بداية الخصم<small class="text-danger">*</small>
                                       @else
                                             Discount's Start Date<small class="text-danger">*</small>
                                        @endif
                                    </label>
                                    <input type="date"  name="start_disc" maxlength="191" class="SpecificInput" value="{{$document->start_disc}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                       <label>
                                             @if(app()->getLocale() == 'ar')
                                        
                                    تاريخ نهاية الخصم <small class="text-danger">*</small>
                                       @else
                                             Discount's Start Date<small class="text-danger">*</small>
                                        @endif
                                       </label>
                                    
                                    <input type="date"  name="end_disc" maxlength="191" class="SpecificInput" value="{{$document->end_disc}}">
                                    </div>
                                   </div>
                                   <hr>
                                   <div class="container-fluid">
                                       <div class="row">
                                           <div class="col-md-12">
                                               <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>
                                                           @if(app()->getLocale() == 'ar')
                                                                الشروط
                                                           @else 
                                                                Terms
                                                           @endif
                                                       </h4>
                                                        <button type="button" class="btn btn-light d-block" onclick="addmoreAddons()">@if(app()->getLocale() == "ar") إضافة المزيد  @else  Add More  @endif </button>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                      <div class="row form-group">
                                                          <div class="col-md-3" style="padding-top:35px">
                                                              <input type="checkbox" value="1" name="ToleranceratioCheck" value="{{$document->ToleranceratioCheck}}"/> 
                                                              <label>
                                                                   @if(app()->getLocale() == 'ar')
                                                                        
                                                                        نسبة التحمل
                                                                        
                                                                   @else
                                                                   Tolerance ratio
                                                                   @endif
                                                              </label>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                  
                                                                    نسبة التحمل
                                                                  @else
                                                                   Tolerance ratio
                                                                  
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="Tolerance_ratio" value="{{$document->Tolerance_ratio}}" >
                                                          </div>
                                                          
                                                          <div class="col-md-3">
                                                              <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                    الحد الاقصي
                                                                  @else
                                                                    Maxmum ratio
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="ToleranceYearPerecenteage" value="{{$document->ToleranceYearPerecenteage}}">
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                      <div class="row form-group">
                                                          <div class="col-md-3" style="padding-top:35px">
                                                              <input type="checkbox" value="1" name="ConsumptionRatio" value="{{$document->ConsumptionRatio}}"/> 
                                                              <label>
                                                                    @if( app()->getLocale() == 'ar')
                                                                    نسبة الاستهلاك ( في حالة التصليح خارج الوكالة )
                                                                    @else
                                                                    Consumption rate (in case of repair outside the agency)
                                                                    @endif
                                                              </label>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                  
                                                                    نسبة الاستهلاك
                                                                  @else
                                                                  Consumption Ratio
                                                                  
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="ConsumptionFirstRatio" value="{{$document->ConsumptionFirstRatio}}">
                                                          </div>
                                                          <div class="col-md-3">
                                                              <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                    الزيادة السنوية
                                                                  @else
                                                                    Yearly Ratio
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="YearPerecenteage" value="{{$document->YearPerecenteage}}">
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="row">
                                                                  <div class="col-md-6">
                                                                      <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                    الحد الاقصي
                                                                  @else
                                                                    Maxmum ratio
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="ConsumptionYearPerecenteage" value="{{$document->ConsumptionYearPerecenteage}}">
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <label>
                                                                  @if(app()->getLocale() == 'ar')
                                                                     النسبة للحد الاقصي
                                                                  @else
                                                                last Maxmum ratio
                                                                  @endif
                                                              </label>
                                                              <input class="SpecificInput" type="text" name="last_percent" value="{{$document->last_percent}}">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                إسم الشرط باللغة العربية
                                                            @else
                                                               Term name In Arabic
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" name="AddonNameAR[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                إسم الشرط باللغة الانجليزية
                                                            @else
                                                               Term name In English
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" name="AddonNameEn[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                حد أدني للسنين
                                                            @else
                                                              Minimum Years
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" name="AddonMaxYear[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                               حد أقصي للمجهول
                                                            @else
                                                             An unknown maximum
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" name="AddonUnkownMaxmum[]">
                                                    </div>
                                                </div>
                                                <div class="addons">
                                                    
                                                </div>
                                                <hr>
                                           </div>
                                           <div class="col-md-12">
                                               <div class="row ">
                                                   <div class="col-md-12">
                                                       <h4>
                                                           @if(app()->getLocale() == 'ar')
                                                                الاضافات
                                                           @else 
                                                                Addons
                                                           @endif
                                                       </h4>
                                                        <button type="button" class="btn btn-light d-block" onclick="addmoreFeatures()">@if(app()->getLocale() == "ar") إضافة المزيد  @else  Add More  @endif </button>
                                                        <br>
                                                    </div>
                                                    
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                إسم الاضافة بالعربية
                                                            @else
                                                                Arabic Feature Name
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" name="FeatureNameAr[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                إسم الاضافة بالانجليزية
                                                            @else
                                                                English Feature Name
                                                            @endif
                                                        </label>
                                                        <input type="text" class="SpecificInput" type="text" name="FeatureNameEn[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                 سعر الاضافة  
                                                            @else
                                                                Feature Cost
                                                            @endif
                                                        </label>
                                                        <input type="number" step=".0001" class="SpecificInput" type="number" name="FeatureCost[]">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="d-block">
                                                            @if(app()->getLocale() == "ar")
                                                                ملاحظات
                                                            @else
                                                               Notices
                                                            @endif
                                                        </label>
                                                        <input  class="SpecificInput" type="text" name="FeatureNotices[]">
                                                    </div>
                                               </div>
                                               <div class="features">
                                                   
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <hr>
                                    
                                   <div class="form-group">
                                       
                                    <div class="text-center">
                                    
                                    
                                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label>
                                                       @if(app()->getLocale() == 'ar')
                                                    البراند
                                                            @else
                                                                Brand
                                                            @endif
                                            </label>
                                            <?php $brands = \App\brands::get(); ?>
                                            <select class="SpecificInput select2 brandChange" name="brand_id">
                                                <option selected disabled>
                                                    @if(app()->getLocale() == 'ar')
                                                    
                                                    إختر نوع البراند
                                                    
                                                    @else
                                                    
                                                    Choose brand name
                                                    
                                                    @endif
                                                </option>
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            
                                        </div>
                                        
                                    </div>
                                                        
                                    </div>
                                        <div class="container-fluid models">
                                            
                                        </div>
                                                                
                                    </div>
                                    

                                  
                                    
                                    
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @if(app()->getLocale() == 'ar')
                            <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                            @else
                            <input type="submit" name="submit" class="btn btn-primary" value="Save">
                            @endif
                          </div>
                        </form>
                        </div>
                            
                            
                           
                        </div>
            

<script>
    $(document).ready(function(){
        $('.brandChange').change(function(){
            id = $(this).val();
          $.ajax({
              url: "{{url('/')}}/view/childerns/"+$(this).val(),
              context: document.body
            }).done(function(data) {
                 //<input type="hidden" name="brand_id[]" value="'+id+'">
                $.each(data,function(i,item){
                    $(".models").append(
                    '<div class="card" style="padding:15px;">'+
                        '<div class="card-heading">'+
                            '<input type="checkbox" name="model_id[]" value="'+item.id+'" > '+ item.name +
                            '<hr>'+
                            '<div class="row">'+
                                '<div class="col-md-3">'+
                                    '<label class="d-block">'+
                                        '@if(app()->getLocale() == "ar")'+
                                            'سعر الشريحة الاولي'+
                                        '@else'+
                                            'Start Price First Slide'+
                                        '@endif'+
                                    '</label>'+
                                    '<input type="number" step=".0001" name="firstSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">'+
                                    '<div class="row">'+
                                        '<div class="col-md-4">'+
                                            '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>'+
                                            '<input class="SpecificInput" type="number" step=".0001" name="OpenFileFirstSlide[]">'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                           '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>'+
                                            '<input type="number" step=".0001" name="OpenFilePerecentFirstSlide[]" class="SpecificInput">'+
                                        '</div>'+
                                         '<div class="col-md-4">'+
                                             '<label> @if(app()->getLocale() == "ar") الحد الادني @else  Minimum Price  @endif </lable>'+
                                            '<input type="number" step=".0001" name="OpenFileFirstSlideMin[]" class="SpecificInput" placeholder="@if(app()->getLocale() == "ar" ) الحد الادني @else Minimum Price @endif">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<label class="d-block">'+
                                        '@if(app()->getLocale() == "ar")'+
                                              'سعر الشريحة الثانية'+
                                        '@else'+
                                            'Start Price Second Slide'+
                                        '@endif'+
                                    '</label>'+
                                    '<input type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">'+
                                     '<div class="row">'+
                                        '<div class="col-md-6">'+
                                            '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>'+
                                            '<input class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                           '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>'+
                                            '<input type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">'+
                                        '</div>'+
                                         
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<label class="d-block">'+
                                        '@if(app()->getLocale() == "ar")'+
                                             'سعر الشريحة  الثالثة'+
                                        '@else'+
                                            'Start Price third Slide'+
                                        '@endif'+
                                    '</label>'+
                                    '<input type="number" step=".0001" name="thirdSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">'+
                                    '<div class="row">'+
                                        '<div class="col-md-6">'+
                                            '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>'+
                                            '<input class="SpecificInput" step=".0001" type="number" name="OpenFileThirdSlide[]">'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                           '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>'+
                                            '<input type="number" step=".0001" name="OpenFilePerecentThirdSlide[]" class="SpecificInput">'+
                                        '</div>'+
                                         
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<label class="d-block">'+
                                        '@if(app()->getLocale() == "ar")'+
                                             'سعر الشريحة  الرابعة'+
                                        '@else'+
                                            'Start Price fourth Slide'+
                                        '@endif'+
                                    '</label>'+
                                    '<input type="number" name="fourthSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">'+
                                    '<div class="row">'+
                                        '<div class="col-md-6">'+
                                            '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>'+
                                            '<input class="SpecificInput" step=".0001" type="number" name="OpenFileFourthSlide[]">'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                           '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>'+
                                            '<input type="number" step=".0001" name="OpenFilePerecentFourthSlide[]" class="SpecificInput">'+
                                        '</div>'+
                                         
                                    '</div>'+
                                '</div>'+
                             '</div>'+
                             '<br>'+
                                '<hr>'+
                                
                    '</div>'
                    );
                  
                });
              
            });
        });
    });
    
    function addmoreAddons() {
        
       
        
        $('.addons').append(
                '<div class="row deleting">'+
                  '<div class="col-md-3 form-group">'+
                                        '<label class="d-block">'+
                                            '@if(app()->getLocale() == "ar")'+
                                                 'إسم الشرط'+
                                            '@else'+
                                                'Term name'+
                                            '@endif'+
                                        '</label>'+
                                        '<input type="text" class="SpecificInput" name="AddonNameAR[]">'+
                                    '</div>'+
                                    '<div class="col-md-3 form-group">'+
                                        '<label class="d-block">'+
                                            '@if(app()->getLocale() == "ar")'+
                                                'إسم الشرط باللغة الانجليزية'+
                                            '@else'+
                                                'Term name In English'+
                                            '@endif'+
                                            
                                           
                                        '</label>'+
                                        '<input type="text" class="SpecificInput" name="AddonNameEn[]">'+
                                    '</div>'+
                                    '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                                'حد أدني للسنين'+
                                                            '@else'+
                                                             'Minimum Years'+
                                                            '@endif'+
                                                        '</label>'+
                                                        '<input type="text" class="SpecificInput" name="AddonMaxYear[]">'+
                                                    '</div>'+
                                                    '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                               'حد أقصي للمجهول'+
                                                            '@else'+
                                                             'An unknown maximum'+
                                                            '@endif'+
                                                            '<button type="button" class="btn btn-danger deleteTerm" onclick="DeleteAddosn(this)" style="float:{{app()->getLocale() == "ar" ? "left" : "right"}}" > <i class="fa fa-trash text-white"></i></button>'+
                                                       '</label>'+
                                                        '<input type="text" class="SpecificInput" name="AddonUnkownMaxmum[]">'+
                                                    '</div>'+
                                                    '</div>'
                                   
            
            );
    }
    
    
    function addmoreFeatures() {
        $('.features').append(
                '<div class="row deletingFeature">'+
                 '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                                'إسم الاضافة بالعربية'+
                                                           '@else'+
                                                                'Arabic Feature Name'+
                                                            '@endif'+
                                                        '</label>'+
                                                        '<input class="SpecificInput" type="text" name="FeatureNameAr[]">'+
                                                    '</div>'+
                                                    '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                               ' إسم الاضافة بالانجليزية'+
                                                            '@else'+
                                                                'English Feature Name'+
                                                            '@endif'+
                                                        '</label>'+
                                                        '<input class="SpecificInput" type="text" name="FeatureNameEn[]">'+
                                                    '</div>'+
                                                   '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                           ' سعر الاضافة  '+
                                                            '@else'+
                                                                'Feature Cost'+
                                                            '@endif'+
                                                            '<button type="button" class="btn btn-danger deleteTerm" onclick="DeleteFeature(this)" style="float:{{app()->getLocale() == "ar" ? "left" : "right"}}" > <i class="fa fa-trash text-white"></i></button>'+
                                                        '</label>'+
                                                        '<input class="SpecificInput" type="number" step=".0001" name="FeatureCost[]">'+
                                                    '</div>'+
                                                    '<div class="col-md-3 form-group">'+
                                                        '<label class="d-block">'+
                                                            '@if(app()->getLocale() == "ar")'+
                                                                'ملاحظات'+
                                                            '@else'+
                                                               'Notices'+
                                                            '@endif'+
                                                        '</label>'+
                                                        '<input  class="SpecificInput" type="text" name="FeatureNotices[]">'+
                                                    '</div>'+
                '</div>'
            );
    }
    
    function DeleteAddosn(button) {
        $(button).closest('.deleting').remove();
    }
    
     function DeleteFeature(button) {
        $(button).closest('.deletingFeature').remove();
    }
</script>








 <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
 <script>tinymce.init({selector:'textarea'});</script>

@endsection