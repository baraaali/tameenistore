<table class="table table-stroped table-responsive table-straped text-center ">
    <thead class="bg-light ">
        <td>
            #
        </td>
        <td>
            {{__('site.name')}}
        </td>
        <td>
            {{__('site.show')}}
        </td>
        <td>{{__('site.delete')}}</td>
    </thead>

    <tbody>
        @foreach($items  as $key=>$book)
        <tbody>
        <tr>
            <td>
                {{$key+1}}
            </td>
            <td>
                {{$book->name}}
            </td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#show-order">
                    {{__('site.show')}}
                </button>
            </td>
            <td>
                <a onclick="return confirm('Are you sure?')" href="{{route('order-delete',$book->id)}}"
                   class="btn btn-danger">
                    <i class="fa fa-trash text-white"></i>
                </a>
            </td>

        </tr>

        </tbody>
    @endforeach

    </tbody>
</table>
      {{$items->links()}}


      @if(count($items)>0)
    
    <!-- Modal -->
    <div class="modal fade" id="show-order" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">{{__('site.order-show')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <label for="inputAddress2">{{__('site.car_name')}} :</label>
                            <span class="text-danger text-center">{{$book->cars->getName()}}</span>           
                       </div>

                       <div class="form-group col-md-12">
                          <label>{{__('site.name')}} : </label>
                          <span class="text-danger text-center">{{$book->name}}</span>
                      </div>
                      <div class="form-group col-md-6">
                          <label>{{__('site.booking_date')}} {{__('site.from')}} : </label>
                          <span class="text-danger text-center">{{$book->from_date}}</span>
                      </div>
                      <div class="form-group col-md-6">
                          <label>{{__('site.to')}} :</label>
                          <span class="text-danger text-center">{{$book->to_date}}</span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="inputAddress2">{{__('site.address')}}:</label>
                          <span class="text-danger text-center">{{$book->address}}</span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="inputAddress2">{{__('site.phone')}} :</label>
                          <span class="text-danger text-center">{{$book->phone}}</span>    
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                </div>
            </div>
        </div>
    </div>

  @endif