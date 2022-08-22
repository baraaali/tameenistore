<table class="table table-stroped table-responsive ">
    <thead class="bg-light ">
        <td colspan="2">تاريخ الانتهاء</td>
        <td>
            النوع
        </td>
        <td>
            نوع المركبة
        </td>
        <td>
            البراند
        </td>
        <td>
            الموديل
        </td>
        <td>
            الشركة
        </td>
        <td>
            الحالة
        </td>
        <td>
            العمليات
        </td>

    </thead>

    @foreach($complete_insurance  as $document)
        <tbody>
        <tr>
            <td>{{date('Y-m-d',strtotime($document->end_date))}}</td>
            
            <td>
            </td>
            <td>
                {{\App\Style::where('id',$document->type_of_use)->first()->$name}}
            </td>
            <td>
                {{$document->vehicle->getName()}}
            </td>

            <td>
                {{$document->idbrand ? $document->idbrand->name  : ''}}
            </td>
            <td>
                {{$document->idmodel ? $document->idmodel->name : ''}}
            </td>
            <td>
                @if(app()->getLocale() == 'ar')
                    {{$document->Insurance_Company_ar}}
                @else
                    {{$document->Insurance_Company_en}}
                @endif

            </td>
            <td>
            @if ($document->status == 1)
            <span class="badge badge-success p-1">{{__('site.active')}}</span>
            @else
            <span class="badge badge-danger p-1">{{__('site.inactive')}}</span>
            @endif
            </td>


            <td>
                <!--//////////////////////check///////////////////////////////-->
                <!-- 'ضد الغير' ||' Against Forieg)-->
                @if($document->type == '0')
                    <a href="{{route('cmDocument-edit',$document->id ,app()->getLocale())}}"
                       class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-success btn-xs" data-toggle="modal"
                       data-target="#exampleModal{{$document->id}}">
                        <i class="fas fa-sync"></i>
                    </a>

                @else
                    <a href="{{route('cmDocument-edit',$document->id ,app()->getLocale())}}"
                       class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                   <a href="{{route('renew_tammeen',[$document->id,0,app()->getLocale()])}}" class="btn btn-success btn-sm">
                    <i class="fas fa-sync"></i> تجديد
                </a>
                    <a onclick="return confirm('Are you sure?')"
                       href="{{route('delete_com_doc',$document->id)}}"
                       class="btn btn-danger btn-xs">
                        <i class="fa fa-trash text-white"></i>
                    </a>
                    <a href="{{route('get_all_brands',$document->Insurance_Company_ar)}}"
                       class="btn btn-warning btn-xs">
                        <i class="fa fa-anchor"></i></a>

                @if($document->display==1)
                    @if($document->end_date>date('Y-m-d H:i:s'))
                    <a href="{{route('add_Brand',$document->id)}}"
                       class="btn btn-secondary btn-xs">
                        <i class="fa fa-plus"></i></a>
                        @endif
                @endif
                @endif

            </td>

        </tr>
        @endforeach
        </tbody>
        <!--------- Branches  Edit Modal !---------->


</table>