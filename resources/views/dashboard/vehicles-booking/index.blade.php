@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative; display: inline-block;top: 6px;">
                {{__('site.vehicles booking')}} 
            </h5>
                </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <div class="col-md-12">
          
            </div>
            <div class="data-table">
                @include('dashboard.vehicles-booking.table',['items'=>$items])
            </div>
        </div>
    </div>



  



@endsection

@section('js')

    <script>
        $(':button').on('click', function () {
            var brand_id = $(this).attr('id');
            var row = 'statusVal_' + brand_id;
            var data = $('.' + row).val();
            var status = data == 0 ? 1 : 0;
            console.log(status);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/items/itemChangeStatus',
                data: {'status': status, 'brand_id': brand_id},
                success: function (data) {
                    console.log(data.success)
                    console.log(status);
                    var clas = 'cl_' + brand_id;
                    if (status == 1) {
                        $('.' + row).attr('value', '1');
                        $('.' + clas).html('نشط');
                        $('.' + clas).removeClass('btn-danger');
                        $('.' + clas).addClass('btn-success');
                    } else {
                        $('.' + row).attr('value', '0');
                        $('.' + clas).html('غير نشط');
                        $('.' + clas).removeClass('btn-success');
                        $('.' + clas).addClass('btn-danger');
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
                url: '/dashboard/items',
                data: filters,
                success: function (data) {
                    $('.data-table').html(data)
                },
                error:function(e){
                    console.log(e);
                }
            })
        }
          $(document).ready(function(){
              var filters = {}
             $('.filter select').on('change',function(){
                 if($(this).val() != '')
                 filters[$(this).attr('name')] = $(this).val()
                 updateDataFilter(filters)
             })
             $('.search').on('input',function(){
                if($(this).val() != '')
                updateDataFilter({'search':$(this).val()})
             })


            })
    </script>
@endsection
