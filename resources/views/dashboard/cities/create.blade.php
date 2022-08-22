@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
	المناطق
		</h5>
		<a href="{{route('cities')}}" class="btn btn-light"  style="float: left" >
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
		<form class="form" action="{{url('/')}}/dashboard/cities/store" method="POST" enctype="multipart/form-data">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>
                            تابع لمنطقة
                        </label>
                        <select class="SpecificInput governorate_id select2" >
                            <option value="0" selected>
                                إختر منطقة 
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary new">إضافة </button>
                </div>
            </div>
			<div  class="row new-city position-relative base">
				
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
					url: "{{route('cities-store')}}",
					type:'post',
					data : {data:data},
					success : function(res){
                        if(res === true)
                        window.location.href = "{{route('cities')}}";
					}

				})
        }
        var getGovernorates = function()
        {
            $('.country_id').on('change',function(){
                var id = $(this).val()
                if(id)
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/dashboard/cities/get-governorates/"+id,
					type:'get',
					success : function(res){
                      var html = ''
                       res.forEach((e,i)=>{
                          html += '<option value="'+e.id+'">'+e.ar_name+'-'+e.en_name+'</option>'
                       })
                       if(html.length)
                       {
                       $($('.governorate_id').get(0)).html(html)  
                        $($('.governorate_id').get(0)).select2()
                       $($('.governorate_id').get(0)).trigger('change')               
                       }
					}
				})
            })
        }
        $(document).ready(function(){
            $('.new').on('click',function(){
            $base =  $('.new-city').clone()[0]
            $($base).removeClass('new-city')
            $('.new-city').before($base)
            $($base).find('.remove').remove()
            $($base).append('<div style="cursor: pointer; position: absolute;top:30px;right: -10px;" class="text-danger h3 remove">&times;</div>')
            $('.new-city').removeClass('new-city')
            $($base).addClass('new-city')
         })
          $(document).on('click','.remove',function(){
              $(this).parent().remove()
              if(!$('.new-city').length)
              $('form > .base').addClass('new-city')
          })
          $('.save').on('click',function(){
              var $en_names = $('.en_name')
              var $ar_names = $('.ar_name')
                const c =  $('.governorate_id').val();
              for (let i = 0; i < $en_names.length; i++) {
                  const en = $($en_names[i]).val();
                  const ar = $($ar_names[i]).val();
                  
                  if(c == 0 && !$('.governorate_id').parent().parent().find('.invalid-feedback').length)                  
                  $('.governorate_id').parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(c != 0) $('.governorate_id').parent().parent().find('.invalid-feedback').remove()
                 
                  if(!en && !$($en_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($en_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(en) $($en_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if(!ar && !$($ar_names[i]).parent().parent().find('.invalid-feedback').length)
                  $($ar_names[i]).parent().after('<div class="invalid-feedback d-block my-4">هذا الحقل ضروري</div>')
                  else if(ar) $($ar_names[i]).parent().parent().find('.invalid-feedback').remove()
                  
                  if(c != 0 && en && ar && !data.some(e => (e.governorate_id == c && e.ar_name == ar && e.en_name == en)))
                  data.push({governorate_id:c,ar_name:ar,en_name:en})

              }
              if(Object.keys(data).length )
              console.log(data);
                 saveData(data)
              })

          getGovernorates()
        })
    </script>
@endsection