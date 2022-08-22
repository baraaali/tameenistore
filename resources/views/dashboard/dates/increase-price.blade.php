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

        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                جميع الاعضاء
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
                    الرصيد
                </th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody>
                @foreach($users as $key=>$user)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->balance->balance??0}}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$user->id}}"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>اضافة رصيد
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$users->links()}}

        </div>
    </div>



    @foreach($users as $user)
        <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة رصيد</h5>
                    </div>
                    <form class="form" method="post" action="{{route('charge_balance_user',$user->id)}}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                               شحن رصيد بقيمه
                                </label>
                                <input type="number" value="" name="value" class="SpecificInput" required="required">
                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">اضافه </button>
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
