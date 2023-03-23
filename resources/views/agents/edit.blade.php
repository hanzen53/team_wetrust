@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">ข้อมูลตัวแทน</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		
		<form id="address" class="form-horizontal" role="form" method="POST" action="/agent/{{$agent->id}}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<div class="box-body">
				<div class="form-group">
					<label for="car_license" class="col-sm-2 control-label">ชื่อตัวแทน</label>
					<div class="col-sm-10">
						<input type="text" name="agent_name" class="form-control" id="agent_name" placeholder="Name" value="{{$agent->agent_name}}">
					</div>
				</div>
				<div class="form-group">
					<label for="car_license" class="col-sm-2 control-label">เบอร์โทร</label>
					<div class="col-sm-10">
						<input type="text" name="tel" class="form-control" id="tel" placeholder="Phone number" value="{{$agent->tel}}">
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
			</div>
		</div>
		
	</form>
	
</div>


<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">ข้อมูล IMEIs</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="table-responsive">
			<table id="ticket" class="table table-striped table-bordered no-margin">
				<thead>
					<tr>
						
						<th class="text-center">ID</th>
						<th class="text-center">IMEI</th>
						<th class="text-center">เบอร์โทร</th>
						<th class="text-center">วันที่โยนข้อมูล</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($devices as $index => $imei)
					
					<tr>
						<td class="text-center">{{$imei->id}}</td>
						<td class="text-center">{{$imei->unit_id}}</td>
						<td class="text-center">{{$imei->phone_number}}</td>
						<td class="text-center">{{$imei->assign_agent_date}}</td>
						<td class="text-center">
							<a href="/agent/show/{{$imei->id}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
						</td>
						
					</tr>
					@endforeach
				</tbody>
			</table>
			
			<p></p>
			
			<div class="center-block">
				<?php echo $devices->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
			</div>
		</div>
	</div>
	
	@stop
	
	@push('js-footer')
	
	@endpush
	
	
	@section('scripts')
	
	@endsection