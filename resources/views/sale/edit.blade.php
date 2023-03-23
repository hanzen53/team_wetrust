@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
<link rel="stylesheet" href="{{secure_asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('css/datepicker.css')}}">
@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>
        <h3 class="box-title">แก้ไขลูกค้า</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        
        <form id="address" class="form-horizontal" role="form" method="POST" action="/sale/update/{{$customer->id}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ตัวแทน</label>
                <div class="col-sm-2">
                    <select name="agent_id" id="agent_id" class="form-control">
                        <option value="0" >เลือกตัวแทน</option>
                        @foreach($agents as $agent)
                        
                        <option value="{{$agent->id}}" @if($agent->id == $customer->agent_id) selected @endif>{{$agent->agent_name}}</option>
                        
                        @endforeach
                    </select>
                </div>
                <label for="name" class="col-sm-2 control-label">ช่องทางรับใบแจ้งหนี้</label>
                <div class="col-sm-2">
                    <select name="billing_channel" id="" class="form-control">
                        <option value="SMS" @if($customer->billing_channel == 'SMS') selected @endif>SMS</option>
                        <option value="LINE" @if($customer->billing_channel == 'LINE') selected @endif>LINE</option>
                        <option value="MAIL" @if($customer->billing_channel == 'MAIL') selected @endif>จดหมาย</option>
                        <option value="EMAIL" @if($customer->billing_channel == 'EMAIL') selected @endif>Email</option>
                    </select>
                </div>
                
            </div>
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ข้อมูล Login</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="username" name="username" value="{{$customer->username}}">
                </div>
                <label for="name" class="col-sm-1 control-label">Password</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="password" value="{{$customer->password}}">
                </div>
                <label for="name" class="col-sm-1 control-label">Email</label>
                <div class="col-sm-2">
                    <input type="email" class="form-control" name="email" value="{{$customer->email}}">
                </div>
            </div>
            
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Login V3</label>
                <div class="col-sm-4">
                    @if($customer->user_login_id != '' || $customer->user_login_id != 0 )
                    <select name="user_login_id" id="user_login_id" class="form-control">
                        @foreach($user_login as $user)
                        <option value="{{$user->id}}" @if($customer->user_login_id == $user->id) selected @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                    @else
                    <select name="user_login_id" id="user_login_id" class="form-control">
                        <option value="0"><span class="label label-danger">-- กรุณาเลือก user ที่เชื่อมโยง --</span></option>
                        @foreach($user_login as $user)
                        <option value="{{$user->id}}" @if($customer->user_login_id == $user->id) selected @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>
            
            
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ชื่อลูกค้า</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อลูกค้า" value="{{$customer->name}}">
                </div>
                <label for="content" class="col-sm-2 control-label">เลขบัตร/เลขผู้เสียภาษี</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="citizen_id" placeholder="หมายเลขบัตร/เลขผู้เสียภาษี" value="{{$customer->citizen_id}}">
                </div>
            </div>

            <div class="form-group">
  
                    
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="โทรศัพท์" value="{{$customer->tel}}">
                    </div>
                </div>
           
            <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 1</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name_1" name="name_1" placeholder="ชื่อลูกค้า" value="{{$customer->name_1}}">
                    </div>
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel_1" name="tel_1" placeholder="โทรศัพท์" value="{{$customer->tel_1}}">
                    </div>
                    
                </div>
                
                
                <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name_2" name="name_2" placeholder="ชื่อลูกค้า" value="{{$customer->name_2}}">
                        </div>
                        <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="tel_2" name="tel_2" placeholder="โทรศัพท์" value="{{$customer->tel_2}}">
                        </div>
                        
                    </div>
    
                <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name_3" name="name_3" placeholder="ชื่อลูกค้า" value="{{$customer->name_3}}">
                        </div>
                        <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="tel_3" name="tel_3" placeholder="โทรศัพท์" value="{{$customer->tel_3}}">
                        </div>
                        
                    </div>
                
                <div class="form-group">
                    <label for="line_id" class="col-sm-2 control-label">Line ID</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="line_id" name="line_id" placeholder="Line ID " value="{{$customer->line_id}}">
                    </div>
    
                </div>
            
            <div class="form-group">
                <label for="search" class="col-sm-2 control-label">ค้นที่อยู่</label>
                <div class="col-sm-10">
                    <input name="search" class="form-control" type="text" placeholder="กรอกอย่างใดอย่างหนึ่ง ตำบล, อำเภอ, จังหวัด หรือ รหัสไปรษณีย์">
                </div>
            </div>
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">เลขที่ตั้ง ,ซอย , ถนน</label>
                <div class="col-sm-4">
                    <input name="address_one" class="form-control" type="text" value="{{$customer->address_one}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                <div class="col-sm-10">
                    <input id="address_auto" class="form-control" type="text" name="address_auto" value="{{$customer->address_auto}}">
                </div>
            </div>
            
            
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">สำเนาบัตรประชาชน / เอกสารจัดบริษัท</label>
                <div class="col-sm-10">
                    <p>
                        <input type="file" class="form-control" name="id_card" value="">
                    </p>
                </div>
            </div>
            
            {{-- <div class="form-group">
                <label for="content" class="col-sm-2 control-label">ลูกค้า Confirm</label>
                <div class="col-sm-10">
                    <input type="radio" class="radio-inline" name="confirm_order_status" @if($customer->confirm_order_status == 1) checked @endif value="1"> ลูกค้าตกลงซื้อ (CF)
                    <input type="radio" class="radio-inline" name="confirm_order_status" @if($customer->confirm_order_status == 0) checked @endif value="0"> ส่งใบเสนอราคาก่อน
                </div>
            </div> --}}
            
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">หมายเหตุ / ข้อมูลเพิ่มเติม</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="note" id="note" cols="30" rows="3">{{$customer->note}}</textarea>
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

{{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="{{secure_asset('js/datepicker.js')}}"></script>
<script type="text/javascript" src="{{secure_asset('js/bootstrap-datepicker.th.min.js')}}"></script>
<script>
    $.Thailand({
        database: '/js/jquery.Thailand.js/database/db.json',
        
        
        //
        onDataFill: function(data){
            console.info('Data Filled', data);
            var html =  'ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
            //                $('#addressAuto').prepend('<div class="alert alert-success">' + html + '</div>');
            $('input[name="owner_address_auto"]').val(html);
            $('input[name="ownership_address_auto"]').val(html);
        },
        
        
        $search: $('#address [name="search"]'),
        $name: $('#address [name="name"]'),
    });
    
    
    $('#address [name="search"]').change(function(){
        console.log('Search', this.value);
    });
    
    $('#register_province').select2();
    $('#register_type').select2();
    $('#register_make').select2();
    $('#user_login_id').select2();
    
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayBtn: true,
        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        thaiyear: true              //Set เป็นปี พ.ศ.
    });  //กำหนดเป็นวันปัจุบัน
    
    $('div.alert').delay(5000).slideUp(700);
</script>
@endsection