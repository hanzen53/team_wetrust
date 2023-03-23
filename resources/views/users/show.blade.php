@extends('adminlte::page')

@section('css')
	<link rel="stylesheet" href="{{secure_asset('vendor/fullcalendar/dist/fullcalendar.css')}}">
	<link rel="stylesheet" href="{{secure_asset('css/app.css')}}">
	{{--<link rel="stylesheet" href="{{secure_asset('vendor/fullcalendar/dist/fullcalendar.print.css')}}">--}}
@stop

@section('title', 'Booing room')

@section('content_header')
	<h1>User {{$user->name}}</h1>
@stop

@section('content')
	<div class="container" id="app">
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="/admin/user/edit/{{$user->id}}" method="post" enctype="multipart/form-data">
					@csrf

					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>ชื่อ:</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-users" aria-hidden="true"></i>
									</div>
									<input type="text" class="form-control pull-right" name="name" value="{{$user->name}}" >
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Email:</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-mail-forward" aria-hidden="true"></i>
									</div>
									<input type="text" class="form-control pull-right"  name="email" value="{{$user->email}}" >
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>กลุ่มผู้ใช้งาน:</label>
								<select name="role" id="" class="form-control">
									<option value="admin" @if($user->role =='admin') selected @endif>Admin</option>
									<option value="admin-bq" @if($user->role =='admin-bq') selected @endif>Admin BQ</option>
									<option value="sale" @if($user->role =='sale') selected @endif>Sale</option>
									<option value="user" @if($user->role =='user') selected @endif>User</option>
								</select>
								<!-- /.input group -->
							</div>
						</div>

					</div>

					<button class="btn btn-success form-control" type="submit">แก้ไขข้อมูล</button>
				</form>
			</div>
		</div>
	</div>
@stop

@section('js')
@stop