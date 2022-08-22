@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	إضافة موديل
		</h5>
		<a href="{{route('models.index')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{route('models.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>
							الماركة 
                        </label>
                        <select class="SpecificInput select2 brand_id" name="brand_id" >
                            <option value="0" selected>
                                الماركة 
                            </option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">
                                    {{$brand->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
				<div class="col-md-4">
                    <div class="form-group">
						<label>الشكل </label>
                        <select class="SpecificInput select2 care_shape_id" name="care_shape_id" >
                            <option value="0" selected>
                                شكل السيارة 
                            </option>
                            @foreach($careshapes as $careshape)
                                <option value="{{$careshape->id}}">
                                    {{$careshape->ar_name}} -  {{$careshape->en_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary new">إضافة </button>
                </div>
            </div>

			<div  class="row new-vehicle position-relative base">
					<div class="col-md-3">
						<div class="form-group">
							<label>
								الإسم 
							</label>
							<input type="text" name="name[]" class="form-control" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>
								عدد الركاب 
							</label>
							<input type="number" name="passengers[]" class="form-control" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" >
							<input type="checkbox" name="status[]"  value="1">
							<label>
								نشر ؟
							</label>
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
        var saveData = function()
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
            $('.new-vehicle').find('[name="name[]"]').val('')
            $('.new-vehicle').find('[name="passengers[]"]').val('')
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-vehicle').clone()[0]
            $($base).removeClass('new-vehicle')
            $('.new-vehicle').before($base)
            clearElement();
          
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-vehicle').removeClass('new-vehicle')
            $($base).addClass('new-vehicle')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-vehicle').length)
              $('form > .base').addClass('new-vehicle')
          })
          $('.save').on('click',function(){
            saveData()
            
          })

        })

   
    </script>
@endsection