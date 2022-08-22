@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	المناطق
		</h5>
		<a href="{{route('governorates')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{url('/')}}/dashboard/governorates/store" method="POST" enctype="multipart/form-data">
			@csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>
                         تابع إلي
                        </label>
                        <select class="SpecificInput select2 country_id" >
                            <option value="0" selected>
                                دولة 
                            </option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->ar_name}} - {{$country->en_name}}
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
			<div  class="row new-governorate position-relative base">
				
					<div class="col-md-4">
                        <div class="form-group">
                            <label>
                               الاسم بالعربية <small class="text-danger">*</small>
                            </label>
                            <input type="text"  class="SpecificInput ar_name" required="required" max="191">
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="form-group">
                            <label>
                                الإسم بالإنجليزية 
                            </label>
                            <input type="text"  placeholder=" الإسم بالإنجليزية " class="SpecificInput en_name"  max="191">
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
            $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('governorates-store')}}",
					type:'post',
					data : {data:data},
					success : function(res){
                        if(res === true)
                        window.location.href = "{{route('governorates')}}";
					}

				})
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-governorate').clone()[0]
            $($base).removeClass('new-governorate')
            $('.new-governorate').before($base)
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-governorate').removeClass('new-governorate')
            $($base).addClass('new-governorate')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-governorate').length)
              $('form > .base').addClass('new-governorate')
          })
          $('.save').on('click',function(){
              var $en_names = $('.en_name')
              var $ar_names = $('.ar_name')
                const c =   $('.country_id').val();
              for (let i = 0; i < $en_names.length; i++) {
                  const en = $($en_names[i]).val();
                  const ar = $($ar_names[i]).val();
                 
                  if(!en && !$($en_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($en_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(en) $($en_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if(!ar && !$($ar_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($ar_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(ar) $($ar_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if(c != 0 && en && ar && !data.some(e => e.country_id == c && e.ar_name == ar && e.en_name == en))
                  data.push({country_id:c,ar_name:ar,en_name:en})

              }
              if(Object.keys(data).length )
               saveData(data)
          })
        })
    </script>
@endsection