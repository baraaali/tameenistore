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
                إرسال إشعار للإعضاء 
            </h5>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
               <form id="notification" action="{{route('user-notifications.post-send')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label for="to">إرسال إلى</label>
                        <div class="d-flex">
                            <label form="single" class="d-inline-block">
                                فرد
                                <input checked type="radio" value="single" id="single" name="to_target" >
                            </label>
                            <label class="d-inline-block" for="group">
                                مجموعة
                                <input type="radio" value="group" id="group" name="to_target" >
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="subject">موضوع الرسالة</label>
                          <input type="text" class="form-control" id="subject" name="subject" placeholder="موضوع الرسالة">
                        </div>
                    </div>
                </div>
                <div class="target-single">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="username">{{__('site.to')}} </label>
                            <select value="" class="form-control select2" name="user_id" id="user_id"> 
                                <option value="" selected >{{__('site.user name')}}</option>
                                @foreach($users as $user)
                                  <option value="{{$user->id}}">
                                      {{$user->name}} - {{$user->email}}
                                  </option>
                              @endforeach
                            </select>
                         </div>
                      </div>
                    </div>
                </div>
                 <div class="target-group d-none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id">{{__('site.country')}}</label>
                               <select class="form-control" name="country_id" id="country_id">
                                   <option value="">الكل</option>
                                   @foreach ($countries as $country)
                                   <option value="{{$country->id}}">{{$country->ar_name}}</option>
                                   @endforeach
                               </select>
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                             <label for="type">نوع العضو</label>
                              <select class="form-control" name="type" id="type">
                                <option value="">الكل</option>
                                <option value="0">مستخدم</option>
                                <option value="2">  معارض السيارات (بيع -شراء)</option>
                                <option value="3">وكالة  تأجير</option>
                                <option value="4">شركه تامين بالعموله _ مكتب تامين بالعموله</option>
                              </select>
                            </div>
                        </div>
                    </div>
                <div class="row d-none count">
                    <div class="col-md-12">
                        <label >الفئة المستهدفة</label>
                        <h5 class="p-3 border text-success">سيتم إرسال الرسالة ل <strong>0</strong> عضو </h5>
                    </div>
                </div>
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
                           <button type="button" class="btn submit btn-primary">إرسال</button>
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
    var csrf =  $('meta[name="csrf-token"]').attr('content');
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
    
        var submitForm = function(){
        $('.submit').on('click',function(){
            $('[name="body"]').val(editor.getData())
            $('#notification').submit()
        })
       }
        var getUsersCount  = function(){
            var getCount = function()
            {
            var conditions = {}
           var country_id = $('#country_id').val()
           var type = $('#type').val()
           if(country_id != '')  conditions['country_id'] = country_id
           if(type != '')  conditions['type'] = type
           console.log(conditions);
             $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url:"{{route('user-notifications.get-user-count')}}",
                type:'post',
                data:{conditions:conditions},
                success:function(count)
                {
                    $('.count').removeClass('d-none');
                    $('.count strong').html(count)
                }
            });
            }
            getCount()
           $('#type,#country_id').on('change',function(){getCount()})
        }

    function selectTarget()
    {
        $('input[name="to_target"]').on('change',function(){
           if($(this).val() === 'group')
           {
               $('.target-group').removeClass('d-none')
               $('.target-single').addClass('d-none')
           }
           else{
            $('.target-group').addClass('d-none')
            $('.target-single').removeClass('d-none')
           }
        })
    }
    $(document).ready(function(){
        submitForm()
        getUsersCount()
        selectTarget()
    })
  
</script>

@endsection