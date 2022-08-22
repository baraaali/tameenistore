<table class="table table-stroped table-responsive   table-responsive d-table">
    <thead class="table-primary">
        <tr>
            <th>{{__('site.name of the ad')}}</th>
            <th>{{__('site.target Category')}}</th>
            <th>{{__('site.target count')}}</th>
            <th>{{__('site.views')}}</th>
            <th>{{__('site.status')}}</th>
            <th>{{__('site.date')}}</th>
            <th>
                معاينة
            </th>
        <th>
            حذف
        </th>
        </tr>
    
    </thead>
    <tbody>
        @foreach ($promotions as $promotion)
        <tr>
                @if ($promotion->ad($promotion)->first())
                <td>{{$promotion->ad($promotion)->first()->$name}}</td>
                @else  
                <td class="text-danger">تم حذف هدا الإعلان</td>
                @endif
                <td>{{$promotion->target($promotion)}}</td>
                <td>{{$promotion->target($promotion,'count')}}</td>
                @if ($promotion->ad($promotion)->first())
                <td>{{$promotion->ad($promotion)->first()->visitors}}</td>
                @else
                <td>0</td>
                @endif
                <td
                class="@if ($promotion->status == 'approved')
                     text-success h6
                    @elseif ($promotion->status == 'rejected')
                    text-danger h6
                @endif"
                >{{__('site.'.$promotion->status)}}</td>
                <td>{{$promotion->created_at}}</td>
                
                <td>
                    <a href="#" class="btn btn-primary btn-sm btn-view"  _id="{{$promotion->id}}" >
                        <i class="fa fa-eye"></i> معاينة
                    </a>
                </td>
                <td>
                    <a onclick="return confirm('Are you sure?')" href="{{url('/')}}/promotion/destroy/{{$promotion->id}}" class="btn btn-danger btn-sm ">
                        <i class="fa fa-trash text-white"></i> حذف
                    </a>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$promotions->links()}}
