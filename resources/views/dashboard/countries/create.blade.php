@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			البلاد و المناطق
		</h5>
		<a href="{{route('countries')}}" class="btn btn-light"  style="float: left" >
			   <i class="fas fa-angle-left"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		 @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
		<form class="form" action="{{url('/')}}/dashboard/countries/store" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label>
						 تابع إلي
						</label>
						<select class="SpecificInput select2" name="parent">
							<option value="0" selected>
								دولة مستقلة
							</option>
							@foreach($countries as $country)
								<option value="{{$country->id}}">
									{{$country->ar_name}} - {{$country->en_name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>
						   الاسم بالعربية <small class="text-danger">*</small>
						</label>
						<input type="text" name="ar_name" class="SpecificInput" required="required" max="191">
					</div>
					<div class="form-group">
						<label>
						   الكود بالعربية 
						</label>
						<input type="text" name="ar_code" placeholder="مصر" class="SpecificInput"  max="191">
					</div>
					<div class="form-group">
						<label>
						   العملة  بالعربية 
						</label>
						<input type="text" name="ar_currency" placeholder="جنيه مصري" class="SpecificInput"  max="191">
					</div>
					<div class="form-group">
						<label>
						   صورة العلم   
						</label>

						<input type="file" name="image" class="SpecificInput" accept="image/*">
					</div>
					
				</div>
				<div class="col-md-2">
					
				</div>
			<div class="col-md-5">
				
				<div class="form-group">
					<label>
					   الاسم  الانجليزية <small class="text-danger">*</small>
					</label>
					<input type="text" name="en_name" class="SpecificInput" required="required" max="191">
				</div>
				<div class="form-group">
					<label>
					   الكود  الانجليزية 
					</label>
					<input type="text" name="en_code" placeholder="EGY" class="SpecificInput" required="required" max="191">
				</div>
				<div class="form-group">
					<label>
					   العملة   الانجليزية 
					</label>
					<input type="text" name="en_currency" placeholder="EGP" class="SpecificInput" required="required" max="191">
				</div>
				<div class="form-group">
						<input type="checkbox"  name="status" checked value="1" style="position: relative;top:2px;">
						<label>
						     تفعيله  الان
						</label>
						
					</div>
					<div class="form-group">
						<input type="checkbox"  name="stay"  value="1" style="position: relative;top:2px;">
						<label>
						     البقاء في هذه الصفحة بعد الحفظ ؟
						</label>
						
					</div>
				<div class="form-group" >
					<input type="submit" name="submit" value="حفظ  "  class="btn btn-dark" style="float: left">
				</div>
				
			</div>
			</div>

		</form>
	</div>
</div>

@endsection