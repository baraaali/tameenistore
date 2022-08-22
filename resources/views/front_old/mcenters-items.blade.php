@if (!count($mcenters))
<div class="my-4 text-center d-block w-100"> {{__('site.no data')}} </div>
@else
@foreach ($mcenters as $center)
    
                 <div class="col-md-12  my-4">
                     <div class="item row">
                         <div class="col-md-3 position-relative">
                             @if ($center->serviceMemberShip->type == 'special')
                             <div class="tag">{{__('site.'.$center->serviceMemberShip->type)}}</div>
                             @endif
                            <img class="w-100" src="{{asset('uploads/'.$center->image)}}">
                            <div class="d-flex justify-content-between p-2  bg-light">
                                <div class="p-1  font-weight-bold">{{$center->getName()}}</div>
                                <div class="p-1  font-weight-bold">
                                    {{$center->getStore->getName()}}
                                    </div>
                             </div>
                            <div class="d-flex justify-content-between p-2  bg-light">
                                <div class="p-1"> {{$center->visitors}} <i class="fa fa-eye" aria-hidden="true"></i> </div>
                                <div class="p-1">{{$center->country->getName()}}</div>
                            </div>
                        </div>
                         <div class="col-md-9 bg-light">
                            <div class="p-2">
                                <div class="">
                                    @if (!count($center->getServices()))
                                     <div class="d-block text-center">{{__('site.no services')}}</div>
                                    @else
                                    <h6 class="text-center my-3">{{__('site.services')}}</h6>
                                    @endif
                                   @foreach ($center->getServices() as $service)
                                       <div class="p-2 d-flex  justify-content-between my-2 bg-white">
                                        <div>
                                            <label class="mx-3" >
                                             {{ $service->getName()}} 
                                             </label>
                                        </div>
                                        <div>
                                            <label class="mx-3" >
                                             {{ $service->vehicle->getName()}} 
                                             </label>
                                        </div>
                                        <div class="item-service" _id="{{ $service->id}}">
                                           <span class="cursor-pointer"> {{__('site.read more')}}</span>
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            {{ $service->price}} <span class="currency">{{$service->mcenter->country->getCurrency()}}</span>
                                        </div>
                                 </div>
                                 <div class="p-3 my-1 border collapse" id="item-service{{$service->id}}">
                                    {{ $service->getDescription()}}
                                 </div>
                                     
                                       @endforeach
                               </div> 
                                <div class="border-top my-3"></div>
                                <div class="d-flex justify-content-center pb-1">
                                   <a href="{{route('mcenters-profil',$center->id,$lang)}}" class="btn btn-info w-50">{{__('site.take order')}}</a>
                                </div>
                            </div>
                         </div>
                     </div>
                 </div>
@endforeach

 {{$mcenters->links()}}
@endif
