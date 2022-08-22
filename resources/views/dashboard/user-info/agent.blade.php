
@include('dashboard.user-info.user-info')

<div class="col-md-12">
    <h3 class="mb-3  py-3 border-bottom">
        <i class="fa fa-info-circle" aria-hidden="true"></i>

        @if(app()->getLocale() == 'ar')
         بيانات الوكالة

        @else
               Agency informations
        @endif
    </h3>
    <div class="card text-white bg-primary shadow">
        <div class="card-body" style="background-color: white;color:#31353D">
            <form method="POST" action="{{route('account-info')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="@if($agent) {{$agent->id}} @endif">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>
                                إسم الدولة أو المنطقة <small class="text-danger">*</small>
                            </label>
                            <select class="SpecificInput select2" name="country_id">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" @if($agent){{$agent->country_id == $country->id ? 'selected' : ''}} @endif>
                                        {{$country->ar_name}} - {{$country->en_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                إسم الوكالة بالعربية <small class="text-danger">*</small>
                            </label>
                            <input type="text"   value="@if($agent){{$agent->ar_name}}@endif" required="required" name="ar_name" maxlength="191" class="SpecificInput">
                        </div>
                        <div class="form-group">
                            <label>
                                 أرقام الهاتف
                            </label>
                            <input type="text" value="@if($agent){{$agent->phones}}@endif" name="phones" placeholder="0xxxxx-0xxxxxx-0xxxxxx-0xxxxxx"  class="SpecificInput">
                        </div>
                        <div class="form-group">
                            <label>
                                وصف الوكالة بالعربية <small class="text-danger">*</small>
                            </label>
                            <textarea name="ar_address"  class="SpecificInput" rows="3" required="required">@if($agent){{$agent->ar_address}}@endif</textarea>
                        </div>
    
                        <div class="form-group">
                            <label>
                                 صورة الوكالة <small class="text-danger">*</small>
                            </label>
                            <input type="file" name="image" class="SpecificInput">
                            <img src="{{url('/')}}/uploads/@if($agent){{$agent->image}}@endif" style="width: auto;height: 100px;">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 صفحة الفيس بوك
                            </label>
                            <input type="text" name="fb_page" value="@if($agent){{$agent->fb_page}}@endif" class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 إنستجرام
                            </label>
                            <input type="text" name="insta_page" value="@if($agent){{$agent->instagram}}@endif"  class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 تويتر
                            </label>
                            <input type="text" name="twitter_page" value="@if($agent){{$agent->twitter_page}}@endif"  class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 البريد الالكتروني
                            </label>
                            <input type="email" name="email" value="@if($agent){{$agent->email}}@endif"  class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 موقع الالكتروني
                            </label>
                            <input type="text" name="website" value="@if($agent){{$agent->website}}@endif"  class="SpecificInput">
                        </div>
    
    
    
    
                    </div>
    
                    <div class="col-md-2">
    
                    </div>
    
                    <div class="col-md-5">
    
                        <div class="form-group">
                            <label>
                                إسم الوكالة   بالانجليزية <small class="text-danger">*</small>
                            </label>
                            <input type="text" value="@if($agent){{$agent->en_name}}@endif"  required="required" name="en_name" maxlength="191" class="SpecificInput">
                        </div>
                        <div class="form-group">
                            <label>
                                وصف الوكالة   بالانجليزية <small class="text-danger">*</small>
                            </label>
                            <textarea name="en_address" class="SpecificInput" rows="3" required="required">@if($agent){{$agent->en_address}}@endif</textarea>
                        </div>
                        <div class="form-group">
                            <label>
                                 تضمين الخريطة - Google Map
                            </label>
                            <input type="text" name="google_map" value="@if($agent){{$agent->google_map}}@endif"  class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 ايام العمل
                            </label>
                            <input type="text" value="@if($agent){{$agent->days_on}}@endif"  placeholder="السبت إلي الاربعاء"  name="days_on" class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                 مواعيد العمل
                            </label>
                            <input type="text" placeholder="9 : 10 AM"  value="@if($agent){{$agent->times_on}}@endif"  name="times_on" class="SpecificInput">
                        </div>
    
                        <div class="form-group">
                            <label>
                                  أنواع السيارات
                            </label>
                            <select class="SpecificInput" name="car_types" >
                                <option value="2" @if($agent){{$agent->cartypes == 2 ? 'selected' : ''}}@endif> جديد  </option>
                                <option value="1" @if($agent){{$agent->cartypes == 1 ? 'selected' : ''}}@endif> مستعمل </option>
                                <option value="0" @if($agent){{$agent->cartypes == 0 ? 'selected' : ''}}@endif> كلاهما </option>
                            </select>
                        </div>
                            <div class="form-group">
                            <label>
                                   نوع الوكالة
                            </label>
                            <select class="SpecificInput" name="agent_type" >
                                <option value="0" @if($agent){{$agent->agent_type == 0 ? 'selected' : ''}}@endif> بيع   </option>
                                <option value="1" @if($agent){{$agent->agent_type == 1 ? 'selected' : ''}}@endif> إيجار </option>
                            </select>
                        </div>
    
    
                        <div class="form-group">
                            <label>
                                   الحالة
                            </label>
                            <select class="SpecificInput" name="status" >
                                <option value="1" @if($agent){{$agent->status == 1 ? 'selected' : ''}}@endif> نشط  </option>
                                <option value="0" @if($agent){{$agent->status == 0 ? 'selected' : ''}}@endif> غير نشط </option>
                            </select>
                        </div>
    
                        {{-- <div class="form-group">
                            <label>
                                نوع العضوية
                            </label>
                            <select class="SpecificInput" name="specific">
                                <option value="0" @if($agent){{$agent->special == 0 ? 'selected' : ''}}@endif> عادية </option>
                                <option value="1" @if($agent){{$agent->special == 1 ? 'selected' : ''}}@endif> فضية  </option>
                                <option value="2" @if($agent){{$agent->special == 2 ? 'selected' : ''}}@endif> ذهبية </option>
                                <option value="3" @if($agent){{$agent->special == 3 ? 'selected' : ''}}@endif> مميزة </option>
                            </select>
                        </div> --}}
    
                        <div class="form-group">
                            <input type="submit" name="submit" value="حفظ " class="btn btn-dark " style="float: left;">
                        </div>
    
    
    
    
    
    
    
    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>