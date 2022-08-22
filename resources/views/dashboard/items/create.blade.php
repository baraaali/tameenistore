@extends('dashboard.layout.app')
@section('content')

<div class="card-body"
    style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;"
    dir="rtl">

    <div class="form-body">
        <form method="POST" action="{{ route('items-Store') }}" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="form-group">
                <label style="display:block">
                    {{__('site.type')}} <small class="text-danger">*</small>
                </label>
                <select class="SpecificInput catChange select2" name="category_id" style="width:100%;">
                    @foreach($viewcategories as $categories)
                    <option value="{{ $categories->id }}">
                        {{ $categories->ar_name }} <small class="text-danger">*</small>
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{__('site.ads_type')}}
                    <span class="text-danger" id="show_price"></span>
                </label>
                <select name="special" class="SpecificInput change_member" id="special">
                    <option>{{__('site.select')}}</option>
                    @foreach( $memberships  as $price)
                        <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->getName()}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label style="display:block">
                    {{__('site.country')}} <small class="text-danger">*</small>

                </label>
                <select class="SpecificInput countChange select2" id="country_id" name="country_id" style="width:100%;">
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">
                        {{ $country->ar_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>
                    {{__('site.the name of the advertisement is in Arabic')}} <small class="text-danger">*</small>
                </label>
                <input type="text" required="required" name="ar_name" maxlength="191" class="SpecificInput">
            </div>

            <div class="form-group">
                <label>
                  {{__('site.the name of the advertisement is in English')}} <small class="text-danger">*</small>
                </label>
                <input type="text" required="required" name="en_name" maxlength="191" class="SpecificInput">
            </div>

            <div class="form-group">
                <label>
                   {{__('site.description in Arabic')}} <small class="text-danger">*</small>
                </label>
                <textarea required="required" name="ar_desciption" style="min-height: 100px"
                    class="SpecificInput"></textarea>
            </div>

            <div class="form-group">
                <label>
                    {{__('site.description in English')}} <small class="text-danger">*</small>
                </label>
                <textarea required="required" name="en_description" style="min-height: 100px"
                    class="SpecificInput"></textarea>

            </div>

            <div class="form-group">
                <label>
                    {{__('site.price')}} <small class="text-danger">*</small>
                </label>
                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    required="required" name="price" class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                    {{__('site.discount percentage %')}} <small class="text-danger">*</small>
                </label>
                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    required="required" name="discount" value="0" class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                   {{__('site.discount value')}}<small class="text-danger">*</small>
                </label>
                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    required="required" name="dicount_percent" value="0" class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                   {{__('site.discount start date')}}<small class="text-danger">*</small>
                </label>
                <input type="date" required="required" name="start_date" class="SpecificInput">
            </div>
            <div class="form-group">
                <label>
                    {{__('site.discount end date')}} <small class="text-danger">*</small>
                </label>
                <input type="date" required="required" name="end_date" class="SpecificInput">
            </div>

            <div>
                <label for="main_image">{{__('site.image')}}</label>
                <input type="file" id="main_image" name="main_image" ><br><br>
            </div>

            <div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('site.close')}}</button>
                <input type="submit" name="submit" class="btn btn-primary" value="  {{__('site.save')}}">
            </div>
        </form>
    </div>

</div>

@endsection
@section('js')
<script>
    $('document').ready(function(){
       var country_id =  $('meta[name="country_id"]').attr('content');
       $('#country_id').val(country_id)
       $('#country_id').trigger('change')
    })
</script>
@endsection