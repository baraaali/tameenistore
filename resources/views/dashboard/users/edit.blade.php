@extends('dashboard.layout.app')
@section('content')
    <?php
    App::setlocale('ar');
    ?>
    <div class="card-body"
         style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;" dir="rtl">

        <div class="form-body">
            <form method="POST" action="{{route('users.update')}}" enctype="multipart/form-data" novalidate>
                @csrf
                    <div class="form-group">
                        <label>الاسم <small class="text-danger">*</small>
                        </label>
                        <input type="text" required="required" name="name" value="{{$user->name}}" maxlength="191" class="SpecificInput">
                    </div>
                    <input type="hidden" value="{{$user->id}}" name="id">
                    <div class="form-group">
                        <label>الايميل <small class="text-danger">*</small>
                        </label>
                        <input type="email" required="required" name="email" value="{{$user->email}}" maxlength="191" class="SpecificInput">
                    </div>
                    <div class="form-group">
                        <label>الموبايل <small class="text-danger">*</small>
                        </label>
                        <input type="text" required="required" name="phones" value="{{$user->phones}}" maxlength="191" class="SpecificInput">
                    </div>
                    <div class="form-group">
                        <label>نوع الحساب<small class="text-danger">*</small>
                        </label>
                        <p class="text-primary btn btn-warning">@if ($user->type==0)
                                مستخدم@elseif($user->type==2)معرض بيع سيارات
                            @elseif($user->type==3)وكاله تأجير
                            @else
                                وسيط بالعموله
                            @endif</p>
                    </div>
                    <div class="form-group">
                        <label style="display:block">
                            البلد <small class="text-danger">*</small>

                        </label>
                        <select class="SpecificInput countChange select2" name="country_id" style="width:100%;">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($user->country_id == $country->id) {{ 'selected' }} @endif>
                                    {{$country->ar_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group">
                    <label>الصورة الرئيسية <small class="text-danger">*</small></label>
                    <input type="file" name="image" class="SpecificInput">
                    <img src="{{asset('uploads/'.$user->image)}}" alt="" style="width: 50px;width: 50px">
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
