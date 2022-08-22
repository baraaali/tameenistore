@isset($car)
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('site.send_booking_request')}}
                    @auth
                        @else
                    <span class="btn btn-xs text-danger">{{__('site.register_first')}}</span></h5>
                @endauth
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('booking')}}" method="post">
                    @csrf
                    <input type="hidden" name="car_id" value="{{$car->id}}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>{{__('site.name')}}</label>
                            <input type="text" name="name"  class="form-control form-control-lg" placeholder=" {{__('site.name')}}" style="border-color: #007EE4;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('site.booking_date')}} {{__('site.from')}} : </label>
                            <input type="date" name="from_date" class="form-control form-control-lg" required style="border-color: #007EE4;" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('site.to')}} </label>
                            <input type="date" name="to_date" class="form-control form-control-lg" style="border-color: #007EE4;" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress2">{{__('site.address')}}</label>
                            <input type="text" name="address" class="form-control form-control-lg" placeholder="{{__('site.address_details')}}" style="border-color: #007EE4;" >
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress2">{{__('site.phone')}}</label>
                            <input type="number" name="phone" class="form-control form-control-lg" placeholder=" {{__('site.phone')}}" style="border-color: #007EE4;" required>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('site.send')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endisset
