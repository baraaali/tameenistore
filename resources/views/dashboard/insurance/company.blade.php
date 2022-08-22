@extends('dashboard.layout.app')
@section('content')
    <style>
        .size{
            font-size: 30px;
        }
    </style>
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			شركات التأمين
		</h5>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			 جميع شركات التأمين
		</label>

		<br>

		<table class="table table-stroped table-responsive table-striped">
			<thead class="bg-light ">
				<td>
					رقم
				</td>
				<td>
				   اسم المستخدم
				</td>
				<td>
				اسم الشركة
				</td>
				<td>
				عنوان الشركة
				</td>
				<td>
				 الحالة
				</td>
				<td>
				 البريد الالكتروني
				</td>



			</thead>
			<tbody >
<!--			    --><?// $Companies = \App\Insurance::paginate(15); ?>

				@foreach($Companies as $company)
					<tr>
						<td>{{$company->id}}</td>
						<td>
						    <a href="#" data-toggle="modal" data-target="#exampleModal{{$company->id}}">{{$company->owner->name}}</a>
						    <div class="modal fade" id="exampleModal{{$company->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$company->id}}" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">اسم المستخدم : {{$company->ar_name}}</h5>
                                  </div>
                                  <div class="modal-body">
                                    @if($company->status == 1)
                                    <form method="post" action="{{route('deactive-insurance')}}">
                                    @else
                                    <form method="post" action="{{route('active-insurance')}}">
                                    @endif
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$company->user_id}}">
                                    <input type="hidden" name="id" value="{{$company->id}}">
                                    <h2>التأمينات الشاملة</h2>
                                    <table class="table table-stroped table-responsive table-striped">
                                	<thead class="bg-light ">
                        				<td>
                        					رقم
                        				</td>
                        				<td>
                        				   اسم المستخدم
                        				</td>
                        				<td>
                        				اسم الشركة
                        				</td>
                        				<td>
                        				موديل السيارة
                        				</td>
                        				<td>
                        				 براند
                        				</td>
                        				<td>
                        				يبدأ في
                        				</td>
                        				<td>
                        				ينتهي في
                        				</td>
                        			</thead>
		                        	<tbody>
                        			    <?php $CompleteDocs = \App\CompleteDoc::where('user_id',$company->user_id)->get();?>
                        				@foreach($CompleteDocs as $CompleteDoc)
                        					<tr>
                        						<td>{{$CompleteDoc->id}}</td>
                        						<td>{{$CompleteDoc->User->name}}</td>
                        						<td>{{$CompleteDoc->Insurance_Company_ar}}</td>
                        						<td>{{$CompleteDoc->idmodel['name']}}</td>
                        						<td>{{$CompleteDoc->idbrand['name']}}</td>
                        						<td>{{$CompleteDoc->created_at}}</td>
                        						<td>{{$CompleteDoc->end_date}}</td>
                        					</tr>
                        				@endforeach
                        			</tbody>
                                    </table>
                                    <hr>
                                    <h2>تأمينات ضد الغير</h2>
                                    <table class="table table-stroped table-responsive table-striped">
                        			<thead class="bg-light ">
                        				<td>
                        					رقم
                        				</td>
                        				<td>
                        				   اسم المستخدم
                        				</td>
                        				<td>
                        				اسم الشركة
                        				</td>
                        				<td>
                        				موديل السيارة
                        				</td>
                        				<td>
                        				 براند
                        				</td>
                        				<td>
                        				يبدأ في
                        				</td>
                        				<td>
                        				ينتهي في
                        				</td>


                        			</thead>
                        			<tbody >
                        			    <? $IncompleteDocs = \App\InsuranceDocument::where('user_id',$company->user_id)->get(); ?>
                        				@foreach( $IncompleteDocs = \App\InsuranceDocument::where('user_id',$company->user_id)->get() as $IncompleteDoc)
                        					<tr>
                        						<td>{{$IncompleteDoc->id}}</td>
                        						<td>{{$IncompleteDoc->User->name}}</td>
                        						<td>{{$IncompleteDoc->Insurance_Company_ar}}</td>
                        						<td>{{$IncompleteDoc->idmodel['name']}}</td>
                        						<td>{{$IncompleteDoc->idbrand['name']}}</td>
                        						<td>{{$IncompleteDoc->created_at}}</td>
                        						<td>{{$IncompleteDoc->end_date}}</td>


                        					</tr>
                        				@endforeach
                        			</tbody>
                        		</table>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                    @if($company->status == 0)
                                    <button type="submit" class="btn btn-success">تفعيل </button>
                                    @else
                                    <button type="submit" class="btn btn-danger">تعطيل </button>
                                    @endif
                                  </div>
                                  </form>
                                </div>
                              </div>
                            </div>
						</td>
						<td>{{$company->ar_name}}</td>
						<td>{{$company->ar_address}}</td>
						<td>
						   <button class="cl_{{$company->id}} btn {{$company->status==0?'btn-danger':'btn-success'}} stat" id="{{$company->id}}" data-url="{{$company->status}}" >
                   {{$company->status==0?'معطله':'مفعله'}}</button>
						 	<input type="hidden" id="statusVal" class="statusVal_{{$company->id}}" value="{{$company->status}}">
                        </td>
						<td>{{$company->email}}</td>


					</tr>
				@endforeach
			</tbody>
		</table>
		{{$Companies->links()}}
	</div>
</div>

<script>


  $(':button').on('click', function() {

      //var data = $(this).attr('data-url');

      var company_id = $(this).attr('id');
      var row='statusVal_'+company_id;
      var data = $('.'+row).val();
      var status=data==0?1:0;
      console.log(status);


      $.ajax({
          type: "GET",
          dataType: "json",
          url: '/dashboard/insurnace/companyChangeStatus',
          data: {'status': status, 'company_id': company_id},
          success: function(data){
              console.log(data.success)
              console.log(status);
              var clas='cl_'+company_id;
              if(status==1){
                  $('.'+row).attr('value', '1');
                  $('.'+clas).html('مفعلة');
                  $('.'+clas).removeClass('btn-danger');
                  $('.'+clas).addClass('btn-success');
              }
              else{
                  $('.'+row).attr('value', '0');
                  $('.'+clas).html('معطله');
                  $('.'+clas).removeClass('btn-success');
                  $('.'+clas).addClass('btn-danger');
              }

          }
      });
  });

</script>
<style>
    .size{
        font-size: 30px;
    }
</style>


@endsection
