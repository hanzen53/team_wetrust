@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>
            <h3 class="box-title">เพิ่มลูกค้าใหม่</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <form class="form-horizontal" role="form" method="POST" action="/sale/update/{{$customer->id}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">ชื่อลูกค้า</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อลูกค้า" value="{{$customer->name}}">
                    </div>
                    <label for="content" class="col-sm-2 control-label">ชื่อผู้ประกอบการ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="business_name" placeholder="ชื่อผู้ประกอบการ" value="{{$customer->business_name}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="โทรศัพท์" value="{{$customer->tel}}">
                    </div>
                    <label for="content" class="col-sm-2 control-label">วันนัดหมายติดตั้ง</label>
                    <div class="col-sm-4">
                        <p>
                            <input type="date" class="form-control" name="booking_install_date" value="{{$customer->booking_install_date}}">
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="birthday" class="col-sm-2 control-label">วันเกิด</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="วันเกิด" value="{{$customer->birthday}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">ประเภทรถ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="car_type" name="car_type" placeholder="ประเภทรถ" value="{{$customer->car_type}}">
                    </div>
                    <label for="name" class="col-sm-2 control-label">จำนวน</label>
                    <div class="col-sm-4">
                        <input type="number" min="0" class="form-control" id="quantity" name="quantity" placeholder="จำนวน" value="{{$customer->quantity}}">
                    </div>
                </div>


                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">เอกสารประกอบ</h3>
                        <div class="box-tools pull-right">
                            <lable class="control-label pull-right">@if($customer->id_card == '') <i class="fa fa-eye text-red" aria-hidden="true"></i> ยังไม่ได้ upload file @else
                                    <a href="{{asset($customer->id_card)}}" target="_blank"><i class="fa fa-eye text-green" aria-hidden="true"></i> ดูไฟล์ </a>@endif</lable>
                            {{--<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>--}}
                            {{--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>--}}
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">สำเนาบัตรประชาชน / เอกสารจัดบริษัท </label>
                            <div class="col-sm-10">
                                <p>
                                    <input type="file" class="form-control" name="id_card" value="{{$customer->id_card}}">
                                </p>
                            </div>

                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->



                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">หมายเหตุ / ข้อมูลเพิ่มเติม</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="note" id="sale_note" cols="30" rows="3">{{$customer->note}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">ลูกค้า Confirm</label>
                    <div class="col-sm-10">
                        <input type="radio" class="radio-inline" name="confirm_order_status" @if($customer->confirm_order_status == 1) checked @endif value="1"> ลูกค้าตกลงซื้อ (CF)
                        <input type="radio" class="radio-inline" name="confirm_order_status" @if($customer->confirm_order_status == 0) checked @endif value="0"> ส่งใบเสนอราคาก่อน
                    </div>
                </div>

                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

            </form>

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection