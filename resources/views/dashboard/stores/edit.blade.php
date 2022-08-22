
   <div class="modal fade" id="edit{{$store->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل</h5>
            </div>
            <form class="form" method="post" action="{{route('stores.update',$store->id)}}" enctype="multipart/form-data">
                @csrf
                {{ method_field('put') }}
                <input type="hidden" name="id" value="{{$store->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            الاسم بالعربية
                        </label>
                        <input type="text" value="{{$store->getName('ar')}}" name="ar_name" class="SpecificInput" required="required">
                    </div>
                    <div class="form-group">
                        <label>
                            الإسم بالإنجليزية
                        </label>
                        <input type="text" value="{{$store->getName('en')}}" name="en_name" class="SpecificInput" required="required">
                    </div>
                         <div class="form-group">
                             <label for="category">  القسم  </label>
                             <select value="{{$store->category}}" class="form-control " name="category" > 
                               @foreach($categories as $category)
                                   <option @if ($store->category == $category->id ) selected @endif value="{{$category->id}}">
                                       {{$category->ar_name}}
                                   </option>
                               @endforeach
                             </select>
                          </div>
                         <div class="form-group">
                             <label for="sub_category">  القسم الفرعي  </label>
                             <select disabled  value="{{$store->sub_category}}"  class="form-control " name="sub_category" > 
                                 <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                         <div class="form-group">
                             <label for="child_category">  القسم الفرع فرعي   </label>
                             <select disabled value="{{$store->child_category}}" class="form-control " name="child_category" > 
                               <option value="">{{__('site.choose')}}</option>
                             </select>
                          </div>
                 
                  
                    <div class="form-group">
                        <input type="checkbox" {{$store->status == 1 ? 'checked' : ''}} name="status" value="1">
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
            $('[name="category"]').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_categories/get-childrens/"+id,
                success: function(data){
                    $('[name="sub_category"]').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('[name="sub_category"]').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
                     $('[name="sub_category"]').prop('disabled',false)
                     $('[name="sub_category"]').trigger('change')
                   }else
                     $('[name="sub_category"]').prop('disabled',true)
                }
            })
            })
            $('[name="category"]').trigger('change')
        }
        var getChildCategories = function(){
            $('[name="sub_category"]').on('change',function(){
             var id = $(this).val()
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/dashboard/service_sub_categories/get-childrens/"+id,
                success: function(data){
                    $('[name="child_category"]').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('[name="child_category"]').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
                     $('[name="child_category"]').prop('disabled',false)
                     $('[name="child_category"]').trigger('change')

                   }else
                     $('[name="child_category"]').prop('disabled',true)
                }
            })
            })
            $('[name="sub_category"]').trigger('change')
        }
        $(document).ready(function(){
            getSubCategories()
            getChildCategories()
        })
</script>