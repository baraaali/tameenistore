@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="margin-top: -26px;text-align: center;">
                ارسال ايميل
            </h5>

        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <form action="{{route('send_email_to_users')}}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>
                            الرسالة <small class="text-danger">*</small>
                        </label>
                        <textarea name="message" class="SpecificInput" rows="5"  ></textarea>
                    </div>
                    <hr>
                    <div class="col-sm-12">
                        <p class="text-danger">اختر مستخدم او اكثر</p>
                    </div>
                    @foreach($users as $user)
                        <div class="col-sm-4 form-group">
                            <input type="checkbox"  class="pl-2" value="{{$user->email}}" name="emails[]">{{$user->name}}
                        </div>
                    @endforeach

                </div>
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-warning" value="ارسال ">
                </div>
            </form>
            {{$users->links()}}
        </div>
    </div>


@endsection

@section('js')

@endsection
