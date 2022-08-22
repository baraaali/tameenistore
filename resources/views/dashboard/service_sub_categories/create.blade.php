@extends('dashboard.layout.app')
@section('css')
    <style>
    .select2-container{
     display:block
        }
    </style>
@endsection
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	  إضافة قسم فرعي  
		</h5>
		<a href="{{route('service_sub_categories.index')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{route('service_sub_categories.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
            
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info new">إضافة </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="service_category_id"> القسم  </label>
                        <select value="" class="form-control select2" name="service_category_id" id="service_category_id"> 
                          @foreach($service_categories as $service_category)
                              <option value="{{$service_category->id}}">
                                  {{$service_category->ar_name}}
                              </option>
                          @endforeach
                        </select>
                     </div>
                </div>
            </div>
			<div  class="row new-service_sub_category position-relative base">
					<div class="col-md-6">
						<div class="form-group">
							<label>
								الإسم بالعربي
							</label>
							<input type="text" name="ar_name[]" class="form-control" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>
								الإسم بالإنجليزية
							</label>
							<input type="text" name="en_name[]" class="form-control" required>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">وصف عربي</label>
                            <textarea class="form-control" name="ar_description[]" id="ar_description" rows="3"></textarea>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">وصف إنجليزي</label>
                            <textarea class="form-control" name="en_description[]" id="en_description" rows="3"></textarea>
                          </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group" >
                                  <input type="checkbox" name="status[]" value="1" >
                                  <label>
                                      نشر ؟
                                  </label>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info w-100 selectimage ">صورة</button>
                                        <input type="file" name="image[]" class="d-none" >
                                    </div>
                                   </div>
                                    <div class="col-md-6">
                                        <img class="preview"  style="width: 70px;height:70px;margin-right:33px" src="" >
                                    </div>
                            </div>
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
            $('.new-service_sub_category').find('.preview').attr('src','')
            $('.new-service_sub_category').find('.preview').hide()
            $('.new-service_sub_category').find('[name="en_name[]"]').val('')
            $('.new-service_sub_category').find('[name="ar_name[]"]').val('')
            $('.new-service_sub_category').find('[name="ar_description[]"]').val('')
            $('.new-service_sub_category').find('[name="en_description[]"]').val('')
            $('.new-service_sub_category').find('[name="image[]"]').val('')
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-service_sub_category').clone()[0]
            $($base).removeClass('new-service_sub_category')
            $('.new-service_sub_category').before($base)
            clearElement();
          
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-service_sub_category').removeClass('new-service_sub_category')
            $($base).addClass('new-service_sub_category')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-service_sub_category').length)
              $('form > .base').addClass('new-service_sub_category')
          })
          $('.save').on('click',function(){
            
             var $en_names = $('[name="en_name[]"]')
             var $ar_names = $('[name="ar_name[]"]')
             var $service_category_id = $('[name="service_category_id"]')
             var errors = {};
              for (let i = 0; i < $en_names.length; i++) {
                  const en = $($en_names[i]).val();
                  const ar = $($ar_names[i]).val();

                  if(!en && !$($en_names[i]).parent().parent().find('.invalid-feedback').length)
                  {
                  $($en_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['en'+i] = true
                  }else if(en)
                  {
                   $($en_names[i]).parent().parent().find('.invalid-feedback').remove()
                    delete errors['en'+i]
                  }
                  
                  if(!ar && !$($ar_names[i]).parent().parent().find('.invalid-feedback').length){
                    $($ar_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['ar'+i] = true
                  } else if(ar){
                    delete errors['ar'+i]                  
                   $($ar_names[i]).parent().parent().find('.invalid-feedback').remove()
                }
                if(!$service_category_id.val())
                {
                 $($service_category_id).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                errors['service_category_id'+i] = true
                }else{
                    $($service_category_id).parent().find('.invalid-feedback').remove()
                    delete errors['service_category_id'+i] 
                }
                }

               if(!Object.keys(errors).length)
                 saveData()
          })

          setImage()
        })
    </script>
@endsection