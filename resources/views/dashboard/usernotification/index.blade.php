@extends('dashboard.layout.app')
@section('css')
<style>
    .ck-content{
    height: 300px !important;
    overflow: auto !important;
    } 
</style>
@endsection
@section('content')
    <div class="card text-white bg-primary shadow">
        <div class="card-header">
            <h5 style="position: relative;display: inline-block;top: 6px;">
                الإشعارات
            </h5>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
               <form id="user-notification" action="{{route('user-notifications.store-auto-notification')}}" method="post">
                @csrf
                <input type="hidden" name="to" value="user">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="purpose">نوع الرسالة</label>
                            <select class="form-control" name="purpose" id="purpose">
                              <option value="welcome_message">الرسالة الترحيبية</option>
                              {{-- <option value="password_recovery">إسترجاع كلمة المرور</option> --}}
                              <option value="add_credit">إضافة الرصيد</option>
                              <option value="balance_discount">خصم الرصيد</option>
                              <option value="new_ad">إعلان جديد</option>
                              <option value="advertisement_expiration_date">إنتهاء تاريخ الاعلان </option>
                              <option value="ad_renewal">تجديد الإعلان</option>
                              <option value="membership_renewal">تجديد العضوية</option>
                              <option value="membership_expiry">إنتهاء العضوية</option>
                              <option value="comprehensive_insurance_request_for_merchants">   طلب تامين شامل للتجار</option>
                              <option value="third_party_insurance_claim_for_traders">  طلب تأمين ضد الغير للتجار    </option>
                              <option value="request_a_rental_car_reservation"> طلب حجز سياراة ايجار</option>
                              <option value="get_mcenter_seller_request"> طلب جديد لمركز الصيانة </option>
                              <option value="get_mcenter_change_request"> تغير حالة طلب مركز الصيانة   </option>
    
                            </select>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="status">تفعيل</label>
                         <input type="checkbox" name="status" id="status">  
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="subject">موضوع الرسالة</label>
                          <input type="text" class="form-control" id="subject" name="subject" placeholder="موضوع الرسالة">
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                          <label for="elements">العناصر</label>
                          <p id="elements"></p>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body">مضمون الرسالة</label>
                                <input type="hidden" name="body">
                                <textarea  class="form-control" id="body">
                                </textarea>
                                </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                           <button type="button" class="btn submit btn-primary">حفظ</button>
                        </div>
                    </div>
                </div>
               </form>
        </div>

    </div>
@endsection()

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script>
    var editor
    ClassicEditor
        .create( document.querySelector( '#body'),{
            language: 'ar'
        }).then(e=>{
            editor = e
        })
        .catch( error => {
            console.error( error );
        } );
    
    var getTemplate = function(purpose){
        if(purpose)
        {
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/dashboard/user-notifications/'+purpose,
                type:'get',
                success : function(response){
                    console.log(response);
                    setTemplate(response)
                }
            }) 
        }
        $('#purpose').on('change',function(){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/dashboard/user-notifications/'+$(this).val(),
                type:'get',
                success : function(response){
                    console.log(response);
                    setTemplate(response)
                }
            })
        })
        $('#status').on('change',function(){
            $('#subject').prop('disabled',!$(this).prop('checked'))
            editor.isReadOnly  = !$(this).prop('checked')
    
        })
    }
    var setTemplate = function(template)
    {
        var subject = ''
        var body = ''
        if( Object.keys(template).length)
        {
            subject = template.subject
            body = template.body
        }

        $('#subject').val(subject);
        editor.setData(body)
        if(template.status === 'active')
        {
            $('#status').prop('checked',true)
            editor.isReadOnly  = false
        }else
        {
            $('#status').prop('checked',false)
            $('#subject').prop('disabled',true)
            editor.isReadOnly  = true
        }

        var elements = getElements($('#purpose').val())
        $('#elements').html(elements.join(' - '))


    }
    var saveTemplate = function(){
        $('.submit').on('click',function(){
            $('[name="body"]').val(editor.getData())
            $('#user-notification').submit()
        })
    }
    
    var getElements = function(purpose)
    {
        switch (purpose) {
            case 'welcome_message':
            return ['[إسم العميل]','[البريد الإلكتروني]','[كلمة المرور]'] 
                break;
            case 'password_recovery':
            return ['[إسم العميل]','[البريد الإلكتروني]','[كلمة المرور الجديدة]']     
                break;
            case 'balance_discount':
            return ['[إسم العميل]','[الرصيد]']    
                break;  
             case 'add_credit':
             return ['[إسم العميل]','[الرصيد]']    
                break;
            case 'new_ad':
            return ['[إسم العميل]','[عنوان الإعلان]']    
                break;
            case 'ad_renewal':
            return ['[إسم العميل]','[عنوان الإعلان]','[عدد الأيام]','[تاريخ الإنتهاء]']    
                break;
            case 'advertisement_expiration_date':
            return ['[إسم العميل]','[عنوان الإعلان]']    
                break;
            case 'membership_renewal':
            return ['[إسم العميل]','[إسم العضوية]','[تاريخ الإنتهاء]']    
                break;
            case 'membership_expiry':
            return ['[إسم العميل]','[إسم العضوية]','[تاريخ الإنتهاء]']    
                break;
            case 'comprehensive_insurance_request_for_merchants':
            return ['[إسم العميل]']    
                break; 
            case 'request_a_rental_car_reservation' :
            return ['[إسم العميل]']    
                break;
            case 'third_party_insurance_claim_for_traders':
            return ['[إسم العميل]']    
                break;
                
        }
    }
    $(document).ready(function(){
        saveTemplate()
        getTemplate('welcome_message')
    })
  
</script>

@endsection