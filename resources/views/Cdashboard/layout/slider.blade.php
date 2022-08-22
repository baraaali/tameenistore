<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
<?php
$messages = \App\CompleteDoc::where(['status'=>1,'display'=>1,'search_show'=>1]);
if (getCountry()>0) $messages=$messages->where('country_id',getCountry());
$messages=collect($messages->get());
$banners = $messages->unique('Insurance_Company_ar');

$banners->values()->all();
?>

<div class="container-fluid">
    <div class="col-md-12">
        <h1>{{__('site.partners')}}</h1>

        <div class="{{count($banners)>3?'well':''}}">
            <div id="myCarousel" class="carousel slide">

                <!-- Carousel items -->
                <div class="carousel-inner">
                    @foreach($banners->chunk(4) as $banner)
                    <div class="item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach($banner as $ban)
                            <div class="col-sm-3">
                                <a href=""><img src="{{ url('uploads/'.$ban->logo) }}" alt="Image" class="img-responsive"></a>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    @endforeach
                </div>
                <!--/carousel-inner-->
                @if(count($banners)>3)
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>

                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                    @endif
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
    </div>
</div>

