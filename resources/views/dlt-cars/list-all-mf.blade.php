@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')



	<div class="box box-solid box-primary" id="app">
		<div class="box-header">
			
			<h3 class="box-title">รถทั้งหมด {{count($cars)}}</h3>

			<div class="btn-group pull-right" role="group" aria-label="...">
				<a href="/list-all-mf-offline?interval=1"><button type="button" class="btn btn-default">1 วัน</button></a>
				<a href="/list-all-mf-offline?interval=3"><button type="button" class="btn btn-default">3 วัน</button></a>
				<a href="/list-all-mf-offline?interval=7"><button type="button" class="btn btn-default">7 วัน</button></a>
				<a href="/list-all-mf-offline?interval=30"><button type="button" class="btn btn-default">มากกว่า 10 วัน</button></a>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">

			@if(Session::has('success'))
				<div class="alert alert-success">
					แก้ข้อมูลสำเร็จ !<br><br>
				</div>
			@endif
			<table id="myTable" class="table table-striped table-responsive">
				<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">Unit ID</th>
					<th class="text-center">ทะเบียน</th>
					<th class="text-center">จังหวัด</th>
					<th class="text-center">เลขตัวถัง</th>
					<th class="text-center">ยี่ห้อรถ</th>
					<th class="text-center">ประเภท</th>
					<th class="text-center">วันที่ยิง Master File ครั้งแรก</th>
					<th class="text-center">Update ล่าลุด</th>
					<th class="text-center">เจ้าของ</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($cars as $index => $car)
				<tr>
						<td class="text-center" >{{$index+1}}</td>
						<td class="text-center">{{$car->unit_id}}</td>
						<td class="text-center"><a href="/crm/car-owner?q={{$car->vehicle_id}}" target="_blank">{{$car->vehicle_id}}</a></td>
						<td class="text-center">{{$car->province_name}}</td>
						<td class="text-center">{{$car->vehicle_chassis_no}}</td>
						<td class="text-center">{{$car->vehicle_type}}</td>
						<td class="text-center">{{$car->vehicle_register_type}}</td>
						<td class="text-center">{{$car->log_time}}</td>
						<td class="text-center">{{$car->update_time}}</td>
						<td class="text-center"><a href="/sale/show/{{$car->customer_id}}" target="blank">{{$car->customer_name}}</a></td>
					
				</tr>
				@endforeach
				</tbody>
			</table>


		</div><!-- /.box-body -->
	</div>

@stop

@push('js-footer')

@endpush


@section('scripts')
	<script>
		$(document).ready( function () {
			$('#myTable').DataTable({
				"aLengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
				"iDisplayLength": 100
			});
		} );
	</script>
@endsection