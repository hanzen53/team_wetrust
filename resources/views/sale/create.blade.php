@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
<link rel="stylesheet" href="{{secure_asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('css/datepicker.css')}}">
@stop

@section('content')
@include('flash/error')
<div class="box box-solid box-primary">
    <div class="box-header">
        <span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>
        <h3 class="box-title">เพิ่มลูกค้าใหม่</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        
        <form id="address" class="form-horizontal" role="form" method="POST" action="/sale/create" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            
            
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="user_type" class="control-label text-danger">ประเภทของลูกค้า</label>
                    <select name="user_type" id="user_type" class="form-control select2">
                        <option value="new">ลูกค้าใหม่</option>
                        <option value="old">ลูกค้าที่มี user อยู่แล้ว</option>
                    </select>
                </div>
                
                <div class="col-sm-3">
                    <label for="name" class="control-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{Request::get('username')}}">
                </div>
                
                <div class="col-sm-3">
                    <label for="content" class="control-label">Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password" value="">
                </div>
                
                <div class="col-sm-3">
                    <label for="content" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{Request::get('email')}}">
                </div>
            </div>
            
            <hr>
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ชื่อลูกค้า</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อลูกค้า" value="{{Request::get('name')}}">
                </div>
                <label for="content" class="col-sm-2 control-label">เลขบัตร/เลขผู้เสียภาษี</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="citizen_id" placeholder="หมายเลขบัตร/เลขผู้เสียภาษี" value="{{old('citizen_id')}}">
                </div>
            </div>
            <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="โทรศัพท์" value="{{Request::get('tel')}}">
                    </div>
                </div>
            
            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 1</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name_1" name="name_1" placeholder="ชื่อลูกค้า" value="{{old('name_1')}}">
                </div>
                <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="tel_1" name="tel_1" placeholder="โทรศัพท์" value="{{old('tel_1')}}">
                </div>
                
            </div>
            
            
            <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 2</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name_2" name="name_2" placeholder="ชื่อลูกค้า" value="{{old('name_2')}}">
                    </div>
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel_2" name="tel_2" placeholder="โทรศัพท์" value="{{old('tel_2')}}">
                    </div>
                    
                </div>

            <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">ข้อมูลการติดต่อ 3</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name_3" name="name_3" placeholder="ชื่อลูกค้า" value="{{old('name_3')}}">
                    </div>
                    <label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tel_3" name="tel_3" placeholder="โทรศัพท์" value="{{old('tel_3')}}">
                    </div>
                    
                </div>
            
            <div class="form-group">
                <label for="line_id" class="col-sm-2 control-label">Line ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="line_id" name="line_id" placeholder="Line ID " value="{{Request::get('line_id')}}">
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
                    <input name="address_one" class="form-control" type="text" value="{{old('address_one')}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                <div class="col-sm-10">
                    <input id="address_auto" class="form-control" type="text" name="address_auto" value="{{old('address_auto')}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">สำเนาบัตรประชาชน / เอกสารจัดบริษัท</label>
                <div class="col-sm-10">
                    <p>
                        <input type="file" class="form-control" name="id_card" value="{{old('id_card')}}">
                    </p>
                </div>
            </div>
            
            {{-- <div class="form-group">
                <label for="content" class="col-sm-2 control-label">ลูกค้า Confirm</label>
                <div class="col-sm-10">
                    <input type="radio" class="radio-inline" name="confirm_order_status" value="1"> ลูกค้าตกลงซื้อ (CF)
                    <input type="radio" class="radio-inline" name="confirm_order_status" value="0"> ส่งใบเสนอราคาก่อน
                </div>
            </div> --}}
            
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">หมายเหตุ / ข้อมูลเพิ่มเติม</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
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
        
        onDataFill: function(data){
            console.info('Data Filled', data);
            var html =  'ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
            //                $('#addressAuto').prepend('<div class="alert alert-success">' + html + '</div>');
            $('input[name="address_auto"]').val(html)
        },
        
        
        $search: $('#address [name="search"]'),
        $name: $('#address [name="name"]'),
    });
    
    $('#address [name="search"]').change(function(){
        console.log('Search', this.value);
    });
    
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayBtn: true,
        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        thaiyear: true              //Set เป็นปี พ.ศ.
    }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
</script>
@endsection