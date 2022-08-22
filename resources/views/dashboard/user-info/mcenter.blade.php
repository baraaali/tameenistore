
@include('dashboard.user-info.user-info')

<div class="col-md-12">
<h3 class="mb-3  py-3 border-bottom">
    <i class="fa fa-info-circle" aria-hidden="true"></i>

    @if(app()->getLocale() == 'ar')
    تعديل بيانات المركز
    @else
    Edit Center Information
    @endif
</h3>
<form action="{{route('account-info')}}" method="post" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-md-5">
    
            <div class="form-group">
                <label>
                    إسم المركز بالعربية <small class="text-danger">*</small>
                </label>
                <input type="text" required="required"   name="ar_name"  value="@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->ar_name}}  @else {{old('ar_name')}} @endif" maxlength="191" class="SpecificInput">
                <input type="hidden"  name="id" value="@if(isset(auth()->user()->mcenter)){{auth()->user()->mcenter->id}}@endif">
            </div>
            <div class="form-group">
                <label>
                     أرقام الهاتف
                </label>
                <input type="text" name="phones" value="@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->phones}}  @else {{old('phones')}} @endif" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                    عنوان المركز بالعربية <small class="text-danger">*</small>
                </label>
                <textarea name="ar_address"  class="SpecificInput" rows="3" required="required">@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->ar_address}}  @else {{old('ar_address')}} @endif</textarea>
            </div>
    
            <div class="form-group">
                <label>
                     صورة المركز <small class="text-danger">*</small>
                </label>
                <input type="file" name="image" 
                 value="@if((auth()->
                 user()->mcenter && auth()->
                user()->mcenter->image ))
                {{auth()-> user()->mcenter->image}}
                @endif"  
                class="SpecificInput" 
               
                >
                
                @if(isset(auth()->user()->mcenter )&& isset(auth()->user()->mcenter->image) )
                <img width="150px" src="{{url('/')}}/uploads/{{auth()->user()->mcenter->image}}">
                @endif
            </div>
    
            <div class="form-group">
                 وصف بالعربي <small class="text-danger">*</small>
              <textarea required class="form-control" name="ar_description" rows="3">@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->ar_description}}  @else {{old('ar_description')}} @endif</textarea>
            </div>
            <div class="form-group">
                وصف بالأنجليزي <small class="text-danger">*</small>
             <textarea required class="form-control" name="en_description" rows="3">@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->en_description}}  @else {{old('en_description')}} @endif</textarea>
           </div>
    
    

        </div>
    
        <div class="col-md-2">
    
        </div>
    
        <div class="col-md-5">
    
            <div class="form-group">
                <label>
                    إسم المركز   بالانجليزية <small class="text-danger">*</small>
                </label>
                <input type="text" required="required" value="@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->en_name}}  @else {{old('en_name')}} @endif"  name="en_name" maxlength="191" class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                    عنوان المركز   بالانجليزية <small class="text-danger">*</small>
                </label>
                <textarea name="en_address"  class="SpecificInput" rows="3" required="required">@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->en_address}}  @else {{old('en_address')}} @endif"</textarea>
            </div>
            <div class="form-group">
                <label>
                     تضمين الخريطة - Google Map
                </label>
                <input type="text" name="google_map"  value="{{old('google_map')}}" class="SpecificInput">
            </div>
    
            <div class="form-group">
                <label>
                     مواعيد العمل
                </label>
                <button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-times">
                    تحديد مواعيد العمل
                  </button>
                  <div class="div-times">
                      @if (auth()-> user()->mcenter)
                    @foreach (auth()->user()->mcenter->times as $item)
                    <div class="d-flex justify-content-between mt-3">
                      <div class="p-2 ml-1 bg-info text-white col-md-4">{{__('site.'.$item->day)}}</div>
                      <div class="p-2  ml-1  bg-info text-white col-md-4">{{$item->start_time}}</div>
                      <div class="p-2   ml-1 bg-info text-white col-md-4">{{$item->end_time}}</div>
                    </div>
                    <input name="day[]" type="hidden" value="{{$item->day}}">
                    <input name="start_time[]" type="hidden"  value="{{$item->start_time}}">
                    <input name="end_time[]" type="hidden"  value="{{$item->end_time}}">
                    @endforeach
                    @endif

                  </div>
               
                
            </div>
            
            <div class="form-group">
                <label>             
                    تحديد مجال العمل   
                </label>
                <button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-services-field">
                    تحديد  مجال العمل 
                  </button>
                  <div class="div-services-field">
                    @if (auth()->user()->mcenter)

               <div class="w-100 mt-3">
                        <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : {{auth()->user()->mcenter->getCategory()}}</div>
                        </div>
                        <div class="w-100  mt-3">
                            <div class="p-2 ml-1 bg-info text-white">  {{__('site.store name')}}   : {{auth()->user()->mcenter->getStore->getName()}}</div>
                     </div>
                 </div>
                @endif
            </div>
    
            <div class="form-group">
                <label>
                       الحالة
                </label>
                <select class="SpecificInput" name="status" value="@if(isset(auth()->user()->mcenter)) {{auth()->user()->mcenter->status}}  @else {{old('status')}} @endif" >
                    <option value="1"> نشط  </option>
                    <option value="0"> غير نشط </option>
                </select>
            </div>
    
    
    
            <div class="form-group">
                <label>
                    نوع العضوية
                </label>
                <select class="SpecificInput select3" name="special"  value="{{old('special')}}" id="special">
                    <option value="">{{__('site.choose')}}</option>
                </select>
            </div>
            @if(auth()->user()->mcenter)
            <div class="p-2 bg-white border my-3">
                <div class="my-2">
                    <strong>سعر العضوية  : </strong>
                     <strong> {{auth()->user()->mcenter->serviceMemberShip->price}} {{__('site.$')}} </strong>
                </div>
                <div class="my-2">
                    <strong>عدد الخدمات   : </strong>
                     <strong> {{auth()->user()->mcenter->serviceMemberShip->ads_number}}  </strong>
                </div>
            </div>
            @endif

    
    
        </div>
        <div class="col-md-12">
            <button type="submit"  class="btn btn-primary btn-lg btn-block">{{__('site.save')}}</button>
        </div>
    </div>
    
    
    {{-- range time modal --}}
    <div class="modal fade" id="modal-times" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">أوقات وأيام العمل</h5>
                </div>
                <div class="modal-body">
                   <div class="row position-relative new-time">
                       <div class="col-md-4">
                        <div class="form-group">
                            <label>اليوم</label>
                          <select name="day[]" class="form-control" >
                            <option value="all_days">{{__('site.all_days')}}</option>
                            <option value="sunday">{{__('site.sunday')}}</option>
                            <option value="monday">{{__('site.monday')}}</option>
                            <option value="tuesday">{{__('site.tuesday')}}</option>
                            <option value="wednesday">{{__('site.wednesday')}}</option>
                            <option value="thursday">{{__('site.thursday')}}</option>
                            <option value="friday">{{__('site.friday')}}</option>
                            <option value="saturday">{{__('site.saturday')}}</option>
                          </select>
                        </div>
                       </div>
                       <div class="col-md-4">
                        <label>من</label>
                        <div class="form-group">
                            <input name="start_time[]"  type="time" class="form-control" >
                          </div>
                       </div>
                       <div class="col-md-4">
                        <label>إلى</label>
                        <div class="form-group">
                            <input name="end_time[]"  type="time" class="form-control" >
                          </div>
                       </div>
                   </div>
                </div>
                <button type="button" id="add-new-time" class="btn btn-primary">{{__('site.add new time')}}</button>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                    <button type="button" class="btn btn-primary save-times">{{__('site.save')}}</button>
                </div>
            </div>
        </div>
    </div>
    
     {{--  modal-services-field  modal --}}
     <div class="modal fade" id="modal-services-field" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title"> تحديد مجال العمل</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                         <div class="form-group">
                             <label for="category">  القسم  </label>
                             <select value="" class="form-control select2" name="category" id="category"> 
                               @foreach($categories as $category)
                                   <option @if(auth()->user()->mcenter &&  auth()->user()->mcenter->sub_category == $category->id) selected  @endif value="{{$category->id}}">
                                       {{$category->ar_name}}
                                   </option>
                               @endforeach
                             </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                         <div class="form-group">
                             <label for="sub_category">  القسم الفرعي  </label>
                             <select disabled value="" class="form-control select2"    name="sub_category" id="sub_category"> 
                                 <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                         <div class="form-group">
                             <label for="child_category">  القسم الفرع فرعي   </label>
                             <select disabled value="" class="form-control select2" name="child_category" id="child_category"> 
                               <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="store">   إسم المحل   </label>
                                <select disabled value="" class="form-control select2" name="store" id="store"> 
                                  <option value="">{{__('site.choose')}}</option>
                                </select>
                             </div>
                         </div>
                     </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                    <button type="button" class="btn btn-primary save-services">{{__('site.save')}}</button>
                </div>
            </div>
        </div>
    </div>
    
     
    
</form>
</div>
@section('js')
<script>
    var getSubCategories = function(){
     $('#category').on('change',function(){
      var id = $(this).val()
     $.ajax({
         type: "get",
         dataType: "json",
         url: "/dashboard/service_categories/get-childrens/"+id,
         success: function(data){
             $('#sub_category').html('');
            if(data.length)
            {
              data.forEach(e => {
                  $('#sub_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
              });
              $("#sub_category").prop('disabled',false)
            }else
              $("#sub_category").prop('disabled',true)
              $('#sub_category').trigger('change')

         },error :function(error){
             console.log(error)
         }
         
     })
     })
     $('#category').trigger('change')
 }
 var saveTimes = function(){
         $days  = $('select[name="day[]"]')
         $start_times  = $('input[name="start_time[]"]')
         $end_times  = $('input[name="end_time[]"]')
         var html = ''
         var errors = {}
         for (let i = 0; i < $days.length; i++) {
             const day = $($days[i]).find('option:selected').html();
             const start_time = $($start_times[i]).val();
             const end_time = $($end_times[i]).val();
             $($start_times[i]).parent().find('.error').remove()
             $($end_times[i]).parent().find('.error').remove()
             if(!start_time) {
              $($start_times[i]).after('<div class="text-danger error">{{__("site.required")}}</div>')
              errors['start_time'] = true
             }
             if(!end_time) {
              $($end_times[i]).after('<div class="text-danger error">{{__("site.required")}}</div>')
               errors['end_time'] = true
             }
             if(start_time && end_time)
             html += `<div class="d-flex justify-content-between mt-3">
             <div class="p-2 ml-1 bg-info text-white col-md-4">`+day +`</div>
             <div class="p-2  ml-1  bg-info text-white col-md-4">`+start_time+`</div>
             <div class="p-2   ml-1 bg-info text-white col-md-4">`+end_time+`</div>
             </div>`
         }
         if(!Object.keys(errors).length) {
         $('.div-times').html(html)
         $('.modal .close').click()
         }
     }
     var removeRowTime = function()
     {
         $(this).parent().remove()
     }
     var clearElement = function($e)
     {
         $($e).find('input').val('')
     }
     var addNewTime = function()
     {
         $new = $('.new-time').clone()[0]
         $($new).removeClass('new-time')
         clearElement($new)
         $($new).append('<div class="remove text-danger mr-2"></div>')
         $('.new-time').parent().append($new)
     }
 var getChildCategories = function(){
     $('#sub_category').on('change',function(){
      var id = $(this).val()
     $.ajax({
         type: "get",
         dataType: "json",
         url: "/dashboard/service_sub_categories/get-childrens/"+id,
         success: function(data){
             $('#child_category').html('');
            if(data.length)
            {
              data.forEach(e => {
                  $('#child_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
              });
              $("#child_category").prop('disabled',false)
            }else
              $("#child_category").prop('disabled',true)

         }
     })
     })
     $('#sub_category').trigger('change')
 }
 var getStores = function(){
       var data = {}
       data['category'] = !$('#category').is(':disabled') ? $('#category').val() : null
       data['sub_category'] =  !$('#sub_category').is(':disabled') ? $('#sub_category').val() : null
       data['child_category'] =  !$('#child_category').is(':disabled') ? $('#child_category').val() : null
        var name = "{{app()->getLocale()}}"+"_name"
       $.ajax({
         type: "post",
         dataType: "json",
         data:data,
         headers: {'X-CSRF-TOKEN': csrf},
         url: "/dashboard/store/get",
         success: function(data){
             $('#store').html('');
            if(data.length)
            {
              data.forEach(e => {
                  $('#store').append('<option value="'+e.id+'">'+e[name]+'</option>')
              });
              $("#store").prop('disabled',false)
            }else
              $("#store").prop('disabled',true)
         }
      
     })
 }
 var saveServices = function()
 {
     var category = !$('#category').is(':disabled') ? $('#category').find('option:selected').html() : null
     var sub_category =  !$('#sub_category').is(':disabled') ? $('#sub_category').find('option:selected').html() : null
     var child_category =  !$('#child_category').is(':disabled') ? $('#child_category').find('option:selected').html() : null
     var store =  !$('#store').is(':disabled') ? $('#store').find('option:selected').html() : null
     var name = "{{app()->getLocale()}}"+"_name"
     var html = ''
     if(child_category)
     html = `<div class="w-100 mt-3">
             <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+child_category +`</div>
             </div>`
     else  if(sub_category)
     html = `<div class="w-100  mt-3">
             <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+sub_category +`</div>
      </div>`
     else
     html = `<div class="w-100  mt-3">
             <div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   : `+category +`</div>
      </div>`
      if(store)
      html += `<div class="w-100  mt-3">
             <div class="p-2 ml-1 bg-info text-white">  {{__('site.store name')}}   : `+store +`</div>
      </div>`
      if(html.length){
     $('.div-services-field').html(html)
     $('.modal .close').click()
     getServiceMemberShip()
      }
 }
 var getServiceMemberShip = function(update = false){
       const mcenter_category = @if(auth()->user()->mcenter) "{{auth()->user()->mcenter->category}}"  @endif;
       const mcenter_sub_category = @if(auth()->user()->mcenter) "{{auth()->user()->mcenter->sub_category}}"  @endif;
       const mcenter_child_category = @if(auth()->user()->mcenter) "{{auth()->user()->mcenter->child_category}}"  @endif;
       const membership = @if(auth()->user()->mcenter) "{{auth()->user()->mcenter->special}}"  @endif;
       const data = {}
       if(update){
           data['category'] = mcenter_category;
           data['sub_category'] = mcenter_sub_category;
           data['child_category'] = mcenter_child_category;
       }else{
           data['category'] = !$('#category').is(':disabled') ? $('#category').val() : null
           data['sub_category'] =  !$('#sub_category').is(':disabled') ? $('#sub_category').val() : null
           data['child_category'] =  !$('#child_category').is(':disabled') ? $('#child_category').val() : null
        }
        var name = "{{app()->getLocale()}}"+"_name"
       $.ajax({
         type: "post",
         dataType: "json",
         data:data,
         headers: {'X-CSRF-TOKEN': csrf},
         url: "/dashboard/service_member_ships/get",
         success: function(data){
             $('#special').html('');
             console.log(data);
             console.log(name);
            if(data.length)
            {
                data.forEach(e => {
                  const selected = membership == e.id ? 'selected' : '';
                  $('#special').append('<option '+selected+' value="'+e.id+'">'+e[name]+'</option>')
              });
              $("#special").prop('disabled',false)
            }else
               $("#special").prop('disabled',true)
         },
      
     })
 }
 $(document).ready(function(){
     // events
     $('#add-new-time').on('click',addNewTime)
     $(document).on('click','.remove',removeRowTime)
     $('.save-times').on('click',saveTimes)
     $('.save-services').on('click',saveServices)
     $('#category,#sub_category,#child_category').on('change',function(){
         setTimeout(getStores,1000)
     });
     getSubCategories()
     getChildCategories()
     getStores()
     getServiceMemberShip(true)

 
 })
</script>
@endsection