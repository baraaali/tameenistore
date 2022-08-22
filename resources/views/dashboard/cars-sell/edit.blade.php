@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			اعلانات السيارات
		</h5>
		<a href="{{route('cars')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i> 
		</a>
		</a>
		{{-- <a href="{{route('cars-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a> --}}
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<div class="form">
			<form method="POST" action="{{route('cars-update')}}" enctype="multipart/form-data">
				@csrf
				
				<input type="hidden" name="id" value="{{$car->id}}">
				<h4>
					معلومات رئيسية
				</h4>
				<br>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>
								الدولة - المنطقة  <small  class="text-danger">*</small>
							</label>
							<select class="SpecificInput select2" dir="rtl" name="country_id"  required>
								@foreach($countries as $country)
									<option value="{{$country->id}}" {{$country->id == $car->country_id ? 'selected' : ''}}>
										{{$country->ar_name}}
									</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>
								 الاسم بالعربي  <small  class="text-danger">*</small>
							</label>
							<input type="text"  required value="{{$car->ar_name}}" name="ar_name" max="191" class="SpecificInput">
						</div>

						<div class="form-group">
							<label>
								 البراند <small  class="text-danger">*</small>
							</label>
							<select class="SpecificInput select2"  required  name="ar_brand">
								@foreach($brands as $brand)
									<option value="{{$brand->id}}" {{$brand->id == $car->ar_brand ? 'selected' : ''}}>
										{{$brand->name}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label>
								 الموديل  <small  class="text-danger">*</small>
							</label>
							<select class="SpecificInput select2"  required name="ar_model">
								@foreach($models as $model)
									<option value="{{$model->id}}" {{$model->id == $car->ar_model ? 'selected' : ''}}>
										{{$model->name}}
									</option>
								@endforeach
							</select>
						</div>

						

					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>
								 الاسم  الانجليزية  <small  class="text-danger">*</small>
							</label>
							<input type="text"  name="en_name" value="{{$car->en_name}}" max="191"  required class="SpecificInput">
						</div>
					</div>
				</div>
				<hr>
				<h4>
						خصائص ا السيارة 
				</h4>
				<br>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>
								 سنة الصنع  <small  class="text-danger">*</small>
							</label>
							<input type="text"  value="{{$car->year}}"  required name="year" max="191" class="SpecificInput">
						</div>
						<div class="form-group">
							<label>
								 	اللون  <small  class="text-danger">*</small>
							</label>
							<input type="text" value="{{$car->color}}" required name="color" max="191" class="SpecificInput">
						</div>
						<div class="form-group">
							<label>
								 	ناقل الحركة  <small  class="text-danger">*</small>
							</label>
							<select class="SpecificInput"   required name="transmission">
								<option value="0" {{$car->transmission == 0 ? 'selected' : ''}}>
									عادي
								</option>
								<option value="1" {{$car->transmission == 1 ? 'selected' : ''}}>
									اوتوماتيك
								</option>
							</select>
						</div>

						<div class="form-group">
							<label>
								 	أقصي سرعة للسيارة  
							</label>
							<input type="text" value="{{$car->max}}"  name="maxSpeed" max="191" class="SpecificInput">
						</div>
						

					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>
								 	الوقود
							</label>
							<input type="text" value="{{$car->fuel}}"   name="fuel" max="191" class="SpecificInput">
						</div>
						<div class="form-group">
							<label>
								 	حالة  السيارة   <small  class="text-danger">*</small>
							</label>
							<select class="SpecificInput"  required name="used">
								<option value="0" {{$car->used == 0 ? 'selected' : ''}}>
									جديدة
								</option>
								<option value="1" {{$car->used == 1 ? 'selected' : ''}}>
									مستعملة
								</option>
							</select>
						</div>
						<div class="form-group">
							<label>
								 	عدد الكيلو مترات
							</label>
							<input type="text" value="{{$car->kilo_meters}}"  name="kilometers" max="191" class="SpecificInput">
						</div>

						<div class="form-group">
							<label>
								 المحرك 
							</label>
							<input type="text" value="{{$car->engine}}"  placeholder="1600" name="engine" max="191" class="SpecificInput">
						</div>
						
					</div>
				</div>

				<hr>
					<h4>
						صفات السيارة  
				</h4>
				<br>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>
								 وصف السيارة باعربية  <small  class="text-danger">*</small>
							</label>
							<textarea class="SpecificInput"   name="ar_description">{{$car->ar_description}}</textarea>
						</div>

						<div class="form-group">
							<label>
								 	مميزات السيارة بالعربية  <small  class="text-danger">*</small>
							</label>
							<textarea class="SpecificInput"   name="ar_features">{{$car->ar_features}}</textarea>
						</div>
						

						

					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>
								 وصف السيارة  بالانجليزية  <small  class="text-danger">*</small>
							</label>
							<textarea class="SpecificInput"   name="en_description">{{$car->en_description}}</textarea>
						</div>

						<div class="form-group">
							<label>
								 	مميزات السيارة  بالانجليزية  <small  class="text-danger">*</small>
							</label>
							<textarea class="SpecificInput"   name="en_features">{{$car->en_features}}</textarea>
						</div>
					</div>
				</div>



				<hr>
					<h4>
						صور السيارة
				</h4>
				<br>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>
								 صور السيارة  <small  class="text-danger">*</small>
							</label>
							<input type="file" multiple   {{$car->Images ? '' : 'required'}} class="SpecificInput uploader" name="images[]" accept="image/*">
							@if($car->Images)
							<div class="old_images">
								@foreach($car->Images as $image)
									<img style="display: inline-block;width: auto;height: 50px;margin: 5px" src="{{url('/')}}/uploads/{{$image->image}}" />
								@endforeach
							</div>
							@endif
							<div class="uploadedimages">
								
							</div>
						</div>

					

						

					</div>
					
				</div>


					<hr>
					<h4>
						إسعار السيارة
				</h4>
				<br>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>
								 السعر <small  class="text-danger">*</small>
							</label>
							<input type="number" value="{{$car->Price ? $car->Price->cost : ''}}"required class="SpecificInput" name="cost">
						</div>


						<div class="form-group">
							<label>
								 هل تريد عمل خصم قيمة ؟
							</label>
							<input type="number" value="{{$car->Price ? $car->Price->discount_amount : ''}}"  class="SpecificInput" name="discount_amount">
						</div>


						<div class="form-group">
							<label>
								 هل تريد عمل خصم  نسبة ؟
							</label>
							<input type="number"  value="{{$car->Price ? $car->Price->discount_percent : ''}}" class="SpecificInput" name="discount_percent">
						</div>

						<div class="form-group">
							<label>
								 تحديد وقت بدأ الخصومات ؟
							</label>
							<input type="date" value="{{$car->Price ? $car->Price->discount_start_date : ''}}" class="SpecificInput" name="discount_start_date">
						</div>

						<div class="form-group">
							<label>
								 تحديد وقت   نهاية الخصومات ؟
							</label>
							<input type="date"  value="{{$car->Price ? $car->Price->discount_end_date : ''}}"  class="SpecificInput" name="discount_end_date">
						</div>

						<div class="form-group">
							<label>
								 نوع الاعلان 
							</label>
							<select value="{{$car->special}}" class="SpecificInput select2" name="special">
							@foreach(\App\AdsMembership::get() as $price)
								<option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->getName()}}</option>
							@endforeach
							</select>
						</div>


						
						<div class="form-group">
							<label>
								 نشر 
							</label>
							<input type="checkbox" value="1" {{$car->status == 1 ? 'checked' : ''}} name="status">
						</div>

						
						

					</div>
					
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="submit" name="submit" class="btn btn-primary" value="حفظ">
					</div>
				</div>
			</form>
		</div>
		
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2();
		
	});

	$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('.uploader').on('change', function() {
        imagesPreview(this, 'div.uploadedimages');
    });
});
</script>
@endsection