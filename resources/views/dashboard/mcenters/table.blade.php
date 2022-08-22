<table class="table table-stroped">
    <thead>
        <td>
            رقم
        </td>
        <td>
            الدولة - المنطقة
        </td>
        <td>
            إسم  المستخدم
        </td>
        <td>
            إسم المركز
        </td>
        <td>
            مجال العمل 
        </td>
        <td>
            الصورة 
        </td>
        <td>
         نوع العضوية
        </td>
        <td>
              الإشتراك 
        </td>
         <td>
             تاريخ التجديد
        </td>
        <td>
            الحالة
        </td>
        <td>
            العمليات
        </td>

    </thead>
    <tbody >
        @foreach($centers as $key=>$center)
            <tr>
                <td>
                    {{$key + 1}}
                </td>
                <td>
                    @isset($center->owner->country)
                    <button class="btn btn-dark btn-xs">
                        {{$center->owner->country->ar_name}}
                    </button>
                        
                    @endisset
                </td>

                <td>
                    <button class="btn btn-primary btn-xs">
                        {{$center->owner->name}}
                    </button>
                </td>

                <td>
                    {{$center->ar_name}}
                </td>
                <td>
                    {{$center->getCategory()}}
                </td>
                <td>
                    <img src="{{url('/')}}/uploads/{{$center->image}}" style="width:auto;height:50px ">
                </td>
                <td>
                  {{$center->serviceMemberShip->ar_name}}
                </td>
                <td>
                  <div style="width: 50px">
                    {{$center->serviceMemberShip->months_number}}
                    شهر <br> عضوية
                    {{__('site.'.$center->serviceMemberShip->type)}}
                  </div>
                  </td> 
                  <td>
                  <div style="width: 90px">
                    {{$center->renewal_at}}
                  </div>
                  </td>
                <td>
                    @if ($center->status == 1)
                        <span data-id={{$center->id}} data-status={{$center->status}} class="p-2 change_status pointer badge badge-success">{{__('site.active')}}</span>
                        @else
                        <span data-id={{$center->id}} data-status={{$center->status}} class="p-2 change_status pointer badge badge-danger">{{__('site.inactive')}}</span>
                    @endif
                </td>
                <td>
                   <div class="d-flex">
                    <a href="{{route('centers-edit',['id'=>$center->id])}}" class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i> 
                    </a>
                    <a href="#"  _id="{{$center->id}}"  class="btn  mx-1 btn-success btn-xs text-white renewal">
                        <i class="fa fa-sync "></i> 
                    </a>
                    <a href="{{route('centers-delete',['id'=>$center->id])}}" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash text-white"></i> 
                    </a>
                   </div>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
{{$centers->links()}}



<!-- Modal -->
<div class="modal fade" id="renewal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">تجديد إشتراك</h5>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <form id="renewal-form" action="{{route('renewal-centers')}}" method="post">
                    @csrf
                   <div class="w-100">
                    <label for="check">
                        <input class="p-0 mx-1" type="checkbox"   id="check" value="1" >
                         هل أنت متأكد من تجديد الإشتراك ؟
                    </label>
                    <input type="hidden" name="id" id="renewal-id" value="" >
                   </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary renewal-save">نعم</button>
            </div>
        </div>
    </div>
</div>
