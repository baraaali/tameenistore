@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	  إضافة عضوية خدمات
		</h5>
		<a href="{{route('service_member_ships.index')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{route('service_member_ships.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="row">
               <div class="col-md-4">
                <div class="form-group">
                    <label for="category">  القسم  </label>
                    <select value="" class="form-control select2" name="category" id="category"> 
                      @foreach($categories as $category)
                          <option value="{{$category->id}}">
                              {{$category->ar_name}}
                          </option>
                      @endforeach
                    </select>
                 </div>
               </div>
               <div class="col-md-4">
                <div class="form-group">
                    <label for="sub_category">  القسم الفرعي  </label>
                    <select disabled value="" class="form-control select2" name="sub_category" id="sub_category"> 
                        <option value="">{{__('site.choose')}}</option>
                    </select>
                 </div>
               </div>
               <div class="col-md-4">
                <div class="form-group">
                    <label for="child_category">  القسم الفرع فرعي   </label>
                    <select disabled value="" class="form-control select2" name="child_category" id="child_category"> 
                      <option value="">{{__('site.choose')}}</option>
                    </select>
                 </div>
               </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info new">إضافة </button>
                </div>
            </div>
			<div  class="row new-service_member_ship position-relative base">
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
                                <label>
                                    السعر  
                                </label>
                                <input type="number" name="price[]" class="form-control" required>
                            </div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>
								عدد الشهور 
							</label>
							<input type="number" name="months_number[]" class="form-control" required>
                        </div>
					</div>
                    <div class="col-md-6">
						<div class="form-group">
							<label>
								 نوع الإعلان
							</label>
                              <select class="form-control" name="type[]" id="type">
                                <option value="normal">عادية</option>
                                <option value="special">{{__('site.featured')}}</option>
                              </select>
                            </div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>
								عدد الإعلانات 
							</label>
							<input type="number" name="ads_number[]" class="form-control" required>
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
        var getSubCategories = function(){
            $('#category').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_categories/get-childrens/"+id,
                success: function(data){
                    $('#sub_category').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('#sub_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
                     $("#sub_category").prop('disabled',false)
                     $('#sub_category').trigger('change')
                   }else
                   $("#sub_category").prop('disabled',true)
                    $('#sub_category').trigger('change')
                }
            })
            })
            $('#category').trigger('change')
        }
        var getChildCategories = function(){
            $('#sub_category').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_sub_categories/get-childrens/"+id,
                success: function(data){
                    $('#child_category').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('#child_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
                     $("#child_category").prop('disabled',false)
                   }else
                     $("#child_category").prop('disabled',true)
                }
            })
            })
            $('#sub_category').trigger('change')
        }
        var clearElement = function()
        {
            $('.new-service_member_ship').find('.preview').attr('src','')
            $('.new-service_member_ship').find('.preview').hide()
            $('.new-service_member_ship').find('[name="en_name[]"]').val('')
            $('.new-service_member_ship').find('[name="ar_name[]"]').val('')
            $('.new-service_member_ship').find('[name="ads_number[]"]').val('')
            $('.new-service_member_ship').find('[name="type[]"]').val('')
        }
        $(document).ready(function(){
            getSubCategories()
            getChildCategories()

            $('.new').on('click',function(){
            $base =  $('.new-service_member_ship').clone()[0]
            $($base).removeClass('new-service_member_ship')
            $('.new-service_member_ship').before($base)
            clearElement();
          
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-service_member_ship').removeClass('new-service_member_ship')
            $($base).addClass('new-service_member_ship')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-service_member_ship').length)
              $('form > .base').addClass('new-service_member_ship')
          })
          $('.save').on('click',function(){
            
             var $en_names = $('[name="en_name[]"]')
             var $ar_names = $('[name="ar_name[]"]')
             var $types = $('[name="type[]"]')
             var $ads_numbers = $('[name="ads_number[]"]')
             var $months_number = $('[name="months_number[]"]')
             var $prices = $('[name="price[]"]')
             var errors = {};
              for (let i = 0; i < $en_names.length; i++) {
                  const en = $($en_names[i]).val();
                  const ar = $($ar_names[i]).val();
                  const type = $($types[i]).val();
                  const ads_number = $($ads_numbers[i]).val();
                  const month_number = $($months_number[i]).val();
                  const price = $($prices[i]).val();

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
                   if(!ads_number && !$($ads_numbers[i]).parent().parent().find('.invalid-feedback').length){
                    $($ads_numbers[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['ads_number'+i] = true
                  } else if(ads_number){
                    delete errors['ads_number'+i]                  
                   $($ar_names[i]).parent().parent().find('.invalid-feedback').remove()
                  }
                  
                   if(!type && !$($types[i]).parent().parent().find('.invalid-feedback').length){
                    $($types[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['type'+i] = true
                  } else if(type){
                    delete errors['type'+i]                  
                   $($types[i]).parent().parent().find('.invalid-feedback').remove()
                  }
                  if(!price && !$($prices[i]).parent().parent().find('.invalid-feedback').length){
                    $($prices[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['price'+i] = true
                  } else if(price){
                    delete errors['price'+i]                 
                   $($prices[i]).parent().parent().find('.invalid-feedback').remove()
                  }
                  if(!month_number && !$($months_number[i]).parent().parent().find('.invalid-feedback').length){
                    $($months_number[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                    errors['months_number'+i] = true
                  } else if(month_number){
                    delete errors['months_number'+i]                 
                   $($months_number[i]).parent().parent().find('.invalid-feedback').remove()
                  }
                  }

               if(!Object.keys(errors).length)
                saveData()
          
          })

        })
    </script>
@endsection