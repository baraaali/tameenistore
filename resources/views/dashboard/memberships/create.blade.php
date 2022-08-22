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
			إنشاء عضوية
		</h4>
		<hr>
		<div class="form">
			<form method="POST" action="{{route('membership-store')}}">
				@csrf

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label> إسم العضوية  <small class="text-danger">*</small>
							</label>
							<input type="text" name="name" required  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> تكلفة  <small class="text-danger">*</small>
							</label>
							<input type="text" name="cost" required  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> سعر بعد الخصم ؟
							</label>
							<input type="text" name="discount"   class="SpecificInput">
						</div>
						<div class="form-group">
							<label> يوم بدأ العرض
							</label>
							<input type="date" name="start_date"   class="SpecificInput">
						</div>
						<div class="form-group">
							<label> يوم  انتهاء العرض
							</label>
							<input type="date" name="end_date"   class="SpecificInput">
						</div>
						<div class="form-group">
							<label> مدة الاشتراك  <small class="text-danger">*</small>
								<small class="text-success"> عليك كتابة عدد الايام فقط </small>
							</label>
							<input type="text" name="duration" required  class="SpecificInput">
						</div>
						<div class="form-group">
							<label> عدد الاعلانات المتاحة للسيارات  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_posts"   class="SpecificInput">
						</div>
							<div class="form-group">
							<label> عدد الاعلانات المتاحة للأقسام  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_deps"   class="SpecificInput">
						</div>
						<div class="form-group">
							<label> عدد الاعلانات المتاحة للتأمينات  <small class="text-danger">*</small>
								<small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

							</label>
							<input type="text" name="limit_docs"   class="SpecificInput">
						</div>
                        <div class="form-group">
                            <label> عدد الاعلانات المتاحة للاشخاص  <small class="text-danger">*</small>
                                <small class="text-success"> اذا كنت تريد عدد لا نهائي ا اكتب -1</small>

                            </label>
                            <input type="text" name="limit_person"   class="SpecificInput">
                        </div>
						<div class="form-group">
							<label>
								 نوع الاعلان
							</label>
							<select class="SpecificInput select2" name="special">
								<option value="0">
									عادي
								</option>
								<option value="1">
									مفضل
								</option>
								<option value="2">
									فضي
								</option>
								<option value="3">
									مميز
								</option>
							</select>
						</div>

						<div class="form-group">
							<label>مميزات العضوية بالعربية<small class="text-danger">*</small>


							</label>
							<textarea name="ar_featuers"></textarea>
						</div>
						<div class="form-group">
							<label>مميزات العضوية  بالانجليزية<small class="text-danger">*</small>


							</label>
							<textarea name="en_featuers"></textarea>
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
