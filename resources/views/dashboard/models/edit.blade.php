<div class="modal fade" id="edit{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">تعديل</h5>
           </div>
           <form class="form" method="post" action="{{route('models.update',$model->id)}}">
               @csrf
               {{ method_field('put') }}
               <input type="hidden" name="id" value="{{$model->id}}">
               <div class="modal-body">
                   <div class="form-group">
                       <label>
                           الاسم بالعربية
                       </label>
                       <input type="text" value="{{$model->name}}" name="name" class="SpecificInput"
                              required="required">
                   </div>

                   <div class="form-group">
                       <label for="category_id">الماركة *</label>
                       <div class="input-group">
                           <select class="SpecificInput select2" id="select2" name="brand_id">
                               @foreach($brands as $br)
                                   <option
                                       value="{{ $br->id }}" @if($model->brand_id == $br->id) {{ 'selected' }} @endif  @if(old('brand_id') == $br->id) {{ 'selected' }} @endif>{{ $br->name }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="category_id">شكل السيارة *</label>
                       <div class="input-group">
                           <select class="SpecificInput select2" id="select2" name="care_shape_id">
                               @foreach($careshapes as $careshape)
                                   <option
                                       value="{{ $careshape->id }}" @if($model->care_shape_id == $careshape->id) {{ 'selected' }} @endif  @if(old('care_shape_id') == $careshape->id) {{ 'selected' }} @endif>{{ $careshape->ar_name .'-'.$careshape->en_name  }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                       <div class="form-group">
                         <label for="passengers">عدد الركاب</label>
                         <input type="number" value="{{$model->passengers}}" class="form-control" name="passengers" id="passengers" >
                       </div>
                   <div class="form-group">
                       <label for="status">تفعيل</label>
                       <input type="checkbox" name="status"   @if($model->status == "1") {{ 'checked' }} @endif >
                   </div>

                   <div class="modal-footer">

                       <button type="submit" class="btn btn-primary">حفظ</button>
                       <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                   </div>
               </div>
           </form>
       </div>
   </div>
</div>
