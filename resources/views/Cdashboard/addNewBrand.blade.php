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

        <div class="form-body">
            <form action="{{route('add_brands',$document,$lang)}}" method="post">
                @csrf
                <input type="hidden" id="doc_id" value="{{$document}}">
                <div class="form-group">
                    <div class="text-center">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>
                                    @if(app()->getLocale() == 'ar')
                                        البراند
                                    @else
                                        Brand
                                    @endif
                                </label>
                                <?php $brands = \App\brands::get(); ?>
                                <select class="SpecificInput select2 brandChange">
                                    <option disabled selected>
                                        @if(app()->getLocale() == 'ar')
                                            إختر نوع البراند

                                        @else

                                            Choose brand name

                                        @endif
                                    </option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">

                            </div>
                        </div>

                    </div>
                    <div id="inbrandtable" class="table-responsive">
                        <table class="table table-stroped table-responsive table-borderd text-center modelTable">
                            <thead class="bg-light ">
                            <td>
                                #
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    الموديل
                                @else
                                    Model
                                @endif
                            </td>
{{--                            <td>--}}
{{--                                @if(app()->getLocale() == 'ar')--}}
{{--                                    نوع الاستخدام--}}
{{--                                @else--}}
{{--                                    Type of use--}}
{{--                                @endif--}}
{{--                            </td>--}}
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

                            </tbody>

                        </table>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="{{__('site.save')}}">
                    </div>
                </div>
            </form>
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
                        $(".modelTable tbody").append('<tr><td><input type="checkbox" name="model_id[]" value="' + item.id + ',' + id + '" /></td>' +
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
