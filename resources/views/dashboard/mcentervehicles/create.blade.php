@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	إضافة مركبة صيانة 
		</h5>
		<a href="{{route('mcentervehicles.index')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{route('mcentervehicles.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
            
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary new">إضافة </button>
                </div>
            </div>
			<div  class="row new-mcentervehicle position-relative base">
					<div class="col-md-3">
						<div class="form-group">
							<label>
								الإسم بالعربي
							</label>
							<input type="text" name="ar_name[]" class="form-control" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>
								الإسم بالإنجليزية
							</label>
							<input type="text" name="en_name[]" class="form-control" required>
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
            
            $('/form').submit()
        }
        var setImage = function()
        {
            $('.preview').hide()
            $(document).on('change','[name="image[]"]',function($event){
            $(this).parent().parent().parent().find('img').attr('src',URL.createObjectURL($event.target.files[0]))
            $(this).parent().parent().parent().find('.preview').show()
           // console.log( $(this).parent().parent().parent().find('img'));
            })
            
            $(document).on('click','.selectimage',function(){
                $(this).next().click()
            })
        }
        var clearElement = function()
        {
            $('.new-mcentervehicle').find('.preview').attr('src','')
            $('.new-mcentervehicle').find('.preview').hide()
            $('.new-mcentervehicle').find('[name="en_name[]"]').val('')
            $('.new-mcentervehicle').find('[name="ar_name[]"]').val('')
            $('.new-mcentervehicle').find('[name="image[]"]').val('')
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-mcentervehicle').clone()[0]
            $($base).removeClass('new-mcentervehicle')
            $('.new-mcentervehicle').before($base)
            clearElement();
          
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-mcentervehicle').removeClass('new-mcentervehicle')
            $($base).addClass('new-mcentervehicle')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-mcentervehicle').length)
              $('form > .base').addClass('new-mcentervehicle')
          })
          $('.save').on('click',function(){
            
             var $en_names = $('[name="en_name[]"]')
              var $ar_names = $('[name="ar_name[]"]')
              var $images = $('[name="image[]"]')
              var $status = $('[name="status[]"]')
              for (let i = 0; i < $en_names.length; i++) {
                  const en = $($en_names[i]).val();
                  const ar = $($ar_names[i]).val();
                  const image = $($images[i]).prop('files')[0];
                  const status = $($status[i]).is(':checked')  ? '1' : '0';

                  if(!en && !$($en_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($en_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(en) $($en_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if(!ar && !$($ar_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($ar_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(ar) $($ar_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if( en && ar && status && !data.some(e =>e.status == status &&  e.ar_name == ar && e.en_name == en))
                  data.push({ar_name:ar,en_name:en,status:status,image:image})
              }
               if(Object.keys(data).length )
                 saveData()
          })

          setImage()
        })
    </script>
@endsection