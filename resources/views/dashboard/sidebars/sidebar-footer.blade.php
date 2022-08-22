<div class="sidebar-footer">
    <a href="{{route('get-user-notifications')}}">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">{{\App\UserNotification::where('user_id',auth()->user()->id)->where('viewed','0')->count()}}</span>
    </a>
    {{-- <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
    </a> --}}
    {{-- <a href="#">
        <i class="fa fa-cog"></i>
    </a> --}}
    <a href="{{route('logout')}}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off"></i>
        <span class="badge-sonar"></span>
    </a>
</div>