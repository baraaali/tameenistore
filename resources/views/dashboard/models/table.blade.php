<table class="table table-stroped table-responsive table-straped text-center">
    <thead class="bg-light ">
    <th>
        رقم
    </th>
    <th>
        الاسم
    </th>
    <th>
        نوع العربة
    </th>
    <th>
        ماركة
    </th>
    <th>
        شكل السيارة
    </th>
    <th>
        عدد الركاب 
    </th>
    <th>{{__('site.status')}}</th>
    <th>
        العمليات
    </th>
    </thead>
    <tbody>
    @foreach($models as $key=>$model)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$model->name}}
            </td>
            <td>
              {{$model->brands->vehicle->ar_name}}
          </td>
            <td>
                {{$model->brands->name}}
            </td>  
            <td>
                {{$model->careshape->ar_name}}
            </td>
            <td>
                {{$model->passengers}}
            </td>
            <td>
                @if ($model->status == '1')
                    <span class="badge badge-success p-1">نشيط</span>
                @else
                <span class="badge badge-danger p-2">{{__('site.inactive')}}</span>
                @endif
            </td>


            <td>
                <a href="#" data-toggle="modal" _id="{{$model->id}}" data-target="#edit{{$model->id}}"
                   class="btn btn-primary btn-sm edit">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                 <a class=" btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"
                   href="{{route('models.delete', $model->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
@if(!isset($is_search))
{{$models->links()}}
@endif
