@extends('dashboard.layout.app')
@section('css')

@section('content')
 <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                   الأقسام الفرعية للخدمات  
            </h5>
            <a href="{{route('service_sub_categories.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <div class="filter col-md-12">
                <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search"  placeholder="بحث">
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select value="" class="form-control select2" name="service_category_id_filter" id="service_category_id_filter"> 
                            <option value="" selected >{{__('site.category')}}</option>
                            @foreach($service_categories as $service_category)
                              <option value="{{$service_category->id}}">
                                  {{$service_category->ar_name}}
                              </option>
                          @endforeach
                        </select>
                     </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select value="" class="form-control select2" name="status" id="status"> 
                            <option value="" selected >{{__('site.status')}}</option>
                            <option value="1"  >{{__('site.active')}}</option>
                            <option value="0"  >{{__('site.deactive')}}</option>
                           
                        </select>
                     </div>
                </div>
                </div>
            </div>
            <label style="display: block">
                الأقسام الفرعية للخدمات  
            </label>
            <div class="data-table">
                @include('dashboard.service_sub_categories.table')

            </div>
        </div>
    </div>

    @foreach($service_sub_categories as $service_sub_category)
        <div class="modal fade" id="edit{{$service_sub_category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> تعديل</h5>
                    </div>
                    <form class="form" method="post" action="{{route('service_sub_categories.update',$service_sub_category->id)}}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$service_sub_category->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="service_category_id"> القسم </label>
                                <select value="{{$service_sub_category->serviceCategory->id}}" class="form-control select2" name="service_category_id" id="service_category_id"> 
                                  @foreach($service_categories as $service_category)
                                      <option value="{{$service_category->id}}">
                                          {{$service_category->ar_name}}
                                      </option>
                                  @endforeach
                                </select>
                             </div>
                            <div class="form-group">
                                <label>
                                    الاسم بالعربية
                                </label>
                                <input type="text" value="{{$service_sub_category->getName('ar')}}" name="ar_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    الإسم بالإنجليزية
                                </label>
                                <input type="text" value="{{$service_sub_category->getName('en')}}" name="en_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label class="d-block">
                                    الوصف بالعربية
                                </label>
                                <textarea name="ar_description" id="ar_description" rows="4" class="w-100">{{$service_sub_category->getDescription('ar')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-block">
                                    الوصف بالإنجليزية
                                </label>
                                <textarea name="en_description" id="en_description" rows="4" class="w-100">{{$service_sub_category->getDescription('en')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                     الصورة
                                </label>
                                <input type="file" name="image" >
                            </div>
                          
                            <div class="form-group">
                                <input type="checkbox" {{$service_sub_category->status == 1 ? 'checked' : ''}} name="status" value="1">
                                <label>
                                    نشر ؟
                                </label>

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

@endsection

@section('js')

    <script>
        var search  = function(){
            var data = {}
            var  ajax_filter = function(data)
            {
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('service_sub_categories.search')}}",
					type:'post',
					data : data,
					success : function(res){
						$('.data-table').html(res)
					}
				})
            }
            $('#service_category_id_filter').on('change',function(){
                data['service_category_id'] = $(this).val()
                ajax_filter(data)
            })
            $('#status').on('change',function(){
                data['status'] = $(this).val()
                ajax_filter(data)
            })
            $('#search').on('input',function(){
                data['search'] = $(this).val()
                ajax_filter(data)
			})
        }
        $(document).ready(function(){
            search()
        })
    </script>
@endsection
