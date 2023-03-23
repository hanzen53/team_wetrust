@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary" id="app">
	
	<div class="box-header">
		<h3 class="box-title pull-left">Total offline (@{{totalOffline}})</h3>
		
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a href="/device-offline?days=1"><button type="button" class="btn btn-default">1 วัน</button></a>
			<a href="/device-offline?days=3"><button type="button" class="btn btn-default">3 วัน</button></a>
			<a href="/device-offline?days=7"><button type="button" class="btn btn-default">7 วัน</button></a>
			<a href="/device-offline?days=30"><button type="button" class="btn btn-default">มากกว่า 10 วัน</button></a>
		</div>
		
		
	</div><!-- /.box-header -->
	<div class="box-body">
		
		<div v-if="loading" class="text-center">
			<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
			<span class="sr-only">Loading...</span>
		</div>
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Protocol</th>
					<th>IMEI</th>
					<th>TEL</th>
					<th>Name</th>
					<th>Alerts</th>
					<th v-column-sortable:last_update_utc>Last update</th>
					<th></th>
				</tr>
			</thead>
			
			<tbody>
				
				<tr v-for="(car,index) in list">
					<th scope="row">@{{index+1}}</th>
					<td>@{{car.protocol}}</td>
					<td>@{{car.device_id}}</td>
					<td>@{{car.tel}}</td>
					<td>@{{car.device_name}}</td>
					<td>@{{car.device_alerts}}</td>
					<td>@{{car.last_update_utc}}</td>
					<td>
						<a :href="'/user/ticket/create/' + <?php echo Request::user()->id?> + '?name=' +car.device_name"> เปิด Ticket </a> |
						<a :href="'/mark-delete-realtime-db?imei=' + car.device_id + '&name=' +car.device_name + '&tel='+car.tel" target="_blank"> แจ้งลบ </a>
					</td>
				</tr>
				
			</tbody>
			
		</table>
		
	</div><!-- /.box-body -->
</div>

@stop

@php
$days = 1;
if(Request::get('days')){
	$days = Request::get('days');
}
@endphp

@push('js-footer')

@endpush


@section('scripts')
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-column-sortable@0.0.1/dist/vue-column-sortable.js"></script>
<script>
	
	new Vue({
		el: '#app',
		data(){
			return {
				loading: false,
				list:[],
				car:[],
				totalOffline : 0,
				url: 'https://api01.wetrustgps.com:7899/api/devices/offline?days='+<?php echo $days;?>,
			}
		},
		created: function () {
			
			this.getAllCar();
			
		},
		directives: {columnSortable},
		methods: {
			getAllCar(){
				var self = this;
				this.loading = true; //the loading begin
				axios.get(`${this.url}`)
				
				.then(function (res) {
					self.list = res.data.device_offline;
					self.totalOffline = res.data.total_offline;
					this.loading = false; 
				})
				.catch(error => {
					this.loading = false;
				})
				.finally(() => this.loading = false)
			},
			orderBy(sortFn) {
				// sort your array data like this.userArray
				this.list.sort(sortFn);
			},
		},
		
	});
</script>
@endsection