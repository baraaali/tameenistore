<style>
    @import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);

    .col-item
    {
        border: 1px solid #E1E1E1;
        border-radius: 5px;
        background: #FFF;
    }
    .col-item .photo img
    {
        margin: 0 auto;
        width: 100%;
    }

    .col-item .info
    {
        padding: 10px;
        border-radius: 0 0 5px 5px;
        margin-top: 1px;
    }

    .col-item:hover .info {
        background-color: #F5F5DC;
    }
    .col-item .price
    {
        /*width: 50%;*/
        float: left;
        margin-top: 5px;
    }

    .col-item .price h5
    {
        line-height: 20px;
        margin: 0;
    }

    .price-text-color
    {
        color: #219FD1;
    }

    .col-item .info .rating
    {
        color: #777;
    }

    .col-item .rating
    {
        /*width: 50%;*/
        float: left;
        font-size: 17px;
        text-align: right;
        line-height: 52px;
        margin-bottom: 10px;
        height: 52px;
    }

    .col-item .separator
    {
        border-top: 1px solid #E1E1E1;
    }

    .clear-left
    {
        clear: left;
    }

    .col-item .separator p
    {
        line-height: 20px;
        margin-bottom: 0;
        margin-top: 10px;
        text-align: center;
    }

    .col-item .separator p i
    {
        margin-right: 5px;
    }
    .col-item .btn-add
    {
        width: 50%;
        float: left;
    }

    .col-item .btn-add
    {
        border-right: 1px solid #E1E1E1;
    }


    .controls
    {
        margin-top: 20px;
    }
    [data-slide="prev"]
    {
        margin-right: 10px;
    }
    .bg-color{
        background-color: #f8f8f8;
        padding-bottom: 40px;
        padding-top: 20px;
        margin-bottom: 30px;
    }
    .sty_title{
        text-align: center;
        font-size: 30px;
        font-style: oblique;
        color: #0c62b7;
    }
    .img-slid{
        min-height: 225px;
        max-height: 225px;
    }
</style>
<?php
use Carbon\Carbon;
if (app()->getLocale() == 'ar') {
    $name='ar_name';
} else {
    $name='en_name';
}
$day = date('Y-m-d');
?>
<div class="container-fluid bg-color">
    <div class="row">
        <p class="text-center sty_title col-md-12"> {{__('site.'.$title)}}</p>
        <hr>
        <!-- Controls -->
        @if (count($items)>0)
            <div class="controls pull-right hidden-xs">
                <a class="left fa fa-chevron-left btn btn-success text-left" href="#carousel-example"
                   data-slide="prev"></a>
                <a class="right fa fa-chevron-right btn btn-success text-right" href="#carousel-example"
                   data-slide="next">

                </a>
            </div>

            <div id="carousel-example" class="carousel slide" data-ride="carousel" style="width: 100%;padding-top: 20px">
                <!-- Wrapper for slides  -->
                <div class="carousel-inner">
                    @foreach($items->chunk(4) as $item)
                        <div class="item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach($item as $index=>$i)

{{--                                    {{dd($i)}}--}}
                                    {{--                        @if(count($i->images)>0)--}}
                                    <div class="col-sm-3">
                                        <div class="col-item">
                                            <div class="photo">
                                                @if($i->discount_percent>0 && $i->discount_end_date>$day)
                                                    <span class="notify-badge mtop-20">{{$i->discount_percent}}%</span>
                                                @endif
                                                <a data-fancybox="{{$title}}" href="{{url('/')}}/uploads/{{$i->main_image}}"  >
                                                    <img src="{{url('/')}}/uploads/{{$i->main_image}}" class="img-responsive img-slid" alt="a" />
                                                </a>
                                            </div>
                                            <div class="badge-holder">
                                    <span class="badge badge-danger badge-custom
                                  @if ($i->membership->type==2)badge-spacial
                                  @elseif($i->membership->type==1)badge-silver
                                  @elseif($i->membership->type==0)badge-normal
                                        @else badge-golden
                                    @endif">
{{--                                        {{dd($i)}}--}}
                                        @if($i->membership->type==2) {{__('site.special')}}
                                        @elseif($i->membership->type==1){{__('site.silver')}}
                                        @elseif($i->membership->type==0){{__('site.normel')}}
                                        @else{{__('site.golden')}}
                                        @endif
                                    </span>
                                            </div>
                                            <div class="info">
                                                <div class="row">
                                                    <div class="price col-md-6">
                                                        <a href="{{URL::route('view-ad', [$i->id,app()->getLocale()] )}}">
                                                            <h5 class="text-danger">   {{$i->$name}}</h5>
                                                        </a>
                                                        <h5 class="price-text-color">{{$i->cost}} {{$i->currency}}</h5>


                                                    </div>
                                                    <div class="rating hidden-sm col-md-6">
                                            <span class="hint-line">
                                            <i class="fa fa-map-marked-alt"></i>
                                                    {{$i->country->$name}}
                                            </span>
                                                    </div>
                                                </div>
                                                <div class="separator clear-left">
                                                    <p class="second-title">
                                        <span class="second-detail">
                                            <i class="fa fa-eye"></i> {{$i->visitors}}
                                        </span>
                                                        <span class="second-detail margin-right">
{{--                                            <i class="far fa-clock"></i>  {{dd()}}--}}
                                            <i class="far fa-clock"></i>  {{Carbon::parse($i->end_ad_date)->toFormattedDateString()}}
                                        </span>
                                                    </p>
                                                    <div class="third-title">
                                                        <div class="row">
                                                            
                                                            {{-- <div class="col-4 text-center p-all third-detail-holder">
                                                                <div class="background-grey">
                                                                    <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
                                                                    <span class="third-detail SecondColor">{{$i->max}}
                                                                        {{__('site.km')}}
                                                             </span>
                                                                </div>
                                                            </div> --}}

                                                            <div class="col-6 text-center p-all third-detail-holder">
                                                                <div class="background-grey">
                                                                    {{-- <i class="fa fa-tags SecondColor" style="display: block"></i> --}}
                                                                    <span class="third-detail SecondColor">{{$i->category->$name}}
                                                        </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 text-center p-all third-detail-holder">
                                                                <div class="background-grey">
                                                                    <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
                                                                    @php $date = new DateTime($i->created_at) @endphp
                                                                    <span class="third-detail SecondColor">{{$date->format('d-m-Y')}}</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="margin-bottom: .5rem">
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                         @endif--}}
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>


{{--<!--Start of Tawk.to Script-->--}}
{{--<script type="text/javascript">--}}
{{--    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();--}}
{{--    (function(){--}}
{{--        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];--}}
{{--        s1.async=true;--}}
{{--        s1.src='https://embed.tawk.to/5fe5ffd5a8a254155ab64ca7/1eqd6umfm';--}}
{{--        s1.charset='UTF-8';--}}
{{--        s1.setAttribute('crossorigin','*');--}}
{{--        s0.parentNode.insertBefore(s1,s0);--}}
{{--    })();--}}
{{--</script>--}}
{{--<!--End of Tawk.to Script-->--}}
