@extends('dashboard.layout.app')
@section('content')
    <?php
    App::setlocale('ar');
    ?>
<div class="card-body"
     style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;" dir="rtl">

    <div class="form-body">
        <form method="POST" action="{{route('accessories-Store')}}"
              enctype="multipart/form-data" novalidate>
            @csrf
            @if(app()->getLocale() == 'ar')
                <style>
                    .form-group {
                        direction: rtl;
                        text-align: right !important;
                    }
                </style>

                <div class="form-group">
                    <label style="display:block">
                        النوع <small class="text-danger">*</small>

                    </label>
                    <select class="SpecificInput catChange select2"
                            name="category_id" style="width:100%;">
                        @foreach($viewcategories as $categories)
                            <option value="{{$categories->id}}">

                                {{$categories->ar_name}} <small
                                    class="text-danger">*</small>


                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label style="display:block">
                        البلد <small class="text-danger">*</small>

                    </label>
                    <select class="SpecificInput countChange select2"
                            name="country_id" style="width:100%;">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->ar_name}}
                            </option>


                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        إسم الاعلان بالعربية <small class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="ar_name" maxlength="191"
                           class="SpecificInput">
                </div>

                <div class="form-group">
                    <label>
                        إسم الاعلان بالانجليزيه <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="en_name" maxlength="191"
                           class="SpecificInput">
                </div>

                <div class="form-group">
                    <label>
                        الوصف بالعربية <small
                            class="text-danger">*</small>
                    </label>
                    <textarea required="required" name="ar_desciption"
                              style="min-height: 100px"
                              class="SpecificInput"></textarea>
                </div>

                <div class="form-group">
                    <label>
                        الوصف بالانجليزيه <small
                            class="text-danger">*</small>
                    </label>
                    <textarea required="required" name="en_description"
                              style="min-height: 100px"
                              class="SpecificInput"></textarea>

                </div>

                <div class="form-group">
                    <label>
                        السعر <small class="text-danger">*</small>
                    </label>
                    <input type="text"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                           required="required" name="price"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        نسبة الخصم % <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                           required="required" name="discount" value="0"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        قيمة الخصم<small class="text-danger">*</small>
                    </label>
                    <input type="text"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                           required="required" name="dicount_percent"
                           value="0" class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        تاريخ بداية الخصم<small
                            class="text-danger">*</small>
                    </label>
                    <input type="date" required="required"
                           name="start_date" class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        تاريخ نهاية الخصم <small
                            class="text-danger">*</small>
                    </label>
                    <input type="date" required="required"
                           name="end_date" class="SpecificInput">
                </div>

            @else
                <style>
                    .form-group {
                        direction: ltr;
                        text-align: left !important;
                    }
                </style>
                <div class="form-group">
                    <label style="display:block">

                        Categories <small class="text-danger">*</small>
                    </label>
                    <select class="SpecificInput catChange select2"
                            name="category_id" style="width:100%;">
                        @foreach($viewcategories as $categories)
                            <option value="{{$categories->id}}">


                                {{$categories->en_name}} <small
                                    class="text-danger">*</small>

                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label style="display:block">

                        Countries <small class="text-danger">*</small>
                    </label>
                    <select class="SpecificInput countChange select2"
                            name="country_id" style="width:100%;">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->en_name}}
                            </option>

                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>
                        department name in arabic <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="ar_name" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        department name in english <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="en_name" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        description in arabic <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="ar_desciption" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        description in english <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required"
                           name="en_description" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        price <small class="text-danger">*</small>
                    </label>
                    <input type="text"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                           required="required" name="price"
                           maxlength="191" class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        discount percentage % <small
                            class="text-danger">*</small>
                    </label>
                    <input type="tel" required="required"
                           name="discount" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        discount value <small
                            class="text-danger">*</small>
                    </label>
                    <input type="tel" required="required"
                           name="dicount_percent" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        discount start date<small
                            class="text-danger">*</small>
                    </label>
                    <input type="date" required="required"
                           name="start_date" maxlength="191"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>
                        discount in date <small
                            class="text-danger">*</small>
                    </label>
                    <input type="date" required="required"
                           name="end_date" maxlength="191"
                           class="SpecificInput">
                </div>

            @endif
            <div class="form-group">
                <label>
                    الصورة الرئيسية <small
                        class="text-danger">*</small>
                </label>
                <input type="file" name="main_image" class="SpecificInput">
            </div>
            <div>
                <label for="images">Select Images:</label>
                <input type="file" id="images" name="images[]" multiple><br><br>


            </div>

            <div>
                @if(app()->getLocale() == 'ar')
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">اغلاق
                    </button>
                    <input type="submit" name="submit" class="btn btn-primary"
                           value="حفظ">
                @else
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <input type="submit" name="submit" class="btn btn-primary"
                           value="Save">
                @endif
            </div>
        </form>
    </div>


</div>



@endsection
