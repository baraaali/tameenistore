@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('assets_web/css/chat.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        <li class="clearfix active">
                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                            <div class="about">
                                <div class="name">{{$receiver->name}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0">{{$receiver->name}}</h6>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden-sm text-right">
                            </div>
                        </div>
                    </div>
                    <div class="chat-history" id="chat-history">
                        <ul class="m-b-0">

                            @foreach ($msgs  as $msg)
                                @if($msg->from_user==$receiver->id)
                                <li class="clearfix">
                                    <div class="message-data text-right">
                                        <span class="message-data-time">{{Carbon\Carbon::parse($msg->created_at)->toFormattedDateString()}}</span>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right"> {{$msg->body}} </div>
                                </li>
                                @else
                                <li class="clearfix">
                                    <div class="message-data">
                                   <span class="text-danger">{{__('site.you')}}</span>
                                    </div>
                                    <div class="message my-message">{{$msg->body}}</div>
                                    <div class="message-data-time">{{Carbon\Carbon::parse($msg->created_at)->toFormattedDateString()}}</div>
                                </li>
                                @endif
                            @endforeach

                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <form action="{{route('chat.send')}}" method="post" style="width: 100%">
                                @csrf
                                @method('post')
                                <input type="hidden" name="user" value="{{$receiver->id}}">
                               <div class="input-group-prepend text-right">
                                   <button class="input-group-text" type="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>                                    </button>
                                   <input type="text" name="msg" id="sen_msg"   required class="form-control" placeholder=" ...اكتب رسالتك هنا ">
                               </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(function(){
        document.getElementById('sen_msg').focus();
    });
    var objDiv = document.getElementById("chat-history");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>
@endsection