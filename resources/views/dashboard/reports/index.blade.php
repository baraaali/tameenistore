@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                تقارير المدفوعات
            </h5>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <div class="col-md-12">
                <div class="filter row">
                    <div class="form-group col-md-2">
                     <div  class="form-group">
                       <label class="text-right d-block" for="search">بحث</label>
                       <input type="text" class="search form-control text-right" name="search" placeholder="بحث">
                     </div>
                    </div>
                    <div class="row col-md-8">
                        <div class="form-group col-md-3">
                            <label class="text-right d-block" for="order">الترتيب</label>
                            <select dir="rtl" class="form-control" name="order">
                                <option value="">--إختيار--</option> 
                                <option value="created_at-desc">احدث التقارير اولا</option>
                                <option value="created_at-asc">التقارير القديمه اولا</option>
                            </select>
                          </div>
{{--                        <div class="form-group col-md-2">--}}
{{--                            <label class="text-right d-block" for="order">السعر</label>--}}
{{--                            <select dir="rtl" class="form-control" name="value">--}}
{{--                                <option value="">--إختيار--</option>--}}
{{--                                <option value="value-desc">من الاعلى للاقل</option>--}}
{{--                                <option value="value-asc">من الاقل للاعلى </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                           <div  class="form-group col-md-3">
                             <label class="text-right d-block" for="status">سبب العمليه</label>
                             <select dir="rtl" class="form-control" name="type">
                               <option value="">--إختيار--</option> 
                               <option value="department">مدفوعات اعلان الاقسام</option>
                               <option value="membership">مدفوعات اعلان العضويه</option>
                               <option value="car">مدفوعات اعلان السيارات</option>
                               <option value="charge">عمليه شحن</option>
                             </select>
                           </div>
                           <div  class="form-group col-md-4">
                            <label class="text-right d-block" for="country_id">المستخدم</label>
                            <select dir="rtl" class="form-control" name="user_id">
                            <option value="">--إختيار--</option> 
                            @foreach($users as $user)
                                <option value="{{$user->id}}">
                                    {{$user->name}}
                                </option>
                            @endforeach
                        </select>
                          </div>
                    </div>
               </div>
            </div>
            <label style="display: block">
                جميع البانرات
            </label>
         {{--    {{dd($items)}}
 --}}            <div class="data-table">
                @include('dashboard.reports.table',['items'=>$items])
            </div>
        </div>
    </div>



  



@endsection

@section('js')

    <script>
        // filters handler
        var updateDataFilter = function(filters){
            $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/dashboard/report_filter',
                data: filters,
                success: function (data) {
                    $('.data-table').html(data)
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
                // if($(this).val() != '')
                updateDataFilter({'search':$(this).val()})
             })


            })
    </script>
@endsection
