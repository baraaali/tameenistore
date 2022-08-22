@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative; display: inline-block; top: 6px;">
               طلبات التأمين الشامل 
            </h5>
  
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
           
            <div class="data-table">
                @include('dashboard.insurancerequescomplete.table',['items'=>$items])
            </div>
        </div>
    </div>  


@endsection

@section('js')

@endsection
