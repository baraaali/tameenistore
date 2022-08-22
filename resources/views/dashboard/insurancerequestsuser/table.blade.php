<table class="table table-stroped table-responsive table-straped text-center  table-responsive">
    <thead class="bg-light ">
        <th>
            اسم الوثيقة
            </th>
            <th>
            اسم العميل
            </th>
            <th>
                ايميل العميل
            </th>
            <th>
               تليفون العميل
            </th>
            <th>
                البراند
            </th>
            <th>
                الموديل
            </th>
            <th>
            سنه صنع السيارة
            </th>
            <th>
            مدة التامين
            </th>
            <th>
                بدأ التأمين
            </th>
            <th>
                الملفات
            </th>
            <th>
            السعر
            </th>
            @if (auth()->user()->type == 4)
            <th>
                تم الانتهاء
            </th>
    
            @endif
    </thead>
    <tbody>
        @foreach($items as $key=>$document)
        <tr>
            <td>
                @if(app()->getLocale() == 'ar')
                   {{$document->companynamear}}
                @else
                   {{$document->companynameen}}
                @endif
            </td>

            <td>
                {{$document->user->name}}
            </td>
            <td>
                {{$document->user->email}}
            </td>
            <td>
                {{$document->user->phones}}
            </td>
            <td>
                {{$document->brand->name}}
            </td>
            <td>
                {{$document->model->name}}
            </td>
            <td>
                {{$document->year}}
            </td>
            <td>
                {{$document->inDuration}}
            </td>
            <td>
                {{$document->start_in}}
            </td>
            <td>
                <?php

                    $images = [];
                    $images = json_decode($document->files);

                ?>

                @if(count($images))
                    @foreach($images as $key=>$image)
                        <a href="{{url('/')}}/uploads/{{$image}}" class="btn btn-light" download>
                            download #_{{++$key}}
                        </a>

                    @endforeach
                @endif
            </td>
            <td>
                {{$document->price}}
            </td>
            @if (auth()->user()->type == 4)

            <td>
                <a href="{{route('deleteinDocument',$document->id)}}" class="btn btn-danger">
                    @if(app()->getLocale() == 'ar')
                        تم الانتهاء
                    @else
                        Done
                    @endif
                </a>
            </td>
            @endif
        </tr>
    @endforeach

    </tbody>
</table>
     {{-- {{$items->links()}} --}}