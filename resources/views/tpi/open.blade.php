@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
	<link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
	<link rel="stylesheet"
		  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="{{asset('css/datepicker.css')}}">


	<style>
		table
		{
			width: 100%;
			border-collapse: collapse;
		}

		table thead td
		{
			border: 1px solid #eeeeee;
		}

		.smallCell
		{
			padding: 10px;
			white-space: nowrap;
		}
	</style>
@stop

@section('content')

	<div class="box box-solid box-primary" id="app">
		{{--<div class="box-header">--}}
		{{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>--}}
		{{--<h3 class="box-title">TPI create job</h3>--}}
		{{--</div><!-- /.box-header -->--}}

		{{--@include('flash/error')--}}

		{{--<div class="box-body">--}}

		{{--<form id="address" class="form-horizontal" role="form" method="POST" action="/tpi-create-job" enctype="multipart/form-data">--}}
		{{--<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />--}}

		{{--<div class="form-group">--}}
		{{--<label for="content" class="col-sm-2 control-label">Area code search</label>--}}
		{{--<div class="col-sm-10">--}}
		{{--<input @keyup="getAreaCode()" type="text" class="form-control" name="search" v-model="search">--}}
		{{--</div>--}}
		{{--</div>--}}

		{{--<div class="form-group">--}}
		{{--<label for="content" class="col-sm-2 control-label">Area code ที่จะจัดส่ง</label>--}}
		{{--<div class="col-sm-10">--}}
		{{--<select name="area_code" id="" class="form-control">--}}
		{{--<option v-for="item in models" :value="item.area_code">@{{item.area_code}} @{{item.address}}</option>--}}
		{{--</select>--}}
		{{--</div>--}}
		{{--</div>--}}

		{{--<div class="form-group">--}}
		{{--<label for="content" class="col-sm-2 control-label">ทะเบียนรถ</label>--}}
		{{--<div class="col-sm-10">--}}
		{{--<select name="car" id="" class="form-control">--}}
		{{--<option value="14-0255">14-0255</option>--}}
		{{--<option value="02-834 83-6075 สบ">02-834 83-6075 สบ</option>--}}
		{{--<option value="02-1066">02-1066</option>--}}
		{{--<option value="ฒล-5145">ฒล-5145</option>--}}
		{{--</select>--}}
		{{--</div>--}}
		{{--</div>--}}

		{{--<div class="form-group">--}}
		{{--<label for="content" class="col-sm-2 control-label">WHS code</label>--}}
		{{--<div class="col-sm-10">--}}
		{{--<select name="whs_code" id="" class="form-control">--}}
		{{--@foreach($whsCode as $whs)--}}
		{{--<option value="{{$whs->whs}}"> {{$whs->whs}} {{$whs->center_name}}</option>--}}
		{{--@endforeach--}}
		{{--</select>--}}
		{{--</div>--}}
		{{--</div>--}}

		{{--<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>--}}

		{{--</form>--}}

		{{--</div><!-- /.box-body -->--}}
	</div>


	<div class="row">
		<div class="col-md-8">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<div class="btn-group pull-right" role="group" aria-label="Basic example">
						<button type="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						<button type="button" class="btn btn-success"><i class="fa fa-refresh"></i> Reload GPS</button>
						<button type="button" class="btn btn-success"><i class="fa fa-download"></i> Import</button>
						<button type="button" class="btn btn-success"><i class="fa fa-upload"></i> Export</button>
						<button type="button" class="btn btn-success"><i class="fa fa-eject"></i> Hide</button>
					</div>
					<h3 class="box-title">TPI Check data</h3>
				</div><!-- /.box-header -->

				@include('flash/error')

				<div class="box-body" style="height:100%; overflow-y:auto; overflow-x:auto;">

					<div class="">
						<table class="table table-bordered">
							<thead>
							<tr>
								<th  class="smallCell">ID</th>
								<th  class="smallCell">tcontrNo</th>
								<th  class="smallCell">tcontrName</th>
								<th  class="smallCell">Cust-No</th>
								<th  class="smallCell">Cust-Name</th>
								<th  class="smallCell">shpto</th>
								<th  class="smallCell">shptoName</th>
								<th  class="smallCell">WhsCode</th>
								<th  class="smallCell">AreaCode </th>
								<th  class="smallCell">ตำบล </th>
								<th  class="smallCell">อำเภอที่ส่ง</th>
								<th  class="smallCell">จังหวัดที่ส่ง</th>
								<th  class="smallCell">ผง/ถุง</th>
								<th  class="smallCell">Item-No</th>
								<th  class="smallCell">Cwgt#</th>
								<th  class="smallCell">Truck_ID</th>
								<th  class="smallCell">Gps</th>
								<th  class="smallCell">DpNo (Q)</th>
								<th  class="smallCell">DspDateTime</th>
								<th  class="smallCell">กรณีพิเศษ</th>
								<th  class="smallCell">Delivery Status (T)</th>
								<th  class="smallCell">การจัดส่งถึงโดย (U)</th>
								<th  class="smallCell">วันที่ถึง (V)</th>
								<th  class="smallCell">หมายเหตุ (W)</th>
								<th  class="smallCell">ตรวจสอบโดย</th>
								<th  class="smallCell">วันที่บันทึก</th>
								<th  class="smallCell">Gps_Lat</th>
								<th  class="smallCell">Gps_Lon</th>
								<th  class="smallCell">Gps_Date</th>
								<th  class="smallCell">TypeIm</th>
								<th  class="smallCell">DpDate</th>
								<th  class="smallCell">Distance</th>
								<th  class="smallCell">Speed</th>
								<th  class="smallCell">RunPeriod</th>
								<th  class="smallCell">StopPeriod</th>
								<th  class="smallCell">ParkPeriod</th>
							</tr>
							</thead>
							<tbody>
							@foreach($jobs as $index => $job)

								<tr @if($job->id == 3 || $job->id == 6) class="success animate infinite pulse" @endif>
									{{--<tr class="success">--}}
									<td  class="smallCell">{{$job->id}}</td>
									<td  class="smallCell">{{$job->tcontrNo}}</td>
									<td  class="smallCell">{{$job->tcontrName}}</td>
									<td  class="smallCell">{{$job->cust_no}}</td>
									<td  class="smallCell">{{$job->cust_name}}</td>
									<td  class="smallCell">{{$job->shpto}}</td>
									<td  class="smallCell">{{$job->shpto_name}}</td>
									<td  class="smallCell">{{$job->whs_code}}</td>
									<td  class="smallCell">{{$job->area_code}}</td>
									<td  class="smallCell">{{$job->thumbol}}</td>
									<td  class="smallCell">{{$job->ampher}}</td>
									<td  class="smallCell">{{$job->province}}</td>
									<td  class="smallCell">{{$job->amount}}</td>
									<td  class="smallCell">{{$job->item_no}}</td>
									<td  class="smallCell">{{$job->cwgt}}</td>
									<td  class="smallCell">{{$job->truck_id}}</td>
									<td  class="smallCell">{{$job->gps}}</td>
									<td  class="smallCell">{{$job->dp_no}}</td>
									<td  class="smallCell">{{$job->dsp_datetime}}</td>
									<td  class="smallCell">{{$job->case}}</td>
									<td  class="smallCell">{{$job->delivery_status}}</td>
									<td  class="smallCell">{{$job->delivery_by}}</td>
									<td  class="smallCell">{{$job->delivery_datetime}}</td>
									<td  class="smallCell"><input type="text" class="form-control input-lg"></td>
									<td  class="smallCell">{{$job->checked_by}}</td>
									<td  class="smallCell">{{$job->checked_datetime}}</td>
									<td  class="smallCell">{{$job->gps_lat}}</td>
									<td  class="smallCell">{{$job->gps_lon}}</td>
									<td  class="smallCell">{{$job->gps_datetime}}</td>
									<td  class="smallCell">{{$job->type_im}}</td>
									<td  class="smallCell">{{$job->dp_datetime}}</td>
									<td  class="smallCell">{{$job->distance}}</td>
									<td  class="smallCell">{{$job->speed}}</td>
									<td  class="smallCell">{{$job->run_period}}</td>
									<td  class="smallCell">{{$job->stop_period}}</td>
									<td  class="smallCell">{{$job->park_period}}</td>


									{{--<td style=">{{$job->created_at}}</td>--}}
									{{--<td class="--}}
									{{--@if($job->status =='by SaleArea') animated infinite pulse @endif">--}}
									{{--@if($job->status =='by SaleArea')--}}
									{{--<strong class="text-green animated infinite pulse">{{$job->status}} </strong>--}}
									{{--@endif--}}
									{{--</td>--}}
									{{--<td class="--}}
									{{--@if($job->status =='by SaleArea') animated infinite pulse @endif">--}}
									{{--@if($job->status =='by SaleArea')--}}
									{{--<strong class="text-green animated infinite pulse">{{$job->status}} </strong>--}}
									{{--@endif--}}
									{{--</td>--}}
									{{--<td style="><input type="text" class="form-control"></td>--}}



								</tr>
							@endforeach
							</tbody>
						</table>
					</div>


				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-solid box-primary">
				<div class="box-header">

					<div class="row">
						<div class="form-group">
							<div class="col-xs-6"><input type="text" class="form-control datepicker" value="2018-06-12 - 2018-06-13"></div>
							<div class="col-xs-6"><input type="text" class="form-control datepicker" value="2018-06-12 - 2018-06-13"></div>
						</div>
					</div>
					<br>


					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-info"><i class="fa fa-search"></i>ค้นหา</button>
									<button type="button" class="btn btn-success"><i class="fa fa-home"></i> WhsCode (2)</button>
									<button type="button" class="btn btn-info"><i class="fa fa-paper-plane"></i> แสดงรายงาน</button>
								</div>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-xs-6">
							<span class="">ถึง by Shipto : 10</span><br>
							<span class="">ถึง by ShipArea : 3</span><br>
							<span class="">No Nav GPS : 3</span><br>
						</div>
						<div class="col-xs-6">
							<span class="">ถึง by ShipArea : 3</span><br>
							<span class="">ถึง by อำเภอ : 2	</span><br>
							<span class="">No other GPS : 2	</span><br>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 center-block">
							<span class="text-center">รวม : 15</span>
						</div>
					</div>
				</div><!-- /.box-header -->

				@include('flash/error')

				<div class="box-body smooth-scroll" style="height:100%; overflow-y:auto; overflow-x:auto;">

					<div class="table">
						<table class="table-bordered">
							<thead>
							<tr>
								<th  class="smallCell">ID</th>
								<th  class="smallCell">tcontrNo</th>
								<th  class="smallCell">tcontrName</th>
								<th  class="smallCell">Cust-No</th>
								<th  class="smallCell">Cust-Name</th>
								<th  class="smallCell">shpto</th>
								<th  class="smallCell">shptoName</th>
								<th  class="smallCell">WhsCode</th>
								<th  class="smallCell">AreaCode </th>
								<th  class="smallCell">ตำบล </th>
								<th  class="smallCell">อำเภอที่ส่ง</th>
								<th  class="smallCell">จังหวัดที่ส่ง</th>
								<th  class="smallCell">ผง/ถุง</th>
								<th  class="smallCell">Item-No</th>
								<th  class="smallCell">Cwgt#</th>
								<th  class="smallCell">Truck_ID</th>
								<th  class="smallCell">Gps</th>
								<th  class="smallCell">DpNo (Q)</th>
								<th  class="smallCell">DspDateTime</th>
								<th  class="smallCell">กรณีพิเศษ</th>
								<th  class="smallCell">Delivery Status (T)</th>
								<th  class="smallCell">การจัดส่งถึงโดย (U)</th>
								<th  class="smallCell">วันที่ถึง (V)</th>
								<th  class="smallCell">หมายเหตุ (W)</th>
								<th  class="smallCell">ตรวจสอบโดย</th>
								<th  class="smallCell">วันที่บันทึก</th>
								<th  class="smallCell">Gps_Lat</th>
								<th  class="smallCell">Gps_Lon</th>
								<th  class="smallCell">Gps_Date</th>
								<th  class="smallCell">TypeIm</th>
								<th  class="smallCell">DpDate</th>
								<th  class="smallCell">Distance</th>
								<th  class="smallCell">Speed</th>
								<th  class="smallCell">RunPeriod</th>
								<th  class="smallCell">StopPeriod</th>
								<th  class="smallCell">ParkPeriod</th>
							</tr>
							</thead>
							<tbody>
							@foreach($jobs as $index => $job)

								<tr @if($job->status =='by SaleArea') class="success" @endif>
									<td  class="smallCell">{{$job->id}}</td>
									<td  class="smallCell">{{$job->tcontrNo}}</td>
									<td  class="smallCell">{{$job->tcontrName}}</td>
									<td  class="smallCell">{{$job->cust_no}}</td>
									<td  class="smallCell">{{$job->cust_name}}</td>
									<td  class="smallCell">{{$job->shpto}}</td>
									<td  class="smallCell">{{$job->shpto_name}}</td>
									<td  class="smallCell">{{$job->whs_code}}</td>
									<td  class="smallCell">{{$job->area_code}}</td>
									<td  class="smallCell">{{$job->thumbol}}</td>
									<td  class="smallCell">{{$job->ampher}}</td>
									<td  class="smallCell">{{$job->province}}</td>
									<td  class="smallCell">{{$job->amount}}</td>
									<td  class="smallCell">{{$job->item_no}}</td>
									<td  class="smallCell">{{$job->cwgt}}</td>
									<td  class="smallCell">{{$job->truck_id}}</td>
									<td  class="smallCell">{{$job->gps}}</td>
									<td  class="smallCell">{{$job->dp_no}}</td>
									<td  class="smallCell">{{$job->dsp_datetime}}</td>
									<td  class="smallCell">{{$job->case}}</td>
									<td  class="smallCell">{{$job->delivery_status}}</td>
									<td  class="smallCell">{{$job->delivery_by}}</td>
									<td  class="smallCell">{{$job->delivery_datetime}}</td>
									<td  class="smallCell"><input type="text" class="form-control input-lg"></td>
									<td  class="smallCell">{{$job->checked_by}}</td>
									<td  class="smallCell">{{$job->checked_datetime}}</td>
									<td  class="smallCell">{{$job->gps_lat}}</td>
									<td  class="smallCell">{{$job->gps_lon}}</td>
									<td  class="smallCell">{{$job->gps_datetime}}</td>
									<td  class="smallCell">{{$job->type_im}}</td>
									<td  class="smallCell">{{$job->dp_datetime}}</td>
									<td  class="smallCell">{{$job->distance}}</td>
									<td  class="smallCell">{{$job->speed}}</td>
									<td  class="smallCell">{{$job->run_period}}</td>
									<td  class="smallCell">{{$job->stop_period}}</td>
									<td  class="smallCell">{{$job->park_period}}</td>


									{{--<td style=">{{$job->created_at}}</td>--}}
									{{--<td class="--}}
									{{--@if($job->status =='by SaleArea') animated infinite pulse @endif">--}}
									{{--@if($job->status =='by SaleArea')--}}
									{{--<strong class="text-green animated infinite pulse">{{$job->status}} </strong>--}}
									{{--@endif--}}
									{{--</td>--}}
									{{--<td class="--}}
									{{--@if($job->status =='by SaleArea') animated infinite pulse @endif">--}}
									{{--@if($job->status =='by SaleArea')--}}
									{{--<strong class="text-green animated infinite pulse">{{$job->status}} </strong>--}}
									{{--@endif--}}
									{{--</td>--}}
									{{--<td style="><input type="text" class="form-control"></td>--}}



								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
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
					models:{},
					area_code: '',
					search: '',
					url: '/tpi-search-area',
				}
			},
			created: function () {

				this.getAreaCode();

			},

			methods: {
				getAreaCode(){
					var self = this;
					axios.get(`${this.url}?search=${this.search}`)
						.then(function (response) {
							console.log(response.data.result);
							self.models = response.data.result
						})
				},

			}
		});
	</script>

	<script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>
	<script>
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayBtn: true,
			language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
			thaiyear: true              //Set เป็นปี พ.ศ.
		}).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
	</script>
@endsection