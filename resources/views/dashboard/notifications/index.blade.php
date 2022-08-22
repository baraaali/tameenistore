@extends('dashboard.layout.app')
@section('content')

    @if(app()->getLocale() == 'ar')

        <style>
            .form-group {
                direction: rtl;
                text-align: right !important;
            }
        </style>

    @else

        <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
        </style>

    @endif
    <style>
        label {
            display: block;
        }

        .select2-container--default .select2-selection--single {
            width: 272px;
        }
    </style>
    <div class="col-lg-12">
        @include('dashboard.layout.message')
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">
                                    @if(app()->getLocale() == 'ar')
                                         الإشعارات
                                    @else
                                        Notifications
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        جميع   الإشعارات
                                    @else
                                        All Notifications
                                    @endif
                                </label>
                                <br>
                                @if ($notifications->count())
                                <table class="table d-block table-stroped table-responsive">
                                    <thead class="bg-light ">
                                        <td>
                                            الموضوع
                                        </td>
                                        <td>
                                            الرسالة
                                        </td>
                                        <td>
                                            التاريخ
                                         </td>
                                         <td>
                                            عمليات
                                         </td>
                               
                                    </thead>
                                    <tbody>
                                    @foreach($notifications as $notification)
                                        <tr
                                        @if ($notification->viewed == '0')
                                        style="background-color: #f7f7f7"
                                        @endif
                                        >
                                            <td>
                                                {{__($notification->subject)}}
                                            </td>
                                            <td dir="rtl" class="text-right">
                                                {!!__($notification->body)!!}
                                            </td>
                                            <td>
                                                {{$notification->created_at}}
                                            </td>
                                            <td>
                                                <button  onclick="if(confirm('هل تريد الحذف?')) $('#delete-form').submit()"  class="btn btn-xs btn-danger">حذف</button>
                                                <form id="delete-form" method="POST" action="{{route('user-notifications.destroy',$notification->id)}}">
                                                  <input type="hidden" name="_method" value="delete">
                                                  @csrf
                                                </form>
                                            </td>
                                               

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$notifications->links()}}
                                @else
                                  <div class="bg-light p-2 text-center border">لا يوجد إشعارات</div>  
                                @endif
                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


