@extends('adminlte::page')

@push('css-head')
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-link"></i> เชื่อมโยงรถกับ อุปกรณ์ GPS เข้ากับรถทะเบียน {{$dlt_car->register_name}}
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-12 invoice-col">

                <form id="address" class="form-horizontal" role="form" method="POST" action="/gps/assign/{{$dlt_car->id}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />


                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">GPS IMEI</label>
                        <div class="col-sm-4">
                            <select name="unit_id" id="unit_id" class="form-control">
                                @foreach($devices as $device)
                                    <option value="{{$device->id}}">{{$device->unit_id}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="register_date" class="col-sm-1 control-label">วันที่ติดตั้ง</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" name="install_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-2">
                            <button type="submit" class="btn btn-success form-control">บันทึกข้อมูล</button>
                        </div>
                    </div>

                    <input type="hidden" name="userID" value="{{Request::get('cid')}}" />

                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->

@if(count($assigned)> 0)
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <a href="/sale/show/{{Request::get('cid')}}"><button class="btn btn-success btn-sm pull-right">กลับหน้าข้อมูลลูกค้า</button></a>
                    <i class="fa fa-link"></i> รายการ IMEI(s) ที่เชื่อมโยง
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-12 invoice-col">

                <table id="ticket" class="table table-striped table-responsive">
                    <thead>
                    <tr>
                        {{--<th class="text-center">ID</th>--}}
                        <th class="text-center">ID</th>
                        {{--<th class="text-center">User</th>--}}
                        <th class="text-center">IMEI</th>
                        <th class="text-center">Phone no</th>
                        <th class="text-center">Operator</th>
                        <th class="text-center">ผู้ผลิต</th>
                        <th class="text-center">รุ่น</th>
                        <th class="text-center">DLT ชนิด</th>
                        <th class="text-center">DLT แบบ</th>
                        <th class="text-center">ผู้นำเข้า</th>
                        <th class="text-center">เพิ่มเมื่อ</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assigned as $index => $st)

                        <tr>
                            <td class="text-center">{{$index+1}}</td>
                            <td class="text-center">{{$st->unit_id}}</td>
                            <td class="text-center">{{$st->phone_number}}</td>
                            <td class="text-center">{{$st->operator}}</td>
                            <td class="text-center"> {{$st->make}}</td>
                            <td class="text-center">{{$st->gps_model}}</td>
                            <td class="text-center">{{$st->dlt_type}}</td>
                            <td class="text-center">{{$st->dlt_style}}</td>
                            <td class="text-center">{{$st->who_add}}</td>
                            <td class="text-center">{{\Carbon\Carbon::parse($st->created_at)->format('d/m/y H:m')}}</td>
                            <td class="text-center">
                                <form action="/gps/un-assign" method="post">
                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    <input type="hidden" name="stock_id" value="{{$st->id}}" />
                                    <input type="hidden" name="car_id" value="{{$dlt_car->id}}" />
                                    <input type="hidden" name="userID" value="{{Request::get('cid')}}" />
                                    <button type="submit" class="btn btn-danger btn-sm">ลบรายการนี้</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endif


@stop

@push('js-footer')

@endpush


@section('scripts')

    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
    <script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>

    <script>
        $('#unit_id').select2();
		//Date picker
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayBtn: true,
			language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
			thaiyear: true              //Set เป็นปี พ.ศ.
		}).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    </script>
@endsection