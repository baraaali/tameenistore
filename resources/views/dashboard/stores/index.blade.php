@extends('dashboard.layout.app')
@section('content')
 <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
            display: inline-block;
            top: 6px;">
            المحالات  
            </h5>
            <a href="{{route('stores.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <div class="filter col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control" id="search"  placeholder="بحث">
                </div>
            </div>
            <label style="display: block">
                المحالات    
            </label>
            <div class="data-table">
                @include('dashboard.stores.table')
            </div>
            
        </div>
    </div>
    <div class="modal-edit">

    </div>


@endsection

@section('js')

    <script>

        var search  = function(){
            $('#search').on('input',function(){
				var search = $(this).val()
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('stores.search')}}",
					type:'post',
					data : {search:search},
					success : function(res){
						$('.data-table').html(res)
					}
				})
			})
        }
        var loadEditModal = function(){
            $(document).on('click','.edit',function(){
                var _id = $(this).attr('_id')
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: '/dashboard/stores/'+_id+'/edit',
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
            search()
            loadEditModal()
        })
      
    </script>
@endsection
