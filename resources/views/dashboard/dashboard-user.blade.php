@extends('dashboard.layout.app')

@section('css')
    <style>
        .add-balance{
            border-radius: 0;
        }
    </style>
@endsection

@section('content')

<div class="container">

    <div class="col-md-12">
        <div class="row">
            @if(auth()->user()->type == 5 && is_null(auth()->user()->mcenter))
            <div class="alert alert-danger w-100" role="alert">
                <strong>حسابك غير مفعل المرجوا ملئ <a href="{{route('account-info')}}"> بيانات المركز</a></strong>
            </div>
           @endif
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="bg-white border p-3 text-center">
                    <h5 class="text-success">الرصيد</h5>
                    <p>
                        <strong class="py-2">
                        {{number_format($balance,2)}}
                         دولار
                    </strong>
                    </p>
                </div>
                <button  data-toggle="modal" data-target="#add_balance_modal"  class="btn add-balance w-100 bg-primary text-white pointer text-center p-2">
                    شحن الرصيد
                </button>
            </div>
            <div class="col-md-3">
                <div class="bg-white border p-3 text-center">
                    <h5 class="text-success">رصيد الإشعارات</h5>
                    <p>
                        <strong class="py-2">
                        {{auth()->user()->notifications_balance}}
                        إشعار
                    </strong>
                    </p>
                </div>
                <button type="button" class="btn add-balance btn-primary text-white pointer w-100 p-2"  data-toggle="modal" data-target="#addNotficationsBalanceID">{{__('site.add balance')}}</button>
            </div>
            @if(auth()->user()->type == 5 && !is_null(auth()->user()->mcenter))
            <div class="col-md-3">
                <div class="bg-white border p-3 text-center">
                    <h5 class="text-success"> تاريخ تجديد العضوية   </h5>
                    <p class="p-0">
                        <strong class="py-2">
                        {{auth()->user()->mcenter->renewal_at}}
                    </strong>
                    @if (date(auth()->user()->mcenter->renewal_at) < date('Y-m-d'))
                    <strong class="mx-2 text-danger">(منتهي)</strong>
                @endif
                    </p>
                   
                </div>
                <button type="button" class="btn add-balance btn-primary text-white pointer w-100 p-2"  data-toggle="modal" data-target="#renew-memebership">{{__('site.renew')}}</button>
            </div>
            @endif

        </div>
    </div>
    <!-- renew membership mcenter -->
    <div class="modal fade" id="renew-memebership" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="renew-memebership_form" action="{{ route('renew-memebership-mcenter') }}" method="post">
            @csrf
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">تجديد عضوية</h5>
                </div>
                <div class="modal-body">
                    @isset(auth()->user()->mcenter->serviceMemberShip)
                    <div class="border">
                    <label class="m-3">
                        إسم العضوية : 
                        <strong class="mx-2">{{auth()->user()->mcenter->serviceMemberShip->getName()}}</strong>
                    </label>
                    <label class="m-3">
                        الحالة :
                        @if (date(auth()->user()->mcenter->renewal_at) < date('Y-m-d'))
                            <strong class="mx-2 text-danger">منتهي</strong>
                            @else
                            <strong class=" mx-2 text-success">جاري</strong>
                        @endif
                    </label>
                </div>
                    @endisset
                         <div class="form-group mt-4">
                             <label>
                                 <input type="checkbox" >
                                 تأكيد العملية
                             </label>
                         </div>
                        </div>
                        <div class="modal-footer direction">
                            <button  disabled type="submit" class="btn btn-primary w-100">تجديد</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <!-- Modal add balance -->
    <div class="modal fade" id="add_balance_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="add_balance_form" action="{{ route('payMoney') }}" method="post">
            @csrf
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">إضافة رصيد</h5>
                </div>
                <div class="modal-body">
                         <div class="form-group">
                           <input type="number" name="amount"  class="form-control" placeholder="أضف مبلغ الشحن" aria-describedby="helpId" required>
                         </div>
                        </div>
                        <div class="modal-footer direction">
                            <button  type="submit" class="btn btn-primary w-100">دفع</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

       {{-- add Notfications Balance  Modal--}}
       <div class="modal fade" id="addNotficationsBalanceID" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">{{__('site.add balance')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="package">{{__('site.notifications package')}}</label>
                      <select class="form-control" name="package" id="package">
                        <option value="">-- {{__('site.choose')}} -- </option>
                        @foreach ($packages as $item)
                        <option price="{{$item->price}}" value="{{$item->id}}"> {{$item->getName()}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="my-2 text-danger discount_price">
                       {!!__('site.deducted from your account') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary d-block text-right submit-balance">{{__('site.submit charge')}}</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
 <script>
  var csrf =  $('meta[name="csrf-token"]').attr('content');
  var setPriceDiscount = function()
     {
         $('.discount_price').hide()
         $('.submit-balance').prop('disabled',true)
         $('#package').on('change',function(){
          if($(this).val())
          {
           var price = parseFloat($('#package option:selected').attr('price'))
           $('.discount_price span').html(price)
           $('.submit-balance').prop('disabled',false)
           $('.discount_price').show()
          }else
          {
          $('.discount_price').hide()
          $('.submit-balance').prop('disabled',true)
          }
         })
     }
     var addNotficationsBalance = function()
     {
      $('.submit-balance').on('click',function(){
          var package_id =  $('#package').val()
        if(package_id)
        $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('add-balance-promotion')}}",
                type:'post',
                data:{package_id: package_id},
                success : function(res){
                    window.location.reload()
                }
		        })

      })
     }
     function toggleConfirmRenew(){
         const $confirm  = $('#renew-memebership_form input');
         const $submit = $('#renew-memebership_form button');
         $confirm.on('change',function(){
             $submit.prop('disabled',!$confirm.is(':checked'));
         })
     }
     $(document).ready(function(){
        addNotficationsBalance()
         setPriceDiscount()
         toggleConfirmRenew()
     })
 </script>
@endsection
