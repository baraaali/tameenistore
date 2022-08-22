

<table class="table table-stroped table-responsive table-straped text-center  table-responsive ">
    <thead class="bg-light ">
        <th>اسم العميل</th>
        <th>ايميل العميل</th>
        <th>تليفون العميل</th>
        <th>البراند</th>
        <th>الموديل</th>
        <th>سنه صنع السيارة</th>
        <th>مدة التامين</th>
        <th>بدأ التأمين</th>
        <th>النسبه</th>
        <th>السعر الاجمالى</th>
        <th>الاضافات</th>
        <th>السعر الصافى </th>
        <th>بدايه التأمين </th>
        <th>الملف </th>
        <th>الشركة </th>
        <th>الحاله</th>
        <th>حذف</th>
        </thead>

    <tbody>
        @foreach($items as $key=>$CompleteDocSubmit)
        @if($CompleteDocSubmit->complete_doc)
        <tr>
            <td>{{$CompleteDocSubmit->user->name}}</td>
            <td>{{$CompleteDocSubmit->user->email}}</td>
            <td>{{$CompleteDocSubmit->user->phones}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->idbrand->name}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->idmodel->name}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->year}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->in_duration}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->start_disc}}</td>
            <td>{{$CompleteDocSubmit->complete_doc->precent}}</td>
            <td>{{$CompleteDocSubmit->price}}</td>
            <td>
                    <?php
                     $submit_add=\App\CompleteDocSubmitAddition::where('complete_doc_submit_id',
                      $CompleteDocSubmit->id)->get();
                    ?>
                    @foreach($submit_add as $sub)
                    @if(app()->getLocale() == 'ar')
                        اسم الاضافه :  {{$sub->addition!=null?$sub->addition->FeatureNameAr:''}}
                    @else
                        addition name :   {{$sub->addition!=null?$sub->addition->FeatureNameEn:''}}
                    @endif
                    <br>
                    <span
                        class="text-white btn btn-secondary">سعر الاضافة :
                        {{$sub->addition!=null?$sub->addition->FeatureCost:''}}</span>
                    <br>
                @endforeach
            </td>
            <td>{{$CompleteDocSubmit->net_price}}</td>
            <td>{{$CompleteDocSubmit->start_date}}</td>
            <td><a href="" download></a>
                <a href="{{asset('uploads/'.$CompleteDocSubmit->file)}}" download>
{{--                                    <img src="{{asset('uploads/'.$CompleteDocSubmit->file)}}">--}}
                    <i class="fa fa-image fa-2x"></i>
                </a>
            </td>
            <td>{{$CompleteDocSubmit->complete_doc->Insurance_Company_ar}}</td>
            @if (auth()->user()->type == 4)
            <td>
                <form action="{{route('submitCompleteDocChangeStatus')}}" method="post">
                    @csrf
                <input type="hidden" name="sub_id" value="{{$CompleteDocSubmit->id}}">
                <input type="hidden" name="status" value="{{$CompleteDocSubmit->status}}">
                <input type="submit" class="btn btn-warning text-center text-white" value="@if($CompleteDocSubmit->status==1){{__('site.pending')}}@elseif($CompleteDocSubmit->status==2){{__('site.viewed')}}@else {{__('site.replayed')}}
                @endif" style="width: 95px">

                </form>
            </td>
            @else
             <td>
                
                    @if($CompleteDocSubmit->status==1) 
                    <span class="badge badge-primary p-2">{{__('site.pending')}}  </span>
                    @elseif($CompleteDocSubmit->status==2)  <span class="badge badge-success p-2">{{__('site.viewed')}}  </span>
                    @else  <span class="badge badge-info p-2"> {{__('site.replayed')}} </span>
                    @endif
               

             </td>
           @endif
           
            <td>
                <a onclick="return confirm('Are you sure?')"
                   href="{{route('hidden_request',$CompleteDocSubmit->id)}}"
                   class="btn btn-primary btn-md">
                    <i class="fa fa-trash text-white"></i>
                </a>
            </td>
        </tr>
        @endif

    @endforeach

    </tbody>
</table>
     {{-- {{$items->links()}} --}}