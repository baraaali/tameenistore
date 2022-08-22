@extends('dashboard.layout.app')
@section('content')
    <div class="card text-white bg-primary shadow">
        <div class="card-header">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                الاعضاء
            </h5>

            <a href="{{route('users-archive')}}" class="btn btn-light" style="float: left">
                <i class="fas fa-trash"></i>
            </a>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                جميع الاعضاء
            </label>

            <br>

            <table class="table table-stroped table-responsive  table-responsive ">
                <thead class="table table-stroped table-responsive table-primary ">
                <th>
                    الرقم
                </th>
                <th>
                    الاسم
                </th>
                <th>
                    البريد الالكتروني
                </th>

                <th>
                    تاريخ الاشتراك
                </th>
                <th>
                    تاريخ انتهاء الاشتراك
                </th>

                <th>
                    العضوية
                </th>

                <th>
                    ip
                </th>
                <th>
                    أخر تسجيل دخول
                </th>
                <th>الدوله</th>
                <th>
                    بلوك
                </th>
                <th>تجديد العضويه</th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody>
                @foreach($users as $key=>$user)
                    <tr>
                        <td>
                            {{$key+1}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>

                        <td>
                            {{$user->started_at}}
                        </td>
                        <td>
                            {{$user->ended_at}}
                        </td>
                        <td>
                            <?php
                            if ($user->type == 0) {
                                echo 'بائع / شاري';
                            } else if ($user->type == 1) {
                                echo 'معرض';
                            } else if ($user->type == 2) {
                                echo 'وكالة بيع';
                            } else if ($user->type == 3) {
                                echo 'وكالة شراء';
                            }


                            ?>
                        </td>

                        <th>
                            {{$user->ip_address}}
                        </th>
                        <th>
                            {{$user->last_login}}
                        </th>
                        <th>{{\App\country::find($user->country_id)->ar_name}}</th>

                        <td>
                            @if($user->block == 1)
                                <a href="{{route('users-delete',$user->id)}}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-stop-circle"></i>

                                </a>
                            @else

                                <a href="{{route('users-unblock',$user->id)}}" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i>

                                </a>
                            @endif
                        </td>
                        <th>
                            <a href="#" data-toggle="modal" data-target="#edit{{$user->id}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> تجديد العضويه
                            </a>
                        </th>
                        <td>
                                <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> تعديل
                                </a>
                            <a class=" btn btn-warning" onclick="return confirm('Are you sure?')"
                               href="{{route('users.delete', $user->id)}}">
                                <i class="fa fa-trash text-white text-primary"></i> </a>
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
            {{$users->links()}}
        </div>
    </div>

   @foreach ($users as $user)
        <!-- Modal -->
        <div class="modal fade" id="edit{{$user->id}}" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-primary">تجديد العضويه</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form" method="post" action="{{route('renew_member_user')}}">
                        @csrf
                            <input type="date" class="form-group form-control" name="date">
                            <input type="hidden" name="user" value="{{$user->id}}">
                            <hr>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

   @endforeach

@endsection
