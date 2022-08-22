<div class="col-md-12">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach($brands as $index=>$brs)
            <div class="panel panel-default">
                <div class="panel-heading bg-primary mb-2" role="tab" id="headingOne">
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <label class="d-block">{{__('site.firstslide')}}</label>
                                            <input type="number" step=".0001" name="firstSlidePrice" class="SpecificInput"
                                        style="margin-bottom:15px;" value="{{$brand->firstSlidePrice}}" required>
                                    
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__('site.Open_File')}} </label>
                                                <input class="SpecificInput" required value="{{$brand->OpenFileFirstSlide}}" type="number" step=".0001" name="OpenFileFirstSlide">
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__('site.Percent')}}</label>
                                                <input type="number" step=".0001" name="OpenFilePerecentFirstSlide"
                                                       class="SpecificInput"  required value="{{$brand->OpenFilePerecentFirstSlide}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__('site.Minimum_Price')}}</label>
                                                <input value="{{$brand->OpenFileMinimumFirstSlide}}" required type="number" step=".0001" name="OpenFileMinimumFirstSlide" class="SpecificInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                   <div class="row">
                                       <div class="col-md-4">
                                        <label class="d-block">
                                            {{__('site.secondslide')}}
                                        </label>
                                        <input type="number" step=".0001" name="SecondSlidePrice" class="SpecificInput"
                                               style="margin-bottom:15px;" value="{{$brand->SecondSlidePrice}}" required>
                                       </div>
                                        <div class="col-md-4">
                                            <label>  {{__('site.Open_File')}} </label>
                                                <input value="{{$brand->OpenFileSecondSlide}}" required class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__('site.Percent')}} </label>
                                                <input type="number" step=".0001" name="OpenFilePerecentSecondSlide"
                                                       class="SpecificInput" value="{{$brand->OpenFilePerecentSecondSlide}}" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="d-block">{{__('site.thirdslide')}}</label>
                                             <input type="number" required value="{{$brand->thirdSlidePrice}}" step=".0001" name="thirdSlidePrice" class="SpecificInput"
                                           style="margin-bottom:15px;">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__('site.Open_File')}}</label>
                                                <input value="{{$brand->OpenFileThirdSlide}}" class="SpecificInput" required step=".0001" type="number" name="OpenFileThirdSlide">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__('site.Percent')}}</label>
                                                <input type="number" step=".0001" name="OpenFilePerecentThirdSlide" required
                                                       class="SpecificInput" value="{{$brand->OpenFilePerecentThirdSlide}}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="d-block">{{__('site.foruthslide')}}</label>
                                            <input type="number" value="{{$brand->fourthSlidePrice}}" required name="fourthSlidePrice" class="SpecificInput" style="margin-bottom:15px;">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__('site.Open_File')}} </label>
                                                <input value="{{$brand->OpenFileFourthSlide}}" class="SpecificInput" step=".0001" type="number" name="OpenFileFourthSlide" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label> {{__('site.Percent')}}</label>
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
                                    <input onclick="if(confirm('هل تريد الحذف?')) $('#delete-form').submit();" type="button" value="{{__('site.delete')}}" class="btn btn-danger text-center">
                                    
                                     <hr>
                            </div>
                           
                            <br>
                        </form>
                        <form id="delete-form" method="POST" action="{{route('delete-model-from-completeDoc',[$name,$brand->model_id])}}">
                            <input type="hidden" name="_method" value="delete">
                            @csrf
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>