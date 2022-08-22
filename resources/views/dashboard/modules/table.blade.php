<table class="table table-stroped table-responsive table-straped text-center ">
    <thead class="bg-light ">
    <th>
        رقم
    </th>
    <th>
        اسم القسم
    </th>
    <th>
        اسم المالك
    </th>
    <th>
        اسم الدوله
    </th>
    <th>الصورة</th>
    <th>الحاله</th>
    <th>{{__('site.ad type')}}</th>
    <th>المشاهدات</th>
    <th>تاريخ انتهاء الاعلان</th>
    <th>
        العمليات
    </th>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$item->name_ar}}
            </td>
            <td>
                {{$item->users->name}}
            </td>
            <td>
                {{$item->country->ar_name}}
            </td>
            <td>
                <img src="{{asset('uploads/'.$item->image)}}" alt=""
                     style="height:50px;width: 50px" class="img-thumbnail">
            </td>
            <td>
                <button class="cl_{{$item->id}} btn {{$item->status==0?'btn-danger':'btn-success'}} stat" id="{{$item->id}}" data-url="{{$item->status}}" >
                    {{$item->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$item->id}}" value="{{$item->status}}">
            </td>
            <td>
                @if ($item->membership)
                @if($item->membership->type==0)عاديه
                @elseif($item->membership->type==1)فضيه
                @elseif($item->membership->type==2)مميزة
                @elseif($item->membership->type==3)ذهبيه
                @endif
                @endif
            </td>
            <td>{{$item->visitor}}</td>
            <td>{{$item->end_date}}</td>
            <td>
                {{-- <a href="{{route('editServices',[$item->id,'ar','admin'])}}" class="btn btn-light circle" >
                    <i class="fas fa-plus-circle"></i>
                </a> --}}
               <div class="d-flex">
                <a href="{{route('modules-edit',$item->id)}}" class="btn btn-primary btn-xs" 
                    data-target="">
                     <i class="fa fa-edit"></i>
                 </a>
                 <a onclick="return confirm('Are you sure?')" href="{{route('modules.destroy',$item->id)}}"
                    class="btn btn-danger btn-xs mx-1">
                     <i class="fa fa-trash text-white"></i>
                 </a>
                
                 @if (auth()->user()->guard == 1)
                 <a href="#" class="btn btn-success btn-xs mx-1" data-toggle="modal"
                    data-target="#renew_item_as_admin{{$item->id}}">
                     <i class="fas fa-sync"></i> 
                 </a>
                 @else
                 <a href="#" class="btn btn-success btn-xs mx-1" data-toggle="modal"
                 data-target="#renew_item_as_user{{$item->id}}">
                 <i class="fas fa-sync"></i> 
                 </a>
                 @endif

               </div>

            </td>
        </tr>
        <!-- Modal -->
        <div class="modal fade" id="renew_item_as_user{{$item->id}}" tabindex="-1"
            aria-labelledby="exampleModalLabel{{$item->id}}" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal"
    aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
<h5 class="modal-title" id="exampleModalLabel">{{__('site.renew')}}</h5>
</div>
<div class="modal-body">
<form action="{{route('renewServices')}}" method="post">
@csrf
<input type="hidden" id="cash" value="" name="cash">
<input type="hidden" id="ad" value="{{$item->id}}" name="ad">
<div class="form-group col-md-12">
<label>{{__('site.ads_type')}}

</label>
<select name="special" class="SpecificInput change_member" id="special">
<option>{{__('site.select')}}</option>
@foreach(\App\NewServiceMembership::get() as $price)
   <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->getName()}}</option>
@endforeach
</select>
</div>
<div class="form-group col-md-12">
<input type="submit"  class="SpecificInput btn btn-primary" value="تجديد" >
</div>

</form>
</div>


</div>
</div>
       </div>

        <div class="modal fade" id="renew_item_as_admin{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تجديد الاعلان </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('modules_renew_date_item')}}">
                            @csrf
                            <input type="hidden" name="item_date_id"
                                   value="{{$item->id}}">
                            <input required type="number" name="item_days" class="form-control form-group" placeholder="ادخل عدد الايام ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق </button>
                            <input type="submit" class="btn btn-primary" value="تجديد">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--------- Branches  Edit Modal !---------->
        <div class="modal fade" id="exampleModalLabel2{{$item->id}}" tabindex="-1"
             role="dialog" aria-labelledby="#exampleModalLabel2{{$item->id}}"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">تعديل
                            البيانات </h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body"
                             style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">


                            <div class="form-body">
                                <form method="POST"
                                      action="{{route('items-Update')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"
                                           value="{{$item->id}}">
                                    @if(app()->getLocale() == 'ar')
                                        <style>
                                            .form-group {
                                                direction: rtl;
                                                text-align: right !important;
                                            }
                                        </style>

                                        <div class="form-group">
                                            <label style="display:block">
                                                النوع <small
                                                    class="text-danger">*</small>

                                            </label>
                                            <select
                                                class="SpecificInput catChange select2"
                                                name="category_id" style="width:100%;">
                                                @foreach($viewcategories as $categories)
                                                    <option value="{{$categories->id}}">

                                                        {{$categories->ar_name}} <small
                                                            class="text-danger">*</small>


                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label style="display:block">
                                                البلد <small
                                                    class="text-danger">*</small>

                                            </label>
                                            <select
                                                class="SpecificInput countChange select2"
                                                name="country_id" style="width:100%;">
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}">
                                                        {{$country->ar_name}}
                                                    </option>


                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                إسم الاعلان بالعربية <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="ar_name" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->ar_name}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                إسم الاعلان بالانجليزيه <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="en_name" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->en_name}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                الوصف بالعربية <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="ar_desciption" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->ar_desciption}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                الوصف بالانجليزيه <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="en_description" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->en_description}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                الصورة الرئيسية <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <img src="{{asset('uploads/'.$item->main_image)}}" alt=""
                                                 style="max-width: 100%;width:50%;height:50%">
                                            <label for="images">صورة الرئيسيه:</label>
                                            <input type="file"
                                                   name="main_image" ><br><br>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                الصور <small
                                                    class="text-danger">*</small>
                                            </label></br>
                                            @foreach($item->images as $viewimage)
                                                <img
                                                    src="{{url('/')}}/uploads/{{$viewimage->image}}"
                                                    style="max-width: 100%;width:50%;height:50%">
                                                @endforeach
                                                </br>
                                                <label for="images">Select
                                                    Images:</label>
                                                <input type="file" id="images"
                                                       name="images[]" multiple><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                السعر <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="price" class="SpecificInput"
                                                   value="{{$item->price}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                نسبة الخصم % <small class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="discount" class="SpecificInput"
                                                   value="{{$item->discount}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                قيمة الخصم<small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="dicount_percent"
                                                   class="SpecificInput"
                                                   value="{{$item->dicount_percent}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                تاريخ بداية الخصم<small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="date" required="required"
                                                   name="start_date"
                                                   class="SpecificInput"
                                                   value="{{$item->start_date}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                تاريخ نهاية الخصم <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="date" required="required"
                                                   name="end_date" class="SpecificInput"
                                                   value="{{$item->end_date}}">
                                        </div>

                                    @else
                                        <style>
                                            .form-group {
                                                direction: ltr;
                                                text-align: left !important;
                                            }
                                        </style>



                                        <div class="form-group">
                                            <label style="display:block">

                                                Categories <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <select
                                                class="SpecificInput catChange select2"
                                                name="category_id" style="width:100%;">
                                                @foreach($viewcategories as $categories)
                                                    <option value="{{$categories->id}}">


                                                        {{$categories->en_name}} <small
                                                            class="text-danger">*</small>

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label style="display:block">

                                                Countries <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <select
                                                class="SpecificInput countChange select2"
                                                name="country_id" style="width:100%;">
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}">
                                                        {{$country->en_name}}
                                                    </option>

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                department name in arabic <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="ar_name" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->ar_name}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                department name in english <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="en_name" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->en_name}}">
                                        </div>



                                        <div class="form-group">
                                            <label>
                                                description in arabic <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="ar_desciption" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->ar_desciption}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                description in english <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="text" required="required"
                                                   name="en_description" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->en_description}}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Images <small
                                                    class="text-danger">*</small>
                                            </label></br>
                                            @foreach($item->images as $viewimage)
                                                <img
                                                    src="{{url('/')}}/uploads/{{$viewimage->image}}"
                                                    style="max-width: 100%;width:50%;height:50%">
                                            @endforeach

                                            <label for="images">Select Images:</label>
                                            <input type="file" id="images"
                                                   name="images[]" multiple><br><br>
                                        </div>




                                        <div class="form-group">
                                            <label>
                                                price <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="price" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->price}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                discount percentage % <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="discount" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->discount}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                discount value <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="tel" required="required"
                                                   name="dicount_percent"
                                                   maxlength="191" class="SpecificInput"
                                                   value="{{$item->dicount_percent}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                discount start date<small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="date" required="required"
                                                   name="start_date" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->start_date}}">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                discount in date <small
                                                    class="text-danger">*</small>
                                            </label>
                                            <input type="date" required="required"
                                                   name="end_date" maxlength="191"
                                                   class="SpecificInput"
                                                   value="{{$item->end_date}}">
                                        </div>

                                    @endif
                                    <div class="modal-footer">

                                        @if(app()->getLocale() == 'ar')
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-dismiss="modal">اغلاق
                                            </button>
                                            <input type="submit" name="submit"
                                                   class="btn btn-primary"
                                                   value="تعديل">
                                        @else
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-dismiss="modal">Close
                                            </button>
                                            <input type="submit" name="submit"
                                                   class="btn btn-primary"
                                                   value="update">
                                        @endif
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </tbody>
</table>
      {{$items->links()}}