@extends('dashboard.layout.app')
@section('content')

    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $renew_date=\App\SubscriptionUser::where('user_id',auth()->user()->id)->where('type','1')
        ->orderBy('id','desc')->first();
    $today=date('Y-m-d');
    ?>
    <style>
        .form-body, .form-body2 {
            display: none;
        }


        .modelTablecom thead td:nth-child(2),
        .modelTablecom tbody tr td:nth-child(2) {
            background: #e5f1ff;
            opacity: 1;
            position: absolute;
        }

    </style>
{{--    <marquee style="font-family:Book Antiqua; color: #FFFFFF" scrollamount="5" loop="100" onmouseover="this.stop();" onmouseleave="this.start();" direction="right" height="100%">--}}
{{--        <h5 class="text-danger mt-2 mark-font">--}}
{{--            @if(isset($renew_date))--}}
{{--                @if($renew_date->end_date>$today)--}}
{{--                    {{__('site.will_ended')}} {{$renew_date->end_date}}--}}
{{--                @else {{__('site.ended')}} : {{$renew_date->end_date}}--}}
{{--                @endif--}}
{{--            @endif--}}
{{--        </h5>--}}
{{--    </marquee>--}}
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">

                            @if(auth()->user()->type == 4)
                                <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                    
                                        <h5 style="position: relative; display: inline-block;top: 6px;">
                                            @if(app()->getLocale() == 'ar')
                                                وثائق تأمين ضد الغير
                                            @else
                                                Against Other's Inusrance Documents
                                            @endif
                                        </h5>
                                    </div>
                                      <div>
                                        <a href="{{route('inDocument-Create',app()->getLocale())}}"
                                            class="btn btn-light circle">
                                             <i class="fas fa-plus-circle"></i>
                                         </a>
     
                                         <a href="{{route('insurancerequestsuser')}}"
                                            class="btn btn-light circle">
                                             <i class="fas fa-cart-plus"></i>
                                         </a>
                                      </div>
                                </div>
                                </div>
                            @endif
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        جميع الوثائق
                                    @else
                                        All Documents
                                    @endif
                                </label>

                                <br>

                                <!--why here and there in controller ?/////////////////////////////////////////////-->
                                <?php $countries = \App\country::where(['parent' => 0, 'status' => 1])->get();

                                $insurance = \App\InsuranceDocument::where('user_id', auth()->user()->id)->get();
                                //$insurance_document = \App\InsuranceDocument::where('insurance_id',$insurance->id)->get();
                                ?>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                        <td>تاريخ الانتهاء</td>
                                        <td>
                                            نوع الوثيقة
                                        </td>
                                        <td>
                                            النوع
                                        </td>
                                        <td>
                                            الشروط
                                        </td>
                                        <td>
                                            نوع المركبة
                                        </td>
                                        <td>
                                            الحالة
                                        </td>
                                        <td width="48%">
                                            العمليات
                                        </td>
                                    </thead>
                                    
                                    @foreach($insurance_document  as $document)
                                        <tbody>
                                        <tr>
                                            <td >{{$document->end_date}}</td>
                                            <td>
                                                @if(app()->getLocale() == 'ar')
                                                    تأمين ضد الغير
                                                @else
                                                    Against Foriegn
                                                @endif
                                            </td>
                                            <td>
                                                {{$document->type_of_use}}
                                            </td>
                                            <td>
                                                @if(app()->getLocale() == 'ar')
                                                    {{$document->ar_term}}
                                                @else
                                                    {{$document->en_term}}
                                                @endif

                                            </td>
                                            <td>
                                                {{$document->vehicle->getName()}}
                                            </td>
                                            <td>
                                                @if ($document->status == 1)
                                                <span class="badge badge-success p-1">{{__('site.active')}}</span>
                                                @else
                                                <span class="badge badge-danger p-1">{{__('site.inactive')}}</span>
                                                @endif
                                            </td>


                                            <td width="40%">
                                                <!--//////////////////////check///////////////////////////////-->
                                                <!-- 'ضد الغير' ||' Against Forieg)-->
                                                @if($document->type == '0')
                                                    <a href="{{route('inDocument-edit',$document->id ,app()->getLocale())}}"
                                                       class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
{{--                                                    <a href="{{route('inDocument-Create',app()->getLocale())}}" class="btn btn-success btn-sm">--}}
{{--                                                        <i class="fas fa-sync"></i> تجديد--}}
{{--                                                    </a>--}}
                                                    <a href="{{route('renew_tammeen',[$document->id,1,app()->getLocale()])}}" class="btn btn-success btn-sm">
                                                        <i class="fas fa-sync"></i> تجديد
                                                    </a>
                                                    <a href="{{route('inDocument-delete',$document->id)}}"
                                                       class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash text-white"></i>
                                                    </a>

                                                @else
                                                    <a href="{{route('inDocument-edit',$document->id ,app()->getLocale())}}"
                                                       class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{route('renew_tammeen',[$document->id,1,app()->getLocale()])}}" class="btn btn-success btn-sm">
                                                        <i class="fas fa-sync"></i> تجديد
                                                    </a>
                                                    <a href="{{route('inDocument-addNew',$document->id,$lang)}}"
                                                       class="btn btn-secondary btn-xs">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a href="{{route('inDocument-show-brands',$document->id,$lang)}}"
                                                       class="btn btn-warning btn-xs">
                                                        <i class="fa fa-compass"></i>
                                                    </a>
                                                    <a onclick="return confirm('Are you sure?')"
                                                       href="{{route('cmDocument-delete',$document->id)}}"
                                                       class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash text-white"></i>
                                                    </a>
                                                @endif
{{--                                                <div class="modal fade" id="exampleModal{{$document->id}}" tabindex="-1"--}}
{{--                                                     aria-labelledby="exampleModalLabel{{$document->id}}"--}}
{{--                                                     aria-hidden="true">--}}
{{--                                                    <div class="modal-dialog">--}}
{{--                                                        <div class="modal-content">--}}
{{--                                                            <div class="modal-header">--}}
{{--                                                                @if(app()->getLocale() == 'ar')--}}
{{--                                                                    <h5 class="modal-title" id="exampleModalLabel">تجديد--}}
{{--                                                                        الـتأمين</h5>--}}
{{--                                                                @else--}}
{{--                                                                    <h5 class="modal-title" id="exampleModalLabel">--}}
{{--                                                                        Insurance Renew</h5>--}}
{{--                                                                @endif--}}
{{--                                                                <button type="button" class="close" data-dismiss="modal"--}}
{{--                                                                        aria-label="Close">--}}
{{--                                                                    <span aria-hidden="true">&times;</span>--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="modal-body">--}}

{{--                                                                <input type="hidden" name="id"--}}
{{--                                                                       value="{{$document->id}}">--}}

{{--                                                                <div class="form-row" style="padding-bottom:20px;">--}}
{{--                                                                    @if(app()->getLocale() == 'ar')--}}
{{--                                                                        <label>أختار العضوية</label>--}}
{{--                                                                    @else--}}
{{--                                                                        <label>Choose Membership</label>--}}
{{--                                                                    @endif--}}
{{--                                                                    <?php $memberships = \App\membership::orderBy('cost', 'asc')->get();?>--}}
{{--                                                                    <select class="form-control costs"--}}
{{--                                                                            name="membership">--}}
{{--                                                                        <option disabled selected>--}}
{{--                                                                            @if(app()->getLocale() == 'ar')--}}
{{--                                                                                أختر العضوية المناسبة--}}
{{--                                                                            @else--}}
{{--                                                                                Choose Member Ship--}}
{{--                                                                            @endif--}}
{{--                                                                        </option>--}}
{{--                                                                        @foreach($memberships as $membership)--}}
{{--                                                                            <option--}}
{{--                                                                                value="{{$membership->id}}_{{$membership->cost}}">{{$membership->name}}</option>--}}
{{--                                                                        @endforeach--}}
{{--                                                                    </select>--}}
{{--                                                                </div>--}}
{{--                                                                <div--}}
{{--                                                                    id="paypal-button-container{{$document->id}}"></div>--}}
{{--                                                                <script>--}}
{{--                                                                    var cost = 0;--}}
{{--                                                                    $(document).ready(function () {--}}
{{--                                                                        $('.costs').change(function () {--}}
{{--                                                                            var str = $(this).val();--}}
{{--                                                                            var res = str.split("_");--}}
{{--                                                                            cost = res[1];--}}
{{--                                                                        });--}}
{{--                                                                    });--}}

{{--                                                                    paypal.Buttons({--}}
{{--                                                                        createOrder: function (data, actions) {--}}
{{--                                                                            // This function sets up the details of the transaction, including the amount and line item details.--}}
{{--                                                                            return actions.order.create({--}}
{{--                                                                                purchase_units: [{--}}
{{--                                                                                    amount: {--}}
{{--                                                                                        value: cost--}}
{{--                                                                                    }--}}
{{--                                                                                }]--}}
{{--                                                                            });--}}
{{--                                                                        },--}}
{{--                                                                        onApprove: function (data, actions) {--}}
{{--                                                                            // This function captures the funds from the transaction.--}}
{{--                                                                            return actions.order.capture().then(function (details) {--}}

{{--                                                                                //window.location.href = "{{url('/')}}/join/to/membershib/{{$membership->id}}/{{app()->getLocale()}}";--}}
{{--                                                                                var data = [];--}}
{{--                                                                            });--}}
{{--                                                                        }--}}
{{--                                                                    }).render('#paypal-button-container{{$membership->id}}');--}}
{{--                                                                    //This function displays Smart Payment Buttons on your web page.--}}
{{--                                                                </script>--}}
{{--                                                            </div>--}}
{{--                                                            @if(app()->getLocale() == 'en')--}}
{{--                                                                <div class="modal-footer">--}}
{{--                                                                    <button type="button" class="btn btn-secondary"--}}
{{--                                                                            data-dismiss="modal">Close--}}
{{--                                                                    </button>--}}

{{--                                                                </div>--}}
{{--                                                            @else--}}
{{--                                                                <div class="modal-footer">--}}
{{--                                                                    <button type="button" class="btn btn-secondary"--}}
{{--                                                                            data-dismiss="modal">إغلاق--}}
{{--                                                                    </button>--}}

{{--                                                                </div>--}}
{{--                                                            @endif--}}

{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                            </td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <!--------- Branches  Edit Modal !---------->


                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!--</div>-->




    <script>
        // $(document).ready(function(){
        //     $('.brandChange').change(function(){
        //       $.ajax({
        //           url: "{{url('/')}}/view/childerns/"+$(this).val(),
        //           context: document.body
        //         }).done(function(data) {
        //             $('.modelChange').find('option').remove().end();
        //             $.each(data,function(i,item){
        //                 $(".modelTable tbody").append('<tr><td><input type="checkbox" name="model_id[]" value="'+item.id+'" /></td><td>'+item.name+'</td><td><input type="text" name="prices[]"></td></tr>');
        //               // $('.modelChange').append('<option value="'+item.id+'">'+item.name+'</optin>')
        //             });

        //         });
        //     });
        // });
    </script>

    <script>
        $(document).ready(function () {
            $('.brandChangeedit').change(function () {
                $.ajax({
                    url: "{{url('/')}}/view/childerns/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    $('.modelChangeedit').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.modelChangeedit').append('<option value="' + item.id + '">' + item.name + '</optin>')
                    });

                });
            });
        });
    </script>


    <script>
        // function OnScroll(div) {
        // var div1 = document.getElementById("col1");
        // // alert(div.scrollLeft);
        // // div1.scrollLeft = div.scrollLeft;
        //     div1.scrollLeft(50);

        // }

        //     $(document).ready(function() {
        //   $(table.modelTablecom tr).on('scroll', function() {
        //     $(.modelTablecom thead).scrollLeft($(this).scrollLeft());
        //   });
        // });

        // var $table = $('table.modelTablecom');
        // $table.floatThead({
        //     scrollContainer: function ($table) {
        //         return $table.closest('.table-scroll');
        //     }
        // });


    </script>

    <script>
        $('.type').change(function () {
            if ($(this).val() == '0') {
                $('.form-body').slideDown();
            } else {
                $('.form-body').slideUp();
            }
        });
        $('.type').change(function () {
            if ($(this).val() == '1') {
                $('.form-body2').slideDown();
            } else {
                $('.form-body2').slideUp();
            }
        });
    </script>
    <!--//////////////////////sondos////////////////////-->
    <script>
        var var1 = 0;
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '{{url("/all/brands/models")}}',
            success: function (rData) {

                $(".btn-new").on('click', function () {
                    var1++;
                    $("#cmbrandtable").append('<tr ><td>' + '<select id="mySelect' + var1 + '" class="SpecificInput brandChangecom select2" name="brand_id[]" style="width:150px;"></select></td><td><select id="modelChangetwo' + var1 + '" class="SpecificInput modelChangetwo select2" name="model_id[]" style="width:150px;"></select></td></tr><tr><td><input type="number" name="year[]" from="1980" to="2025" placeholder="e.g 2008"></td><td><input type="number" name="inmethodfrom[]"></td><td><input type="number" name="inmethodto[]"></td><td><input type="number" name="percentage[]"></td><td><input type="number" name="fileprice[]"></td><td><input type="number" name="minimum[]"></td></tr>');

                    $.each(rData, function (i, brand) {
                        //  .attr("brand", i)
                        $('#mySelect' + var1).append($('<option></option>').val(brand.id).text(brand.name));

                    });
                    $('#mySelect' + var1).change(function () {

                        var id = $(this).attr('id');
                        var idsliced = id.slice(8);
                        $.ajax({
                            url: "{{url('/')}}/view/childerns/" + $(this).val(),
                            context: document.body
                        }).done(function (data) {
                            $('#modelChangetwo' + idsliced).find('option').remove().end();
                            $.each(data, function (i, item) {
                                $('#modelChangetwo' + idsliced).append('<option value="' + item.id + '">' + item.name + '</option>')
                            });
                        });

                    });
                    $('.select2').select2();
                });
            }
        });


    </script>
    <script>
        var var2 = 0;
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '{{url("/all/brands/models")}}',
            success: function (rData) {

                $(".inbtn-new").on('click', function () {
                    var2++;

                    $("#inbrandtable tbody").append('<tr><td>' + '<select id="inmySelect' + var2 + '" class="SpecificInput brandChangein select2" name="brand_id[]" style="width:150px;"></select></td><td><select id="modelChangein' + var2 + '" class="SpecificInput modelChangein select2" name="model_id[]" style="width:150px;"></select></td><td><select  name="type_of_use[]" >' +
                        @if(app()->getLocale() == 'ar')  '<option value="private" >خاص</option><option value="rent"> أجرة</option>'
                    @else  '<option value="private">private</option><option value="rent">rent</option>' @endif


                    + '</select></td><td><input type="number" name="price[]"></td><td><input type="number" name="firstinterval[]"></td><td><input type="number" name="secondinterval[]"></td><td><input type="number" name="thirdinterval[]"></td></tr>'
                )
                    ;

                    $.each(rData, function (i, brand) {
                        //  .attr("brand", i)
                        $('#inmySelect' + var2).append($('<option></option>').val(brand.id).text(brand.name));

                    });
                    $('#inmySelect' + var2).change(function () {

                        var id1 = $(this).attr('id');
                        var idsliced1 = id1.slice(10);
                        $.ajax({
                            url: "{{url('/')}}/view/childerns/" + $(this).val(),
                            context: document.body
                        }).done(function (data) {
                            $('#modelChangein' + idsliced1).find('option').remove().end();
                            $.each(data, function (i, item) {
                                $('#modelChangein' + idsliced1).append('<option value="' + item.id + '">' + item.name + '</option>')
                            });
                        });

                    });

                    $('.select2').select2();
                });
            }
        });


    </script>
    <!--////////////////////////////////////-->
    <script>
        // $(document).ready(function(){
        //     $('.brandChangecom').change(function(){
        //       $.ajax({
        //           url: "{{url('/')}}/view/childerns/"+$(this).val(),
        //           context: document.body
        //         }).done(function(data) {
        //             $('.modelChangecom').find('option').remove().end();
        //             $.each(data,function(i,item){
        //                 $(".modelTablecom tbody").append('<tr><td><input type="checkbox" name="model_id[]" value="'+item.id+'" /></td><td>'+item.name+'</td><td><input type="number" name="year[]" from="1980" to="2025" placeholder="e.g 2008"></td><td><input type="number" name="inmethodfrom[]"></td><td><input type="number" name="inmethodto[]"></td><td><input type="number" name="percentage[]"></td><td><input type="number" name="fileprice[]"></td><td><input type="number" name="minimum[]"></td></tr>');

        //             });

        //         });
        //     });
        // });
    </script>



    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script > tinymce.init({selector: 'textarea'});</script>


@endsection

