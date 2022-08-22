@foreach($rows as $row)
            <form action="{{route('change_date_brand',$row->id,$lang)}}" method="post">
                @csrf
                <div class="form-group mb-5">
                    <div id="inbrandtable" class="table-responsive">
                        <table class="table table-stroped table-responsive   text-center modelTable">
                            <thead class="table-active">
                                <td>{{__('site.brand')}}</td>
                            <td>
                                  الموديل
                                
                            </td>
                            <td>{{__('site.status')}}</td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    السعر
                                @else
                                    Price
                                @endif
                            </td>

                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الاولي
                                @else
                                    First Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثانيه
                                @else
                                    second Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثالثه
                                @else
                                    third Insurance Interval
                                @endif
                            </td>

                            </thead>
                            <tbody>
                            <tr>
                                <td>{{\App\brands::where('id',$row->brand_id)->first()->name}}</td>
                                <td>{{\App\models::where('id',$row->model_id)->first()->name}}</td>
                                <td>
                                    <select name="status" class="form-group ">
                                        <option value="0" @if ($row->status==0) selected @endif>{{__('site.not_active')}}</option>
                                        <option value="1"  @if ($row->status==1) selected @endif>{{__('site.active')}}</option>
                                    </select>
                                </td>
                                <td><input type="text" name="price" value="{{$row->price}}"></td>
                                <td><input type="text" name="firstinterval" value="{{$row->firstinterval}}"></td>
                                <td><input type="text" name="secondinterval" value="{{$row->secondinterval}}"></td>
                                <td><input type="text" name="thirdinterval" value="{{$row->thirdinterval}}"></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                   
                    <div class="text-center">
                        <input type="submit" class="btn btn-success " value="{{__('site.save')}}">
                        <input onclick="if(confirm('هل تريد الحذف?')) $('#delete-form').submit();" type="button" value="{{__('site.delete')}}" class="btn btn-danger text-center">

                        
                    </div>
                </div>
            </form>
            <form id="delete-form" method="POST" action="{{route('delete-model-from-single',$row->id)}}">
                <input type="hidden" name="_method" value="delete">
                @csrf
            </form>

            @endforeach