

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('governorates-update')}}" method="post">
            @csrf
		<input type="hidden" name="id" value="{{$governorate->id}}">
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
                              <label for="country_id">دولة</label>
                              <select value="{{$governorate->country_id}}" class="form-control select2" name="country_id" id="country_id"> 

                                <option value="0" selected>
                                    دولة 
                                </option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">
                                        {{$country->ar_name}} - {{$country->en_name}}
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
                                <input value="{{$governorate->ar_name}}" type="text" name="ar_name"  class="SpecificInput ar_name" required="required" max="191">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    الإسم بالإنجليزية 
                                </label>
                                <input value="{{$governorate->en_name}}" type="text" name="en_name"  placeholder=" الإسم بالإنجليزية " class="SpecificInput en_name"  max="191">
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


    
