@extends('adminlte::page')

@section('css')

@stop

@section('title', 'Address')

@section('content_header')

@stop

@section('content')
	@include('flash/sweetAlert')
	<div class="container" id="app">

		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						Avatar
					</div>
					<div class="panel-body">
						<div class="center-block">
							<img src="{{asset('/uploads/'.$user->avatar)}}" alt="" class="img-responsive">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						Profile
					</div>
					<div class="panel-body">
						<form  class="form-horizontal" action="/user/profile" method="post" enctype="multipart/form-data">
							@csrf

							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">ชื่อ-สกุล</label>
								<div class="col-sm-6">
									<input name="name" class="form-control" type="text" value="{{$user->name}}">
								</div>
							</div>

							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">โทรศัพท์</label>
								<div class="col-sm-6">
									<input name="tel" class="form-control" type="text" value="{{$user->tel}}">
								</div>
							</div>

							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-6">
									<input name="email" class="form-control" type="email" value="{{$user->email}}">
								</div>
							</div>

							<div class="form-group">
								<label for="search" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-6">
									<input id="password" class="form-control" type="password" name="password" value="">
									<small class="text-red">เว้นว่างถ้าไม่ต้องการเปลี่ยน</small>
								</div>
							</div>

							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">Avatar</label>
								<div class="col-sm-8">
									<input name="avatar" class="form-control" type="file" value="{{$user->avatar}}">
								</div>
							</div>

							<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



@stop

@section('js')

@stop