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

							<div class="box-tools float-right">
								<form action="/sale/dashboard" method="get">
									<div class="input-group input-group-sm" style="width: 300px;">
										<input type="text" name="q" class="form-control float-right" placeholder="Search">

										<div class="input-group-btn">
											<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
										</div>
									</div>
								</form>
							</div>
						{{--</div>--}}
						<div class="box-body">
							<div class="box">
								{{--<div class="box-header">--}}
								{{--<h3 class="box-title">ข้อมูลที่พบ</h3>--}}
								{{--</div><!-- /.box-header -->--}}
								<table class="table table-striped table-responsive">
									<thead>
									<tr>
										<th class="text-center">ID</th>
										<th class="text-center">ชื่อลูกค้า</th>
										<th class="text-center">เบอร์โทรศัพท์</th>
										<th class="text-center">วันที่นัดติดตั้ง</th>
										<th class="text-center">Confirm</th>
										<th class="text-center">บัตรประชาชน/เอกสารบริษัท</th>
										<th class="text-center">เพิ่มรถ</th>
										<th class="text-center">Action</th>
									</tr>
									</thead>
									<tbody>
									<?php $i = 1?>
									@foreach($mySold as $sold)
										<tr>

											<th class="text-center">{{$sold->id}}</th>
											<td class="text-center">{{$sold->name}}</td>
											<td class="text-center"> {{$sold->tel}}</td>
											<td class="text-center"> {{$sold->booking_install_date}}</td>
											<td class="text-center">
												@if($sold->confirm_order_status == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
											</td>
											<td class="text-center">
												@if($sold->id_card == '') <i class="fa fa-eye text-red" aria-hidden="true"></i> ยังไม่ได้ upload file @else
													<a href="{{asset($sold->id_card)}}" target="_blank"><i class="fa fa-eye text-green" aria-hidden="true"></i> ดูไฟล์ </a>@endif
											</td>
											<td class="text-center"><a href="/dlt-car-add/{{$sold->id}}"><button class="btn btn-xs bg-olive margin"><i class="fa fa-plus text-white" aria-hidden="true"></i> เพิ่มรถ</button></a></td>
											<td class="text-center"> <a href="/sale/show/{{$sold->id}}">Show</a> | <a href="/sale/update/{{$sold->id}}">Edit</a> </td>
										</tr>
										<?php $i++?>
									@endforeach
									</tbody>
								</table>

								<div class="text-center">
									<?php echo $mySold->appends(['q' => urldecode(Request::get('q'))])->render(); ?>
								</div>
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