<div class="col-md-12">
    <h3 class="mb-3  py-3 border-bottom">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
    
        @if(app()->getLocale() == 'ar')
        تعديل بيانات المستخدم
        @else
        Edit User Information
        @endif
    </h3>
    <form method="POST" action="{{route('user-update')}}"
    enctype="multipart/form-data">
  @csrf
  <input type="hidden" value="{{auth()->user()->id}}">
  <div class="col-md-12">
      <div class="row">
          <div class="form-group col-md-4">
              @if(app()->getLocale() == 'ar')
                  <label>
                      الأسم <small class="text-danger">*</small>
                      @else
                          Name <small class="text-danger">*</small>
                  </label>
              @endif
              <input type="text" value="{{auth()->user()->name}}" name="name"
                     max="191" class="SpecificInput">
          </div>


          <div class="form-group col-md-4">
              @if(app()->getLocale() == 'ar')
                  <label>
                      التيليفون <small class="text-danger">*</small>
                      @else
                          Mobil No. <small class="text-danger">*</small>
                  </label>
              @endif
              <input type="tel" required value="{{auth()->user()->phones}}"
                     name="phone" max="191" class="SpecificInput">


          </div>
          <div class=" form-group col-md-4">

              @if(app()->getLocale() == 'ar')
                  <label>
                      البريد الألكتروني <small class="text-danger">*</small>
                      @else
                          Email Address <small class="text-danger">*</small>
                  </label>
              @endif
              <input type="email" value="{{auth()->user()->email}}"
                     name="email" max="191" class="SpecificInput">

          </div>
          <div class=" form-group col-md-4">

              @if(app()->getLocale() == 'ar')
                  <label>
                      الصورة<small class="text-danger">*</small>
                      @else
                          Image <small class="text-danger">*</small>
                  </label>
              @endif
              <input type="file" name="img" class="">
              <img src="{{url('/')}}/uploads/{{auth()->user()->image}}"
                   style="width:100px;height:50px !important;">

          </div>

          <div class="col-md-4 form-group">

              @if(app()->getLocale() == 'ar')
                  <label>
                      كلمة المرور<small class="text-danger">*</small>
                      @else
                          Password <small class="text-danger">*</small>
                  </label>
              @endif
              <input type="password" name="password" class="SpecificInput">

          </div>

          <div class="col-md-8"></div>
          <div class="col-md-4">
              <input type="submit" class="btn btn-primary btn-block"
                     value="{{app()->getLocale() == 'ar' ? 'تعديل' : 'update'}}">
          </div>
      </div>
  </div>
</form>

</div>