<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
<?php
if (session()->has('country')){
    $country=Session::get('country');
    $country_id=\App\country::where('en_name',$country)->first()->id;
    $featureedCars = \App\Cars::where(['special'=>1,'status'=>1,'country_id'=>$country_id])->get();
}
else
    $featureedCars = \App\Cars::where(['special'=>1,'status'=>1])->get() ; ?>

<?php
use Carbon\Carbon;
?>

<div class="container-fluid">
    <div class="col-md-12">
        <h1>{{__('site.partners')}}</h1>

        <div class="{{count($featureedCars)>3?'well':''}}">
            <div id="myCarousel" class="carousel slide">

                <!-- Carousel items -->
                <div class="carousel-inner">
                    @foreach($featureedCars as $banner)
                        <div class="item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                <div class="col-sm-3"><a href=""><img src="{{url('/')}}/uploads/{{$banner->Images ? $banner->Images[0]->image : ''}}" alt="Image" class="img-responsive"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--/carousel-inner-->
                @if(count($featureedCars)>3)
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>

                    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                @endif
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
    </div>
</div>

