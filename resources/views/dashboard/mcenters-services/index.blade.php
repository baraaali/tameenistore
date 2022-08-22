@extends('dashboard.layout.app')
@section('content')

<div class="card mt-5">
 <div class="card-header bg-primary text-white">
        <h5 style="position: relative; display: inline-block;top: 6px;">
            {{__('site.maintenance services')}} 
        </h5>
     
       <a data-toggle="modal" data-target="#add-new"  class="btn btn-light text-dark"  style="float: left;margin-right:10px;" >
            <i class="fas fa-plus-circle"></i>
        </a>
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                     aria-labelledby="v-pills-profile-tab">
                           @include('dashboard.mcenters-services.table')
                </div>
            </div>
        </div>
    </div>
</div>

</div>


    
@include('dashboard.modals.new-mcenter-service')
<div class="data-edit"></div>

@endsection
@section('js')
<script>
    var csrf =  $('meta[name="csrf-token"]').attr('content');

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
                    $('#mcenter_vehicle_id').trigger('change')
                
                },
                error:function($e){
                    console.log($e)
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


