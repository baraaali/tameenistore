@extends('dashboard.layout.app')
@section('content')
 @if(auth()->user()->guard == 1 )
   @include('dashboard.user-info.regular')

  @elseif (auth()->user()->type == 2 || auth()->user()->type == 3) <!-- agents -->
     @include('dashboard.user-info.agent') 

  @elseif (auth()->user()->type == 5) <!-- mcenters -->
     @include('dashboard.user-info.mcenter')   
     
  @elseif(auth()->user()->type == 4) <!-- insurance -->
      @include('dashboard.user-info.insurance')
      
   @elseif(auth()->user()->type == 0  ) <!-- regular -->
      @include('dashboard.user-info.regular')

  @endif
@endsection