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
			<h3 class="box-title">ส่งข้อมูลไป lite version</h3>
		</div><!-- /.box-header -->

		@include('flash/error');

		<div class="box-body">

			<form id="address" class="form-horizontal" role="form" method="POST" action="/forward-2-lite" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<label for="content" class="col-sm-2 control-label">1 imei 1 บรรทัด</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="imei" id="note" cols="30" rows="10"></textarea>
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

@endsection