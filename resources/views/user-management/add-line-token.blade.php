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
			<h3 class="box-title">Line token</h3>
		</div><!-- /.box-header -->
		<div class="box-body">

			@if(Session::has('success'))
				<div class="alert alert-success">
					<strong>Wow!</strong>เพิ่ม Line token สำเร็จแล้ว !<br><br>
				</div>
			@endif

			<form id="address" class="form-horizontal" role="form" method="POST" action="/add-line-token" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<h3 class="box-title">Line token</h3>
				<hr>

				<div class="form-group">
					<label for="user" class="col-sm-2 control-label">User</label>
					<div class="col-sm-4">
						{{--<input type="text" class="form-control" id="register_province" name="register_province" placeholder="จังหวัด" value="{{old('register_province')}}">--}}
						<select name="user" id="user" class="form-control select2" style="width: 100%;">
							@foreach($users as $user)
								<option value="{{$user->id}}">{{$user->name}} <small>({{$user->email}})</small></option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="line_token" class="col-sm-2 control-label">Line token</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="line_token" name="line_token" placeholder="Line token" value="{{old('line_token')}}">
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