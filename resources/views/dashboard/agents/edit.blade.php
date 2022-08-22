@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			الوكالات
		</h5>
		<a href="{{route('agents',['type'=>$agent->agent_type])}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i>
		</a>
		<a href="#"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<form method="POST" action="{{route('agents-update')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id" value="{{$agent->id}}">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label>
							إسم الدولة أو المنطقة <small class="text-danger">*</small>
						</label>
						<select class="SpecificInput select2" name="country_id">
							@foreach($countries as $country)
								<option value="{{$country->id}}" {{$agent->country_id == $country->id ? 'selected' : ''}}>
									{{$country->ar_name}} - {{$country->en_name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>
							إسم الوكالة بالعربية <small class="text-danger">*</small>
						</label>
						<input type="text"   value="{{$agent->ar_name}}" required="required" name="ar_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 أرقام الهاتف
						</label>
						<input type="text" value="{{$agent->phones}}" name="phones" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							وصف الوكالة بالعربية <small class="text-danger">*</small>
						</label>
						<textarea name="ar_address"  class="SpecificInput" rows="3" required="required">{{$agent->ar_address}}</textarea>
					</div>

					<div class="form-group">
						<label>
							 صورة الوكالة <small class="text-danger">*</small>
						</label>
						<input type="file" name="image" class="SpecificInput">
						<img src="{{url('/')}}/uploads/{{$agent->image}}" style="width: auto;height: 100px;">
					</div>

					<div class="form-group">
						<label>
							 صفحة الفيس بوك
						</label>
						<input type="text" name="fb_page" value="{{$agent->fb_page}}" class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 إنستجرام
						</label>
						<input type="text" name="insta_page" value="{{$agent->instagram}}"  class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 تويتر
						</label>
						<input type="text" name="twitter_page" value="{{$agent->twitter_page}}"  class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 البريد الالكتروني
						</label>
						<input type="email" name="email" value="{{$agent->email}}"  class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 موقع الالكتروني
						</label>
						<input type="text" name="website" value="{{$agent->website}}"  class="SpecificInput">
					</div>




				</div>

				<div class="col-md-2">

				</div>

				<div class="col-md-5">

					<div class="form-group">
						<label>
							إسم الوكالة   بالانجليزية <small class="text-danger">*</small>
						</label>
						<input type="text" value="{{$agent->en_name}}"  required="required" name="en_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							وصف الوكالة   بالانجليزية <small class="text-danger">*</small>
						</label>
						<textarea name="en_address" class="SpecificInput" rows="3" required="required">{{$agent->en_address}}</textarea>
					</div>
					<div class="form-group">
						<label>
							 تضمين الخريطة - Google Map
						</label>
						<input type="text" name="google_map" value="{{$agent->google_map}}"  class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 ايام العمل
						</label>
						<input type="text" value="{{$agent->days_on}}"  placeholder="السبت إلي الاربعاء"  name="days_on" class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							 مواعيد العمل
						</label>
						<input type="text" placeholder="9 : 10 AM"  value="{{$agent->times_on}}"  name="times_on" class="SpecificInput">
					</div>

					<div class="form-group">
						<label>
							  أنواع السيارات
						</label>
						<select class="SpecificInput" name="car_types" >
							<option value="2" {{$agent->cartypes == 2 ? 'selected' : ''}}> جديد  </option>
							<option value="1" {{$agent->cartypes == 1 ? 'selected' : ''}}> مستعمل </option>
							<option value="0" {{$agent->cartypes == 0 ? 'selected' : ''}}> كلاهما </option>
						</select>
					</div>
						<div class="form-group">
						<label>
							   نوع الوكالة
						</label>
						<select class="SpecificInput" name="agent_type" >
							<option value="0" {{$agent->agent_type == 0 ? 'selected' : ''}}> بيع   </option>
							<option value="1" {{$agent->agent_type == 1 ? 'selected' : ''}}> إيجار </option>
						</select>
					</div>


					<div class="form-group">
						<label>
							   الحالة
						</label>
						<select class="SpecificInput" name="status" >
							<option value="1" {{$agent->status == 1 ? 'selected' : ''}}> نشط  </option>
							<option value="0" {{$agent->status == 0 ? 'selected' : ''}}> غير نشط </option>
						</select>
					</div>

					<div class="form-group">
						<label>
							نوع العضوية
						</label>
						<select class="SpecificInput" name="specific">
							<option value="0" {{$agent->special == 0 ? 'selected' : ''}}> عادية </option>
							<option value="1" {{$agent->special == 1 ? 'selected' : ''}}> فضية  </option>
							<option value="2" {{$agent->special == 2 ? 'selected' : ''}}> ذهبية </option>
							<option value="3" {{$agent->special == 3 ? 'selected' : ''}}> مميزة </option>
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
