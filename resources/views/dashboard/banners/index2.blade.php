@extends('dashboard.layout.app')
@section('content')
    <?php $arr=['الرئيسيه','سيارات للبيع','سيارات للايجار','وكالات البيع','وكالات الايجار','الاعلانات','كل الاقسام','القسم الواحد'
//        ,'بجوار الاعلانات الذهبيه','بجوار الاعلانات المميزة ','بجوار الاعلانات الفضيه','بجوار الاعلانات العاديه'
    ];
    $types=['اعلى الصفحه','جانب الصفحه الايمن','جانب الصفحه الايسر'];
    ?>
    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                إعلانات البنرات 
            </h5>
            <a href="#" data-toggle="modal" data-target="#create" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
         
            <table class="table table-stroped table-responsive table-straped text-center  ">
                <thead class="bg-light ">
                <th>
                    رقم
                </th>
                <th>
                    الاسم باللغة العربيه
                </th>

                <th>
                    الاسم باللغة الانجليزيه
                </th>
                <th>السعر </th>
                <th>المده </th>
                <th>مكان الظهور </th>
                <th>صفحه الظهر </th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody >
                @foreach($banners as $key=>$banner)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$banner->name_ar}}
                        </td>

                        <td>{{$banner->name_en}}</td>
                        <td>{{$banner->price}}</td>
                        <td>{{$banner->duration}}</td>
                        <td>{{$types[$banner->type]}}</td>
                        <td>{{$arr[$banner->page]}}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$banner->id}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> تعديل
                            </a>

                            <a class=" btn btn-danger btn-xs " onclick="return confirm('Are you sure?')" href="{{ route('banners.destroy', $banner->id)}}">
                                <i class="fa fa-trash text-white"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$banners->links()}}
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
                <div class="modal-header mb-2">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة  </h5>
                </div>
                <form class="mt-1" method="POST" action="{{route('add-user-banner')}}"
                enctype="multipart/form-data">
              @csrf
              <div>
                  <div class="form-group">
                      <label style="display:block">{{__('site.select_ad')}} <small class="text-danger">*</small>
                      </label>
                      <select
                          class="SpecificInput"
                          name="banner_id" style="width:100%;" id="banner" required>
                          <option value="">{{__('site.select')}}</option>
                          @foreach($banners as $banner)
                              <option value="{{$banner->id}}">{{$banner->getName()}}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label style="display:block">{{__('site.price')}} <small class="text-danger">*</small>
                      </label>
                      <select
                          class="SpecificInput catChange " name="price" id="price" style="width:100%;" id="price" required>
                      </select>
                  </div>
                  <div class="form-group">
                      <label style="display:block">{{__('site.show_place')}} <small class="text-danger">*</small>
                      </label>
                      <select
                          class="SpecificInput catChange " name="place" id="place" style="width:100%;" id="place">
                      </select>
                  </div>
                 <div class="form-group">
                  <label style="display:block">{{__('site.page')}} <small class="text-danger">*</small>
                  </label>
                  <select
                      class="SpecificInput catChange " name="page" id="page" style="width:100%;" id="page" required>
                  </select>
              </div>
              <div class="form-group">
                  <label>{{__('site.select_image')}}</label>
                  <input type="file" name="file" class="SpecificInput" required id="imgInp">
              </div>
              <div class="form-group">
                  <img src="{{asset('uploads/banner_default.jpg')}}" id="blah" alt="" class="img-thumbnail" style="width: 100% ;height: 100%">
              </div>
              <div class="form-group">
                  <label>{{__('site.select_country')}}</label>
                  <select
                          class="SpecificInput countChange select2"
                          name="country_id" style="width:100%;">
                      @foreach($countries as $country)
                          <option value="{{$country->id}}">
                              {{$country->ar_name}}
                          </option>


                      @endforeach
                  </select>                                                            </div>
              <div class="form-group">
                  <label>{{__('site.start_date')}}</label>
                  <input type="date" name="start_date" class="SpecificInput" required>
              </div>
              <div class="form-group">
                  <label>{{__('site.link')}}</label>
                  <input type="text" name="link" class="SpecificInput" placeholder="https://www.google.com">
              </div>
                  <button type="button" class="btn btn-secondary"
                          data-dismiss="modal">{{__('site.close')}}
                  </button>
                  <input type="submit" name="submit"
                         class="btn btn-primary"
                         value="{{__('site.save')}}">
              </div>
          </form>
                
            </div>
        </div>
    </div>


    @foreach($banners as $row)
    <div class="modal fade" id="edit{{$row->id}}" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> تعديل الاعلان </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;">
                   <div class="form-body">
                       <form method="POST" action="{{route('banners.update',$banner->id)}}"
                             enctype="multipart/form-data">
                           @csrf
                           <div>
                               <div class="form-group">
                                   <label>{{__('site.select_country')}}</label>
                                   <select
                                           class="SpecificInput countChange select2"
                                           name="country_id" style="width:100%;">
                                       @foreach($countries as $country)
                                           <option value="{{$country->id}}"
                                           @if ($country->id==$row->country_id) selected @endif>
                                               {{$country->ar_name}}
                                           </option>
                                       @endforeach
                                   </select>
                               </div>
                               <div class="form-group">
                                   <label>{{__('site.status')}}</label>
                                   <select class="SpecificInput" name="active" id="">
                                       <option value="0" @if ($row->active==0)selected @endif>مفعل
                                       </option>
                                       <option value="1" @if ($row->active==1)selected @endif>غير مفعل</option>
                                   </select>
                               </div>
                               <div class="form-group">
                                   <label>{{__('site.link')}}</label>
                                   <input type="text" name="link" value="{{$row->link}}" class="SpecificInput" placeholder="https://www.google.com">
                               </div>
                               <button type="button" class="btn btn-secondary"
                                       data-dismiss="modal">{{__('site.close')}}
                               </button>
                               <input type="submit" name="submit"
                                      class="btn btn-primary"
                                      value="{{__('site.save')}}">
                           </div>
                       </form>
                   </div>


               </div>

           </div>
       </div>

   </div>
</div>

    @endforeach

@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#banner').change(function () {
            var item=$(this).val();
            if(item){
                $.ajax({
                    type:"GET",
                    url:"{{url('dashboard/banners/get-info')}}"+"/"+item+"/"+"{{$lang}}",
                    success:function(res){
                        if(res){
                            $("#price").empty();
                            $("#place").empty();
                            $("#page").empty();
                            var type=res['type'];
                        $("#price").append('<option value="'+res['price']+'">'+res['price']+'</option>');
                        $("#place").append('<option value="'+res['type']+'">'+res['type_trans']+'</option>');
                        $("#page").append('<option value="'+res['page']+'">'+res['page_trans']+'</option>');
                        }else{
                            console.log(res)
                            $("#price").empty();
                            $("#place").empty();
                            $("#page").empty();
                        }
                    }
                });}
        });
    });

    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    $(document).ready(function () {
        $('#banner_re').change(function () {

            var item=$(this).val();
            if(item){
                $.ajax({
                    type:"GET",
                    url:"{{url('dashboard/banners/get-info')}}"+"/"+item+"/"+"{{$lang}}",
                    success:function(res){
                        if(res){
                            $("#price_re").empty();
                            $("#place_re").empty();
                            $("#page_re").empty();
                            var type=res['type'];
                            $("#price_re").append('<option value="'+res['price']+'">'+res['price']+'</option>');
                            $("#place_re").append('<option value="'+res['type']+'">'+res['type_trans']+'</option>');
                            $("#page_re").append('<option value="'+res['page']+'">'+res['page_trans']+'</option>');
                        }else{
                            console.log(res)
                            $("#price_re").empty();
                            $("#place_re").empty();
                            $("#page_re").empty();
                        }
                    }
                });}
        });
    });
</script>
@endsection
{{-- @section('js')--}} 

{{--    <script>--}}
{{--        $(':button').on('click', function() {--}}
{{--            var brand_id = $(this).attr('id');--}}
{{--            var row='statusVal_'+brand_id;--}}
{{--            var data = $('.'+row).val();--}}
{{--            var status=data==0?1:0;--}}
{{--            console.log(status);--}}


{{--            $.ajax({--}}
{{--                type: "GET",--}}
{{--                dataType: "json",--}}
{{--                url: '/dashboard/banners/brandChangeStatus',--}}
{{--                data: {'status': status, 'brand_id': brand_id},--}}
{{--                success: function(data){--}}
{{--                    console.log(data.success)--}}
{{--                    console.log(status);--}}
{{--                    var clas='cl_'+brand_id;--}}
{{--                    if(status==1){--}}
{{--                        $('.'+row).attr('value', '1');--}}
{{--                        $('.'+clas).html('نشط');--}}
{{--                        $('.'+clas).removeClass('btn-danger');--}}
{{--                        $('.'+clas).addClass('btn-success');--}}
{{--                    }--}}
{{--                    else{--}}
                       {{-- $('.'+row).attr('value', '0');
{{--                        $('.'+clas).html('غير نشط');--}}
{{--                        $('.'+clas).removeClass('btn-success');--}}
{{--                        $('.'+clas).addClass('btn-danger');--}}
{{--                    }--}}

{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection --}}
