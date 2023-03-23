@extends('theme-v2/common/master')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Device Stock
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="breadcrumb-item active">Device Stock</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			@include('flash/error')
			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"> ปล่อย IMEI ที่ผูกแล้วให้ว่าง</h3>

							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
									<i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
									<i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<form id="address" class="form-horizontal" role="form" method="POST" action="/release-imei" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

								<div class="box">
								{{--<div class="box-header with-border">--}}
								{{--<h3 class="box-title">Quick Example</h3>--}}
								{{--</div>--}}
								<!-- /.box-header -->
									<!-- form start -->

									<div class="box-body">
										<div class="form-group">
											<label for="content" class="col-sm-2 control-label">IMEI</label>
											<div class="col-sm-12">
												<input type="text" class="form-control" name="imei">
											</div>
										</div>

										<div class="form-group">
											<label for="content" class="col-sm-2 control-label">เหตุผลที่ยกเลิก</label>
											<div class="col-sm-12">
												<textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
											</div>
										</div>

									</div>
									<!-- /.box-body -->

									<div class="box-footer">
										<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
									</div>
								</div>
							</form>
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