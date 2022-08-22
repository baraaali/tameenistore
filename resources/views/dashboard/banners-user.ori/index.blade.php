@extends('dashboard.layout.app')
@section('content')

<div class="card mt-5">
 <div class="card-header bg-primary text-white">
        <h5 style="position: relative; display: inline-block;top: 6px;">
            {{__('site.banners_ads')}}
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
                           @include('dashboard.banners-user.table')
                </div>
            </div>
        </div>
    </div>
</div>

</div>


@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#banner').change(function () {
            var item=$(this).val();
            if(item){
                $.ajax({
                    type:"GET",
                    url:"{{url('dashboard/banners/get-info')}}"+"/"+item+"/"+"{{$lang}}",
                    success:function(res){
                        if(res){
                            $("#price").empty();
                            $("#place").empty();
                            $("#page").empty();
                            var type=res['type'];
                        $("#price").append('<option value="'+res['price']+'">'+res['price']+'</option>');
                        $("#place").append('<option value="'+res['type']+'">'+res['type_trans']+'</option>');
                        $("#page").append('<option value="'+res['page']+'">'+res['page_trans']+'</option>');
                        }else{
                            console.log(res)
                            $("#price").empty();
                            $("#place").empty();
                            $("#page").empty();
                        }
                    }
                });}
        });
    });

    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    $(document).ready(function () {
        $('#banner_re').change(function () {

            var item=$(this).val();
            if(item){
                $.ajax({
                    type:"GET",
                    url:"{{url('dashboard/banners/get-info')}}"+"/"+item+"/"+"{{$lang}}",
                    success:function(res){
                        if(res){
                            $("#price_re").empty();
                            $("#place_re").empty();
                            $("#page_re").empty();
                            var type=res['type'];
                            $("#price_re").append('<option value="'+res['price']+'">'+res['price']+'</option>');
                            $("#place_re").append('<option value="'+res['type']+'">'+res['type_trans']+'</option>');
                            $("#page_re").append('<option value="'+res['page']+'">'+res['page_trans']+'</option>');
                        }else{
                            console.log(res)
                            $("#price_re").empty();
                            $("#place_re").empty();
                            $("#page_re").empty();
                        }
                    }
                });}
        });
    });
</script>
@endsection


