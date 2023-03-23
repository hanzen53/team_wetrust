@extends('theme-v2/common/master')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Device Stock
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="breadcrumb-item active">Device Stock</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="row no-gutters py-2">

							<div class="col-sm-6 col-lg-3">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                ผูกใช้งานแล้ว
              </span>
										<span class="text-primary font-size-40">{{$stat[0]->used}}</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar" role="progressbar" style="width: 35%; height: 4px;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 hidden-down">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
               ยังไม่ผูกใช้งาน
              </span>
										<span class="text-info font-size-40">{{$stat[1]->available}}</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-info" role="progressbar" style="width: 55%; height: 4px;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 d-none d-lg-block">
								<div class="box-body br-1 border-light">
									<div class="flexbox mb-1">
              <span class="font-size-18">
                Agent use
              </span>
										<span class="text-warning font-size-40">{{$stat[2]->agent_use}}</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-warning" role="progressbar" style="width: 65%; height: 4px;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


							<div class="col-sm-6 col-lg-3 d-none d-lg-block">
								<div class="box-body">
									<div class="flexbox mb-1">
              <span class="font-size-18">
               Wetrust use
              </span>
										<span class="text-danger font-size-40">{{($stat[0]->used+$stat[1]->available) - $stat[2]->agent_use}}</span>
									</div>
									<div class="progress progress-xxs mt-10 mb-0">
										<div class="progress-bar bg-danger" role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
				<!-- /.col -->

			</div>


			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="box-header with-border">
							<a href="device-stock/create"><button type="link" class="btn btn-success"><i class="fa fa-plus"></i> Add new stock</button></a>
							<a href="sim-will-expire"><button type="link" class="btn btn-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> SIM ที่ใกล้หมดอายุ</button></a>
							{{--<h3 class="box-title">Stock</h3>--}}

							<div class="box-tools pull-right">
								<div class="search-box">
									<a class="nav-link hidden-sm-down" href="javascript:void(0)"><i class="mdi mdi-magnify"></i></a>
									<form action="/device-stock" method="GET" class="app-search" style="display: none;" >
										<input type="text" name="search" class="form-control" placeholder="Search &amp; enter">
										<a class="srh-btn"><i class="ti-close"></i></a>
									</form>
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table id="ticket" class="table table-striped table-bordered no-margin">
									<thead>
									<tr>
										{{--<th class="text-center">ID</th>--}}
										<th class="text-center">ID</th>
										{{--<th class="text-center">User</th>--}}
										<th class="text-center">IMEI</th>
										<th class="text-center">Phone no</th>
										<th class="text-center">Operator</th>
										<th class="text-center">วันหมดอายุ SIM</th>
										<th class="text-center">วันที่เติมเงินล่าสุด</th>
										<th class="text-center">รุ่น</th>
										{{--<th class="text-center">DLT ชนิด</th>--}}
										{{--<th class="text-center">DLT แบบ</th>--}}
										<th class="text-center">ผู้นำเข้า</th>
										<th class="text-center">วันที่นำเข้า</th>
										<th class="text-center">ใช้งานแล้ว</th>
										<th class="text-center">Action</th>
									</tr>
									</thead>
									<tbody>
									@foreach($stock as $index => $st)

										<tr>
											<td class="text-center">{{$st->id}}</td>
											<td class="text-center">{{$st->unit_id}}</td>
											<td class="text-center"><a href="#" data-toggle="modal" data-target="#sim-update-{{$st->phone_number}}">{{$st->phone_number}}</a></td>
											<td class="text-center">{{$st->operator}}</td>
											<td class="text-center"> {{$st->sim_expire_date}}</td>
											<td class="text-center"> {{$st->sim_last_paid}}</td>
											{{--<td class="text-center"> {{$st->sim_last_paid}}</td>--}}
											<td class="text-center">{{$st->gps_model}}</td>
											{{--<td class="text-center">{{$st->dlt_type}}</td>--}}
											{{--<td class="text-center">{{$st->dlt_style}}</td>--}}
											<td class="text-center">{{$st->who_add}}</td>
											<td class="text-center">{{\Carbon\Carbon::parse($st->created_at)->format('d/m/y H:m')}}</td>
											<td class="text-center">
												@if($st->used == 1)
													<i class="fa fa-check text-success" aria-hidden="true"></i>
												@else
													<i class="fa fa-times text-red" aria-hidden="true"></i>
												@endif
											</td>
											<td class="text-center">
												<a href="/device-stock/show/{{$st->id}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
											</td>

										</tr>


										<div class="modal none-border" id="sim-update-{{$st->phone_number}}">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title"><strong>บันทึการเติมเงินหมายเลข {{$st->phone_number}}</strong></h4>
													</div>
													<form role="form" action="/update-sim/{{$st->id}}" method="post" enctype="multipart/form-data">
													<div class="modal-body">

															@csrf
															<div class="form-group row">
																<label class="col-sm-3 col-form-label">วันที่เติมล่าสุด</label>
																<div class="col-sm-9">
																	<input  class="form-control" type="date" placeholder="" value="" name="sim_expire_date">
																</div>
															</div>
															<div class="form-group row">
																<label class="col-sm-3 col-form-label">วันหมดอายุ</label>
																<div class="col-sm-9">
																	<input  class="form-control" type="date" placeholder="" value="" name="sim_last_paid">
																</div>
															</div>

													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-white waves-effect" data-dismiss="modal">ยกเลิก</button>
														<button type="submit" class="btn btn-danger delete-event waves-effect waves-light">ยืนยัน</button></a>
													</div>
													</form>
												</div>
											</div>
										</div>

									@endforeach
									</tbody>
								</table>

								<p></p>

								<div class="center-block dataTables_paginate paging_simple_numbers">
									<?php echo $stock->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
				<!-- /.col -->

			</div>

		</section>
		<!-- /.content -->

	</div>




@endsection