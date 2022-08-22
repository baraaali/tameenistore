@extends('layouts.app')
@section('content')

<style type="text/css">

</style>
<div class="container">
	
<?php $mcenters = \App\Mcenters::where('status',1)->paginate(5); ?>
@foreach($mcenters as $mcenter)
	<div class="box-shadow-card">
		<div class="row">
			<div class="col-md-2 text-center" style="padding-top:25px">
				<ul style="list-style: none;" class="card-ul">
					<li style="margin-bottom:30px;cursor: pointer" onclick="show('information-{{$mcenter->id}}')">
						<i class="fa fa-info" style="font-size:24px;color:#0674FD"></i>
						<br>
						@if(app()->getLocale() == 'ar')
							<span class="third-detail">
								معلومات رئيسية
							</span>
						@else
							<span class="third-detail">
								Basic Information
							</span>

						@endif
					</li>
					<li style="margin-bottom:30px;cursor: pointer" onclick="show('dates-{{$mcenter->id}}')">
						<i class="fa fa-stopwatch" style="font-size:24px;color:#FFC107"></i>
						<br>
						@if(app()->getLocale() == 'ar')
							<span class="third-detail">
								مواعيد العمل
							</span>
						@else
							
							<span class="third-detail">
								Days, Hours
							</span>
						@endif
					</li>
					<li style="margin-bottom:30px;cursor: pointer" onclick="show('address-{{$mcenter->id}}')">
						<i class="fa fa-map-marker-alt" style="font-size:24px;color:#DC3545"></i>
						<br>
						@if(app()->getLocale() == 'ar')
							<span class="third-detail">
								العنوان 
							</span>
						@else
							
							<span class="third-detail">
								Address
							</span>
						@endif
					</li>
				</ul>
				<div style="border-style: solid;
						    height: 255px;
						    width: 0px;
						    border-width: 0;
						    border-left-width: 2px;
						    border-color: #f1f1f1;
						    position: absolute;
						    left: 0px;
						    top: 0px;">
					
				</div>
			</div>
			<div class="col-md-10" style="padding-top: 25px;">
				<div class="first-header" style="margin-bottom:10px;"> 
					 	<span class="badge badge-primary" style="font-weight: normal;padding-top:5px;padding-bottom:5px;">
					 		<i class="fa fa-map-marker-alt"></i>
					 		@if(app()->getLocale() == 'ar')
					 			{{$mcenter->country->ar_name}}
					 		@else
					 			{{$mcenter->country->en_name}}
					 		@endif
					 	</span>

					 	<span class="badge badge-primary" style="font-weight: normal;padding-top:5px;padding-bottom:5px;">
					 		<i class="fa fa-user"></i>
					 		{{$mcenter->owner->name}}
					 	</span>

					 	@if($mcenter->special == 3)
					 		<span class="badge badge-warning" style="font-weight: normal;padding-top:5px;padding-bottom:5px;">
					 		<i class="fa fa-star"></i>
					 		@if(app()->getLocale() == 'ar')
					 			مميز
					 		@else
					 			Gold
					 		@endif
					 	</span>
					 	@endif
				</div>


				<div class="basic-information information-{{$mcenter->id}}" >
					<div class="second-nav" >
					<img src="{{url('/')}}/uploads/{{$mcenter->image}}" style="width:auto;height:50px;">
					<h4 clas="card-title " style="margin: 0px;display: inline-block;font-size: 15px;font-weight: 600;position: relative;top:10px;">
						@if( app()->getLocale() == 'ar' )
							{{$mcenter->ar_name}}
						@else
							{{$mcenter->en_name}}
						@endif
					<br>
						<span style="margin-top:5px;position: relative;top:5px;">
							 {{$mcenter->phones}}
						</span>
					</h4>

					</div>
					
				</div>
				<div class="work-days dates-{{$mcenter->id}}"   style="display: none;">
					<div class="second-nav" >
					<img src="{{url('/')}}/uploads/{{$mcenter->image}}" style="width:auto;height:50px;">
					<h4 clas="card-title " style="margin: 0px;display: inline-block;font-size: 15px;font-weight: 600;position: relative;top:10px;">
						@if( app()->getLocale() == 'ar' )
							{{$mcenter->ar_name}}
						@else
							{{$mcenter->ar_name}}
						@endif
					<br>
						<span style="margin-top:5px;position: relative;top:5px;">
							 {{$mcenter->phones}}
						</span>
					</h4>

					</div>
					<br>
					<br>
					<div class="second-nav" >
						<p class="third-detail">
							@if(app()->getLocale()=='ar')
								ايام العمل : {{$mcenter->days_on}}
							@else
								Work Days : {{$mcenter->days_on}}
							@endif
						</p>
						<p class="third-detail">
							@if(app()->getLocale()=='ar')
								ساعات العمل : {{$mcenter->times_on}}
							@else
								Work Hours : {{$mcenter->times_on}}
							@endif
						</p>
					</div>
				</div>

				<div class="address address-{{$mcenter->id}}"  style="display: none;"  >
					
					<br>
					<div class="second-nav" >
						<p class="third-detail">
							@if(app()->getLocale()=='ar')
								العنوان :  {!!$mcenter->ar_address!!}
							@else
								Address : {!!$mcenter->en_address!!}
							@endif
						</p>
						<iframe src="{{$mcenter->google_map}}" height="138" frameborder="0" style="border:0;width: 100%" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						
					</div>
				</div>
		</div>
	</div>
@endforeach
</div>



<script type="text/javascript">
	function show (specific)
	{
		var res = specific.split("-");
		if(specific[0] == 'i')
		{
			$('.dates-'+res[1]).fadeOut('200');
			$('.address-'+res[1]).fadeOut('200');

			$('.'+specific).fadeIn('3000');
		}
		else if (specific[0] == 'd')
		{
			$('.information-'+res[1]).fadeOut('200');
			$('.address-'+res[1]).fadeOut('200');

			$('.'+specific).fadeIn('3000');
		}
		else
		{
			$('.information-'+res[1]).fadeOut('200');
			$('.dates-'+res[1]).fadeOut('200');
			$('.'+specific).fadeIn('3000');
		}
		
	}
</script>
@endsection