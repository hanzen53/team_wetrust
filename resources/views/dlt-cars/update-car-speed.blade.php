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
			<h3 class="box-title">แก้ไขการเตือนความเร็ว</h3>
		</div><!-- /.box-header -->
		<div class="box-body">

			@if(Session::has('success'))
				<div class="alert alert-success">
					แก้ข้อมูลสำเร็จ !<br><br>
				</div>
			@endif

			<form id="address" class="form-horizontal" role="form" method="POST" action="/update-speed-limit" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				{{--<h4 class="box-title">แก้ไขทะเบียนรถ ที่แสดงหน้า online</h4>--}}
				<p>

				<div class="form-group">
					<label for="user" class="col-sm-2 control-label">IMEI</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="device_id" name="device_id" placeholder="IMEI" value="{{old('device_id')}}">
					</div>
				</div>

				<div class="form-group">
					<label for="line_token" class="col-sm-2 control-label">ความเร็ว limit</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="speed_limit" name="speed_limit" placeholder="ความเร็ว limit" value="{{old('speed_limit')}}">
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

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<script>
		$('#user').select2();
		$('.alert').fadeOut(7000);
	</script>
@endsection