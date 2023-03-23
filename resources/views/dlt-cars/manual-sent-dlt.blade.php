@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

	<div class="box box-solid box-primary">
		<div class="box-header">
			{{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มรถเข้าระบบ </a></span>--}}
			<h3 class="box-title">ส่งข้อมูลเข้าขนส่ง กรณีฉุกเฉิน</h3>
		</div><!-- /.box-header -->
		<div class="box-body">

			@if(Session::has('success'))
				<div class="alert alert-success">
					ส่งข้อมูลสำเร็จ !<br><br>
				</div>
			@endif

			<form id="address" class="form-horizontal" role="form" method="POST" action="/manual-sent-dlt" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				{{--<h4 class="box-title">แก้ไขทะเบียนรถ ที่แสดงหน้า online</h4>--}}
				<p>

				<div class="form-group">
					<label for="user" class="col-sm-2 control-label">DLT Unit ID</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="unit_id" name="unit_id" placeholder="079000100000xxxxxxxxxxxxxx" value="{{old('unit_id')}}">
					</div>
				</div>

				<div class="form-group">
					<label for="line_token" class="col-sm-2 control-label">หมายเลขใบขับขี่</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="driver_id" name="driver_id" placeholder="หมายเลขใบขับขี่" value="{{old('driver_id')}}">
						<small class="text-danger">ปล่อยว่างถ้าต้องการข้อมูลล่าสุดจาก API</small>
					</div>
				</div>

				<div class="form-group">
					<label for="line_token" class="col-sm-2 control-label">Latitude</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="">
						<small class="text-danger">ปล่อยว่างถ้าต้องการข้อมูลล่าสุดจาก API</small>
					</div>

					<label for="line_token" class="col-sm-1 control-label">Longitude</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="lon" name="lon" placeholder="Longitude" value="">
						<small class="text-danger">ปล่อยว่างถ้าต้องการข้อมูลล่าสุดจาก API</small>
					</div>
				</div>

				<button type="submit" class="btn btn-success pull-right">ส่งข้อมูล</button>

			</form>

		</div><!-- /.box-body -->
	</div>

@stop

@push('js-footer')

@endpush


@section('scripts')

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<script>
		$('#user').select2();
		$('.alert').fadeOut(7000);
	</script>
@endsection