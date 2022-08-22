@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
               الاعضاء
            </h5>
            <a href="#" data-toggle="modal" data-target="#create" class="btn btn-light"
               style="float: left;margin-right:10px;">
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                جميع اعضاء التأمين
            </label>
            <table class="table table-stroped table-responsive table-straped text-center">
                <thead class="bg-light ">
                <th>
                    رقم
                </th>
                <th>
                    الاسم
                </th>
                <th>
                    الايميل
                </th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody>
                @foreach($agents as $key=>$agent)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$agent->owner->name}}
                        </td>
                        <td>
                            {{$agent->owner->email}}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$agent->user_id}}"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i> تجديد الاشتراك
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$agents->links()}}

        </div>
    </div>



    @foreach($agents as $agent)
        <div class="modal fade" id="edit{{$agent->user_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
                    </div>
                    <form class="form" method="post" action="{{route('date.renew',[$agent->user_id,$type])}}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                  تجديد الاشتراك حتى
                                </label>
                                <input type="date" value="" name="date" class="SpecificInput" required="required">
                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">تجديد</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#confirmDelete').on('click', function () {
                var action = $(this).attr
                alert(action);
            });
        });


    </script>

@endsection
