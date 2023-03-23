@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <span class="pull-right">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">ลบข้อมูลนี้</button></span>
            <h3 class="box-title">Stock {{$stock->unit_id}}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <form id="address" class="form-horizontal" role="form" method="POST" action="/device-stock/show/{{$stock->id}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                <div class="form-group">
                    
                    <label for="content" class="col-sm-2 control-label">Phone number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="phone_number" placeholder="Phone number" value="{{$stock->phone_number}}">
                    </div>
                    <label for="content" class="col-sm-1 control-label">Operator</label>
                    <div class="col-sm-4">
                        <select name="operator" id="operator" class="form-control">
                            <option value="True" @if($stock->operator == 'True') selected @endif>True</option>
                            <option value="AIS" @if($stock->operator == 'AIS') selected @endif>AIS</option>
                            <option value="DTAC" @if($stock->operator == 'DTAC') selected @endif>DTAC</option>
                            <option value="myByCAT" @if($stock->operator == 'myByCAT') selected @endif>myByCAT</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">IMEI</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="unit_id" name="unit_id" placeholder="IMEI" value="{{$stock->unit_id}}">
                        </div>
                    <label for="name" class="col-sm-1 control-label">GPS รุ่น</label>
                    <div class="col-sm-4">
                        <select name="gps_model" id="gps_model" class="form-control">
                            {{--<option value="AW-GPS-3G" @if($stock->gps_model == 'alv05') selected @endif>AVL05</option>--}}
                            {{--<option value="at072g" @if($stock->gps_model == 'at072g') selected @endif>AT07-2G</option>--}}
                            {{--<option value="at073g" @if($stock->gps_model == 'at073g') selected @endif>AT07-3G</option>--}}
                            {{--<option value="t1" @if($stock->gps_model == 't1') selected @endif>T1</option>--}}
                            {{--<option value="t333" @if($stock->gps_model == 't333') selected @endif>T333</option>--}}
                            {{--<option value="gt06" @if($stock->gps_model == 'gt06') selected @endif>GT06E</option>--}}


                            <option value="AW-GPS-3G" @if($stock->gps_model == 'AW-GPS-3G') selected @endif>AW-GPS-3G</option>
                            <option value="ET800D-3G" @if($stock->gps_model == 'ET800D-3G') selected @endif>ET800D-3G</option>
                            <option value="ET800M" @if($stock->gps_model == 'ET800M') selected @endif>ET800M</option>
                            <option value="TS107" @if($stock->gps_model == 'TS107') selected @endif>TS107</option>
                            <option value="TS1073G" @if($stock->gps_model == 'TS1073G') selected @endif>TS1073G</option>
                            <option value="T-333" @if($stock->gps_model == 'T-333') selected @endif>T1</option>
                            <option value="T-333" @if($stock->gps_model == 'T-333') selected @endif>T-333</option>
                            <option value="GT06E" @if($stock->gps_model == 'GT06E') selected @endif>GT06E</option>
                            <option value="VT900 T" @if($stock->gps_model == 'VT900 T') selected @endif>VT900 T</option>
                            <option value="TK116" @if($stock->gps_model == 'TK116') selected @endif>TK116</option>
                            <option value="LK210"@if($stock->gps_model == 'LK210') selected @endif>LK210</option>
                            <option value="GV20"@if($stock->gps_model == 'GV20') selected @endif>GV20</option>
                        </select>
                    </div>

                </div>

                {{--<div class="form-group">--}}
                    {{--<label for="content" class="col-sm-2 control-label">DLT ชนิดอุปกรณ์</label>--}}
                    {{--<div class="col-sm-4">--}}
                        {{--<input type="text" class="form-control" name="dlt_type" placeholder="DLT ชนิดอุปกรณ์" value="{{$stock->dlt_type}}">--}}
                    {{--</div>--}}
                    {{--<label for="name" class="col-sm-2 control-label">DLT แบบ</label>--}}
                    {{--<div class="col-sm-4">--}}
                        {{--<input type="text" class="form-control" id="dlt_style" name="dlt_style" placeholder="DLT แบบ" value="{{$stock->dlt_style}}">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

            </form>

        </div><!-- /.box-body -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-danger" role="document">
            <form action="/device-stock/delete/{{$stock->id}}" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">กรุณายืนยันการทำรายการ</h4>
                </div>
                <div class="modal-body">
                    คุณ {{Auth::user()->name}} แน่ใจใช่ไหมว่าจะลบ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">ยืนยันการลบ</button>
                </div>
            </div>
            </form>
        </div>
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $('#make').select2();
        $('#operator').select2();
        $('#gps_model').select2();
        $('.alert').fadeOut(7000);
    </script>
@endsection