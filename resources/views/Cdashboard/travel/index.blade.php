<?php
if($lang == 'ar' || $lang == 'en')
{
    App::setlocale($lang);
}
else
{
    App::setlocale('ar');
}
    ?>

@extends('Cdashboard.layout.app')
@section('controlPanel')
    <div class="mt-5">
        <form method="POST" action="{{route('agent-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <label>{{__('site.name_ar')}} <small class="text-danger">*</small></label>
                        <input class="SpecificInput" value="" name="ar_com_name" max="191">
                    </div>
                    <div class="col-md-6">
                        <label> {{__('site.name_en')}} <small class="text-danger">*</small></label>
                        <input class="SpecificInput" value="" name="ar_com_name" max="191">
                    </div>
                    <div class="col-md-6">
                        <label>{{__('site.address_ar')}} <small class="text-danger">*</small></label>
                        <input class="SpecificInput" value="" name="address_ar">
                    </div>
                    <div class="col-md-6">
                        <label>{{__('site.address_en')}} <small class="text-danger">*</small></label>
                        <input class="SpecificInput" value="" name="address_en">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="display:inline-block">{{__('site.phone')}}</label>
                            <small class="text-danger">*</small>
                            <input class="SpecificInput" value="" name="phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <lable>{{__('site.logo')}}<small class="text-danger">*</small></lable>
                        <input type="file" name="logo" class="SpecificInput">
                    </div>
                    <div class="col-md-6">
                        <lable>{{__('site.email')}}<small class="text-danger">*</small></lable>
                        <input type="logo" name="email" class="SpecificInput">
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-8">
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary btn-block"
                           value="{{__('site.save')}}"/>
                </div>
            </div>

        </form>
    </div>

@endsection
