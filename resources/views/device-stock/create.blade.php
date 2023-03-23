@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            {{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>--}}
            <h3 class="box-title">เพิ่ม Stock</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <form id="address" class="form-horizontal" role="form" method="POST" action="/device-stock" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">IMEI</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="unit_id" name="unit_id" placeholder="IMEI">
                        </div>
                    <label for="name" class="col-sm-1 control-label">GPS รุ่น</label>
                    <div class="col-sm-4">
                        <select name="gps_model" id="gps_model" class="form-control">
                            <option value="AW-GPS-3G">AW-GPS-3G</option>
                            <option value="ET800D-3G">ET800D-3G</option>
                            <option value="ET800M">ET800M</option>
                            <option value="TS107">TS107</option>
                            <option value="TS1073G">TS1073G</option>
                            <option value="T-333">T1</option>
                            <option value="T-333">T-333</option>
                            <option value="GT06E">GT06E</option>
                            <option value="VT900">VT900 T</option>
                            <option value="TK116">TK116</option>
                            <option value="LK210">LK210</option>
                            <option value="GV20">GV20</option>
                            <option value="ST901">ST901</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                   
                    <label for="content" class="col-sm-2 control-label">Phone number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="phone_number" placeholder="Phone number">
                    </div>
                    
                    <label for="content" class="col-sm-1 control-label">Operator</label>
                    <div class="col-sm-4">
                        <select name="operator" id="operator" class="form-control">
                            <option value="TRUE">TRUE</option>
                            <option value="AIS">AIS</option>
                            <option value="DTAC">DTAC</option>
                            <option value="myByCAT">myByCAT</option>
                        </select>
                    </div>
                </div>

                

                {{--<div class="form-group">--}}
                    {{--<label for="content" class="col-sm-2 control-label">DLT ชนิดอุปกรณ์</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="dlt_type" placeholder="DLT ชนิดอุปกรณ์">--}}
                    {{--</div>--}}
                    {{--<label for="name" class="col-sm-2 control-label">DLT แบบ</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" id="dlt_style" name="dlt_style" placeholder="DLT แบบ">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

            </form>

        </div><!-- /.box-body -->
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