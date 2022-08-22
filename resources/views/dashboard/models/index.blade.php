@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                كل الاعلانات
            </h5>
            <a href="{{route('models.create')}}" class="btn btn-light"
               style="float: left;margin-right:10px;">
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
           <div class="row">
            <div class="filter col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control" id="search"  placeholder="بحث">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select value="" class="form-control select2" name="vehicle_id" id="vehicle_id"> 
                        <option value="" selected >نوع العربة</option>
                        @foreach($vehicles as $vehicle)
                          <option value="{{$vehicle->id}}">
                              {{$vehicle->ar_name}}
                          </option>
                      @endforeach
                    </select>
                 </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select value="" class="form-control select2" name="brand_id" id="brand_id"> 
                        <option value="" selected >ماركة</option>
                        @foreach($brands as $brand)
                          <option value="{{$brand->id}}">
                              {{$brand->name}}
                          </option>
                      @endforeach
                    </select>
                 </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select value="" class="form-control select2" name="care_shape_id" id="care_shape_id"> 
                        <option value="" selected >الشكل</option>
                        @foreach($careshapes as $careshape)
                          <option value="{{$careshape->id}}">
                              {{$careshape->ar_name .'-'.$careshape->en_name}}
                          </option>
                      @endforeach
                    </select>
                 </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select value="" class="form-control select2" name="status" id="status"> 
                        <option value="" selected >{{__('site.status')}}</option>
                        <option value="1"  >{{__('site.active')}}</option>
                        <option value="0"  >{{__('site.deactive')}}</option>
                       
                    </select>
                 </div>
            </div>
           </div>

            <label style="display: block">
                جميع الموديلات
            </label>
            <div class="data-table">
                @include('dashboard.models.table')
            </div>

        </div>
    </div>
    <div class="modal-edit"></div>
     
@endsection

@section('js')
    <script>
        
        var search  = function(){
            var data = {}
            var ajax_filter = function(data){
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('models.search')}}",
					type:'post',
					data : data,
					success : function(res){
                        console.log(res);
						$('.data-table').html(res)
					}
				})
            }
            $('#search').on('input',function(){
				data['search'] = $(this).val()
                ajax_filter(data)
			})
             $('#vehicle_id').on('change',function(){
				data['vehicle_id'] = $(this).val()
                ajax_filter(data)
			})
            $('#brand_id').on('change',function(){
                data['brand_id'] = $(this).val()
                ajax_filter(data)
            }) 
            $('#care_shape_id').on('change',function(){
                data['care_shape_id'] = $(this).val()
                ajax_filter(data)
            })
            $('#status').on('change',function(){
                data['status'] = $(this).val()
                ajax_filter(data)
            })
        }
        var loadEditModal = function(){
            $(document).on('click','.edit',function(){
                var _id = $(this).attr('_id')
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: '/dashboard/models/'+_id+'/edit',
					type:'get',
					success : function(res){
                        console.log(res);
						$('.modal-edit').html(res)
                        $('#edit'+_id).modal('show')
                       
					}
				})
            })
        }

        $(document).ready(function () {
            $('#confirmDelete').on('click', function () {
                var action = $(this).attr
                alert(action);
            });
            search()
            loadEditModal()
        });


    </script>

@endsection
