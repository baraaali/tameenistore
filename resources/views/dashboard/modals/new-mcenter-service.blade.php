
<button type="button" class="d-none load-edit-modal"  data-toggle="modal" data-target="#edit-modal"></button>

<div class="modal fade " id="{{isset($service_edit)? "edit-modal" : "add-new" }}">
    <div class="modal-dialog" role="document">
        <form action="{{route('create-mcenter-service')}}" method="post">
            @csrf
        <input type="hidden" name="id" value="{{isset($service_edit) ? $service_edit->id : ''}}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">{{__('site.add new service')}}</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ar_name">{{__('site.ar name')}}</label>
                                <input required type="text" name="ar_name" id="ar_name" value="{{isset($service_edit) ? $service_edit->ar_name : ''}}" class="form-control" placeholder="{{__('site.ar name')}}">
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="en_name">{{__('site.en name')}}</label>
                                <input required type="text" name="en_name" id="en_name" value="{{isset($service_edit) ? $service_edit->en_name : ''}}" class="form-control" placeholder="{{__('site.en name')}}">
                              </div>
                        </div>
                    </div>
                   <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                            <label for="vehicle">{{__('site.vehicle type')}}</label>
                            <select class="form-control select2" value="{{isset($service_edit) ? $service_edit->mcenter_vehicle_id : ''}}"  name="mcenter_vehicle_id" id="mcenter_vehicle_id">
                            <option value="" >{{__('site.choose')}}</option>
                             @foreach ($vehicles as $vehicle)
                             <option @if(isset($service_edit) && $service_edit->mcenter_vehicle_id == $vehicle->id) selected @endif value="{{$vehicle->id}}" >{{$vehicle->getName()}}</option>
                             @endforeach
                            </select>
                          </div>
                       </div>
                   </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price">{{__('site.price')}}</label>
                                <input required type="number" step="0.01" name="price" id="price" value="{{isset($service_edit) ? $service_edit->price : ''}}" class="form-control" placeholder="{{__('site.price')}}">
                              </div>
                        </div>
                    </div>
                    <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="ar_description">{{__('site.ar description')}}</label>
                            <textarea required class="form-control" name="ar_description" id="ar_description" rows="3">{{isset($service_edit) ? $service_edit->ar_description : ''}}</textarea>
                          </div>
                     </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                            <label for="en_description">{{__('site.en description')}}</label>
                            <textarea required class="form-control" name="en_description" id="en_description" rows="3">{{isset($service_edit) ? $service_edit->en_description : ''}}</textarea>
                          </div>
                       </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{isset($service_edit) && $service_edit->status == 1 ? 'checked' : ''}}>   {{__('site.active')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('site.save')}}</button>
            </div>
        </div>
    </form>
    </div>
</div>