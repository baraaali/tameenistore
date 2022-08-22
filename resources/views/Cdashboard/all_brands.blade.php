@extends( 'Cdashboard.layout.app' )
@section('controlPanel' )


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>
    <style>
        .searchbar{
            margin-bottom: auto;
            margin-top: auto;
            height: 60px;
            background-color: #353b48;
            border-radius: 30px;
            padding: 10px;
        }

        .search_input{
            color: white;
            border: 0;
            outline: 0;
            background: none;
            width: 0;
            caret-color:transparent;
            line-height: 40px;
            transition: width 0.4s linear;
        }

        .searchbar:hover > .search_input{
            padding: 0 10px;
            width: 450px;
            caret-color:red;
            transition: width 0.4s linear;
        }

        .searchbar:hover > .search_icon{
            background: white;
            color: #e74c3c;
        }

        .search_icon{
            height: 40px;
            width: 40px;
            float: right;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            color:white;
            text-decoration:none;
        }

        .panel-default>.panel-heading {
            background: #0773fd; /* Old browsers */
            border: 1px solid #f8f9fa !important;
           padding: 5px;}

        .panel-title a{ font-size: 28px; color: #fff !important;}
        .margn-20{
            margin: 20px;
        }
    </style>
    <div class="card" style="padding:15px;">
        <div class="card-heading">
            <div class="d-flex justify-content-center h-100">
                <form action="{{route('get_all_brands_search')}}" method="get">
                    @csrf
                    <div class="searchbar">
                        <input class="search_input" type="text" name="search" placeholder="Search...">
                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
            </div>
            <hr>
                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <a href="{{route('all_complete')}}" class="btn btn-danger btn-sm">
                            {{__('site.ins_added')}} ا
                        </a>
                    </div>

                </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach($brands as $index=>$brs)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$index}}" aria-expanded="true" aria-controls="collapseOne">

                                                @php
                                                  if ($index==null)
                                                    $br_name=\App\brands::where('id',$brs[0]->brand_id)->first()->name;
                                                 else   $br_name=\App\brands::where('id',$index)->first()->name;
                                                @endphp
                                                <div class="text-center"> {{$index !=null?$br_name:__('site.all')}}</div>
                                            </a>

                                        </h4>
                                    </div>
                                    <div id="collapseOne{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body margn-20">
                                            @foreach($brs as $i=>$brand)
{{--                                                {{dd($brand)}}--}}
                                                <?php
                                                $mod_name=\App\models::where('id',$brand->model_id)->first()->name;
                                                ?>
                                                <div class="row m-4">
                                                    <div class="col-md-6">
                                                        <p class="text-danger btn btn-warning">{{__('site.brand_name')}} {{$brand->idbrand->name}} </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="text-white btn btn-secondary ">{{__('site.model_name')}} {{$mod_name}} </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form action="{{route('update_brand')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$brand->id}}" name="id">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="d-block">{{__('site.firstslide')}}</label>
                                                            <input type="number" step=".0001" name="firstSlidePrice" class="SpecificInput"
                                                                   style="margin-bottom:15px;" value="{{$brand->firstSlidePrice}}" required>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>{{__('site.Open_File')}} </lable>
                                                                        <input class="SpecificInput" required value="{{$brand->OpenFileFirstSlide}}" type="number" step=".0001" name="OpenFileFirstSlide">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>{{__('site.Percent')}}</lable>
                                                                        <input type="number" step=".0001" name="OpenFilePerecentFirstSlide"
                                                                               class="SpecificInput"  required value="{{$brand->OpenFilePerecentFirstSlide}}">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>{{__('site.Minimum_Price')}}</lable>
                                                                        <input value="{{$brand->OpenFileMinimumFirstSlide}}" required type="number" step=".0001" name="OpenFileMinimumFirstSlide" class="SpecificInput">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="d-block">
                                                                {{__('site.secondslide')}}
                                                            </label>
                                                            <input type="number" step=".0001" name="SecondSlidePrice" class="SpecificInput"
                                                                   style="margin-bottom:15px;" value="{{$brand->SecondSlidePrice}}" required>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>  {{__('site.Open_File')}} </lable>
                                                                        <input value="{{$brand->OpenFileSecondSlide}}" required class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>{{__('site.Percent')}} </lable>
                                                                        <input type="number" step=".0001" name="OpenFilePerecentSecondSlide"
                                                                               class="SpecificInput" value="{{$brand->OpenFilePerecentSecondSlide}}" required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="d-block">{{__('site.thirdslide')}}</label>
                                                            <input type="number" required value="{{$brand->thirdSlidePrice}}" step=".0001" name="thirdSlidePrice" class="SpecificInput"
                                                                   style="margin-bottom:15px;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>{{__('site.Open_File')}}</lable>
                                                                        <input value="{{$brand->OpenFileThirdSlide}}" class="SpecificInput" required step=".0001" type="number" name="OpenFileThirdSlide">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>{{__('site.Percent')}}</lable>
                                                                        <input type="number" step=".0001" name="OpenFilePerecentThirdSlide" required
                                                                               class="SpecificInput" value="{{$brand->OpenFilePerecentThirdSlide}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="d-block">{{__('site.foruthslide')}}</label>
                                                            <input type="number" value="{{$brand->fourthSlidePrice}}" required name="fourthSlidePrice" class="SpecificInput" style="margin-bottom:15px;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>{{__('site.Open_File')}} </lable>
                                                                        <input value="{{$brand->OpenFileFourthSlide}}" class="SpecificInput" step=".0001" type="number" name="OpenFileFourthSlide" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label> {{__('site.Percent')}}</lable>
                                                                        <input type="number" step=".0001" name="OpenFilePerecentFourthSlide"
                                                                               required   class="SpecificInput" value="{{$brand->OpenFilePerecentFourthSlide}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <input type="hidden" id="statusVal" class="statusVal_{{$brand->id}}" value="{{$brand->search_show}}">
                                                        <input type="submit" value="{{__('site.update')}}" class="btn btn-primary text-center">
                                                        <button onclick="myFunction({{$brand->id}})" class="cl_{{$brand->id}} btn {{$brand->search_show==0?'btn-danger':'btn-success'}} stat"
                                                                value="{{$brand->id}}" id="buttonStatus" data-url="{{$brand->search_show}}" >
                                                            {{$brand->search_show==0?'معطله':'مفعله'}}</button>
                                                        <hr>
                                                    </div>
                                                    <br>
                                                </form>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>

            function myFunction(id) {
                var company_id = id;
                var row='statusVal_'+company_id;
                var data = $('.'+row).val();
                var status=data==0?1:0;
                //alert(status);
                console.log(status);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/insurace/docChangeShowStatus',
                    data: {'status': status, 'company_id': company_id},
                    success: function(data){
                        console.log(data.success)
                        console.log(status);
                        var clas='cl_'+company_id;
                        if(status==1){

                            $('.'+clas).html('مفعلة');
                            $('.'+clas).removeClass('btn-danger');
                            $('.'+clas).addClass('btn-success');
                            $('.'+row).attr('value', '0');
                        }
                        else{

                            $('.'+clas).html('معطله');
                            $('.'+clas).removeClass('btn-success');
                            $('.'+clas).addClass('btn-danger');
                            $('.'+row).attr('value', '1');
                        }

                    }
                });
            };
        </script>

@endsection
