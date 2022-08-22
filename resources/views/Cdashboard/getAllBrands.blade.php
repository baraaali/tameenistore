@extends('Cdashboard.layout.app')
@section('controlPanel')

    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>


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

    <div class="card-body"
         style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
       <div class="btn btn-secondary">
           <a href="{{route('Cdashboard-insurance',$lang)}}" class="text-warning">{{__('site.go_back')}}</a></div>
        <div class="form-body">
            <div class="text-center text-warning">{{__('site.all_brands')}}</div>
           @foreach($rows as $row)
            <form action="{{route('change_date_brand',$row->id,$lang)}}" method="post">
                @csrf
                <div class="form-group mb-5">
                    <div id="inbrandtable" class="table-responsive">
                        <table class="table table-stroped table-responsive   text-center modelTable">
                            <thead class="table-active">
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    الموديل
                                @else
                                    Model
                                @endif
                            </td>
                            <td>{{__('site.brand')}}</td>
                            <td>{{__('site.status')}}</td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    السعر
                                @else
                                    Price
                                @endif
                            </td>

                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الاولي
                                @else
                                    First Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثانيه
                                @else
                                    second Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثالثه
                                @else
                                    third Insurance Interval
                                @endif
                            </td>

                            </thead>
                            <tbody>
                            <tr>
                                <td>{{\App\brands::where('id',$row->brand_id)->first()->name}}</td>
                                <td>{{\App\models::where('id',$row->model_id)->first()->name}}</td>
                                <td>
                                    <select name="status" class="form-group ">
                                        <option value="0" @if ($row->status==0) selected @endif>{{__('site.not_active')}}</option>
                                        <option value="1"  @if ($row->status==1) selected @endif>{{__('site.active')}}</option>
                                    </select>
                                </td>
                                <td><input type="text" name="price" value="{{$row->price}}"></td>
                                <td><input type="text" name="firstinterval" value="{{$row->firstinterval}}"></td>
                                <td><input type="text" name="secondinterval" value="{{$row->secondinterval}}"></td>
                                <td><input type="text" name="thirdinterval" value="{{$row->thirdinterval}}"></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="{{__('site.save')}}">
                    </div>
                </div>
            </form>

            @endforeach
        </div>


    </div>


    <script>
        $(document).ready(function () {
            $('.brandChange').change(function () {
                id = $(this).val();
                other = $('#doc_id').val();
                $.ajax({
                    url: "{{url('/')}}/view/childerns/models/" + $(this).val()+'/'+other,
                    context: document.body
                }).done(function (data) {
                    // <input type="hidden" name="brand_id[]" value="'+id+'">
                    $.each(data, function (i, item) {
                        $(".modelTable tbody").append('' +
                            '<tr><td><input type="checkbox" name="model_id[]" value="' + item.id + ',' + id + '" /></td>' +
                            '<td>' + item.name + '</td>' +
                            // '<td><select name="type_of_use[]" class="SpecificInput select2">' +
                            // '<option value="private"> خاص</option>' +
                            // '<option value="rent"> أجرة</option>' +
                            // '</select></td>' +
                            '<td><input type="text" name="price[]"></td>' +
                            '<td><input type="text" name="firstinterval[]"></td>' +
                            '<td><input type="text" name="secondinterval[]"></td>' +
                            '<td><input type="text" name="thirdinterval[]"></td>' +
                            '</tr>');

                    });

                });
            });
        });
    </script>

    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js"
            referrerpolicy="origin">
    </script>
    <script> tinymce.init({selector: 'textarea'});</script>

@endsection
