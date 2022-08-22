<div class="third" style="display: none;">
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

                <select name="country_thrd" class="select2 SpecificInput">


                    @foreach($countries as $country)
                        <option value="{{$country->id}}">
                            @if(app()->getLocale() == 'ar')

                                {{$country->ar_name}}

                            @else
                                {{$country->en_name}}
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

                <input type="text" name="ar_facility_name" class="SpecificInput" >

            </div>

            <div class="form-group mtop-15">
                <label>
                    @if(app()->getLocale() == 'ar')
                        إسم المنشأة   الانجليزية
                    @else
                        Name of your facility in English
                    @endif <small class="text-danger">*</small>

                </label>

                <input type="text" name="en_facility_name" class="SpecificInput" >

            </div>


        </div>

    </div>
</div>