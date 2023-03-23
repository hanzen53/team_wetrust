@extends('adminlte::page')

@section('css')
	<link rel="stylesheet" href="{{secure_asset('vendor/fullcalendar/dist/fullcalendar.css')}}">
	<link rel="stylesheet" href="{{secure_asset('css/app.css')}}">
	{{--<link rel="stylesheet" href="{{secure_asset('vendor/fullcalendar/dist/fullcalendar.print.css')}}">--}}
@stop

@section('title', 'Booing room')

@section('content_header')
	<h1>การจองห้อง</h1>
@stop

@section('content')

	@include('flash/sweetAlert')
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">

				<div class="box-body no-padding">
					<table class="table table-condensed">
						<tbody>
						<tr>
							<th>ID</th>
							<th>Full name</th>
							<th>Role</th>
							<th></th>
						</tr>
						@foreach($users as  $value)
							<tr>
								<td>{{$value->id}}</td>
								<td>{{$value->name}}</td>
								<td><a href="/admin/user/edit/{{$value->id}}">แก้ไข</a></td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				<hr>

				{{--<div class="row">--}}
				{{--<div class="col-md-2">--}}
				{{--<button class="btn btn-warning form-control" type="link">ย้อนกลับ</button>--}}
				{{--</div>--}}
				{{--<div class="col-md-10">--}}
				{{--<button class="btn btn-success form-control" type="submit">จองห้อง</button>--}}
				{{--</div>--}}
				{{--</div>--}}
			</div>
		</div>
	</div>


@stop

@section('js')
	<script src="{{secure_asset('js/moment/min/moment.min.js')}}"></script>
	<script src="{{secure_asset('js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
	<script src="{{secure_asset('js/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>

	<script>
		//Date picker
		$('.datepicker').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			todayHighlight: true

		});

		//Timepicker
		$('.timepicker').timepicker({
			showInputs: true,
			showMeridian: false
		});
	</script>
@stop