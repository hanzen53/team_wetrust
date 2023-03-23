@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' DLT ')

@section('content')
	<style>
		/* Always set the map height explicitly to define the size of the div
		 * element that contains the map. */
		#map {
			height: 500px;
		}
	</style>

	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">ค้นหารถ</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<form action="/device-status" method="get">
							<div class="col-sm-10">
								<input type="text" v-model="imei" class="form-control" id="imei" name="imei" placeholder="IMEI" @keypress.up.enter="fetchData()">
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-success pull-right form-control">ค้นหา</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@if(count($data)>0)
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">ข้อมูล</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<ul>
								<li><strong>ทะเบียน :</strong>  {{@$data['device_name']}}</li>
								<li><strong>คนขับ :</strong>  {{@$data['last_know_position'][0]['driver_id']}}</li>
								<li><strong>หมายเลขตัวถัง :</strong>  {{@$data['last_know_position'][0]['driver_id']}}</li>
								<li><strong>Unit ID :</strong> {{@$data['device_id']}}</li>
								<li><strong>เวลาปัจจุบัน เครื่อง GPS :</strong> {{@\Illuminate\Support\Carbon::parse($data['last_know_position'][0]['utc_ts'])->format('d-m-Y H:i')}}</li>
								<li><strong>เวลาที่ server รับข้อมูล :</strong> {{@\Illuminate\Support\Carbon::parse($data['last_know_position'][0]['recv_utc_ts'])->format('d-m-Y H:i')}}</li>
								<li><strong>สถานะ :</strong> <span class="text-success"><strong>Online</strong></span></li>
							</ul>
							<hr>
							<p>
								<h4>ข้อมูลดิบ</h4>
							</p>


							<form action="/raw-file-csv" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="form-group">

									<input type="text"  class="form-control" name="daterange" value="" />

								</div>
								<div class="form-group">
									<input type="hidden" name="unit_id" value="{{@$data['device_id']}}">
									<button type="submit" class="btn btn-success pull-right form-control">Download CSV</button>

								</div>
							</form>
						</div>
						<div class="col-md-8">
							<div id="map"></div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<pre><?php print_r($data)?></pre>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
@stop

@push('js-footer')

@endpush


@section('scripts')
	<script>

		function initMap() {
			var myLatLng = {lat: <?php echo @$data['last_know_position'][0]['lat']?>, lng: <?php echo @$data['last_know_position'][0]['lon']?>};

			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 16,
				center: myLatLng
			});

			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				title: 'Hello World!'
			});
		}

	</script>

	<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtiFk1HJp19sUIyvGVPNjN2E_o9iJtZ28&callback=initMap">
	</script>

	{{--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>--}}
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	<!-- Include Date Range Picker -->
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	<script type="text/javascript">
		$(function() {
			$('input[name="daterange"]').daterangepicker({
				"showDropdowns": true,
			}, function(start, end, label) {
				console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
			});
		});
	</script>


@endsection