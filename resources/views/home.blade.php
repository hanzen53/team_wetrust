@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">แก้ไขเร่งด่วน</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <div class="row">
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ number_format(count($unkonwOwner)) }}</h3>
        
                      <p>IMEI ที่ยังรู้เจ้าของ</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="/unknow-owner" class="small-box-footer" target="_blank">จัดการ <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ number_format($tmp_device_un_use) }}</h3>
        
                      <p>IMEI ที่ยังไม่ได้ผูก (มีบน V3)</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="/device-stock-unused-run-on-v3" class="small-box-footer">จัดการ <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{ number_format($dlt_customer) }}</h3>
        
                      <p>รอยืนยันข้อมูลลูกค้า</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/confirm-customer" class="small-box-footer">จัดการ <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ number_format($device_canceled) }}</h3>
        
                      <p>ยืนยันการลบ IMEI</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="/device-canceled" class="small-box-footer">จัดการ <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            
        </div><!-- /.box-body -->
    </div>
@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection