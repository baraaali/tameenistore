@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			المعارض
		</h5>
		<a href="{{route('exhibitors')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i> 
		</a>
		<a href="#"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<form method="POST" action="{{route('exhibitors-update')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id" value="{{$exhibitor->id}}">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label>
							إسم الدولة أو المنطقة <small class="text-danger">*</small>
						</label>
						<select class="SpecificInput" name="country_id">
							@foreach($countries as $country)
								<option value="{{$country->id}}" {{$exhibitor->country_id == $country->id ? 'selected' : ''}}>
									{{$country->ar_name}} - {{$country->en_name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>
							إسم المعرض بالعربية <small class="text-danger">*</small>
						</label>
						<input type="text"   value="{{$exhibitor->ar_name}}" required="required" name="ar_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 أرقام الهاتف  
						</label>
						<input type="text" value="@foreach($exhibitor->phones as $key=>$phone){{$phone->phone}}@if($key != count($exhibitor->phones)-1)-@endif @endforeach" name="phones" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput"> 
					</div>
					<div class="form-group">
						<label>
							وصف المعرض بالعربية <small class="text-danger">*</small>
						</label>
						<textarea name="ar_description"  class="SpecificInput" rows="3" >{{$exhibitor->ar_description}}</textarea> 
					</div>

					<div class="form-group">
						<label>
							 صورة المعرض <small class="text-danger">*</small>
						</label>
						<input type="file" name="image" class="SpecificInput"> 
						<img src="{{url('/')}}/uploads/{{$exhibitor->image}}" style="width: auto;height: 100px;">
					</div>

					<div class="form-group">
						<label>
							 صفحة الفيس بوك 
						</label>
						<input type="text" name="fb_page" value="{{$exhibitor->fb_page}}" class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 إنستجرام  
						</label>
						<input type="text" name="insta_page" value="{{$exhibitor->instagram}}"  class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 تويتر  
						</label>
						<input type="text" name="twitter_page" value="{{$exhibitor->twitter_page}}"  class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 البريد الالكتروني  
						</label>
						<input type="email" name="email" value="{{$exhibitor->email}}"  class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 موقع الالكتروني  
						</label>
						<input type="text" name="website" value="{{$exhibitor->website}}"  class="SpecificInput"> 
					</div>




				</div>

				<div class="col-md-2">
					
				</div>

				<div class="col-md-5">
					
					<div class="form-group">
						<label>
							إسم المعرض   بالانجليزية <small class="text-danger">*</small>
						</label>
						<input type="text" value="{{$exhibitor->en_name}}"  required="required" name="en_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							وصف المعرض   بالانجليزية <small class="text-danger">*</small>
						</label>
						<textarea name="en_description" class="SpecificInput" rows="3" >{{$exhibitor->en_description}}</textarea> 
					</div>
					<div class="form-group">
						<label>
							 تضمين الخريطة - Google Map  
						</label>
						<input type="text" name="google_map" value="{{$exhibitor->google_map}}"  class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 ايام العمل  
						</label>
						<input type="text" value="{{$exhibitor->days_on}}"  placeholder="السبت إلي الاربعاء"  name="days_on" class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							 مواعيد العمل  
						</label>
						<input type="text" placeholder="9 : 10 AM"  value="{{$exhibitor->times_on}}"  name="times_on" class="SpecificInput"> 
					</div>

					<div class="form-group">
						<label>
							  أنواع السيارات  
						</label>
						<select class="SpecificInput" name="car_types" >
							<option value="2" {{$exhibitor->cartypes == 2 ? 'selected' : ''}}> جديد  </option>
							<option value="1" {{$exhibitor->cartypes == 1 ? 'selected' : ''}}> مستعمل </option>
							<option value="0" {{$exhibitor->cartypes == 0 ? 'selected' : ''}}> كلاهما </option>
						</select>
					</div>


					<div class="form-group">
						<label>
							   الحالة  
						</label>
						<select class="SpecificInput" name="status" >
							<option value="1" {{$exhibitor->status == 1 ? 'selected' : ''}}> نشط  </option>
							<option value="0" {{$exhibitor->status == 0 ? 'selected' : ''}}> غير نشط </option>
						</select>
					</div>

					<div class="form-group">
						<label>
							نوع العضوية
						</label>
						<select class="SpecificInput" name="specific">
							<option value="0" {{$exhibitor->special == 0 ? 'selected' : ''}}> عادية </option>
							<option value="1" {{$exhibitor->special == 1 ? 'selected' : ''}}> فضية  </option>
							<option value="2" {{$exhibitor->special == 2 ? 'selected' : ''}}> ذهبية </option>
							<option value="3" {{$exhibitor->special == 3 ? 'selected' : ''}}> مميزة </option>
						</select>
					</div>

					<div class="form-group">
						<input type="submit" name="submit" value="حفظ " class="btn btn-dark " style="float: left;">
					</div>


					

					

					

				</div>
			</div>
		</form>
	</div>
</div>


@endsection