@extends('theme-v2/common/master')
@section('content')

	<style>
		.smallCell{
			padding: 10px;
			white-space: nowrap;
		}
	</style>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">รายการ IMEI ที่ใกล้ครบชำระ</h3>
							<div class="box-tools pull-right">
								<div class="search-box">
									<a class="nav-link hidden-sm-down" href="javascript:void(0)"><i class="mdi mdi-magnify"></i></a>
									<form action="{{Request::url()}}" method="GET" class="app-search" style="display: none;" >
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
										<th class="text-center">ID</th>
										<th class="text-center">IMEI</th>
										<th class="text-center">วันที่ชำระ</th>
										<th class="text-center">ช่องทางการชำระ</th>
										<th class="text-center">ธนาคาร</th>
										<th class="text-center">ค่าบริการรายปี</th>
										<th class="text-center">ชำระครั้งต่อไป</th>
										<th class="text-center">เลขที่ใบเสร็จ</th>
										<th class="text-center">Slip</th>
									</tr>
									</thead>
									<tbody>
									@foreach($paidList as $index => $st)

										<tr>
											<td class="text-center">{{$st->id}}</td>
											<td class="text-center">{{$st->imei}}</td>
											<td class="text-center">{{$st->paid_date}}</td>
											<td class="text-center">{{$st->paid_channel}}</td>
											<td class="text-center"> {{$st->bank}}</td>
											<td class="text-center"> {{$st->paid_for_year}}</td>
											<td class="text-center">{{$st->next_paid}}</td>
											<td class="text-center">{{$st->receipt_no}}</td>
											<td class="text-center"><a href="{{$st->paid_slip}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>

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

								<div class="center-block dataTables_paginate paging_simple_numbers">
									<?php echo $paidList->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>





@endsection