@extends('theme-v2/common/master')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				ชำระเงิน
				<small>Control panel</small>
			</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="breadcrumb-item active">ชำระเงิน</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content" id="app">


			<div class="row">
				<div class="col-12 ">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"> เพิ่มการชำระเงิน IMEI {{$imei}}</h3>

							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
									<i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
									<i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<form id="address" class="form-horizontal" role="form" method="POST" action="/payment/{{$imei}}" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

								<div class="box">
									<div class="box-body">
										<div class="form-group">
											<label for="paid_date">วันที่ชำระ</label>
											<input type="datetime-local" name="paid_date" class="form-control" id="paid_date" value="">
										</div>

										<div class="form-group">
											<label for="paid_channel">ค่าบริการรายปี</label>
											<select name="paid_for_year" id="paid_for_year" class="form-control" @change="onChange()" v-model="paid_for_year">
												<option value="59">59</option>
												<option value="60">60</option>
												<option value="61">61</option>
												<option value="62">62</option>
												<option value="63">63</option>
												<option value="64">64</option>
												<option value="65">65</option>
											</select>
										</div>

										<div class="form-group">
											<label for="paid_channel">ช่องทางการชำระ</label>
											<div class="demo-radio-button">
												<input name="paid_channel" type="radio" id="transfer" class="radio-col-red" checked="" value="transfer" v-model="paid_channel">
												<label for="transfer">โอน</label>
												<input name="paid_channel" type="radio" id="cheque" class="radio-col-blue"  value="cheque" v-model="paid_channel">
												<label for="cheque">เชค</label>
												<input name="paid_channel" type="radio"  id="cash" class="radio-col-green"  value="cash" v-model="paid_channel">
												<label for="cash">เงินสด</label>
											</div>
										</div>

										<div class="form-group" v-show="paid_channel != 'cash'">
											<label for="bank">ธนาคาร</label>
											<select name="bank" id="bank" class="form-control">
												<option value="kbank">กสิกรไทย</option>
												<option value="ktb">กรุงไทย</option>
												<option value="tmb">ทหารไทย</option>
												<option value="scb">ไทยพานิชย์</option>
												<option value="bbl">กรุงเทพ</option>
												<option value="wetrust">จ่ายที่ Wetrust</option>
											</select>
										</div>
										
										<div class="form-group">
											<label for="paid_slip">Slip / เอกสารยืนยัน</label>
											<input type="file" name="paid_slip" class="form-control" id="paid_slip" value="" placeholder="เอกสารยืนยัน">
										</div>

										<div class="form-group">
											<label for="next_paid">รอบชำระครั้งต่อไป</label>
											<input type="date" name="next_paid" class="form-control" id="next_paid" value="{{$next_paid}}">
										</div>

										<div class="form-group">
											<label for="paid_date">เลขที่ใบเสร็จรับเงิน</label>
											<input type="text" name="receipt_no" class="form-control" id="receipt_no" value="" v-model="receipt_no">
										</div>

										<div class="form-group">
											<label for="who_operate">จ่ายแบบ <small>(ย้อนหลัง,ปกติ,บางส่วน)</small></label>
											<input type="text" name="payment_type" class="form-control" id="payment_type" value="">
										</div>

										<div class="form-group">
											<label for="who_operate">ชื่อพนักงานที่ปิดยอดได้</label>
											<input type="text" name="who_operate" class="form-control" id="who_operate" value="">
										</div>

									</div>
									<!-- /.box-body -->

									<div class="box-footer">
										<input type="hidden" name="user_id" value="{{$user_id}}">
										<button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
									</div>
								</div>
							</form>
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

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script>
		var app = new Vue({
			el: '#app',
			data: {
				paid_channel: 'transfer',
				receipt_no : '',
				paid_for_year: 61
			},
			methods: {
				onChange() {
					console.log(this.paid_for_year)
					paid_for_year = this.paid_for_year;
					receipt_no = <?php echo $imei?>+'/'+this.paid_for_year;
				}
			}
		})
	</script>
@endsection