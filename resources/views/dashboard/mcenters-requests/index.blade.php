@extends('dashboard.layout.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/star-rating-svg.css')}}">
<script type="text/javascript" src="{{asset('js/star-rating-svg.js')}}"></script>
@endsection
@section('content')

<div class="card mt-5">
 <div class="card-header bg-primary text-white">
        <h5 style="position: relative; display: inline-block;top: 6px;">
            {{__('site.maintenance requests')}}     
           </h5>
     
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                     aria-labelledby="v-pills-profile-tab">
                          <div class="filter my-4">
                              <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select value="" class="form-control select2" name="user_id" id="user_id"> 
                                            <option value="" selected >{{__('site.user name')}}</option>
                                            @foreach($users as $user)
                                              <option value="{{$user->id}}">
                                                  {{$user->name}}
                                              </option>
                                          @endforeach
                                        </select>
                                     </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                        <select value="" class="form-control select2" name="service_id" id="service_id"> 
                                            <option value="" selected >{{__('site.service')}}</option>
                                            @foreach($mcenter_services as $service)
                                              <option value="{{$service->id}}">
                                                  {{$service->getName()}}
                                              </option>
                                          @endforeach
                                        </select>
                                     </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select value="" class="form-control select2" name="status" id="status"> 
                                            <option value="" selected >{{__('site.status')}}</option>
                                            <option value="in review"  > {{__('site.in review')}} </option>
                                            <option value="approved"  >  {{__('site.approved')}} </option>
                                            <option value="rejected"  >  {{__('site.rejected')}} </option>
                                            <option value="canceled"  >   {{__('site.canceled')}} </option>
                                            <option value="finished"  >  {{__('site.finished')}} </option>
                                        </select>
                                     </div>
                                </div>
                              </div>
                          </div>
                          <div class="data-table">
                            @include('dashboard.mcenters-requests.table')
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
    var csrf =  $('meta[name="csrf-token"]').attr('content');
    let maintenance_request_id = 0;
   function openModal(){
       $('.open-modal').on('click',function(){
        maintenance_request_id = $(this).attr('data-request-id');
        $("#maintenance_request_id").val(maintenance_request_id); 
        $('#rate-modal').modal('show');  
        })
   }
 
    function saveRating()
    {
        $('#save-rating').on('click',function(){
            $('#rate-form').submit()
        })
    }
    var init = function()
    {
        saveRating();
        openModal();
        $(document).on('change','.change_status',function(){
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
                },
                error:function(e){
                    console.log(e)
                }
            })
        })

        // set rate
        $(".rating").starRating({
        initialRating: 0,
        strokeColor: '#894A00',
        strokeWidth: 10,
        starSize: 25,
        useFullStars:true,
        callback: function(currentRating, $el){
        const data = $($el).attr('data-key');
        $('#'+data).val(currentRating)
       }
        })
        // rating function
        const $ratingResults = $('.rating-results');
        $ratingResults.each(function(i,$e){
            const rating = $($e).attr('data-results');
            if(rating != undefined)
            {
                $($e).starRating({
                    readOnly: true,
                    initialRating: parseInt(rating),
                    strokeColor: '#894A00',
                    strokeWidth: 10,
                    starSize: 25,
                    useFullStars:true
            })
            $($e).children('button').hide()

            }

        })

        // filters
        const search = {};
        $('.filter select').on('change',function(){
            search[$(this).attr('name')] = $(this).val();
            console.log(search);
            $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/cp/mcenter-requests",
					type:'post',
                    data:search,
					success : function(res){
						$('.data-table').html(res)
					}
			})
        })
       
    }

    const deleteRequest = function(id){
           if(confirm("{{__('site.are you sur ?')}}"))
           $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/cp/mcenter-requests/"+id,
					type:'delete',
					success : function(res){
						window.location.reload()
					}
				})
        
    }
    $(document).ready(init)
</script>
@endsection


