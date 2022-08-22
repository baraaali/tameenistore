@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	إضافة مركات
		</h5>
		<a href="{{route('brands.index')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{route('brands.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary new">إضافة </button>
                </div>
            </div>
			<div class="row">
				<div class="form-group col-md-4">
					<label for="vehicle_id"> نوع العربة </label>
					<select value="" class="form-control select2" name="vehicle_id" id="vehicle_id"> 
					  @foreach($vehicles as $vehicle)
						  <option value="{{$vehicle->id}}">
							  {{$vehicle->ar_name}} - {{$vehicle->en_name}}
						  </option>
					  @endforeach
					</select>
				 </div>
			</div>
			<div  class="row new-brand position-relative base">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>
										الاسم 
									</label>
									<input type="text" value="" name="name[]" class="form-control" required="required">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>
										بلد الصنع 
									</label>
									<input type="text" value="" name="manufacturing_country[]" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<div class="col-md-12">
								  <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
											 صورة
											</label>
											<button type="button" class="btn btn-info selectimage ">صورة</button>
											<input type="file" name="image[]" class="d-none" >
		
										</div>
									   </div>
										<div class="col-md-6">
											<img class="preview"  style="width: 70px;height:70px;margin-right:33px" src="" >
										</div>
								  </div>
								</div>
							</div>
							<div class="col-md-12">
									<input type="checkbox"  name="status[]" value="1" >
									<label>
										نشر ؟
									</label>
	
							</div>
						</div>
					</div>
					
		   </div>
           <div class="row" >
              <div class="col-md-12">
                <button type="button" class="btn btn-primary save"> حفظ</button>
              </div>
           </div>
		</form>
	</div>
</div>

@endsection

@section('js')
    <script>
        var data = []
		
        var saveData = function(data)
        {
            $('.form').submit()
        }
		var setImage = function()
        {
            $('.preview').hide()
            $(document).on('change','[name="image[]"]',function($event){
            $(this).parent().parent().parent().find('img').attr('src',URL.createObjectURL($event.target.files[0]))
            $(this).parent().parent().parent().find('.preview').show()
            })
            
            $(document).on('click','.selectimage',function(){
                $(this).next().click()
            })
        }
		var clearElement = function()
        {
            $('.new-brand').find('.preview').attr('src','')
            $('.new-brand').find('.preview').hide()
            $('.new-brand').find('[name="name[]"]').val('')
            $('.new-brand').find('[name="manufacturing_country[]"]').val('')
            $('.new-brand').find('[name="image[]"]').val('')
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-brand').clone()[0]
            $($base).removeClass('new-brand')
            $('.new-brand').before($base)
			clearElement()
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-brand').removeClass('new-brand')
            $($base).addClass('new-brand')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-brand').length)
              $('form > .base').addClass('new-brand')
          })
          $('.save').on('click',function(){
                  saveData()
          })
		  setImage()
        })
    </script>
@endsection