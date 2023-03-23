@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลการติดต่อและแจ้งปัญหา</h3>
        <div class="box-tools pull-right">
            <a href="/user/ticket/create/{{$user->id}}"><button type="button" class="btn btn-danger">แจ้งปัญหาใหม่</button></a>
        </div>
        
    </div><!-- /.box-header -->
    <div class="box-body">
        
        ชื่อลูกค้า : <strong>{{$user->name}}</strong><br>
        เบอร์โทรลูกค้า : <strong>{{$user->tel}}</strong><br>
        Login หน้าลูกค้า : <strong><a href="http://center.wetrustgps.com/remote-login/{{$user->id}}" target="_blank">{{$user->username}}</a></strong>
        
        @if(count($tickets)>0)
        <hr>
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">ข้อมูลที่พบ</h3>
            </div><!-- /.box-header -->
            <table id="ticket" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ทะเบียนรถ</th>
                        <th>เรื่อง</th>
                        <th>สถานะ</th>
                        <th>วันที่แจ้ง</th>
                        <th>ดูข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <th scope="row">{{$ticket->id}}</th>
                        <th>{{$ticket->car_license}}</th>
                        <td>{{$ticket->subject}}</td>
                        <td>
                            @if($ticket->status == 'S01')
                            <span class="label label-danger">เปิด</span>
                            @elseif($ticket->status == 'S02')
                            <span class="label label-primary">กำลังดำเนินการ</span>
                            @elseif($ticket->status == 'S03')
                            <span class="label label-success">ปิด</span>
                            @endif
                        </td>
                        <td> {{$ticket->created_at}}</td>
                        <td> <a href="/user/ticket/detail/{{$ticket->id}}"><button type="button" class="btn btn-success">ตรวจสอบข้อมูล</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <hr>
        <div class="box box-primary hidden-print">
            <div class="box-header with-border">
                <h3 class="box-title">ยังไม่มีข้อมูลการแจ้งปัญหาของลูกค้ารายนี้</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <a href="/user/ticket/create/{{$user->id}}"><button type="button" class="btn btn-danger">แจ้งปัญหาใหม่</button></a>
            </div><!-- /.box-body -->
        </div>
        @endif
        
      
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">รถที่เกี่ยวข้อง</h3>
            </div><!-- /.box-header -->
            <table id="ticket" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IMEI</th>
                        <th>สถานะ</th>
                        <th>ทะเบียน</th>
                        <th>Chassi</th>
                        <th>ยี่ห้อ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                    <tr>
                        <th>{{$car['id']}}</th>
                        <th>{{$car['unit_id']}}</th>
                        <td>{{$car['register_name']}}</td>
                        <td>{{$car['register_chassi']}}</td>
                        <td>{{$car['register_make']}}</td>                               
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div><!-- /.box-body -->
</div>




@stop

@push('js-footer')

@endpush


@section('scripts')
<script>
    $(document).ready(function(){
        $('#devices').DataTable();
    });
</script>
@endsection