@extends('theme-v2/common/master')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				ข้อมูลลูกค้า
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="breadcrumb-item active">ข้อมูลลูกค้า</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			@include('flash/error')
			<div class="row">
				<div class="col-12 ">
					<div class="box">
						{{--<div class="box-header with-border">--}}
							{{--<h3 class="box-title">เพิ่ม Stock</h3>--}}

							{{--<div class="box-tools pull-right">--}}
								{{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">--}}
									{{--<i class="fa fa-minus"></i></button>--}}
								{{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">--}}
									{{--<i class="fa fa-times"></i></button>--}}
							{{--</div>--}}
						{{--</div>--}}
						<div class="box-body">
							<div class="box">
								<form id="address" class="form-horizontal" role="form" method="POST" action="/sale/create" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />


									<div class="row">
										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="user_type" class="control-label text-danger">ประเภทของลูกค้า</label>
												<select name="user_type" id="user_type" class="form-control select2">
													<option value="new">ลูกค้าใหม่</option>
													<option value="old">ลูกค้าที่มี user อยู่แล้ว</option>
												</select>
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="name" class="control-label">Username</label>
												<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{old('username')}}">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->
										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="content" class="control-label">Password</label>
												<input type="text" class="form-control" name="password" placeholder="Password" value="">
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="content" class="control-label">Email</label>
												<input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->
									</div>


									<hr>

									<div class="row">
										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="name" class="control-label">ชื่อลูกค้า</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="ชื่อลูกค้า" value="{{old('name')}}">
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="name" class="control-label">ประเภทรถ</label>
												<input type="text" class="form-control" id="car_type" name="car_type" placeholder="ประเภทรถ" value="{{old('car_type')}}">
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="name" class="control-label">โทรศัพท์</label>
												<input type="text" class="form-control" id="tel" name="tel" placeholder="โทรศัพท์" value="{{old('tel')}}">
											</div>
											<div class="form-group">
												<label for="name" class="control-label">วันเกิดลูกค้า</label>
												<input type="text" class="form-control datepicker" id="birthday" name="birthday" placeholder="วันเกิด" value="{{old('birthday')}}">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->
										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="content" class="control-label">เลขบัตร/เลขผู้เสียภาษี</label>
												<input type="number" class="form-control" name="citizen_id" placeholder="หมายเลขบัตร/เลขผู้เสียภาษี" value="{{old('citizen_id')}}">
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="content" class="control-label">ชื่อผู้ประกอบการ</label>
												<input type="text" class="form-control" name="business_name" placeholder="ชื่อผู้ประกอบการ" value="{{old('business_name')}}">
											</div>
											<!-- /.form-group -->
											<div class="form-group">
												<label for="content" class="control-label">วันนัดติดตั้ง</label>
												<input type="text" class="form-control datepicker" name="booking_install_date" value="{{old('booking_install_date')}}">
											</div>
											<div class="form-group">

											</div>
										</div>
										<!-- /.col -->
									</div>

									<hr>

									<div class="row">

										<div class="col-md-12 col-12">
											<div class="form-group">
												<label for="name" class="control-label">ค้าหาที่อยู่</label>
												<input type="text" class="form-control" name="search" placeholder="กรอกอย่างใดอย่างหนึ่ง ตำบล, อำเภอ, จังหวัด หรือ รหัสไปรษณีย์" autocomplete="off">
											</div>
										</div>

										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="name" class="control-label">เลขที่ตั้ง ,ซอย , ถนน</label>
												<input name="address_one" class="form-control" type="text" value="{{old('address_one')}}">
											</div>
										</div>
										<!-- /.col -->
										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="name" class="control-label">ที่อยู่</label>
												<input id="address_auto" class="form-control" type="text" name="address_auto" value="{{old('address_auto')}}">
											</div>
										</div>
										<!-- /.col -->
									</div>




									<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

								</form>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
				<!-- /.col -->

			</div>

		</section>
		<!-- /.content -->

	</div>
@endsection

@section('scripts')

	{{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>
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