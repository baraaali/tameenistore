@extends('dashboard.layout.app')
@section('content')
 <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                     عضويات الخدمات  
            </h5>
            <a href="{{route('service_member_ships.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
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
                    <div class="col-md-2">
                     <div class="form-group">
                         <select value="" class="form-control select2" name="category" id="category"> 
                            <option value="">{{__('site.choose')}}</option>
                            @foreach($categories as $category)
                               <option value="{{$category->id}}">
                                   {{$category->ar_name}}
                               </option>
                           @endforeach
                         </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                         <select disabled value="" class="form-control select2" name="sub_category" id="sub_category"> 
                             <option value="">{{__('site.choose')}}</option>
                         </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                         <select disabled value="" class="form-control select2" name="child_category" id="child_category"> 
                           <option value="">{{__('site.choose')}}</option>
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
            </div>
            <label style="display: block">
                عضويات الخدمات    
            </label>
            <div class="data-table">
                @include('dashboard.service_member_ships.table')
            </div>
            
        </div>
    </div>
    <div class="modal-edit">

    </div>

@endsection

@section('js')

    <script>

    var search  = function(){
            var data = {}
            var ajax_filter = function(data){
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('service_member_ships.search')}}",
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
            $('#category').on('change',function(){
                data['category'] = $(this).val()
                ajax_filter(data)
            })
            $('#sub_category').on('change',function(){
                data['sub_category'] = $(this).val()
                ajax_filter(data)
            })
            $('#child_category').on('change',function(){
                data['child_category'] = $(this).val()
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
					url: '/dashboard/service_member_ships/'+_id+'/edit',
					type:'get',
					success : function(res){
                        console.log(res);
                        $('#edit'+_id).modal('hide')
						$('.modal-edit').html(res)
                        $('#edit'+_id).modal('show')
                       
					}
				})
            })
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
                    $('#sub_category').append('<option value="">إختيار</option>')
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
                    $('#child_category').append('<option value="">إختيار</option>')
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
   
        $(document).ready(function(){
            search()
            loadEditModal()
            getSubCategories()
            getChildCategories()
        })
      
    </script>
@endsection
