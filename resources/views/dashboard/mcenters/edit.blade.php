@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			مراكز الصيانة
		</h5>
		<a href="{{route('centers')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i>
		</a>
		<a href="#"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<form method="POST" action="{{route('centers-update')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id" value="{{$center->id}}">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label>
							إسم الدولة أو المنطقة <small class="text-danger">*</small>
						</label>
						<select class="SpecificInput select2" name="country_id">
							@foreach($countries as $country)
								<option value="{{$country->id}}" {{$center->country_id == $country->id ? 'selected' : ''}}>
									{{$country->ar_name}} - {{$country->en_name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>
							إسم المركز بالعربية <small class="text-danger">*</small>
						</label>
						<input type="text"   value="{{$center->ar_name}}" required="required" name="ar_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 أرقام الهاتف
						</label>
						<input type="text" value="{{$center->phones}}" name="phones" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							وصف المركز بالعربية <small class="text-danger">*</small>
						</label>
						<textarea name="ar_address"  class="SpecificInput" rows="3" required="required">{{$center->ar_address}}</textarea>
					</div>

					<div class="form-group">
						<label>
							 صورة المركز <small class="text-danger">*</small>
						</label>
						<input type="file" name="image" class="SpecificInput">
						<img src="{{url('/')}}/uploads/{{$center->image}}" style="width: auto;height: 100px;">
					</div>

				</div>

				<div class="col-md-2">

				</div>

				<div class="col-md-5">

					<div class="form-group">
						<label>
							إسم المركز   بالانجليزية <small class="text-danger">*</small>
						</label>
						<input type="text" value="{{$center->en_name}}"  required="required" name="en_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							وصف المركز   بالانجليزية <small class="text-danger">*</small>
						</label>
						<textarea name="en_address" class="SpecificInput" rows="3" required="required">{{$center->en_address}}</textarea>
					</div>
					<div class="form-group">
						<label>
							 تضمين الخريطة - Google Map
						</label>
						<input type="text" name="google_map" value="{{$center->google_map}}"  class="SpecificInput">
					</div>

					
					<div class="form-group">
						<label>
							 مواعيد العمل
						</label>
						<button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-times">
							تعديل مواعيد العمل
						  </button>
						  <div class="div-times">
							  @foreach ($times as $time)
							  <div class="d-flex justify-content-between mt-3">
								<div class="p-2 ml-1 bg-info text-white col-md-4">{{__('site.'.$time->day)}}</div>
								<div class="p-2  ml-1  bg-info text-white col-md-4">{{$time->start_time}}</div>
								<div class="p-2   ml-1 bg-info text-white col-md-4">{{$time->end_time}}</div>
								</div>
							  @endforeach
						  </div>
						
					</div>
 
					<div class="form-group">
						<label>
							 الخدمات المقدمة 
						</label>
						<button type="button" class="btn btn-primary w-100 d-block" data-toggle="modal" data-target="#modal-services">
							تعديل الخدمات المقدمة 
						  </button>
						  <div class="div-services">
							  @if ($center->getCategory())
							  <div class="w-100  mt-3">
								<div class="p-2 ml-1 bg-info text-white">  {{__('site.section')}}   :{{$center->getCategory()}}</div>
					      	 </div>
							  @endif
							  @if ($center->getStore)
							  <div class="w-100  mt-3">
								<div class="p-2 ml-1 bg-info text-white">  {{__('site.store name')}}   : {{$center->getStore->ar_name}}</div>
						     </div>
							  @endif
						  </div>
						
					</div>



					<div class="form-group">
						<label>
							   الحالة
						</label>
						<select class="SpecificInput" name="status" >
							<option value="1" {{$center->status == 1 ? 'selected' : ''}}> نشط  </option>
							<option value="0" {{$center->status == 0 ? 'selected' : ''}}> غير نشط </option>
						</select>
					</div>

					<div class="form-group">
						<label>
							نوع العضوية
						</label>
						<select class="SpecificInput select3" value="{{$center->special}}"  name="special"  id="special">
							@foreach ($center->getServiceMemberShips() as $ms)
							<option value="{{$ms->id}}">{{$ms->ar_name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<input type="submit" name="submit" value="حفظ " class="btn btn-dark " style="float: left;">
					</div>








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
						<option value="">{{__('site.choose')}}</option>
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

  {{-- range time modal --}}
  <div class="modal fade" id="modal-services" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title"> تعديل مجال العمل</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
					 <div class="form-group">
						 <label for="category">  القسم  </label>
						 <select value="" class="form-control select2" name="category" id="category"> 
						   @foreach($categories as $category)
							   <option value="{{$category->id}}">
								   {{$category->ar_name}}
							   </option>
						   @endforeach
						 </select>
					  </div>
					</div>
					<div class="col-md-4">
					 <div class="form-group">
						 <label for="sub_category">  القسم الفرعي  </label>
						 <select disabled value="" class="form-control select2"    name="sub_category" id="sub_category"> 
							 <option value="">{{__('site.choose')}}</option>
						 </select>
					  </div>
					</div>
					<div class="col-md-4">
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
</div>



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
			  getStores()

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
			  getStores()

		 }
	 })
	 })
	 $('#sub_category').trigger('change')
 }
 var getStores = function(){
	 $("#store").prop('disabled',true)
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
		 },
	  
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
	 $('.div-services').html(html)
	 $('.modal .close').click()
	 getServiceMemberShip()
	  }
 }
 var getServiceMemberShip = function(){
	 $("#store").prop('disabled',true)
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
		 url: "/dashboard/service_member_ships/get",
		 success: function(data){
			 $('#special').html('');
			 console.log(data);
			 console.log(name);
			if(data.length)
			{
			  data.forEach(e => {
				  $('#special').append('<option value="'+e.id+'">'+e[name]+'</option>')
			  });
			 //  $("#special").prop('disabled',false)
			}
			 //  $("#store").prop('disabled',true)
		 },
	  
	 })
 }
 $(document).ready(function(){
	 // events
	 $('#add-new-time').on('click',addNewTime)
	 $(document).on('click','.remove',removeRowTime)
	 $('.save-times').on('click',saveTimes)
	 $('.save-services').on('click',saveServices)
	 getSubCategories()
	 getChildCategories()
	 getStores()

 
 })

</script>
 <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script > tinymce.init({selector: 'textarea'});</script>
@endsection
