<div class="fourth" style="display: none;">
    <hr>
    <h1 class="forms-header">
        @if(app()->getLocale() == 'ar')
            معلومات حول منشاتك
        @else
            Information About Your Facility
        @endif
    </h1>
    <div class="break-line-sm">
    </div>
    <div class="row">

        <div class="col-md-4">

            <div class="form-group mtop-15">
                    <label>
                        @if(app()->getLocale() == 'ar')
                            إختر الدولة
                        @else
                            Country
                        @endif <small class="text-danger">*</small>

                    </label>

                    <select name="country_forth" class="select2 SpecificInput">


                        @foreach($countries2 as $coun)
                            <option value="{{$coun->id}}">
                                @if(app()->getLocale() == 'ar')

                                    {{$coun->ar_name}}

                                @else
                                    {{$coun->en_name}}
                                @endif
                            </option>
                        @endforeach
                    </select>

                </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        إسم المنشأة  بالعربية
                    @else
                        Name of your facility in ARABIC
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="ar_name" class="SpecificInput" >

            </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        إسم المنشأة   الانجليزية
                    @else
                        Name of your facility in English
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="en_name" class="SpecificInput" >

            </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        عنوان المنشأة  بالعربية
                    @else
                        Name of Company In Arabic
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="ar_address" class="SpecificInput" >

            </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        عنوان المنشأة  بالانجليزية
                    @else
                        Company Address In English
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="en_address" class="SpecificInput" >

            </div>
            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        التيليفون
                    @else
                        Phones
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="tel" name="phones" class="SpecificInput" >

            </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        الموقع الالكتروني
                    @else
                        Website
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="email" name="website" class="SpecificInput" >

            </div>


            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        موقعنا
                    @else
                        Google Map
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="website" class="SpecificInput">

            </div>
            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        أيام العمل
                    @else
                        Days On
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="days_on" class="SpecificInput">

            </div>
            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        الموقع الالكتروني
                    @else
                        Website
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="email" name="website" class="SpecificInput" >

            </div>
            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        أوقات العمل
                    @else
                        Times On
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="times_on" class="SpecificInput">

            </div>


        </div>

    </div>
</div>