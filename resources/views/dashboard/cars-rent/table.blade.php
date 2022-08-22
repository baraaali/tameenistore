<table class="table table-stroped table-responsive table-straped text-center ">
 <thead class="bg-light ">
    <td>
        رقم
    </td>
    <td>
        الدولة - المنطقة
    </td>

    <td>
        إسم العربية
    </td>

    <td>
        المودل
    </td>
    <td>
        السعر
    </td>
    <td>
        الحالة
    </td>


    <td>
        الزيارات
    </td>
    <td>
        تاريخ الانتهاء
    </td>
    <td>
        العمليات
    </td>
 </thead>
    <tbody>
        @foreach($items as $key=>$ad)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                    {{$ad->country->ar_name}}
            </td>


            <td>
                {{$ad->ar_name}}
            </td>

            <td>
                @if($ad->model)
                {{$ad->model->name}}                    
                @endif
            </td>
            <td>
                <strong>
               {{$ad->Price->cost }}
               {{$ad->Price->currency}} 
                </strong>
            </td>
            <td>
                <button class="cl_{{$ad->id}} btn {{($ad->status==0)?'btn-danger':'btn-success'}} stat" id="{{$ad->id}}" data-url="{{$ad->status}}" >
                    @if($ad->status==1)
                        نشط
                        @else
                 غير نشط 
                 @endif
                </button>
                <input type="hidden" id="statusVal" class="statusVal_{{$ad->id}}" value="{{$ad->status}}">
            </td>

            <td>
                {{$ad->visitors}}
            </td>
            <td>
                {{$ad->end_ad_date}}
            </td>
            <td>
                  <div class="d-flex">
                    <a href="{{route('Ads-edit',$ad->id,app()->getLocale())}}"
                        class="btn btn-primary btn-xs ">
                         <i class="fa fa-edit"></i> 
                     </a>
                     @if (auth()->user()->guard == 1)
                     <a href="#" class="btn btn-success btn-xs mx-1" data-toggle="modal"
                        data-target="#renew_item_as_admin{{$ad->id}}">
                         <i class="fas fa-sync"></i> 
                     </a>
                     @else
                     <a href="#" class="btn btn-success btn-xs mx-1" data-toggle="modal"
                     data-target="#renew_item_as_user{{$ad->id}}">
                     <i class="fas fa-sync"></i> 
                     </a>
                     @endif
 
                     <a onclick="return confirm('Are you sure?')"
                        href="{{route('Ads-delete',$ad->id)}}"
                        class="btn btn-danger btn-xs">
                         <i class="fa fa-trash text-white"></i> 
                     </a>
                  </div>
                
                <!--  renew_item_as_admin -->
                <div class="modal fade" id="renew_item_as_admin{{$ad->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">تجديد الاعلان </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('dashboard_renew_date_ads')}}">
                                    @csrf
                                    <input type="hidden" name="item_date_id"
                                           value="{{$ad->id}}">
                                    <input required type="number" name="item_days" class="form-control form-group" placeholder="ادخل عدد الايام ">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق </button>
                                    <input type="submit" class="btn btn-primary" value="تجديد">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end  renew_item_as_admin  -->
                <!--  renew_item_as_user -->
                <div class="modal fade" id="renew_item_as_user{{$ad->id}}" tabindex="-1"
                     aria-labelledby="exampleModalLabel{{$ad->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                @if(app()->getLocale() == 'ar')
                                    <h5 class="modal-title" id="exampleModalLabel">تجديد
                                        الاعلان</h5>
                                @else
                                    <h5 class="modal-title" id="exampleModalLabel">Ads
                                        Renew</h5>
                                @endif
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('renew_ads_from_balance')}}" method="post">
                                    @csrf
                                    <input type="hidden" id="cash" value="" name="cash">
                                    <input type="hidden" id="ad" value="{{$ad->id}}" name="ad">
                                    <div class="form-group col-md-12">
                                        <label>{{__('site.ads_type')}}
                                        </label>
                                        <select name="special" class="SpecificInput change_member" id="special">
                                            <option>{{__('site.select')}}</option>
                                            @foreach(\App\AdsMembership::get() as $price)
                                                <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->getName()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="submit"  class="SpecificInput btn btn-primary" name="{{__('site.send')}}" >
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                        data-dismiss="modal">{{__('site.close')}}
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
                  <!--  renew_item_as_user -->
            </td>

        </tr>
    @endforeach

    </tbody>
</table>
      {{$items->links()}}