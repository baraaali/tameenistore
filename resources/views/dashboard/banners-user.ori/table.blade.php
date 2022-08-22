<table class="table table-stroped table-responsive ">
    <thead class="bg-light ">
        <td>اسم الاعلان بالعربيه</td>
        <td>الدوله </td>
        <td>الحاله</td>
        <td>تاريخ البدء</td>
        <td>تاريخ الانتهاء</td>
        <td> الصورة</td>
        <td> العمليات</td>
    </thead>
   <tbody>
   @foreach($banners as $row)
        <tr>
            <td>{{$row->Banner->name_ar}}</td>
            <td>{{$row->country->ar_name}}</td>
            <td><button class="btn btn-secondary text text-white">{{$row->active==0?'مفعل':'غير مفعل'}}</button></td>
            <td>{{$row->start_date}}</td>
            <td>{{$row->end_date}}</td>
            <td><img src="{{asset('uploads/'.$row->file)}}" class="img-thumbnail"
                     style="width: 100px;height: 60px" alt=""></td>
            <td>
                <a href="" class="btn btn-primary btn-xs" data-toggle="modal"
                   data-target="#edit_banner">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="#" class="btn btn-success btn-xs" data-toggle="modal"
                   data-target="#renew_banner">
                    <i class="fas fa-sync"></i> تجديد
                </a>
                <a onclick="return confirm('Are you sure?')"
                   href="{{route('deleteBanner',$row->id)}}"
                   class="btn btn-danger btn-xs">
                    <i class="fa fa-trash"></i>
                </a>
            </td>

        </tr>
   @endforeach

        </tbody>
        <!--------- Branches  Edit Modal !---------->
</table>

<!--Branches create Modal -->
<div class="modal fade" id="exampleModal" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('site.select_banner')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;">
                    <div class="form-body">
                        <form method="POST" action="{{route('add-user-banner')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.select_ad')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                        class="SpecificInput"
                                        name="banner_id" style="width:100%;" id="banner" required>
                                        <option value="">{{__('site.select')}}</option>
                                        @foreach($banners as $banner)
                                            <option value="{{$banner->id}}">{{$banner->$name2}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.price')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                        class="SpecificInput catChange " name="price" id="price" style="width:100%;" id="price" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.show_place')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                        class="SpecificInput catChange " name="place" id="place" style="width:100%;" id="place">
                                    </select>
                                </div>
                               <div class="form-group">
                                <label style="display:block">{{__('site.page')}} <small class="text-danger">*</small>
                                </label>
                                <select
                                    class="SpecificInput catChange " name="page" id="page" style="width:100%;" id="page" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{__('site.select_image')}}</label>
                                <input type="file" name="file" class="SpecificInput" required id="imgInp">
                            </div>
                            <div class="form-group">
                                <img src="{{asset('uploads/banner_default.jpg')}}" id="blah" alt="" class="img-thumbnail" style="width: 100% ;height: 100%">
                            </div>
                            <div class="form-group">
                                <label>{{__('site.select_country')}}</label>
                                <select
                                        class="SpecificInput countChange select2"
                                        name="country_id" style="width:100%;">
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">
                                            {{$country->ar_name}}
                                        </option>


                                    @endforeach
                                </select>                                                            </div>
                            <div class="form-group">
                                <label>{{__('site.start_date')}}</label>
                                <input type="date" name="start_date" class="SpecificInput" required>
                            </div>
                            <div class="form-group">
                                <label>{{__('site.link')}}</label>
                                <input type="text" name="link" class="SpecificInput" placeholder="https://www.google.com">
                            </div>
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{__('site.close')}}
                                </button>
                                <input type="submit" name="submit"
                                       class="btn btn-primary"
                                       value="{{__('site.save')}}">
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>
@if(isset($row))
<!--renew_banner  Modal -->
<div class="modal fade" id="renew_banner" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تجديد العضويه </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;">
                    <div class="form-body">
                        <form method="POST" action="{{route('renew_banner',$row->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.select_ad')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                            class="SpecificInput"
                                            name="banner_id" style="width:100%;" id="banner_re" required>
                                        <option value="">{{__('site.select')}}</option>
                                        @foreach($banners as $banner)
                                            <option value="{{$banner->id}}">{{$banner->$name2}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.price')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                            class="SpecificInput catChange " name="price" id="price_re" style="width:100%;" id="price" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.show_place')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                            class="SpecificInput catChange " name="place" id="place_re" style="width:100%;" id="place">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display:block">{{__('site.page')}} <small class="text-danger">*</small>
                                    </label>
                                    <select
                                            class="SpecificInput catChange " name="page" id="page_re" style="width:100%;" id="page" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('site.start_date')}}</label>
                                    <input type="date" name="start_date" class="SpecificInput" required>
                                </div>

                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{__('site.close')}}
                                </button>
                                <input type="submit" name="submit"
                                       class="btn btn-primary"
                                       value="{{__('site.save')}}">
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>
<!--edit_banner  Modal -->
<div class="modal fade" id="edit_banner" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل الاعلان </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;">
                    <div class="form-body">
                        <form method="POST" action="{{route('edit-user-banner',$row->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="form-group">
                                    <label>{{__('site.select_country')}}</label>
                                    <select
                                            class="SpecificInput countChange select2"
                                            name="country_id" style="width:100%;">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"
                                            @if ($country->id==$row->country_id) selected @endif>
                                                {{$country->ar_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('site.status')}}</label>
                                    <select class="SpecificInput" name="active" id="">
                                        <option value="0" @if ($row->active==0)selected @endif>مفعل
                                        </option>
                                        <option value="1" @if ($row->active==1)selected @endif>غير مفعل</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('site.link')}}</label>
                                    <input type="text" name="link" value="{{$row->link}}" class="SpecificInput" placeholder="https://www.google.com">
                                </div>
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{__('site.close')}}
                                </button>
                                <input type="submit" name="submit"
                                       class="btn btn-primary"
                                       value="{{__('site.save')}}">
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>
@endif