@if (!count($mc_requests))
<br>
<label class="d-block  text-center">
    {{__('site.no requests')}}
</label>
<br>
@else
<table class="table table-stroped table-responsive mt-5">
    <thead class="bg-light ">
       <tr>
           <th>{{__('site.user name')}}</th>
           <th>{{__('site.services')}}</th>
           <th>{{__('site.additional services')}}</th>
           <th>{{__('site.delivery to')}}</th>
           <th>{{__('site.delivery day')}}</th>
           <th>{{__('site.delivery time')}}</th>
           <th>{{__('site.price')}}</th>
           <th>{{__('site.status')}}</th>
           @if (auth()->user()->type == 0)
           <th style="width: 155px">{{__('site.rates')}}</th>
           @endif
           @if (auth()->user()->type == 5)
           <th>{{__('site.change status')}}</th>
           @endif
           <th>{{__('site.actions')}}</th>
       </tr>
    </thead>
    <tbody>
        @foreach ($mc_requests as $request)
        <tr>
           <td>{{$request->user->name}} </td>
           <td> 
               <ul>
                   @foreach ($request->services() as $i => $service)
                     <ol>  {{($i + 1).' - '.$service->getName()}}</ol>
                   @endforeach
               </ul>
            </td>    
            <td> 
                <ul>
                    @foreach ($request->additionalServices() as $i => $service)
                      <ol>  {{($i + 1).' - '.$service->getName()}}</ol>
                    @endforeach
                </ul>
             </td> 
            <td>{{__('site.'.$request->delivery_to)}}</td>
            <td>{{$request->delivery_day}}</td>
            <td>{{$request->time() }}</td>
            <td>{{$request->price }}</td>
            <td>
                <div class="
                @if ($request->status == 'approved')
                text-success
                @elseif($request->status == 'rejected' || $request->status == 'canceled')
                text-danger
                @endif
                ">
                {{__("site.".$request->status )}}
            </div>
            </td>
            @if (auth()->user()->type == 5)
            <td> 
                  <select  value="{{$request->status}}" _id="{{$request->id}}" class="change_status">
                    <option @if($request->status == 'in review') selected @endif value="in review">{{__('site.in review')}}</option>
                    <option @if($request->status == 'approved') selected @endif value="approved">{{__('site.approved')}}</option>
                    <option @if($request->status == 'finished') selected @endif value="finished">{{__('site.finished')}}</option>
                    <option @if($request->status == 'rejected') selected @endif value="rejected">{{__('site.rejected')}}</option>
                    <option @if($request->status == 'canceled') selected @endif value="canceled">{{__('site.canceled')}}</option>
                  </select>
            </td>
            @endif
            @if (auth()->user()->type == 0)
            <td>
                <div @if ($request->rate) data-results={{$request->rate->getRateResults()}}  @endif  class="rating-results ">
                    <div  class="val pt-3"></div>
                    <button type="button" 
                    @if($request->status == 'in review' ||
                    $request->status == 'approved'
                    ) 
                   profiml disabled
                    @endif
                    data-request-id="{{$request->id}}" class="btn btn-info text-white btn-xs w-100 open-modal" >تقييم</button>
                </div>
            </td>
            @endif
            <td>
                <button class="btn btn-danger btn-xs"  onclick="deleteRequest({{$request->id}})">{{__('site.delete')}}</button>

            </td>
        </tr>
        @endforeach
        {{$mc_requests->links()}}
    </tbody>
</table>
@endif



<!-- Modal -->
<div class="modal fade" id="rate-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">تقييم</h5>
                    </div>
            <div class="modal-body">
                <form id="rate-form" action="{{route('rate-menters')}}" method="post">
                   <input type="hidden" value="0" name="maintenance_request_id" id="maintenance_request_id">
                    @csrf
                    <div class="container-fluid">
                        <div class="p-2">
                            <div class="font-weight-bold my-1">جودة الخدمة</div>
                            <div class="rating" data-key="quality"></div>
                            <input type="hidden" value="0" name="quality" id="quality">
                         </div>
                         <div class="p-2">
                             <div class="font-weight-bold my-1">التسليم في الموعد</div>
                             <div class="rating" data-key="delivery_time"></div>
                             <input type="hidden" value="0" name="delivery_time" id="delivery_time">
                          </div>
                          <div class="p-2">
                             <div class="font-weight-bold my-1">التعامل معه مرة أخرى</div>
                             <div class="rating" data-key="delay_again"></div>
                             <input type="hidden" value="0" name="delay_again" id="delay_again">
                          </div>
                          <div class="my-2">
                              <label>ملاحظات</label>
                              <textarea class="w-100" name="notes" id="notes" cols="30" rows="5"></textarea>
                         </div> 
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                <button type="button" id="save-rating" class="btn btn-primary">{{__('site.save')}}</button>
            </div>
        </div>
    </div>
</div>
