@extends('layouts.app')
@section('content')
<style type="text/css">
	.py-4{
		background-color: #f3f3f3;
	}
</style>
<div class="col-lg-12">
	<div class="container">
		<div class="row">
			@if(app()->getLocale() == 'ar')
             <div class="com-card col-lg-12">
				<div class="card-head col-lg-12">
					<h5>مقارنة</h5>
				</div>
				<div class="card-body col-lg-12">
					<table class="table table-stroped table-responsive ">
					  <thead class="bg-light ">
					    <tr>
					      <th scope="col">الأسم</th>
					      <th scope="col">سياؤة بوغاتي</th>
					      <th scope="col">سيارة أودي</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <th scope="row">الصورة</th>
					      <td><img src="{{url('/')}}/uploads/unnamed.png" alt=""></td>
					      <td><img src="{{url('/')}}/uploads/audi_PNG1741.png" alt=""></td>
					    </tr>
					    <tr>
					      <th scope="row">بلد المنشأ</th>
					      <td>Jacob</td>
					      <td>Thornton</td>
					    </tr>
					    <tr>
					      <th scope="row">الماركة</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">الموديل</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">قوة المحرك</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">{{__('site.status')}}</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					     <tr>
					      <th scope="row">KM</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					     <tr>
					      <th scope="row">نوع الفتيس</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">سنة النشأ</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					  </tbody>
					</table>
				</div>
			</div>
			@else
             <div class="com-card col-lg-12">
				<div class="card-head col-lg-12">
					<h5>Comparison</h5>
				</div>
				<div class="card-body col-lg-12">
					<table class="table table-stroped table-responsive ">
					  <thead class="bg-light ">
					    <tr>
					      <th scope="col">Name</th>
					      <th scope="col">Car 1</th>
					      <th scope="col">Car 2</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <th scope="row">Image</th>
					      <td><img src="{{url('/')}}/uploads/unnamed.png" alt=""></td>
					      <td><img src="{{url('/')}}/uploads/audi_PNG1741.png" alt=""></td>
					    </tr>
					    <tr>
					      <th scope="row">Country</th>
					      <td>Jacob</td>
					      <td>Thornton</td>
					    </tr>
					    <tr>
					      <th scope="row">Brand</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">Model</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">Engine</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">Usage</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					     <tr>
					      <th scope="row">KM</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					     <tr>
					      <th scope="row">Transimision</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					    <tr>
					      <th scope="row">Year</th>
					      <td>Larry the Bird</td>
					      <td>@twitter</td>
					    </tr>
					  </tbody>
					</table>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>


@endsection