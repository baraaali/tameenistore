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
            <h4 class="card-title">{{__('site.maintenance requests')}}</h4>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">

                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">
                                    {{__('site.maintenance requests')}}
                                </h5>
                              
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                @if (!count($mc_requests))
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        لايوجد  طلبات 
                                    @else
                                        no requests
                                    @endif
                                </label>
                                <br>
                                @else
                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                       <tr>
                                           <th>{{__('site.user name')}}</th>
                                           <th>{{__('site.services')}}</th>
                                           <th>{{__('site.additional services')}}</th>
                                           <th>{{__('site.delivery to')}}</th>
                                           <th>{{__('site.delivery day')}}</th>
                                           <th>{{__('site.delivery time')}}</th>
                                           <th>{{__('site.price')}}</th>
                                           <th>{{__('site.status')}}</th>
                                           @if (auth()->user()->type == 5)
                                           <th>{{__('site.change status')}}</th>
                                           @endif
                                       </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mc_requests as $request)
                                        <tr>
                                           <td>{{$request->user->name}}</td>
                                           <td> 
                                               <ul>
                                                   @foreach ($request->services() as $i => $service)
                                                     <ol>  {{($i + 1).' - '.$service->getName()}}</ol>
                                                   @endforeach
                                               </ul>
                                            </td>    
                                            <td> 
                                                <ul>
                                                    @foreach ($request->additionalServices() as $i => $service)
                                                      <ol>  {{($i + 1).' - '.$service->getName()}}</ol>
                                                    @endforeach
                                                </ul>
                                             </td> 
                                            <td>{{__('site.'.$request->delivery_to)}}</td>
                                            <td>{{$request->delivery_day}}</td>
                                            <td>{{$request->time() }}</td>
                                            <td>{{$request->price }}</td>
                                            <td>
                                                <div class="
                                                @if ($request->status == 'approved')
                                                text-success
                                                @elseif($request->status == 'rejected' || $request->status == 'canceled')
                                                text-danger
                                                @endif
                                                ">
                                                {{__("site.".$request->status )}}
                                            </div>
                                            </td>
                                            @if (auth()->user()->type == 5)
                                            <td> 
                                                  <select  value="{{$request->status}}" _id="{{$request->id}}" id="change_status">
                                                    <option @if($request->status == 'in review') selected @endif value="in review">{{__('site.in review')}}</option>
                                                    <option @if($request->status == 'approved') selected @endif value="approved">{{__('site.approved')}}</option>
                                                    <option @if($request->status == 'finished') selected @endif value="finished">{{__('site.finished')}}</option>
                                                    <option @if($request->status == 'rejected') selected @endif value="rejected">{{__('site.rejected')}}</option>
                                                    <option @if($request->status == 'canceled') selected @endif value="canceled">{{__('site.canceled')}}</option>
                                                  </select>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        {{$mc_requests->links()}}
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

@endsection
@section('js')
<script>
    var init = function()
    {
        $('#change_status').on('change',function(){
            var status = $(this).val()
            var id = $(this).attr('_id')
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                type: "post",
                data: {status:status,id:id},
                dataType: "json",
                url: "{{route('change-status-mcenter-requests')}}",
                success: function(res){
                    if(res)
                    window.location.reload()
                }
            })
        })
    }
    $(document).ready(init)
</script>
@endsection

