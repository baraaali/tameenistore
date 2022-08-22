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
@include('dashboard.layout.message')
<div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                            <h4>
                               @if(app()->getLocale() == 'ar')
                                 إضافة تأمين ضد الغير
                               @else
                                Create Third Party Insurance
                               @endif
                            </h4>
                            <div class="form-body">
                                <form method="POST" action="{{route('ddElgher-Store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <!--<input type="hidden" name="insurance_id" value="insurance->id">-->

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

                                       <select class="SpecificInput" name="type_of_use" >
                                         @if(app()->getLocale() == 'ar')
                                                <option value="private">
                        			               خاص
                        			               </option>
                        			           <option value="rent">
                        			                 أجرة
                        			           </option>
                			           @else
                    			               <option value="private">
                    			              private
                    			               </option>
                    			             <option value="rent">
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
                                       <input type="file" name="logo" class="SpecificInput">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
                                            اسم شركه التامين بالعربيه
                                            @else
                                            Insurance Company Name In Arabic
                                          @endif
                                       </label>
                                       <input type="text" name="Insurance_Company_ar" class="SpecificInput" max="191">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label>
                                          @if(app()->getLocale() == 'ar')
اسم شركه التامين بالانجليزيه
                                          @else
                                            Insurance Company Name in English
                                          @endif
                                       </label>
                                       <input type="text" name="Insurance_Company_en" class="SpecificInput" max="191">
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
                                       <input type="number" name="deliveryFee" class="SpecificInput" max="191">
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

                                    <input type="text" required="required" name="ar_term" maxlength="191" class="SpecificInput">
                                    </div>
                                     <div class="form-group col-md-6">
                                         <label>
                                          @if(app()->getLocale() == 'ar')
                                              شروط الوثيقة بالانجليزية  <small class="text-danger">*</small>
                                          @else
                                             Terms in English  <small class="text-danger">*</small>
                                          @endif
                                       </label>

                                    <input type="text" required="required" name="en_term" maxlength="191" class="SpecificInput">
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
                                    <input type="tel"  name="precent" maxlength="191" class="SpecificInput">
                                    </div>
                                    <div class="form-group col-md-3">
                                          <label>
                                          @if(app()->getLocale() == 'ar')
                                                                               قيمة الخصم<small class="text-danger">*</small>
                                          @else
                                             Discount's Value  <small class="text-danger">*</small>
                                          @endif
                                       </label>

                                    <input type="tel" name="discount_q" maxlength="191" class="SpecificInput">
                                    </div>
                                    <div class="form-group col-md-3">

                                    <label>
                                         @if(app()->getLocale() == 'ar')

                                    تاريخ بداية الخصم<small class="text-danger">*</small>
                                       @else
                                             Discount's Start Date<small class="text-danger">*</small>
                                        @endif
                                    </label>
                                    <input type="date"  name="start_disc" maxlength="191" class="SpecificInput">
                                    </div>
                                    <div class="form-group col-md-3">
                                       <label>
                                             @if(app()->getLocale() == 'ar')

                                    تاريخ نهاية الخصم <small class="text-danger">*</small>
                                       @else
                                             Discount's Start Date<small class="text-danger">*</small>
                                        @endif
                                       </label>

                                    <input type="date"  name="end_disc" maxlength="191" class="SpecificInput">
                                    </div>
                                   </div>
                                   <hr>
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
                // <input type="hidden" name="brand_id[]" value="'+id+'">
                $.each(data,function(i,item){
                    $(".modelTable tbody").append('<tr><td><input type="checkbox" name="model_id[]" value="'+item.id+','+id+'" /></td>'+
                    '<td>'+item.name+'</td>'+
                    '<td><select name="type_of_use[]" class="SpecificInput select2">'+
                    '<option value="private"> خاص</option>'+
                    '<option value="rent"> أجرة</option>'+
                    '</select></td>'+
                     '<td><input type="text" name="price[]"></td>'+
                    '<td><input type="text" name="firstinterval[]"></td>'+
                    '<td><input type="text" name="secondinterval[]"></td>'+
                    '<td><input type="text" name="thirdinterval[]"></td>'+
                    '</tr>');

                });

            });
        });
    });
</script>

<script>
    // $(document).ready(function(){
    //     $('.brandChangeedit').change(function(){
    //       $.ajax({
    //           url: "{{url('/')}}/view/childerns/"+$(this).val(),
    //           context: document.body
    //         }).done(function(data) {
    //             $('.modelChangeedit').find('option').remove().end();
    //             $.each(data,function(i,item){
    //                 $('.modelChangeedit').append('<option value="'+item.id+'">'+item.name+'</optin>')
    //             });

    //         });
    //     });
    // });
</script>






 <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
 <script>tinymce.init({selector:'textarea'});</script>

@endsection
