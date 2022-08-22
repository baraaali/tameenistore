@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="direction">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success')) 

    <h6 class="alert alert-success direction">{{ __(session('success')) }}</h6>

@endif 

@if(session()->has('error'))
<h6 class="alert alert-danger direction">{{ __(session('error')) }}</h6>
@endif
