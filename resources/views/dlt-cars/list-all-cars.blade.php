@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')



	<div class="box box-solid box-primary" id="app">
		<div class="box-header">
			{{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มรถเข้าระบบ </a></span>--}}
			<h3 class="box-title">รถทั้งหมด @{{total}}</h3>
		</div><!-- /.box-header -->
		<div class="box-body">

			<div v-if="loading" class="text-center">
				<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
				<span class="sr-only">Loading...</span>
			</div>

			@if(Session::has('success'))
				<div class="alert alert-success">
					แก้ข้อมูลสำเร็จ !<br><br>
				</div>
			@endif
			<table id="ticket" class="table table-striped table-responsive">
				<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">Unit ID</th>
					<th class="text-center">ทะเบียน</th>
					<th class="text-center">Chassis No</th>
					<th class="text-center">Protocol</th>
					<th class="text-center">Last update</th>
					<th class="text-center">Delay (Hours)</th>
					<th class="text-center">DLT Data</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>
				<tbody>

				<tr v-for="(car, index) in models"  v-bind:class="{ danger: car.diff > 0 }">
					<td class="text-center" >@{{index+1}}</td>
					<td class="text-center">@{{car.imei}}</td>
					<td class="text-center">@{{car.device_name}}</td>
					<td class="text-center">@{{car.chassis_no}}</td>
					<td class="text-center">@{{car.protocol}}</td>
					<td class="text-center">@{{car.updated_at}}</td>
					<td class="text-center">@{{car.diff}}</td>
					<td class="text-center">
							<i class="fa fa-check text-green" aria-hidden="true" v-if="car.allow_send_data_to_dlt == 1"></i>
							<i class="fa fa-exclamation-triangle text-red" aria-hidden="true" v-else></i>
					</td>

					<td class="text-center">
						<a :href="'/allow-dlt/' + car.imei">Send data</a> |
						<a :href="'/block-dlt/' + car.imei">Stop data</a> |
						<a :href="'/dlt-master-file-delete/' + car.imei"><span class="text-red">Delete master</span></a>
					</td>
				</tr>

				</tbody>
			</table>


		</div><!-- /.box-body -->
	</div>

@stop

@push('js-footer')

@endpush


@section('scripts')
	<script src="https://unpkg.com/vue"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script>

		new Vue({
			el: '#app',
			data(){
				return {
					loading: false,
					models:{},
					total :0,
					area_code: '',
					//url: 'https://gpsservice.dlt.go.th/masterfile/getList/0/15000',
					url: 'https://api01.wetrustgps.com:7899/api/devices/lists-master',
	

				}
			},
			created: function () {

				this.getAllCar();

			},

			methods: {
				getAllCar(){
					var self = this;
					var auth = 'd2VnbG9iYWw6NzRyakg0aFJaU3JI',
						headers = {"Authorization": "Basic " + auth};
						this.loading = true; //the loading begin
					axios.get(`${this.url}`)
						.then(function (response) {
							console.log(response);
							self.total = response.data.count;
							self.models = response.data.results;
						})
						.catch(error => {
                    		this.loading = false;
                		})
						.finally(() => this.loading = false)
				},
				// moment: function () {
				// 	return moment(date).format('MMMM Do YYYY, h:mm:ss a');
				// }
			},
			computed: {
				orderedDiff: function () {
					return _.orderBy(this.models, 'diff')
				}
			}
		});
	</script>
@endsection