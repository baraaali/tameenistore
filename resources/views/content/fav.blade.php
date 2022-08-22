@extends('layouts.app')
@section('content')
<style type="text/css">
	.py-4{
		background-color: #f3f3f3;
	}
</style>

<div class="col-lg-12">
	<div class="container">
		<div class="row">
             <div class="fav-card col-lg-12">
				<div class="card-head col-lg-12">
					 @if(app()->getLocale() == 'ar')
					<h5><i class="fas fa-heart"></i> المفضلة </h5>
					@else
					<h5><i class="fas fa-heart"></i>Favourites</h5>
					@endif
				</div>
				<div class="card-body col-lg-12">
                   <div class="row">
                   	<div class="col-lg-6">
                   		<div class="card"> 
                        <img src="{{url('/')}}/uploads/5d3ec6cd8d581.jpg" class="card-image">
                        <p class="card-title">
                            مرسيدس - بينز - موديل 2012
                        </p>
                        <p class="second-title">
                            <span class="second-detail">
                                <i class="fa fa-eye"></i> 1121 مرة
                            </span>
                            <span class="second-detail margin-right">
                                <i class="far fa-clock"></i>  منذ 1 يوم
                            </span>
                        </p>
                        <div class="third-title">
                            <div class="row">
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">220</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-road SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">23500</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">2020</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <hr style="margin-bottom: .5rem">
                        <div class="fourth-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-user" ></i>
                                    <span class="third-detail" style="padding-top:0px;">
                                        احمد وائل عزالدين
                                    </span>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                   	</div>
                   	<div class="col-lg-6">
                   		<div class="card"> 
                        <img src="{{url('/')}}/uploads/5d3ec6cd8d581.jpg" class="card-image">
                        <p class="card-title">
                            مرسيدس - بينز - موديل 2012
                        </p>
                        <p class="second-title">
                            <span class="second-detail">
                                <i class="fa fa-eye"></i> 1121 مرة
                            </span>
                            <span class="second-detail margin-right">
                                <i class="far fa-clock"></i>  منذ 1 يوم
                            </span>
                        </p>
                        <div class="third-title">
                            <div class="row">
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">220</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-road SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">23500</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">2020</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <hr style="margin-bottom: .5rem">
                        <div class="fourth-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-user" ></i>
                                    <span class="third-detail" style="padding-top:0px;">
                                        احمد وائل عزالدين
                                    </span>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                   	</div>
                   	<div class="col-lg-6">
                   		<div class="card"> 
                        <img src="{{url('/')}}/uploads/5d3ec6cd8d581.jpg" class="card-image">
                        <p class="card-title">
                            مرسيدس - بينز - موديل 2012
                        </p>
                        <p class="second-title">
                            <span class="second-detail">
                                <i class="fa fa-eye"></i> 1121 مرة
                            </span>
                            <span class="second-detail margin-right">
                                <i class="far fa-clock"></i>  منذ 1 يوم
                            </span>
                        </p>
                        <div class="third-title">
                            <div class="row">
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">220</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-road SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">23500</span>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">2020</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <hr style="margin-bottom: .5rem">
                        <div class="fourth-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-user" ></i>
                                    <span class="third-detail" style="padding-top:0px;">
                                        احمد وائل عزالدين
                                    </span>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                   	</div>
                   </div>
				</div>

		</div>
	</div>
</div>


@endsection