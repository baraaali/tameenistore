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
<style>
	.pt-4, .py-4 {
    padding-top: 0rem!important;
}
</style>
<div class="col-lg-12 cover-adv" style="background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
	@if(app()->getLocale() == 'ar')

        <div class="upper">
        <h2 class="place"style="margin: 0px auto;">
           إيجار السيارات
            <br>
            <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
     </div>
    @else

     <div class="upper">
        <h2 class="place"style="margin: 0px auto;">
           Cars For Rent
            <br>
            <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
     </div>
    @endif
</div>
<div class="container">
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-3">
			<div class="col-lg-12 f-price">
				<div class="f-head"><p class="third-detail" style="font-size:18px;margin: 0">
					@if( app()->getLocale() == 'ar' )
						متوسط الاسعار
					@else
						Cost average
					@endif
				</p></div>
				<div class="f-body">
					<div class="slidecontainer">
				  <input type="range" min="1" max="10000" value="50" class="slider" id="myRange">
				  <p style="margin-top: 20px;">Value: <span id="demo"></span></p>
				</div>
				<button class="apply btn btn-primary">Apply</button>
				</div>
			</div>
			<div class="col-lg-12 f-cat">
				<div class="f-head"><p class="third-detail" style="font-size:18px;margin: 0">
						@if( app()->getLocale() == 'ar' )
						جميع  البراندات
					@else
						All Brands
					@endif
				</p></div>
				<?php  $brands = \App\brands::where('status',1)->get(); ?>
				<div class="f-body">
					<select class="SpecificInput brandChange select2">
                        <option value="0">{{__('site.select')}}</option>

					    @foreach($brands as $key=>$brand)

							<option value="{{$brand->id}}">
							    {{$brand->name}}
							</option>


						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-12 f-brand">
				<div class="f-head"><p class="third-detail" style="font-size:18px;margin: 0">
						@if( app()->getLocale() == 'ar' )
						جميع  الموديلات
					@else
						All Models
					@endif
				</p></div>
				<?php  $brands = \App\models::get(); ?>
				<div class="f-body">
					<select class="SpecificInput modelChange select2">
{{--					    @foreach($brands as $key=>$brand)--}}

{{--							<option value="{{$brand->id}}">--}}
{{--							    {{$brand->name}}--}}
{{--							</option>--}}


{{--						@endforeach--}}
					</select>
				</div>
			</div>

				<div class="col-lg-12 f-trans">
				<div class="f-head"><p class="third-detail" style="font-size:18px;margin: 0">
						@if( app()->getLocale() == 'ar' )
							ناقل الحركة
					@else
						Transmission Type

					@endif
				</p></div>
				<div class="f-body">
					<select name="" id="" class="SpecificInput">
						<option  selected="selected">
							@if(app()->getLocale() == 'ar')
								إختار ناقل الحركة
							@else
								Choose Transmission..
							@endif
						</option>
						<option value="0">
							@if( app()->getLocale() == 'ar' )
								عادة
							@else
								Manual

							@endif
						</option>
						<option value="1">
							@if( app()->getLocale() == 'ar' )
								اوتوماتيك
							@else

								Automatic

							@endif
						</option>
					</select>
				</div>
			</div>

		</div>
		<div class="col-lg-9" style="padding-top: 30px;">
			<div class="col-lg-12">
				<div class="row">
					<div class="col">
						<label style="font-weight: 600">
							@if(app()->getLocale() == 'ar')
								نوع السيارات
							@else
								Condition
							@endif
						</label>
						<select name="condition" class="col-lg-12 cond-ajax" style="border:1px solid #d3d3d3;border-radius: 5px;">

				      	<option selected disabled>
				      		@if(app()->getLocale() == 'ar')
				      			إختر  نوع السيارات
				      		@else
				      			Choose Condition
				      		@endif
				      	</option>
				      	<option value="2">
				      		@if(app()->getLocale() == 'ar')
				      			جديد
				      		@else
				      			New
				      		@endif
				      	</option>
				      	<option value="1">
				      		@if(app()->getLocale() == 'ar')
				      			مستخدم
				      		@else
				      			Used
				      		@endif
				      	</option>
						<option value="0">
							@if(app()->getLocale() == 'ar')
				      			كلاهما
				      		@else
				      			Used and New
				      		@endif
						</option>
				      </select>
					</div>
					<div class="col">
				      <label style="font-weight: 600">
				      	@if(app()->getLocale() == 'ar')
				      		المعارض
				      	@else
				      		Exhibitors
				      	@endif
				      </label>

				      <select name="exhibtors" class="col-lg-12 exhibtors" style="border:1px solid #d3d3d3;border-radius: 5px;">

				      	<option selected disabled>
				      		@if(app()->getLocale() == 'ar')
				      			إختر المعرض
				      		@else
				      			Choose Exhibitor

				      		@endif
				      	</option>


				      </select>
				    </div>
				    <div class="col">
				      <label style="font-weight: 600">
				      	@if(app()->getLocale() == 'ar')
				      		الوكالات
				      	@else
				      		Agents
				      	@endif
				      </label>

				      <select name="exhibtors" class="col-lg-12 agents" style="border:1px solid #d3d3d3;border-radius: 5px;">

				      	<option selected disabled>
				      		@if(app()->getLocale() == 'ar')
				      			إختر الوكالة
				      		@else
				      			Choose Agent

				      		@endif
				      	</option>


				      </select>
				    </div>
				</div>
			</div>

			<hr>

			<div class="col-lg-12">

				<div class="row ads">
                    <?php $cars = \App\Cars::where(['status'=>1,'sell'=>0])->orderBy('id','desc')->paginate() ; ?>
					@foreach($cars as $car)
						<div class="col-md-6">
							<a href="{{URL::route('view-ad', [$car->id,app()->getLocale()] )}}" style="text-decoration: none;">
								<div class="card">
			                        <img src="{{url('/')}}/uploads/{{$car->Images ? $car->Images[0]->image : ''}}" class="card-image">
			                        <div class="cost-holder">
			                            {{$car->Price->cost}} {{$car->Price->currency}}
			                        </div>
			                         @if($car->special == 3)
			                        <div class="badge-holder">
			                            <span class="badge badge-warning">
			                                مميز
			                            </span>
			                        </div>
			                        @elseif ($car->special == 2)
			                        <div class="badge-holder">
			                            <span class="badge badge-success">
			                                مميز
			                            </span>
			                        </div>
			                        @elseif ($car->special == 1)
			                            <div class="badge-holder">
			                                <span class="badge badge-success">
			                                    مميز
			                                </span>
			                            </div>
			                        @endif
			                        <p class="card-hint-line">
			                            <span class="hint-line">
			                                <i class="fa fa-map-marker-alt"></i>
			                               @if(app()->getLocale() == 'ar')
			                                {{$car->country->ar_name}}
			                               @else
			                                {{$car->country->en_name}}
			                               @endif
			                            </span>
			                        </p>
			                        <p class="card-title">
			                            @if(app()->getLocale() == 'ar')
			                                {{$car->ar_name}}
			                            @else
			                                {{$car->en_name}}
			                            @endif
			                        </p>
			                        <p class="second-title">
			                            <span class="second-detail">
			                                <i class="fa fa-eye"></i> {{$car->visitors}}
			                            </span>
			                            <span class="second-detail margin-right">
			                                <i class="far fa-clock"></i>  {{Carbon::parse($car->created_at)->toFormattedDateString()}}
			                            </span>
			                        </p>
			                        <div class="third-title">
			                            <div class="row">
			                                <div class="col-4 text-center p-all third-detail-holder">
			                                    <div class="background-grey">
			                                        <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
			                                        <span class="third-detail SecondColor">{{$car->max}}
			                                            @if(app()->getLocale() == 'ar')

			                                                كم\س
			                                            @else

			                                            km\h

			                                            @endif
			                                        </span>
			                                    </div>

			                                </div>
			                                <div class="col-4 text-center p-all third-detail-holder">
			                                    <div class="background-grey">
			                                        <i class="fa fa-road SecondColor" style="display: block"></i>
			                                        <span class="third-detail SecondColor">{{$car->kilo_meters}}
			                                          @if(app()->getLocale() == 'ar')

			                                                كم
			                                            @else

			                                            km

			                                            @endif</span>
			                                    </div>

			                                </div>
			                                <div class="col-4 text-center p-all third-detail-holder">
			                                    <div class="background-grey">
			                                        <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
			                                        <span class="third-detail SecondColor">{{$car->year}}</span>
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
			                                        {{$car->OwnerInformation->User->name}}
			                                    </span>
			                                </div>

			                            </div>
			                        </div>
			                    </div>
							</a>
						</div>
					@endforeach

					{{$cars->links()}}

				</div>
			</div>
		</div>
	</div>
</div>

</div>

























<script>
	$(document).ready(function(){
  	$(".show").click(function(){
	  	$(".hidden").slideToggle();
	  });
  	$(".show1").click(function(){
	  	$(".hidden1").slideToggle();
	  });
});

</script>



<script>
    $(document).ready(function(){
        $('.brandChange').change(function(){
           $.ajax({
              url: "{{url('/')}}/view/childerns/"+$(this).val(),
              context: document.body
            }).done(function(data) {
                $('.modelChange').find('option').remove().end();
                $.each(data,function(i,item){
                    $('.modelChange').append('<option value="'+item.id+'">'+item.name+'</optin>')
                });

            });
        });
    });
</script>


<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>






@endsection
