
@include('dashboard.user-info.user-info')


<div class="col-md-12" >
    <h3 class="mb-3  py-3 border-bottom">
        <i class="fa fa-info-circle" aria-hidden="true"></i>

        @if(app()->getLocale() == 'ar')
          وثائق تأكيد الهوية  
        @else
            Information About Your Facility
        @endif
    </h3>
    <form method="POST" action="{{route('upload-user-documents')}}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{__('site.license_image')}}</label>
                        <input type="file" name="license_image" required class="SpecificInput">
                        @isset($doc)
                        <img src="{{asset('uploads/'.$doc->license_image)}}" alt="" style="width: 50px;height: 50px">
                        @endisset
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{__('site.id_image')}}</label>
                        <input type="file" required name="id_image" class="SpecificInput">
                        @isset($doc)
                            <img src="{{asset('uploads/'.$doc->id_image)}}" alt="" style="width: 50px;height: 50px">
                        @endisset
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{__('site.company_name')}}</label>
                        <input type="text" required name="company_name" class="SpecificInput" value="@isset($doc){{$doc->company_name}}@endisset">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{__('site.license_number')}}</label>
                        <input type="text" required name="license_number" value="@isset($doc){{$doc->license_number}}@endisset" class="SpecificInput" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>{{__('site.start_date')}} </label>
                    <div class="form-group">
                        <input class="SpecificInput" required  name="start_date" type="date" value="@isset($doc){{$doc->start_date}}@endisset">
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>{{__('site.end_date')}} </label>
                    <div class="form-group">
                        <input class="SpecificInput" required  name="end_date" type="date" value="@isset($doc){{$doc->end_date}}@endisset">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <input class="SpecificInput btn btn-primary" value="{{__('site.send')}}"  type="submit">
                    </div>
                </div>
                
            </div>
        </div>

    </form>
</div>