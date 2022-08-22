@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			اعدادات الويب سايت
		</h5>
	</div>
	<?php $websites = \App\Website::where('id',1)->get();?>
	@if($websites)
	@foreach($websites as $website)
	<div class="card-body" style="background-color: white;color:#31353D">
		<form method="POST" action="{{route('update-website')}}" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>
						Meta Tags <small class="text-danger">*</small>
						</label>
						<input type="text" name="auth_meta_tags" class="form-control" value="{{$website->auth_meta_tags}}">
					</div>
					<div class="form-group">
						<label>
						Meta Description <small class="text-danger">*</small>
						</label>
						<textarea type="text" name="description" class="form-control">{{$website->description}}</textarea>
					</div>
					<div class="form-group">
						<label>
						Arabic Description <small class="text-danger">*</small>
						</label>
						<textarea type="text" name="description_ar" class="form-control">{{$website->description_ar}}</textarea>
					</div>
					<div class="form-group">
						<label>
						English Description <small class="text-danger">*</small>
						</label>
						<textarea type="text" name="description_en" class="form-control">{{$website->description_en}}</textarea>
					</div>
                    <div class="form-group">
                        <label>
                            token<small class="text-danger">*</small>
                        </label>
                        <textarea type="text" name="token" class="form-control">{{$website->token}}</textarea>
                    </div>
					<div class="form-group">
						<label>
						 First Email <small class="text-danger">*</small>
						</label>
						<input type="email" class="form-control" name="email_1" value="{{$website->email_1}}">
					</div>
					<div class="form-group">
						<label>
						 Second Email <small class="text-danger">*</small>
						</label>
						<input type="email" class="form-control" name="email_2" value="{{$website->email_2}}">
					</div>
					<div class="form-group">
						<label>
						  First Mobile No.<small class="text-danger">*</small>
						</label>
						<input type="tel" class="form-control" name="phone_1" value="{{$website->phone_1}}">
					</div>
					<div class="form-group">
						<label>
						  Second Mobile No.<small class="text-danger">*</small>
						</label>
						<input type="tel" class="form-control" name="phone_2" value="{{$website->phone_2}}">
					</div>
					<div class="form-group">
						<label>
						  Google Map<small class="text-danger">*</small>
						</label>
						<textarea type="text" name="google_map" class="form-control">{{$website->google_map}}</textarea>
					</div>
						<div class="form-group">
						<label>
						Key Words <small class="text-danger">*</small>
						</label>
						<input type="text" name="keywords" class="form-control" value="{{$website->keywords}}">
					</div>
                    <div class="form-group">
                        <label>
                            phone<small class="text-danger">*</small>
                        </label>
                        <input type="text" name="phone" class="form-control" value="{{$website->phone}}">
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="status" {{$website->data == 1 ? 'checked' : ''}}  value="1" style="position: relative;top:2px;">
                        <label>
                            {{__('site.required_data')}}
                        </label>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="whats" {{$website->whats == 1 ? 'checked' : ''}}  value="1" style="position: relative;top:2px;">
                        <label>
                           active Whatsapp
                        </label>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="fatoorah" {{$website->fatoorah == 1 ? 'checked' : ''}}  value="1" style="position: relative;top:2px;">
                        <label>
                            active my fatoorah
                        </label>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="fatoorah_tameen" {{$website->fatoorah_tameen == 1 ? 'checked' : ''}}  value="1" style="position: relative;top:2px;">
                        <label>
                            active my fatoorah_tameen
                        </label>

                    </div>
				</div>
					<div class="form-group">
						<input type="submit" name="submit" value="حفظ " class="btn btn-dark " style="float: left;">
					</div>

				</div>
			</div>
		</form>
	</div>
	@endforeach
	@endif
</div>


@endsection
