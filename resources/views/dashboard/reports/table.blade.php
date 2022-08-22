<table class="table table-stroped table-responsive table-straped text-center ">
    <thead class="bg-light ">
    <th>م</th>
    <th>اسم المستخدم</th>
    <th>الاميل</th>
    <th>الرصيد قبل</th>
    <th>المبلغ المدفوع</th>
    <th>الرصيد بعد </th>
    <th>نوع العمليه</th>
    <th>القائم بالعمليه</th>
    <th>سبب العمليه</th>
    <th colspan="2">التاريخ</th>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
        <tr>
            <td> {{$key + 1}}</td>
            <td class="text-info">{{$item->user->name}} </td>
            <td class="text-primary">{{$item->user->email}}  </td>
            <td class="text-danger">{{$item->balance_before}}</td>
            <td class="text-success">{{$item->value}}  </td>
            <td class="text-danger">{{$item->balance_after}}</td>
            <td class="text-warning"> {{$item->transaction=="in"?__('site.inside'):__('site.outside')}}</td>
            <td class="text-success">{{$item->type_id==-1?__('site.admin'):__('site.your_res')}}</td>
            <td class="text-primary ">@if($item->type=="charge") {{__('site.pro_charge')}}
                @elseif($item->type=="membership"){{__('site.for_membership')}}
                @elseif($item->type=="department"){{__('site.for_department')}}
                @else {{__('site.for_car')}}@endif</td>

            <td>{{Carbon\Carbon::parse($item->created_at)->toFormattedDateString()}}</td>

        </tr>
    @endforeach

    </tbody>
</table>
      {{$items->links()}}