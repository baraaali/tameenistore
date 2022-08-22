

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('cities-update')}}" method="post">
            @csrf
		<input type="hidden" name="id" value="{{$city->id}}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">تعديل</h5>
            </div>
            <div class="modal-body">
                    <div  class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="governorate_id">المنطقة أو الجهة</label>
                              <select value="{{$city->governorate_id}}" class="form-control select2" name="governorate_id" id="governorate_id"> 

                                <option value="0" selected>
                                    دولة 
                                </option>
                                @foreach($governorates as $governorate)
                                    <option value="{{$governorate->id}}">
                                        {{$governorate->ar_name}} - {{$governorate->en_name}}
                                    </option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                   الاسم بالعربية <small class="text-danger">*</small>
                                </label>
                                <input value="{{$city->ar_name}}" type="text" name="ar_name"  class="SpecificInput ar_name" required="required" max="191">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    الإسم بالإنجليزية 
                                </label>
                                <input value="{{$city->en_name}}" type="text" name="en_name"  placeholder=" الإسم بالإنجليزية " class="SpecificInput en_name"  max="191">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block text-right">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                </div>
            </div>
        </form>
    </div>
</div>


    
