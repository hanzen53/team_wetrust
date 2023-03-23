@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
<link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
@stop

@section('content')

<div class="box box-solid box-primary">
	<div class="box-header">
		{{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>--}}
		<h3 class="box-title">Assign ให้ Agent</h3>
	</div><!-- /.box-header -->
	
	@include('flash/error')
	
	<div class="box-body">
		<form class="form-horizontal" role="form" method="POST" action="/assign-stock-to-agent" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			
			<div class="box-body">
				
				<div class="form-group">
					<label for="content" class="col-sm-2 control-label">ชื่อตัวแทน</label>
					<div class="col-sm-4">
						
						<select name="agent_name" id="agent_name" class="form-control">
							@foreach($agents as $agent)
							<option value="{{$agent->id}}">{{$agent->agent_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="content" class="col-sm-2 control-label">IMEI (1 IMEI ต่อ 1 บรรทัด)</label>
					<div class="col-sm-4">
						
						<textarea class="form-control" name="imei" id="" cols="30" rows="10"></textarea>
					</div>
					
					
					
				</div>
				<!-- /.box-body -->
				
				<div class="box-footer">
					<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
				</div>
				
				
			</form>
		</div>
	</div>
	
	@stop
	
	@push('js-footer')
	
	@endpush
	
	
	@section('scripts')
	
	@endsection