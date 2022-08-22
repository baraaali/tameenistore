@extends('Cdashboard.layout.app')
@section('controlPanel')
    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    $name = app()->getLocale() == 'ar' ? 'ar_name' : 'fr_name'
    ?>


    @if(app()->getLocale() == 'ar')

        <style>
            .form-group {
                direction: rtl;
                text-align: right !important;
            }
            .font_20{
               font-size: 20px;
            }
        </style>

    @else
        <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
            .font_20{
                font-size: 20px;
            }
        </style>
    @endif
@include('dashboard.layout.message')
    <div class="col-lg-12" style="background-image: url({{asset('/bg.jpg')}})">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{__('site.maintenance services')}}</h4>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">

                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">
                                    {{__('site.maintenance services')}}
                                </h5>
                               <a   data-toggle="modal" data-target="#add-new" class="btn bg-white text-dark circle">
                                    <i class="fas fa-plus-circle"></i>
                                    {{__('site.add_new')}}
                                </a>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                @if (empty($services))
                                <label style="display: block">
                                    {{__('site.no services')}}
                                </label>
                                <br>
                                @else
                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                       <tr>
                                           <th>{{__('site.name')}}</th>
                                           <th>{{__('site.vehicle type')}}</th>
                                           <th>{{__('site.description')}}</th>
                                           <th>{{__('site.price')}}</th>
                                           <th>{{__('site.additional services')}}</th>
                                           <th>{{__('site.status')}}</th>
                                           <th>{{__('site.actions')}}</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                        <tr>
                                            <td>{{$service->getName()}}</td>
                                            <td>{{$service->vehicle->getName()}}</td>
                                            <td>{{$service->getDescription()}}</td>
                                            <td>{{$service->price}}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($service->addtionalServices as $item)
                                                     <ol>{{$item->getName()}}</ol>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @if ($service->status == "1")
                                                    <span class="badge badge-success">{{__('site.active')}}</span>
                                                    @else
                                                    <span class="badge badge-danger">{{__('site.deactive')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" _id="{{$service->id}}" class="btn btn-primary edit">{{__('site.edit')}}</button>
                                                <button type="button" _id="{{$service->id}}"  class="btn btn-danger delete">{{__('site.delete')}}</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{$services->links()}}
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

          </div>
        </div>
    </div>

   @include('Cdashboard.modals.new-mcenter-service')
   <div class="data-edit"></div>

@endsection
@section('js')
    <script>
        var  loadEditModal = function()
        {
        var id = $(this).attr('_id')
        $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/cp/mcenter-services/show/"+id,
					type:'get',
					success : function(res){
						$('.data-edit').html(res)
                        console.log(res);
                        $('.load-edit-modal').trigger('click')
					}
				})
        }
        var deleteItem = function()
        {
            var id = $(this).attr('_id')
           if(confirm("{{__('site.are you sur ?')}}"))
           $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/cp/mcenter-services/delete/"+id,
					type:'delete',
					success : function(res){
						window.location.reload()
					}
				})

        }
        $(document).ready(function(){
            $('.edit').on('click',loadEditModal)
            $('.delete').on('click',deleteItem)
        })
    </script>
@endsection

