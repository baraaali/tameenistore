@extends('layouts.app')
@section('content')
<?php
	use Carbon\Carbon;
	if($lang == 'ar' || $lang == 'en')
		{
			App::setlocale($lang);
		}
		else
		{
			App::setlocale('ar');
		}

?>

<div class="container">
    <p style="font-weight:600">
        @if(app()->getLocale() == 'ar')

            مرحبا بكـ مجددا يبدو انك لست مشترك بإحدي العضويات
            <br>
            من فضلك إختر الانسب إليك
        @else
            Hello Again, it seems you are not a member with memberships
            <br>
            please choose the best one for you

        @endif
    </p>

    <div class="row">
            @foreach($memberships as $membership)
                <div class="col-md-3">
                    <div class="card"  style="height:250px">
                          <div class="card-body">
                            <h5 class="card-title">
                                {{$membership->name}}
                            </h5>
                           <hr>
                            <p class="card-text">
                                @if(app()->getLocale() == 'ar')
                                    {!! $membership->ar_m_feature !!}
                                @else
                                    {!! $membership->en_m_feature !!}
                                @endif
                            </p>
                            @if(app()->getLocale() == 'ar')

                            <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-left:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                    {{$membership->cost}} $
                                </span>
                            </div>

                            @else

                             <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-right:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                    {{$membership->cost}} $
                                </span>
                            </div>


                            @endif

                            <a href="{{url('/')}}/join/to/membershib/{{$membership->id}}/{{app()->getLocale()}}"  class="btn btn-primary btn-block" style="position: absolute;
    bottom: 15px;
    width: 81%;color:white">
                                @if(app()->getLocale() == 'ar')
                                    إختر هذا
                                @else
                                    Choose This
                                @endif
                            </a>

                          </div>
                        </div>
                </div>
            @endforeach
            {{$memberships->links()}}
    </div>


</div>
<script>
    function showAlert()
    {
        alert('Sorry this service not working Now Till Online Payment Done || عذرا هذه الخدمة ليست متاحة حتي تتاح خدمات الدفع الالكتروني');
    }
</script>
@endsection
