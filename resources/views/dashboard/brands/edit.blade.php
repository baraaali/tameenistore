<div class="modal fade" id="edit{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل  </h5>
            </div>
            <form class="form" method="post" action="{{route('brands.update',$brand->id)}}">
                @csrf
                {{ method_field('put') }}
                <input type="hidden" name="id" value="{{$brand->id}}">
                <div class="modal-body">
                <div class="form-group">
                    <label for="vehicle_id"> نوع العربة </label>
                    <select value="{{$brand->vehicle_id}}" class="form-control select2" name="vehicle_id"> 
                      @foreach($vehicles as $vehicle)
                          <option value="{{$vehicle->id}}">
                              {{$vehicle->ar_name}} - {{$vehicle->en_name}}
                          </option>
                      @endforeach
                    </select>
                 </div>
                    <div class="form-group">
                        <label>
                            الاسم بالعربية
                        </label>
                        <input type="text" value="{{$brand->name}}" name="name" class="SpecificInput" required="required">
                    </div>
                    <div class="form-group">
                        <label>
                            بلد الصنع 
                        </label>
                        <input type="text" value="{{$brand->manufacturing_country}}" name="manufacturing_country" class="SpecificInput">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" {{$brand->status == 1 ? 'checked' : ''}} name="status" value="1">
                        <label>
                            نشر ؟
                        </label>

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>