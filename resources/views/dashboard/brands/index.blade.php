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

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                كل الماركات
            </h5>
            <a href="{{route('brands.create')}}"  class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
                 <div class="row">
                   <div class="col-md-5">
                    <div  class="form-group p-0">
                        <input type="text" class="search form-control text-right" name="search" placeholder="بحث">
                </div>
                   </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select value="" class="form-control select2" id="vehicle_id_filter"> 
                            <option value="" selected >نوع العربة</option>
                            @foreach($vehicles as $vehicle)
                              <option value="{{$vehicle->id}}">
                                  {{$vehicle->ar_name}}
                              </option>
                          @endforeach
                        </select>
                     </div>
                </div>
                 </div>

                  
            <label style="display: block">
                جميع الماركات
            </label>
          <div class="data-table">
              @include('dashboard.brands.table')
          </div>
        </div>
    </div>

    <div class="modal-edit"></div>


@endsection

@section('js')

    <script>
        $(document).on('click',':button', function() {
            var brand_id = $(this).attr('id');
            var row='statusVal_'+brand_id;
            var data = $('.'+row).val();
            var status=data==0?1:0;
            console.log(status);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/brands/brandChangeStatus',
                data: {'status': status, 'brand_id': brand_id},
                success: function(data){
                    console.log(data.success)
                    console.log(status);
                    var clas='cl_'+brand_id;
                    if(status==1){
                        $('.'+row).attr('value', '1');
                        $('.'+clas).html('نشط');
                        $('.'+clas).removeClass('btn-danger');
                        $('.'+clas).addClass('btn-success');
                    }
                    else{
                        $('.'+row).attr('value', '0');
                        $('.'+clas).html('غير نشط');
                        $('.'+clas).removeClass('btn-success');
                        $('.'+clas).addClass('btn-danger');
                    }

                }
            });
        });

        // filters handler
        var updateDataFilter = function(filters){
            $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('brands.search')}}",
                data: filters,
                success: function (data) {
                    $('.data-table').html(data)
                },
                error:function(e){
                    console.log(e);
                }
            })
        }

        var loadEditModal = function(){
            $(document).on('click','.edit',function(){
                var _id = $(this).attr('_id')
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: '/dashboard/brands/'+_id+'/edit',
					type:'get',
					success : function(res){
                        console.log(res);
						$('.modal-edit').html(res)
                        $('#edit'+_id).modal('show')
                       
					}
				})
            })
        }
        $(document).ready(function(){
              var filters = {}
             $('.search').on('input',function(){
                filters['search'] =  $(this).val()
                updateDataFilter(filters)
             })
             $('#vehicle_id_filter').on('change',function(){
                filters['vehicle_id'] =  $(this).val()
                updateDataFilter(filters)
             })

             loadEditModal()


            })
    </script>
@endsection
