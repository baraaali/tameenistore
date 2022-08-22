@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			العضويات
		</h5>
		<a href="{{route('membership')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i>
		</a>
		<a href="{{route('membership-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<h4>
			 تعديل عضوية
		</h4>
		<hr>
		<div class="form">
			<form method="POST" action="{{route('membership-update')}}">
				@csrf
				<input type="hidden" name="id" value="{{$membership->id}}">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label> إسم العضوية  <small class="text-danger">*</small>
							</label>
							<input type="text" name="name" value="{{$membership->name}}" required  class="SpecificInput form-control">
						</div>
						<div class="form-group">
							<label> تكلفة  <small class="text-danger">*</small>
							</label>
							<input type="text" name="cost" value="{{$membership->cost}}" required  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> سعر بعد الخصم ؟
							</label>
							<input type="text" name="discount" value="{{$membership->discount}}"  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> يوم بدأ العرض
							</label>
							<input type="text" name="start_date" value="{{$membership->start_date}}"   class="SpecificInput datepicker">
						</div>
						<div class="form-group">
							<label> يوم  انتهاء العرض
							</label>
							<input type="text" name="end_date" value="{{$membership->end_date}}"  class="SpecificInput datepicker">
						</div>
						<div class="form-group">
							<label> مدة الاشتراك  <small class="text-danger">*</small>
								<small class="text-success"> عليك كتابة عدد الايام فقط </small>
							</label>
							<input type="text" name="duration" value="{{$membership->duration}}" required  class="SpecificInput">
						</div>
	                    <div class="form-group">
							<label> عدد الاعلانات المتاحة للسيارات  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_posts" value="{{$membership->limit_posts}}"   class="SpecificInput">
						</div>
							<div class="form-group">
							<label> عدد الاعلانات المتاحة للأقسام  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_deps" value="{{$membership->limit_deps}}"  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> عدد الاعلانات المتاحة للتأمينات  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_docs" value="{{$membership->limit_docs}}"  class="SpecificInput">
						</div>
                        <div class="form-group">
                            <label> عدد الاعلانات المتاحة للاشخاص  <small class="text-danger">*</small>
                                <small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

                            </label>
                            <input type="text" name="limit_person" value="{{$membership->limit_person}}"  class="SpecificInput">
                        </div>
						<div class="form-group">
							<label>
								 نوع الاعلان
							</label>
							<select class="SpecificInput select2" name="special">
								<option value="0" {{$membership->special == 0 ? 'selected' : ''}}>
									عادي
								</option>
								<option value="1" {{$membership->special == 1 ? 'selected' : ''}}>
									مفضل
								</option>
								<option value="2" {{$membership->special == 2 ? 'selected' : ''}}>
									فضي
								</option>
								<option value="3" {{$membership->special == 3 ? 'selected' : ''}}>
									مميز
								</option>
							</select>
						</div>
						<div class="form-group">
							<label>مميزات العضوية بالعربية<small class="text-danger">*</small>


							</label>
							<textarea name="ar_featuers">{{$membership->ar_m_feature}}</textarea>
						</div>
						<div class="form-group">
							<label>مميزات العضوية  بالانجليزية<small class="text-danger">*</small>


							</label>
							<textarea name="en_featuers">{{$membership->en_m_feature}}</textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="حفظ" class="btn btn-dark">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>




@endsection
