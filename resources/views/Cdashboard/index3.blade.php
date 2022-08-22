@extends('Cdashboard.layout.app')
@section('controlPanel')


<?php

    if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }

?>


 @if(app()->getLocale() == 'ar')

                                   <style>
                                       .form-group{
                                           direction:rtl;
                                           text-align:right !important;
                                       }
                                   </style>

                                   @else

                                    <style>
                                       .form-group{
                                           direction:ltr;
                                           text-align:left !important;
                                       }
                                   </style>

                                    @endif
<div class="col-lg-12">
<div class="row">


  <div class="col-12">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          <div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative; display: inline-block;top: 6px;">
			@if(app()->getLocale() == 'ar')
			معلومات الفروع
			@else
             Branches Informations
			@endif
		</h5>
		<a href="#" class="btn btn-light circle" data-toggle="modal" data-target="#exampleModal" >
			   <i class="fas fa-plus-circle"></i>
		</a>
		<!--<a href="#"  class="btn btn-light circle">-->
		<!--	   <i class="fas fa-trash"></i> -->
		<!--</a>-->
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			@if(app()->getLocale() == 'ar')
		    جميع الفروع
		    @else
		    All Branches
		    @endif
		</label>

		<br>
       @if(auth()->user()->type == 2 || auth()->user()->type == 3 )
       <?php $countries = \App\country::where(['parent'=>0,'status'=>1])->get();
       $agent = \App\Agents::where('user_id',auth()->user()->id)->first();
        $agent_branch = \App\AgentBranches::where('agent_id',$agent->id)->get();

       ?>
		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				@if(app()->getLocale() == 'ar')
				<td>
				  اسم الفرع بالعربية
				</td>
				<td>
				اسم الفرع بالانجليزية
				</td>

				<td>
				العمليات
				</td>

				@else

				<td>
				Name In arabic
				</td>
				<td>
				Name In English
				</td>

				<td>
				Operations
				</td>
				@endif
			</thead>
			@foreach($agent_branch  as $branch)
			<tbody >
					<tr>
						<td>
							{{$branch->ar_name}}
						</td>
						<td>
							{{$branch->en_name}}
						</td>

						<td>
							<a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModalLabel2{{$branch->id}}" >
								<i class="fa fa-edit"></i>
							</a>
							<a onclick="return confirm('Are you sure?')" href="{{route('agBranch-delete',$branch->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i>
							</a>
						</td>

					</tr>

			</tbody>
			<div class="modal fade" id="exampleModalLabel2{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="#exampleModalLabel2{{$branch->id}}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">تعديل البيانات الشخصية</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                 <div class="modal-body">
              <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
            		<div class="form">

            			<form method="POST" action="{{route('agBranch-Update')}}" enctype="multipart/form-data">
            				@csrf
            				<input type="hidden" name="agent_id" value="{{$branch->id}}">
            			   @if(app()->getLocale() == 'ar')
            				<div class="form-group">
            				<label>
            					إسم الفرع بالأنجليزية <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="en_name" value="{{$branch->en_name}}" maxlength="191" class="SpecificInput">
            				</div>

            	        	<div class="form-group">
            				<label>
            					إسم الفرع بالعربية <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="ar_name" value="{{$branch->ar_name}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				 عنوان الفرع بالنجليزية  <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="en_address" value="{{$branch->en_address}}" maxlength="191" class="SpecificInput">
            				</div>

            	        	<div class="form-group">
            				<label>
            				عنوان الفرع بالعربية <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="ar_address" value="{{$branch->ar_address}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				  رقم الهاتف <small class="text-danger">*</small>
            				</label>
            				<input type="tel" required="required" name="phones" value="{{$branch->phones}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				  ايام العمل <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="days_on" value="{{$branch->days_on}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				  أوقات العمل <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="times_on" value="{{$branch->times_on}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            					<label>
            				    نوع السيارات <small class="text-danger">*</small>
            					</label>
            					<select class="SpecificInput" name="car_type" value="{{$branch->car_type}}">
            							<option value="0">Used</option>
            					        <option value="1">New</option>
            					</select>
            				</div>

            				<div class="form-group">
            				<label>
            					 صورة الفرع <small class="text-danger">*</small>
            				</label>
            				<input type="file" name="image" class="SpecificInput" required="required">
            				</div>

            				@else
            					<div class="form-group">
            				<label>
            				Branch Name In English <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="en_name" value="{{$branch->en_name}}" maxlength="191" class="SpecificInput">
            				</div>

            	        	<div class="form-group">
            				<label>
            				Branch Name In Arabic <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="ar_name" value="{{$branch->ar_name}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				Branch Address In English <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="en_address" value="{{$branch->en_address}}" maxlength="191" class="SpecificInput">
            				</div>

            	        	<div class="form-group">
            				<label>
            				Branch Address In Arabic <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="ar_address" value="{{$branch->ar_address}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				 Mobil No.  <small class="text-danger">*</small>
            				</label>
            				<input type="tel" required="required" name="phones" value="{{$branch->phones}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				Days on <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="days_on" value="{{$branch->days_on}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            				<label>
            				 Times on <small class="text-danger">*</small>
            				</label>
            				<input type="text" required="required" name="times_on" value="{{$branch->times_on}}" maxlength="191" class="SpecificInput">
            				</div>

            				<div class="form-group">
            					<label>
            				    Car Types  <small class="text-danger">*</small>
            					</label>
            					<select class="SpecificInput" name="car_type" value="{{$branch->car_type}}">
            							<option value="0">Used</option>
            					        <option value="1">New</option>
            					</select>
            				</div>

            				<div class="form-group">
            				<label>
            				Branch Images <small class="text-danger">*</small>
            				</label>
            				<input type="file" name="image" class="SpecificInput" required="required">
            				</div>

            				@endif
            		<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if(app()->getLocale() == 'ar')
                    <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                    @else
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                    @endif
                  </div>
            	</form>
            </div>

            	</div>
                  </div>
              </div>
            </div>
            </div>

			@endforeach
		</table>

        <!--Branches create Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> إنشاء فرع جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
          <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
        		<div class="form">
        			<form method="POST" action="{{route('agBranch-Store')}}" enctype="multipart/form-data">
        				@csrf
        				<input type="hidden" name="agent_id" value="{{$agent->id}}" >
        				<div class="form-group">
        				@if(app()->getLocale() == 'ar')
        				<label>
        					إسم الفرع بالأنجليزية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_name" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        					إسم الفرع بالعربية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_name" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 عنوان الفرع بالنجليزية  <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_address" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				عنوان الفرع بالعربية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_address" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  رقم الهاتف <small class="text-danger">*</small>
        				</label>
        				<input type="tel" required="required" name="phones" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  ايام العمل <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="days_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  أوقات العمل <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="times_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        					<label>
        				    نوع السيارات <small class="text-danger">*</small>
        					</label>
        					<select class="SpecificInput" name="car_type">
        							<option value="0">Used</option>
        					        <option value="1">New</option>
        					</select>
        				</div>

        				<div class="form-group">
        				<label>
        					 صورة الفرع <small class="text-danger">*</small>
        				</label>
        				<input type="file" name="image" class="SpecificInput" required="required">
        				</div>


        				@else

        				<label>
        				Branch Name In English <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_name" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				Branch Name In Arabic <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_name" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				Branch adress in English<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_address" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        			   Branch Address in Arabic <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_address" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				Mobile No. <small class="text-danger">*</small>
        				</label>
        				<input type="tel" required="required" name="phones" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Days On <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="days_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				Times On <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="times_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        					<label>
        				    Cars Type <small class="text-danger">*</small>
        					</label>
        					<select class="SpecificInput" name="car_type">
        							<option value="0">Used</option>
        					        <option value="1">New</option>
        					</select>
        				</div>

        				<div class="form-group">
        				<label>
        			     Branch Image <small class="text-danger">*</small>
        				</label>
        				<input type="file" name="image" class="SpecificInput" required="required">
        				</div>
        				@endif
        		<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(app()->getLocale() == 'ar')
                <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                @else
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                @endif
              </div>
        	</form>
        </div>

        	</div>
              </div>

            </div>
          </div>
        </div>

          <!--------- Branches  Edit Modal !---------->

	@endif










	@if(auth()->user()->type == 1)
	    <?php $countries = \App\country::where(['parent'=>0,'status'=>1])->get();
	       $exhibitor = \App\Exhibition::where('user_id',auth()->user()->id)->first();
           $Exhibition_branch = \App\ExhibitorBranches::where('exhibitor_id',$exhibitor->id)->get();
         ?>
		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				@if(app()->getLocale() == 'ar')
				<td>
				  اسم الفرع بالعربية
				</td>
				<td>
				اسم الفرع بالانجليزية
				</td>

				<td>
				العمليات
				</td>

				@else

				<td>
				Name In arabic
				</td>
				<td>
				Name In English
				</td>

				<td>
				Operations
				</td>
				@endif

			</thead>
			@foreach($Exhibition_branch as $branches)
			<tbody >
					<tr>
						<td>
							{{$branches->ar_name}}
						</td>
						<td>
							{{$branches->en_name}}
						</td>

						<td>
							<a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModalLabel3{{$branches->id}}" >
								<i class="fa fa-edit"></i>
							</a>
							<a href="{{route('exBranch-delete',$branches->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i>
							</a>
						</td>
					</tr>

			</tbody>
			  <div class="modal fade" id="exampleModalLabel3{{$branches->id}}" tabindex="-1" role="dialog" aria-labelledby="#exampleModalLabel3{{$branches->id}}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">تعديل البيانات الشخصية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             <div class="modal-body">
          <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
        		<div class="form">

        			<form method="POST" action="{{route('exBranch-Update')}}" enctype="multipart/form-data">
        				@csrf
        				<input type="hidden" name="id" value='{{$branches->id}}'>
        			   @if(app()->getLocale() == 'ar')
        				<div class="form-group">
        				<label>
        					إسم الفرع بالأنجليزية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_name" value="{{$branches->en_name}}" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        					إسم الفرع بالعربية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_name" value="{{$branches->ar_name}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 وصف الفرع بالنجليزية  <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_address" value="{{$branches->en_description}}" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				وصف الفرع بالعربية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_address" value="{{$branches->ar_description}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  رقم الهاتف <small class="text-danger">*</small>
        				</label>
        				<input type="tel" required="required" name="phones" value="{{$branches->phones}}" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				 فيس بوك<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="fb_page" value="{{$branches->fb_page}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 صفحة الانستجرام<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="instagram" value="{{$branches->instagram}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 صفحة تويتر<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="twitter_page" value="{{$branches->twitter_page}}" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				 الوقع الالكتروني<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="website" value="{{$branches->website}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 البريد الالكتروني<small class="text-danger">*</small>
        				</label>
        				<input type="email" required="required" name="email" value="{{$branches->email}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 خريطة جوجل<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="google_map" value="{{$branches->google_map}}" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				  ايام العمل <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="days_on" value="{{$branches->days_on}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  أوقات العمل <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="times_on" value="{{$branches->times_on}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        					<label>
        				    نوع السيارات <small class="text-danger">*</small>
        					</label>
        					<select class="SpecificInput" name="car_type" value="{{$branches->car_type}}">
        							<option value="0">Used</option>
        					        <option value="1">New</option>
        					</select>
        				</div>

        				<div class="form-group">
        				<label>
        					 صورة الفرع <small class="text-danger">*</small>
        				</label>
        				<input type="file" name="image" class="SpecificInput" required="required">
        				</div>

        				@else
        					<div class="form-group">
        				<label>
        				Branch Name In English <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_name" value="{{$branches->en_name}}" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				Branch Name In Arabic <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_name" value="{{$branches->ar_name}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				Branch description In English <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="en_address" value="{{$branches->en_address}}" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				Branch description In Arabic <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_address" value="{{$branches->ar_address}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Mobil No.  <small class="text-danger">*</small>
        				</label>
        				<input type="tel" required="required" name="phones" value="{{$branches->phones}}" maxlength="191" class="SpecificInput">
        				</div>
        					<div class="form-group">
        				<label>
        				 Facebook Link <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="fb_page" value="{{$branches->fb_page}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Instagram Page <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="instagram" value="{{$branches->instagram}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Twitter Link <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="twitter_page" value="{{$branches->twitter_page}}" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				 Wesbite Link<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="website" value="{{$branches->website}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Email  <small class="text-danger">*</small>
        				</label>
        				<input type="email" required="required" name="email" value="{{$branches->email}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Google Map<small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="google_map" value="{{$branches->google_map}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				Days on <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="days_on" value="{{$branches->days_on}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 Times on <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="times_on" value="{{$branches->times_on}}" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        					<label>
        				    Car Types  <small class="text-danger">*</small>
        					</label>
        					<select class="SpecificInput" name="car_type" value="{{$branches->car_type}}">
        							<option value="0">Used</option>
        					        <option value="1">New</option>
        					</select>
        				</div>

        				<div class="form-group">
        				<label>
        				Branch Images <small class="text-danger">*</small>
        				</label>
        				<input type="file" name="image" class="SpecificInput" required="required">
        				</div>

        				@endif
        		<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(app()->getLocale() == 'ar')
                <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                @else
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                @endif
              </div>
        	</form>
        </div>

        	</div>
              </div>
          </div>
        </div>
        </div>
			@endforeach
		</table>

	   	<!--Branches Edit Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إنشاء فرع جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
          <div class="card-body" style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
        		<div class="form">
        			<form method="POST" action="{{route('exBranch-Store')}}" enctype="multipart/form-data">
        				@csrf
        				<input type="hidden" name="exhibitor_id" value="{{$exhibitor->id}}">
        				<div class="form-group">

        				<label>
        				    @if(app()->getLocale() == 'ar')
        				        	إسم الفرع بالأنجليزية
        				    @else
        				         Name In English
        				    @endif
        				</label>
        				<input type="text" required="required" name="en_name" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        					إسم الفرع بالعربية <small class="text-danger">*</small>
        				</label>
        				<input type="text" required="required" name="ar_name" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        	            وصف الفرع بالانجليزية
        				</label>
        				<input type="text"  name="en_description	" maxlength="191" class="SpecificInput">
        				</div>

        	        	<div class="form-group">
        				<label>
        				وصف الفرع بالعربية
        				</label>
        				<input type="text"  name="ar_description	" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  رقم الهاتف
        				</label>
        				<input type="tel"  name="phones" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				 الفيسبوك
        				</label>
        				<input type="text"  name="fb_page" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 انستجرام
        				</label>
        				<input type="text"  name="instagram" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 تويتر
        				</label>
        				<input type="text"  name="twitter_page" maxlength="191" class="SpecificInput">
        				</div>
        				<div class="form-group">
        				<label>
        				 الموقع الالكتروني
        				</label>
        				<input type="text"  name="website" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 البريد الالكتروني
        				</label>
        				<input type="email" name="email" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				 خريطة جوجل
        				</label>
        				<input type="text"  name="google_map" maxlength="191" class="SpecificInput">
        				</div>


        				<div class="form-group">
        				<label>
        				  ايام العمل
        				</label>
        				<input type="text"  name="days_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        				<label>
        				  أوقات العمل
        				</label>
        				<input type="text"  name="times_on" maxlength="191" class="SpecificInput">
        				</div>

        				<div class="form-group">
        					<label>
        				    نوع السيارات
        					</label>
        					<select class="SpecificInput" name="car_type">
        							<option value="0">Used</option>
        					        <option value="1">New</option>
        					</select>
        				</div>

        				<div class="form-group">
        				<label>
        					 صورة الفرع
        				</label>
        				<input type="file" name="image" class="SpecificInput">
        				</div>




        		<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(app()->getLocale() == 'ar')
                <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                @else
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                @endif
              </div>
        	</form>
        </div>

        	</div>
              </div>

            </div>
          </div>
        </div>

          <!--------- Branches  Edit Modal !---------->


	@endif
	</div>


</div>

      </div>

    </div>
  </div>

</div>
</div>
















        <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
 <script>tinymce.init({selector:'textarea'});</script>


@endsection

