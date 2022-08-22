@extends('dashboard.layout.app')
@section('content')
    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                أسعار الإشعارات
            </h5>
            <a href="#" data-toggle="modal" data-target="#create" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                أسعار الإشعارات 
            </label>
            <table class="table table-stroped table-responsive table-straped text-center ">
                <thead class="table-primary">
                <th>
                    رقم
                </th>
                <th>
                     الاسم بالعربى
                </th>

                <th>
                    الاسم بالانجلش
                </th>
                 <th>السعر</th>
                 <th>العدد</th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody >
                @foreach($prices as $key=>$price)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$price->name_ar}}
                        </td>
                        <td  dir="ltr" class="text-left">
                            {{$price->name_en}}
                        </td>
                        <td>{{$price->price}}</td>
                        <td>{{$price->number}}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$price->id}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> تعديل
                            </a>
{{--                            <a href="{{route('notification-price.destroy',$price->id)}}" id="confirmDelete" class="btn btn-danger">--}}
{{--                                <i class="fa fa-trash text-white"></i> حذف--}}
{{--                            </a>--}}
{{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
{{--                               data-action="{{ route('notification-price.destroy', $price->id) }}">--}}
{{--                                <i class="fa fa-close text-danger"></i>حذف--}}
{{--                            </a>--}}
                            <a class=" btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('notification-price.destroy', $price->id)}}">
                                <i class="fa fa-trash text-white text-primary"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$prices->links()}}
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة باقة جديدة</h5>
                </div>
                <form class="form" method="post" action="{{route('notification-price.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>
                                الاسم بالعربى
                            </label>
                            <input type="text" name="name_ar" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                                الاسم بالانجلش
                            </label>
                            <input dir="ltr" type="text" name="name_en" class="SpecificInput text-left" required>
                        </div>
                        <div class="form-group">
                            <label>
                              السعر
                            </label>
                            <input type="text" name="price" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                              العدد
                            </label>
                            <input type="number" name="number" class="SpecificInput" required>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @foreach($prices as $price)
        <div class="modal fade" id="edit{{$price->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="tdocument">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إضافة  سعر جديد</h5>
                    </div>
                    <form class="form" method="post" action="{{route('notification-price.update',$price->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$price->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                    الاسم بالعربية
                                </label>
                                <input type="text" value="{{$price->name_ar}}" name="name_ar" class="SpecificInput" required="required">
                            </div>

                            <div class="form-group">
                                <label>
                                    الاسم بالانجليزيه
                                </label>
                                <input dir="ltr" type="text" value="{{$price->name_en}}" name="name_en" class="SpecificInput textl-left" required="required">
                            </div>

                            <div class="form-group">
                                <label>
                                    السعر
                                </label>
                                <input type="text" name="price" value="{{$price->price}}" class="SpecificInput" required>
                            </div>
                             <div class="form-group">
                                <label>
                                    العدد
                                </label>
                                <input type="number" name="number" value="{{$price->number}}" class="SpecificInput" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

@endsection

@section('js')

@endsection
