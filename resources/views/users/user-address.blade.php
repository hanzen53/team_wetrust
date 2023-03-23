@extends('adminlte::page')

@section('css')
	<link rel="stylesheet" href="{{secure_asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
	<link rel="stylesheet" href="{{secure_asset('css/app.css')}}">
	{{--<link rel="stylesheet" href="{{secure_asset('vendor/fullcalendar/dist/fullcalendar.print.css')}}">--}}
@stop

@section('title', 'Address')

@section('content_header')

@stop

@section('content')
	<div class="container" id="app">
		<div class="panel panel-default">
			<div class="panel-heading">
				เพิ่มที่อยู่
			</div>
			<div class="panel-body">
				<form  class="form-horizontal" action="/user/address/create" method="post" enctype="multipart/form-data">
					@csrf

					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">ชื่อ/บริษัท/หน่วยงาน</label>
						<div class="col-sm-4">
							<input name="full_name" class="form-control" type="text" value="{{old('full_name')}}">
						</div>
					</div>

					<div class="form-group">
						<label for="search" class="col-sm-2 control-label">ค้นที่อยู่</label>
						<div class="col-sm-6">
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
						<label for="name" class="col-sm-2 control-label">หมายเลขโทรศัพท์</label>
						<div class="col-sm-4">
							<input name="tel" class="form-control" type="text" value="{{old('tel')}}">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-4">
							<input name="email" class="form-control" type="email" value="{{old('email')}}">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">หมายเลขผู้เสียภาษี</label>
						<div class="col-sm-4">
							<input name="tax_number" class="form-control" type="text" value="{{old('tax_number')}}">
						</div>
					</div>

					<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

				</form>
			</div>
		</div>



		@foreach($userAddress as $userAdd)
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="#" data-toggle="modal" data-target="#remove_address-{{$userAdd->id}}"><i class="fa fa-trash-o text-red fa-2x" aria-hidden="true"></i></a></span>
					ที่อยู่ทั้งหมด
				</div>
				<div class="panel-body">
					<span>ชื่อ/บริษัท/หน่วยงาน: {{$userAdd->full_name}}</span><br>
					<span>ชืเลขที่ตั้ง ,ซอย , ถนน: {{$userAdd->address_one}}</span><br>
					<span>{{$userAdd->address_auto}}</span><br>
					<span>โทร: {{$userAdd->tel}}</span><br>
					<span>Email: {{$userAdd->email}}</span><br>
					<span>หมายเลขผู้เสียภาษี: {{$userAdd->tax_number}}</span><br>
				</div>
			</div>


			<!-- Modal -->
			<div class="modal fade" id="remove_address-{{$userAdd->id}}" tabindex="-1" role="dialog" aria-labelledby="remove_address-{{$userAdd->id}}">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="remove_address-{{$userAdd->id}}">ยืนยันการลบ</h4>
						</div>
						{{--<form action="/booking-option-remove/{{$equ['item_id']}}" method="POST">--}}
						{{--@csrf--}}
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<span>ชื่อ/บริษัท/หน่วยงาน: {{$userAdd->full_name}}</span><br>
									<span>ชืเลขที่ตั้ง ,ซอย , ถนน: {{$userAdd->address_one}}</span><br>
									<span>{{$userAdd->address_auto}}</span><br>
									<span>โทร: {{$userAdd->tel}}</span><br>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
							<a href="/user/address/delete/{{$userAdd->id}}"><button type="submit" class="btn btn-danger">ยืนยันการลบ</button></a>
						</div>
						{{--</form>--}}
					</div>
				</div>
			</div>
		@endforeach


	</div>



@stop

@section('js')
	<script src="{{secure_asset('js/moment/min/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
	<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
	<script type="text/javascript" src="{{secure_asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<script>
		$.Thailand({
			database: '/js/jquery.Thailand.js/database/db.json',

			onDataFill: function(data){
				console.info('Data Filled', data);
				var html =  'ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
//                $('#addressAuto').prepend('<div class="alert alert-success">' + html + '</div>');
				$('input[name="address_auto"]').val(html)
			},


			$search: $('.form-horizontal [name="search"]'),
			$name: $('.form-horizontal [name="name"]'),
		});

		$('.form-horizontal [name="search"]').change(function(){
			console.log('Search', this.value);
		});
	</script>

@stop