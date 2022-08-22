@extends('layouts.app')
@section('content')
    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>

    <div class="col-lg-12">
@include('dashboard.layout.message')
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">


                    @if(app()->getLocale() == 'ar')
                        <a class="nav-link" id="v-pills-home-tab" href="{{url('/')}}/cp/index/{{app()->getLocale()}}"
                           aria-controls="v-pills-home" aria-selected="false">معلومات رئيسية</a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ads/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">إعلانات</a>
                        <!--اhref-->
                        <a class="nav-link active" id="v-pills-accessories-tab" href=""
                           aria-controls="v-pills-accessories" aria-selected="true">أقسام</a>


                        <a class="nav-link " id="v-pills-profile-tab"
                           href="{{url('/')}}/Cdashboard/insurance/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">تأمين</a>
                        @if(auth()->user()->type==3)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="{{route('my_orders',$lang)}}" aria-controls="v-pills-messages"
                               aria-selected="false">
                                <span
                                    class="badge badge-pill badge-danger m-1">{{\App\Booking::with('owner')->count()}}</span>طلباتى
                            </a>
                        @endauth
                        @if(auth()->user()->type >= 1)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="/Cdashboard/branches/{{app()->getLocale()}}" aria-controls="v-pills-messages"
                               aria-selected="false">معلومات الفروع</a>
                        @endif



                    @else
                        <a class="nav-link" id="v-pills-home-tab" href="{{url('/')}}/cp/index/{{app()->getLocale()}}"
                           aria-controls="v-pills-home" aria-selected="false">Personal Information</a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ads/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Advertisment</a>

                        <!--aria control &href-->
                        <a class="nav-link active" id="v-pills-accessories-tab" href=""
                           aria-controls="v-pills-accessories" aria-selected="true"> Departments </a>

                        <a class="nav-link" id="v-pills-profile-tab" href="{{url('/')}}/cp/ins/{{app()->getLocale()}}"
                           aria-controls="v-pills-profile" aria-selected="true">Insurance</a>


                        @if(auth()->user()->type >= 1)
                            <a class="nav-link" id="v-pills-messages-tab"
                               href="{{url('/')}}/Cdashboard/branches/{{app()->getLocale()}}"
                               aria-controls="v-pills-messages" aria-selected="false">Branches</a>
                        @endif

                    @endif

                </div>
            </div>


            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative; display: inline-block;top: 6px;">
                                    {{__('site.orders')}}
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">{{__('site.all_orders')}}</label>
                                <br>

                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                        <td>
                                            #
                                        </td>
                                        <td>
                                            {{__('site.name')}}
                                        </td>
                                        <td>
                                            {{__('site.show')}}
                                        </td>
                                        <td>{{__('site.delete')}}</td>
                                        <td></td>
                                    </thead>

                                    <?php
                                    $name = $lang .'_name';
                                    ?>
                                    @foreach($books  as $key=>$book)
                                        <tbody>
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$book->name}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#show-order">
                                                    {{__('site.show')}}
                                                </button>
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')" href="{{route('order-delete',$book->id)}}"
                                                   class="btn btn-danger">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                            </td>

                                        </tr>

                                        </tbody>
                                    @endforeach
                                </table>

                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>

@if(count($books)>0)
    <div class="modal fade" id="show-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('site.order-show')}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>{{__('site.name')}} : </label>
                                <span class="text-danger text-center">{{$book->name}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{__('site.booking_date')}} {{__('site.from')}} : </label>
                                <span class="text-danger text-center">{{$book->from_date}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{__('site.to')}} :</label>
                                <span class="text-danger text-center">{{$book->to_date}}</span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputAddress2">{{__('site.address')}}:</label>
                                <span class="text-danger text-center">{{$book->address}}</span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputAddress2">{{__('site.phone')}} :</label>
                                <span class="text-danger text-center">{{$book->phone}}</span>                            </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputAddress2">{{__('site.car_name')}} :</label>
                                <span class="text-danger text-center">{{$book->cars->$name}}</span>                            </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                </div>

            </div>
        </div>
    </div>
@endif

@endsection
