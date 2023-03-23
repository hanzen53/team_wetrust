@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ค้นหาข้อมูลลูกค้าจากทะเบียนรถ</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <form action="/crm/car-owner" method="GET" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="ทะเบียนรถ,IMEI" value="{{Request::get('q')}}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">ค้นหา</button>
                </span>
            </div><!-- /input-group -->
        </form>
        
        
        
    </div><!-- /.box-body -->
</div>


@if(count($dltCars)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลรถ DLT</h3>
    </div>
    <div class="box-body">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">ข้อมูลที่พบ</h3>
            </div><!-- /.box-header -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STOCK ID</th>
                        <th>IMEI</th>
                        <th>ทำเบียนรถ</th>
                        <th>ชื่อลูกค้า</th>
                        <th>เบอร์โทรลูกค้า</th>
                        <th>ดูข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dltCars as $car)
                    <tr>
                        
                        <th scope="row">{{$car['gps_stock_id']}}</th>
                        <td>{{$car['imei']}}</td>
                        <td>{{$car['name']}}</td>
                        <td>{{$car['customer_name']}}</td>
                        <td>{{$car['customer_tel']}}</td>
                        <td> <a href="/sale/show/{{$car['customer_id']}}"><button type="button" class="btn btn-success">ตรวจสอบข้อมูล</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif


@if(count($v3Cars)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลรถ V3</h3>
    </div>
    <div class="box-body">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">ข้อมูลที่พบ</h3>
            </div><!-- /.box-header -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IMEI</th>
                        <th>ทำเบียนรถ</th>
                        <th>ชื่อลูกค้า</th>
                        <th>เบอร์โทรลูกค้า</th>
                        <th>User Login V3</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($v3Cars as $car)
                    <tr>
                        
                        <th scope="row">{{$car['id']}}</th>
                        <td>{{$car['imei']}}</td>
                        <td>{{$car['name']}}</td>
                        <td>{{$car['customer_name']}}</td>
                        <td>{{$car['customer_tel']}}</td>
                        <td> <strong><a href="http://center.wetrustgps.com/remote-login/{{$car['customer_id']}}" target="_blank">{{$car['customer_name']}}</a></strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection