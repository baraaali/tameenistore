@extends('dashboard.layout.app')
@section('content')
    <?php
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $name2=$lang=='ar'?'name_ar':'name_en';

    ?>

    <div class="col-lg-12">

        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative; display: inline-block;top: 6px;">{{__('site.balance')}}
                                    @if(isset($balance))
                                    <span class="ml-5 mr-5 btn btn-danger">{{$balance->balance}}</span>
                                    @else <span class="ml-5 mr-5 btn btn-danger">{{__("site.you_don't_have_balance")}}</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <br>
                                <div class="table-responsive">
                                    <table id="mytable" class="table table-stroped table-responsive table-bordred table-striped">
                                        <thead class="bg-light ">
                                        <th>#</th>
                                        <th>{{__('site.trans_type')}}</th>
                                        <th>{{__('site.value')}}</th>
                                        <th>{{__('site.why')}}</th>
                                        <th>{{__('site.who')}}</th>
                                        <th>{{__('site.time')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($rows as $i=>$row)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$row->transaction=="in"?__('site.inside'):__('site.outside')}}</td>
                                            <td class="text-danger">{{$row->value}}</td>
                                            <td class="text-info">@if($row->type=="charge") {{__('site.pro_charge')}}
                                                @elseif($row->type=="membership"){{__('site.for_membership')}}
                                                @elseif($row->type=="department"){{__('site.for_department')}}
                                                @elseif($row->type=="mcenters"){{__('site.maintenance centers')}}
                                                @else {{__('site.for_car')}}@endif
                                            </td>
                                            <td class="text-success">{{$row->type_id==-1?__('site.admin'):__('site.your_selve')}}</td>
                                            <td class="text-primary"> {{Carbon\Carbon::parse($row->created_at)->toFormattedDateString()}}</td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            </div>

                        </div>


                    </div>

                </div>

                </div>
        </div>
    </div>

@endsection
