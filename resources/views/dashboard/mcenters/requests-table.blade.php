<table class="table table-stroped table-responsive ">
    <thead class="bg-light ">
        <tr>
            <th>{{__('site.center name')}}</th>
            <th>{{__('site.user name')}}</th>
            <th>{{__('site.services')}}</th>
            <th>{{__('site.additional services')}}</th>
            <th>{{__('site.delivery to')}}</th>
            <th>{{__('site.delivery day')}}</th>
            <th>{{__('site.delivery time')}}</th>
            <th>{{__('site.price')}}</th>
            <th>{{__('site.status')}}</th>
            @if (auth()->user()->type == 5)
            <th>{{__('site.change status')}}</th>
            @endif
        </tr>
     </thead>
     <tbody>
         @foreach ($mc_requests as $request)
         <tr>
            <td>{{$request->mcenter->getName()}}</td>
            <td>{{$request->user->name}}</td>
            <td> 
                    @foreach ($request->services() as $i => $service)
                      <div>  {{($i + 1).' - '.$service->getName()}}</div>
                    @endforeach
             </td>    
             <td> 
                     @foreach ($request->additionalServices() as $i => $service)
                       <div>  {{($i + 1).' - '.$service->getName()}}</div>
                     @endforeach
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
                   <select  value="{{$request->status}}" _id="{{$request->id}}" id="change_status">
                     <option @if($request->status == 'in review') selected @endif value="in review">{{__('site.in review')}}</option>
                     <option @if($request->status == 'approved') selected @endif value="approved">{{__('site.approved')}}</option>
                     <option @if($request->status == 'finished') selected @endif value="finished">{{__('site.finished')}}</option>
                     <option @if($request->status == 'rejected') selected @endif value="rejected">{{__('site.rejected')}}</option>
                     <option @if($request->status == 'canceled') selected @endif value="canceled">{{__('site.canceled')}}</option>
                   </select>
             </td>
             @endif
         </tr>
         @endforeach
         {{$mc_requests->links()}}
     </tbody>
</table>
