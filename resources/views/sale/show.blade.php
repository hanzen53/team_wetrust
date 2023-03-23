@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
<link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
@stop

@section('content')

@if($customer->status == 0)
<div class="pad margin no-print">
    <div class="callout callout-danger" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        ลูกคค้ายกเลิก
    </div>
</div>
@endif

<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-user"></i> ข้อมูลลูกค้า <a href="/sale/update/{{$customer->id}}">(แก้ไขข้อมูลลูกค้า)</a>
                <small class="pull-right">วันที่ลงข้อมูล {{$customer->created_at}}</small>
                
            </h2>
            
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-7 invoice-col">
            
            <address>
                <strong>{{$customer->name}}</strong><br>
                {{-- ชื่อผู้ประกอบการ : {{$customer->business_name}}<br> --}}
                โทรศัพท์: {{$customer->tel}}<br>
                ที่อยู่ : {{$customer->address_one}} {{$customer->address_auto}}<br>
                Line ID : <strong>{{$customer->line_id}} </strong><br>
                ตัวแทน : <strong>{{$customer->agent_name}} </strong><br>
                
            </address>
            <p>
                Username: {{$customer->username}}<br>
                Password: {{$customer->password}}<br>
                Login หน้าลูกค้า : <strong><a href="http://center.wetrustgps.com/remote-login/{{$customer->user_login_id}}" target="_blank">{{$customer->username}}</a></strong><br>
                ออก Invoice / หนังสือแจ้ง : <strong><a href="/sale/user-invoice/{{$customer->id}}" target="_blank">{{$customer->username}}</a></strong>
            </p>
        </div>
        <!-- /.col -->
        <div class="col-sm-5 invoice-col">
            
            <address>
                ข้อมูลการติดต่อเพิ้มเติม : <br>
                ชื่อผู้ติดต่อ 1 : {{$customer->name_1}} โทรศัพท์ : {{$customer->tel_1}}<br>
                ชื่อผู้ติดต่อ 2 : {{$customer->name_2}} โทรศัพท์ : {{$customer->tel_2}}<br>
                ชื่อผู้ติดต่อ 3 : {{$customer->name_3}} โทรศัพท์ : {{$customer->tel_3}}<br>
            </address>
            
            @if($customer->id_card == '') 
                <i class="fa fa-eye text-red" aria-hidden="true"></i> ยังไม่ได้ upload file 
            @else
                <h4>บัตรประชาชน/เอกสารบริษัท :</h4>  <a href="{{asset($customer->id_card)}}" target="_blank"><i class="fa fa-eye text-green fa-2" aria-hidden="true"></i> ดูไฟล์ </a>
            @endif
            
        </div>
    </div>
    <!-- /.row -->
    
</section>
<!-- /.content -->
@if($customer->confirm == 0)
<section class="invoice">
    <div class="row">
        
        <a href="#" data-toggle="modal" data-target="#cs-{{$customer->id}}"><button type="link" class="btn btn-success btn-lg btn-block">ยืนยันข้อมูล</button></a>
        
    </div>
</section>
@endif

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-car"></i> ข้อมูลรถ
                <a href="/assign-devices/{{$customer->id}}/{{$customer->user_login_id}}"><button class="btn btn-success" type="link">Update การโยนรถ</button></a>
                <span class="pull-right"><a href="/dlt-car-add/{{$customer->id}}"><i class="fa fa-plus"></i> เพิ่มรถ </a> </span>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    
    
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col">
            
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table id="cars" class="table table-striped">
                        <thead>
                            <tr>
                                
                                <th>ID</th>
                                <th>GPS IMEI</th>
                                <th>เบอร์ SIM</th>
                                <th>วันที่ติดตั้ง</th>
                                <th>ทะเบียน</th>
                                <th>หมายเลขตัวถังรถ</th>
                                <th>จังหวัด</th>
                                <th>ยี่ห้อ</th>
                                <th>เพิ่ม GPS</th>
                                <th>Master file</th>
                                <th>ออกหนังสือ</th>
                                <th>สร้างรถบน API</th>
                                <th>ดูข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if($cars)
                            
                            @foreach($cars as $indexKey => $car)
                            <tr>
                                
                                <td class="align-middle text-center">{{$indexKey+1}}</td>
                                <td class="align-middle text-center">{{@$car['unit_id']}}</td>
                                <td class="align-middle text-center">{{@$car['tel']}}</td>
                                <td class="align-middle text-center">{{@$car['install_date']}}</td>
                                <td class="align-middle text-center">{{$car['register_name']}}</td>
                                <td class="align-middle text-center">{{$car['register_chassi']}}</td>
                                <td class="align-middle text-center">{{$car['register_province']}}</td>
                                <td class="align-middle text-center">{{$car['register_make']}}</td>
                                <td class="align-middle text-center">
                                    <a href="/gps/assign/{{$car['id']}}?cid={{$customer->id}}"><i class="fa fa-plus text-white fa-2" aria-hidden="true"></i></a>
                                </td>
                                <td class="align-middle text-center"> <a href="#" data-toggle="modal" data-target="#modal-{{@$car['unit_id']}}"><i class="fa fa-compress fa-2" aria-hidden="true"></i></a></td>
                                <td class="align-middle text-center">
                                    <a href="/dlt/certificate/{{$car['id']}}"><i class="fa fa-file-o fa-2" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="ไม่มีลายเซ็นต์"></i></a>
                                    <a href="/dlt/certificate/{{$car['id']}}?sign=1"><i class="fa fa-file-word-o fa-2" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="มีลายเซ็นต์"></i></a>
                                    <a href="/scan-me/{{$car['id']}}"><i class="fa fa-qrcode fa-2" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="QR scan me"></i></a>
                                </td>
                                <td class="align-middle text-center"> <a href="#" data-toggle="modal" data-target="#modal-create-api-{{@$car['unit_id']}}"><i class="fa fa-car fa-2" aria-hidden="true"></i></a></td>
                                <td class="align-middle text-center"><a href="/dlt-car-show/{{$car['id']}}"><i class="fa fa-eye fa-2" aria-hidden="true"></i></a></td>
                                <td class="align-middle text-center"><a href="/sale/delete/{{$car['id']}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>
                            </tr>
                            <!-- create master file -->
                            <div class="modal fade" id="modal-{{@$car['unit_id']}}">
                                <form action="/post-master-file" method="post">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">สร้าง Master file</h4>
                                                    
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <h4 class="text-center">กดส่งข้อมูลเพื่อยืนยันการสร้าง Master file ทะเบียน {{$car['register_name']}}</h4>
                                                    
                                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                    <input type="hidden"  id="unit_id" name="unit_id" value="{{$car['id']}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-primary">ส่งข้อมูล</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal -->
                                
                                <!-- create car file -->
                                <div class="modal fade" id="modal-create-api-{{@$car['unit_id']}}">
                                    <form action="/create-car-on-api" method="post">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">สร้างรถบน API server</h4>
                                                        
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <h4 class="text-center">กดส่งข้อมูลเพื่อยืนยันการสร้างรถบน API server ทะเบียน {{$car['register_name']}} </h4>
                                                        
                                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                        <input type="hidden"  id="imei" name="imei" value="{{@$car['unit_id']}}">
                                                        <input type="hidden"  id="name" name="name" value="{{@$car['register_name']}}">
                                                        <input type="hidden"  id="tel" name="tel" value="{{@$car['tel']}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">ส่งข้อมูล</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    @endforeach
                                    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                        
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </section>
        
        
        <section class="invoice">
            
            <h2 class="page-header">
                <i class="fa fa-users"></i> ข้อ user ที่ดูรถ
                
                <span class="pull-right"><a href="#" data-toggle="modal" data-target="#add-user"><i class="fa fa-plus"></i> เพิ่ม user </a> </span>
            </h2>
            
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table id="cars" class="table table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th class="align-middle text-center">ID</th>
                                        <th class="align-middle text-center">Username</th>
                                        <th class="align-middle text-center">ชื่อ</th>
                                        <th class="align-middle text-center">เบอร์โทร</th>
                                        <th class="align-middle text-center">Line ID</th>
                                        <th class="align-middle text-center">Login</th>
                                        <th class="align-middle text-center">โยนรถ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if($loginUsers)
                                    
                                    @foreach($loginUsers as $indexKey => $user)
                                    <tr>
                                        <td class="align-middle text-center">{{$indexKey+1}}</td>
                                        <td class="align-middle text-center">{{$user->username}}</td>
                                        <td class="align-middle text-center">{{$user->name}}</td>
                                        <td class="align-middle text-center">{{$user->tel}}</td>
                                        <td class="align-middle text-center">{{$user->line}}</td>
                                        <td class="align-middle text-center"><a href="http://center.wetrustgps.com/remote-login/{{$user->id}}" target="_blank">{{$user->username}}</a></td>
                                    <td class="align-middle text-center"><a href="/parent-user-assign-car/{{$customer->id}}?sub-user={{$user->id}}" target="_blank">โยนรถ</a></td>
                                        
                                    </tr>
                                    @endforeach
                                    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
        </section>    
        
        
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-picture-o"></i> ภาพที่เกี่ยวข้อง
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            @foreach($images as $indexKey => $img)
                            <div class="row">
                                <div class="col-sm-1">{{$indexKey+1}}</div>
                                <div class="col-sm-2"><a href="{{url($img->path)}}" target="_blank"><img src="{{asset($img->path)}}" alt="" width="80" height="80"></a></div>
                                <div class="col-sm-6">{{$img->path}}</div>
                                <div class="col-sm-2">{{$img->created_at}}</div>
                                <div class="col-sm-1"><a href="/delete-data/{{$img->id}}" style="color : red">ลบภาพ</a></div>
                            </div>
                            <hr>
                            @endforeach
                            
                            <hr>
                            
                            <form id="my-awesome-dropzone" action="/upload-data" class="dropzone" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="dz-message">
                                    <div class="icon"><span class="s7-cloud-upload"></span></div>
                                    <h2>ลากไฟล์ภาพลงที่นี้ หรือ คลิกที่ นี่</h2><span class="note">(สามารถเลือกได้หลายๆไฟล์พร้อมๆกัน)</span>
                                </div>
                                <input type="hidden" name="imei" value="kokarat">
                                <input type="hidden" name="who_upload" value="{{Auth::user()->id}}">
                                <input type="hidden" name="prefix" value="{{$customer->id}}">
                                <input type="hidden" name="save_to_path" value="dlt-cars">
                            </form>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.row -->
            
        </section>
        <!-- /.content -->
       
       
        <section class="invoice">
                <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-book"></i> บันทึก Notes
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                <div class="panel with-nav-tabs">
                        <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1primary" data-toggle="tab">ทั่วไป</a></li>
                                    <li><a href="#tab2primary" data-toggle="tab">ติดตามทวงหนี้</a></li>
                                    <li><a href="#tab3primary" data-toggle="tab">แก้ไขปัญหา</a></li>
                                    <li><a href="#tab4primary" data-toggle="tab">ประวัติการติดต่อ</a></li>
                                    <li><a href="#tab5primary" data-toggle="tab">ประวัติการเติมเงิน</a></li>
                                    
                                </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1primary">
                                        @if(count($notes)>0)
                                        <div class="">
                                            <div class="box-body">
                                                <div class="direct-chat-messages">
                                                    @foreach($notes as $note)
                                                        @if($note['note_type'] == 1)
                                                        <h4>{{$note['note_created_at']}}</h4>
                                                        <div class="direct-chat-msg @if($note['who_note']->id == Auth::user()->id) right  @endif">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name  @if($note['who_note']->id != Auth::user()->id) pull-left @else pull-right @endif"> {{$note['who_note']->name}} </span>
                                                            </div><!-- /.direct-chat-info -->
                                                            <img class="direct-chat-img" src="{{asset('uploads/'.$note['who_note']->avatar)}}" alt="message user image"><!-- /.direct-chat-img -->
                                                            <div class="direct-chat-text">
                                                                {!! $note['note_content'] !!}
                                                                <p><small >{{$note['note_created_at']}}</small></p>
                                                            </div><!-- /.direct-chat-text -->
                                                        </div><!-- /.direct-chat-msg -->
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                        </div>
                                        @endif
                                </div>
                                <div class="tab-pane fade" id="tab2primary">
                                        @if(count($notes)>0)
                                        <div class="">
                                            <div class="box-body">
                                                <div class="direct-chat-messages">
                                                    @foreach($notes as $note)
                                                        @if($note['note_type'] == 2)
                                                        <h4>{{$note['note_created_at']}}</h4>
                                                        <div class="direct-chat-msg @if($note['who_note']->id == Auth::user()->id) right  @endif">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name  @if($note['who_note']->id != Auth::user()->id) pull-left @else pull-right @endif"> {{$note['who_note']->name}} </span>
                                                            </div><!-- /.direct-chat-info -->
                                                            <img class="direct-chat-img" src="{{asset('uploads/'.$note['who_note']->avatar)}}" alt="message user image"><!-- /.direct-chat-img -->
                                                            <div class="direct-chat-text">
                                                                {!! $note['note_content'] !!}
                                                                <p><small>{{$note['note_created_at']}}</small></p>
                                                            </div><!-- /.direct-chat-text -->
                                                        </div><!-- /.direct-chat-msg -->
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                        </div>
                                        @endif
                                </div>
                                <div class="tab-pane fade" id="tab3primary">
                                        @if(count($notes)>0)
                                        <div class="">
                                            <div class="box-body">
                                                <div class="direct-chat-messages">
                                                    @foreach($notes as $note)
                                                        @if($note['note_type'] == 3)
                                                        <h4>{{$note['note_created_at']}}</h4>
                                                        <div class="direct-chat-msg @if($note['who_note']->id == Auth::user()->id) right  @endif">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name  @if($note['who_note']->id != Auth::user()->id) pull-left @else pull-right @endif"> {{$note['who_note']->name}} </span>
                                                            </div><!-- /.direct-chat-info -->
                                                            <img class="direct-chat-img" src="{{asset('uploads/'.$note['who_note']->avatar)}}" alt="message user image"><!-- /.direct-chat-img -->
                                                            <div class="direct-chat-text">
                                                                {!! $note['note_content'] !!}
                                                                <p><small>{{$note['note_created_at']}}</small></p>
                                                            </div><!-- /.direct-chat-text -->
                                                        </div><!-- /.direct-chat-msg -->
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                        </div>
                                        @endif
                                </div>
                                <div class="tab-pane fade" id="tab4primary">
                                        @if(count($notes)>0)
                                        <div class="">
                                            <div class="box-body">
                                                <div class="direct-chat-messages">
                                                    @foreach($notes as $note)
                                                        @if($note['note_type'] == 4)
                                                        <h4>{{$note['note_created_at']}}</h4>
                                                        <div class="direct-chat-msg @if($note['who_note']->id == Auth::user()->id) right  @endif">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name  @if($note['who_note']->id != Auth::user()->id) pull-left @else pull-right @endif"> {{$note['who_note']->name}} </span>
                                                            </div><!-- /.direct-chat-info -->
                                                            <img class="direct-chat-img" src="{{asset('uploads/'.$note['who_note']->avatar)}}" alt="message user image"><!-- /.direct-chat-img -->
                                                            <div class="direct-chat-text">
                                                                {!! $note['note_content'] !!}
                                                              
                                                            </div><!-- /.direct-chat-text -->
                                                        </div><!-- /.direct-chat-msg -->
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                        </div>
                                        @endif
                                </div>
                                <div class="tab-pane fade" id="tab5primary">
                                        @if(count($notes)>0)
                                        <div class="">
                                            <div class="box-body">
                                                <div class="direct-chat-messages">
                                                    @foreach($notes as $note)
                                                        @if($note['note_type'] == 5)
                                                        <h4>{{$note['note_created_at']}}</h4>
                                                        <div class="direct-chat-msg @if($note['who_note']->id == Auth::user()->id) right  @endif">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name  @if($note['who_note']->id != Auth::user()->id) pull-left @else pull-right @endif"> {{$note['who_note']->name}} </span>
                                                            </div><!-- /.direct-chat-info -->
                                                            <img class="direct-chat-img" src="{{asset('uploads/'.$note['who_note']->avatar)}}" alt="message user image"><!-- /.direct-chat-img -->
                                                            <div class="direct-chat-text">
                                                                {!! $note['note_content'] !!}
                                                                <p><small>{{$note['note_created_at']}}</small></p>
                                                            </div><!-- /.direct-chat-text -->
                                                        </div><!-- /.direct-chat-msg -->
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
        </section>


        <section class="invoice">
            <div class="row">
 
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-sticky-note-o"></i> Note
                    </h2>
                    
                    <form action="/dlt-customer-note" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                                <div class="">
                                    <select name="type" id="type" class="form-control">
                                        <option value="1">ทั่วไป</option>
                                        <option value="2">ติดตามทวงหนี้</option>
                                        <option value="3">แก้ไขปัญหา</option>
                                        <option value="4">การติดต่อ</option>
                                        <option value="5">การเติมเงิน</option>
                                    </select>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="">
                                <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="customer_id" value="{{$customer->id}}">
                        <div class="form-group">
                            <button class="btn btn-success pull-right" type="submit">ส่งข้อมูล</button>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            
            
            
            <!-- Modal -->
            <div class="modal fade" id="cs-{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <form action="/confirm-customer" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">ยืนยันข้อมูลลูกค้า </h4>
                            </div>
                            <div class="modal-body">
                                
                                กรุณาตรวจสอบข้อมูลให้ครบถ้วนการบันทึกข้อมูลจะบันทึก <h1>{{Request::user()->name}} </h1>ว่าเป็นผู้ยืนยันข้อมูล
                                <input type="hidden" value="{{$customer->id}}" name="customer_id">
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </section>

        
        <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form action="/create-user/parent/{{$customer->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">เพิ่ม User ดูรถ </h4>
                        </div>
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="username" value="">
                            </div>
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">ชื่อที่แสดง</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อที่แสดง" value="">
                            </div>
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">email</label>
                                <input type="text" class="form-control" name="email" id="username" placeholder="email" value="">
                            </div>
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">โทรศัพท์</label>
                                <input type="text" class="form-control" name="tel" id="tel" placeholder="โทรศัพท์" value="">
                            </div>
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">Line ID</label>
                                <input type="text" class="form-control" name="line" id="line" placeholder="Line ID" value="">
                            </div>
                            <div class="form-group">
                                <label for="customer_code" class="pull-left">Password</label>
                                <input type="text" class="form-control" name="password" id="tel" placeholder="Password" value="">
                            </div>
                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        
        @stop
        
        @push('js-footer')
        
        @endpush
        
        
        @section('scripts')
        <script src="{{secure_asset('js/tinymce/tinymce.min.js')}}"></script>
        <script>
            $(document).ready( function () {
                // $('#cars').DataTable();
            } );
        </script>
        
        
        <script>
            tinymce.init({
                selector: 'textarea',
                height: 120,
                theme: 'modern',
                plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak']
            });
        </script>
        @endsection