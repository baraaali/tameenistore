@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			وكالات التأمين
		</h5>
		<a href="{{route('insurnaces.index')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i>
		</a>
{{--		<a href="#"  class="btn btn-light"  style="float: left" >--}}
{{--			   <i class="fas fa-trash"></i>--}}
{{--		</a>--}}
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<form method="POST" action="{{route('insurnaces.store')}}" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-5">
                    <div class="form-group">
                        <label>
                            إسم الوسيط التأمينى <small class="text-danger">*</small>
                        </label>
                        <input type="text" required="required" name="user_name" maxlength="191" class="SpecificInput">
                    </div>
                    <div class="form-group">
                        <label>
                            البريد الالكتروني <small class="text-danger">*</small>
                        </label>
                        <input type="email" required="required" name="user_email" maxlength="191" class="SpecificInput">
                    </div>
                    <div class="form-group">
                        <label>
                            إسم الدولة أو المنطقة <small class="text-danger">*</small>
                        </label>
                        <select class="SpecificInput select2" name="country_id">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->ar_name}} - {{$country->en_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
					<div class="form-group">
						<label>
							إسم الوكالة بالعربية <small class="text-danger">*</small>
						</label>
						<input type="text" required="required" name="ar_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 أرقام الهاتف
						</label>
						<input type="text" name="phones" ninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							عنوان الوكالة بالعربية <small class="text-danger">*</small>
						</label>
						<input name="ar_address" class="SpecificInput"  >
					</div>
					<div class="form-group">
						<label>
							 صورة الوكالة <small class="text-danger">*</small>
						</label>
						<input type="file" name="image" class="SpecificInput" required="required">
					</div>
					<div class="form-group">
						<label>
							 البريد الالكتروني
						</label>
						<input type="email" name="email" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 موقع الالكتروني
						</label>
						<input type="text" name="website" class="SpecificInput">
					</div>
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-5">
                    <div class="form-group">
                        <label>
                            كلمة المرور
                        </label>
                        <input type="password" name="password" class="SpecificInput">
                    </div>
                    <div class="form-group">
                        <label>
                            إعد كلمة المرور
                        </label>
                        <input type="password" name="password_confirmation" class="SpecificInput">
                    </div>
					<div class="form-group">
						<label>
							إسم الوكالة   بالانجليزية <small class="text-danger">*</small>
						</label>
						<input type="text" required="required" name="en_name" maxlength="191" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							عنوان الوكالة   بالانجليزية <small class="text-danger">*</small>
						</label>
						<input name="en_address" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 تضمين الخريطة - Google Map
						</label>
						<input type="text" name="google_map" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 ايام العمل
						</label>
						<input type="text" placeholder="السبت إلي الاربعاء"  name="days_on" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							 مواعيد العمل
						</label>
						<input type="text" placeholder="9 : 10 AM"  name="times_on" class="SpecificInput">
					</div>
					<div class="form-group">
						<label>
							   الحالة
						</label>
						<select class="SpecificInput" name="status" >
							<option value="1"> نشط  </option>
							<option value="0"> غير نشط </option>
						</select>
					</div>
					<div class="form-group">
{{--						<label>--}}
{{--							نوع العضوية--}}
{{--						</label>--}}
{{--						<select class="SpecificInput" name="special">--}}
{{--							<option value="0"> عادية </option>--}}
{{--							<option value="1"> فضية  </option>--}}
{{--							<option value="2"> ذهبية </option>--}}
{{--							<option value="3"> مميزة </option>--}}
{{--						</select>--}}
					</div>

				</div>
			</div>
            <div class="row">
                <div class="form-group">
                    <input type="submit" name="submit" value="حفظ " class="btn btn-primary text-center">
                </div>
            </div>
		</form>
	</div>
</div>


@endsection
