@if (empty($services->count()))
<br>
<label class="d-block  text-center">
    {{__('site.no services')}}
</label>
<br>
@else
<table class="table table-stroped table-responsive mt-4 d-block ">
    <thead class="bg-light ">
       <tr>
           <th>{{__('site.name')}}</th>
           <th>{{__('site.vehicle type')}}</th>
           <th>{{__('site.description')}}</th>
           <th>{{__('site.price')}}</th>
           <th>{{__('site.additional services')}}</th>
           <th>{{__('site.status')}}</th>
           <th>{{__('site.actions')}}</th>
       </tr>
    </thead>
    <tbody>
        @foreach ($services as $service)
        <tr>
            <td>{{$service->getName()}}</td>
            <td>{{$service->vehicle->getName()}}</td>
            <td>{{$service->getDescription()}}</td>
            <td>{{$service->price}}</td>
            <td>
                <ul>
                    @foreach ($service->addtionalServices as $item)
                     <ol>{{$item->getName()}}</ol>
                    @endforeach
                </ul>
            </td>
            <td>
                @if ($service->status == "1")
                    <span class="badge badge-success">{{__('site.active')}}</span>
                    @else
                    <span class="badge badge-danger">{{__('site.deactive')}}</span>
                @endif
            </td>
            <td>
                <button type="button" _id="{{$service->id}}" class="btn btn-primary edit">{{__('site.edit')}}</button>
                <button type="button" _id="{{$service->id}}"  class="btn btn-danger delete">{{__('site.delete')}}</button>
            </td>
        </tr>
        @endforeach
        {{$services->links()}}
    </tbody>
</table>
@endif