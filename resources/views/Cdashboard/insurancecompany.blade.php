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

<style type="text/css">
input{
    border: none !important;
    border-color: transparent !important;
}
</style>
<?php
$insurance = \App\Insurance::where('user_id',auth()->user()->id)->get();
if($insurance){
$insurance_documentrequest = \App\userinsurance::whereIn('insurance_id',$insurance->pluck('id'))->get();
}
 ?>

<div class="container-fluid">
    <br>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif



 <div class="container-fluid">


        <div class="section-3" style="padding: 25px !important; margin-top:25px;background-color: #F3F3F3">
<table class="table table-stroped table-responsive  text-center">
    <thead class="bg-light ">
        @if(app()->getLocale() == 'ar')

                                    <th>
                                    اسم الوثيقة
                                    </th>
                                    <th>
                                    اسم العميل
                                    </th>
                                    <th>
                                        ايميل العميل
                                    </th>
                                    <th>
                                       تليفون العميل
                                    </th>
                                    <th>
                                        البراند
                                    </th>
                                    <th>
                                        الموديل
                                    </th>
                                    <th>
                                    سنه صنع السيارة
                                    </th>
                                    <th>
                                    مدة التامين
                                    </th>
                                    <th>
                                        بدأ التأمين
                                    </th>
                                    <th>
                                        الملفات
                                    </th>
                                    <th>
                                    السعر
                                    </th>
                                    <th>
                                        تم الانتهاء
                                    </th>


                                @else

                                    <th>
                                    Insurance name
                                    </th>
                                    <th>
                                        Client Name
                                    </th>
                                    <th>
                                    Client Email
                                    </th>

                                    <th>
                                    Client Phone
                                    </th>
                                    <th>
                                        Brand
                                    </th>
                                    <th>
                                        Model
                                    </th>
                                    <th>
                                    manufacturing year
                                    </th>
                                    <th>
                                    Insurance Duration
                                    </th>
                                    <th>
                                    Price
                                    </th>
                                    <th>
                                        Done
                                    </th>
                                @endif
                            </thead>

                             <tbody>
                                @foreach($insurance_documentrequest as $key=>$document)
                                    <tr>

                                        <td>
                                            @if(app()->getLocale() == 'ar')
                                               {{$document->companynamear}}
                                            @else
                                               {{$document->companynameen}}
                                            @endif
                                        </td>

                                        <td>
                                            {{$document->user->name}}
                                        </td>
                                        <td>
                                            {{$document->user->email}}
                                        </td>
                                        <td>
                                            {{$document->user->phones}}
                                        </td>
                                        <td>
                                            {{$document->brand->name}}
                                        </td>
                                        <td>
                                            {{$document->model->name}}
                                        </td>
                                        <td>
                                            {{$document->year}}
                                        </td>
                                        <td>
                                            {{$document->inDuration}}
                                        </td>
                                        <td>
                                            {{$document->start_in}}
                                        </td>
                                        <td>
                                            <?php

                                                $images = [];
                                                $images = json_decode($document->files);

                                            ?>

                                            @if(count($images))
                                                @foreach($images as $key=>$image)
                                                    <a href="{{url('/')}}/uploads/{{$image}}" class="btn btn-light" download>
                                                        download #_{{++$key}}
                                                    </a>

                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            {{$document->price}}
                                        </td>
                                        <td>
                                            <a href="{{route('deleteinDocument',$document->id)}}" class="btn btn-danger">
                                                @if(app()->getLocale() == 'ar')
                                                    تم الانتهاء
                                                @else
                                                    Done
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                             </tbody>
                      </table>



        </div>


</div>
 <hr>





</div>



@endsection
