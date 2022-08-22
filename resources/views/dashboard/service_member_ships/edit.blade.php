
   <div class="modal fade" id="edit{{$service_member_ship->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل</h5>
            </div>
            <form class="form" method="post" action="{{route('service_member_ships.update',$service_member_ship->id)}}" enctype="multipart/form-data">
                @csrf
                {{ method_field('put') }}
                <input type="hidden" name="id" value="{{$service_member_ship->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            الاسم بالعربية
                        </label>
                        <input type="text" value="{{$service_member_ship->getName('ar')}}" name="ar_name" class="SpecificInput" required="required">
                    </div>
                    <div class="form-group">
                        <label>
                            الإسم بالإنجليزية
                        </label>
                        <input type="text" value="{{$service_member_ship->getName('en')}}" name="en_name" class="SpecificInput" required="required">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        السعر  
                                    </label>
                                    <input type="number"  value="{{$service_member_ship->price}}" name="price" class="form-control" required>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    عدد الشهور 
                                </label>
                                <input type="number" value="{{$service_member_ship->months_number}}" name="months_number" class="form-control" required>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                     نوع الإعلان
                                </label>
                                  <select class="form-control" value="{{$service_member_ship->type}}" name="type" id="type">
                                    <option @if($service_member_ship->type == 'normal') selected @endif  value="normal">عادية</option>
                                    <option  @if($service_member_ship->type == 'special') selected @endif   value="special">{{__('site.featured')}}</option>
                                  </select>
                                </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    عدد الإعلانات 
                                </label>
                                <input type="number"  value="{{$service_member_ship->ads_number}}" name="ads_number" class="form-control" required>
                            </div>
                        </div>
                    </div>

                         <div class="form-group">
                             <label for="category">  القسم  </label>
                             <select value="{{$service_member_ship->category}}" class="form-control " name="category"  id="category_edit"> 
                               @foreach($categories as $category)
                                   <option @if ($service_member_ship->category == $category->id ) selected @endif value="{{$category->id}}">
                                       {{$category->ar_name}}
                                   </option>
                               @endforeach
                             </select>
                          </div>
                         <div class="form-group">
                             <label for="sub_category">  القسم الفرعي  </label>
                             <select disabled  value="{{$service_member_ship->sub_category}}"  class="form-control " name="sub_category"   id="sub_category_edit"> 
                                 <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                         <div class="form-group">
                             <label for="child_category">  القسم الفرع فرعي   </label>
                             <select disabled value="{{$service_member_ship->child_category}}" class="form-control " name="child_category"  id="child_category_edit" > 
                               <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                 
                  
                    <div class="form-group">
                        <input type="checkbox" {{$service_member_ship->status == 1 ? 'checked' : ''}} name="status" value="1">
                        <label>
                            نشر ؟
                        </label>

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
         var getSubCategories = function(){
            $('#category_edit').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_categories/get-childrens/"+id,
                success: function(data){
                    $('#sub_category_edit').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $el = '<option value="'+e.id+'">'+e.ar_name+'</option>'
                         if(e.id ==  $('#sub_category_edit').attr('value')) 
                         $el = '<option  selected value="'+e.id+'">'+e.ar_name+'</option>'
                         $('#sub_category_edit').append($el)
                     });
                     $('#sub_category_edit').prop('disabled',false)
                     $('#sub_category_edit').trigger('change')
                   }else{
                      $('#sub_category_edit').prop('disabled',true)
                     $('#sub_category').trigger('change')
                   }
                }
            })
            })
            $('#category_edit').trigger('change')
        }
        var getChildCategories = function(){
            $('#sub_category_edit').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_sub_categories/get-childrens/"+id,
                success: function(data){
                    $('#child_category_edit').html('');
                   if(data.length)
                   {
                 data.forEach(e => {
                        $el = '<option value="'+e.id+'">'+e.ar_name+'</option>'
                        if(e.id ==  $('#child_category_edit').attr('value')) 
                        $el = '<option selected value="'+e.id+'">'+e.ar_name+'</option>'

                        $('#child_category_edit').append($el)
                     });
                     $('#child_category_edit').prop('disabled',false)
                     $('#child_category_edit').trigger('change')

                   }else
                     $('#child_category_edit').prop('disabled',true)
                }
            })
            })
            $('#sub_category_edit').trigger('change')
        }
        $(document).ready(function(){
            getSubCategories()
            getChildCategories()
        })
</script>