@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<style>
    .tableNoWrap{
        padding: 10px;
        white-space: nowrap;
    }
</style>

@php 
use Carbon\Carbon;
@endphp


<div class="box box-solid box-primary" id="app">
    <div class="box-header">
        <h3 class="box-title">เพิ่มรายการชำระใหม่</h3>
    </div>
    <div class="box-body">
    <form action="/payment/{{$imei}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
               
                <div class="col-sm-4">
                        <label for="name" class="control-label">วันที่รับชำระ</label>
                    <input type="date" class="form-control" id="paid_date" name="paid_date" placeholder="วันที่รับชำระ" value="{{old('paid_date')}}">
                </div>
                
                <div class="col-sm-4">
                        <label for="name" class="control-label">ค่าบริการรายปี</label>
                        <select name="paid_for_year" id="paid_for_year" class="form-control" >
                                <option value="0000">เลือกปี</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
    
                        </select>
                </div>
                
               
                
        </div>
        
        <div class="form-group">
               
                <div class="col-sm-4">
                        <label for="paid_channel">ช่องทางการชำระ</label>
                        <div class="demo-radio-button">
                           <input name="paid_channel" type="radio" id="transfer" class="radio-col-red" checked="transfer" value="transfer" v-model="paid_channel">
                           <label for="transfer">โอน</label>
                           <input name="paid_channel" type="radio" id="cheque" class="radio-col-blue"  value="cheque" v-model="paid_channel">
                           <label for="cheque">เชค</label>
                           <input name="paid_channel" type="radio"  id="cash" class="radio-col-green"  value="cash" v-model="paid_channel">
                           <label for="cash">เงินสด</label>
                           <input name="paid_channel" type="radio"  id="agent" class="radio-col-green"  value="agent" v-model="paid_channel">
                           <label for="cash">จ่ายที่ ตัวแทน</label>
                           <input name="paid_channel" type="radio"  id="billme" class="radio-col-green"  value="billme" v-model="paid_channel">
                           <label for="cash">Billme</label>
                        </div>
               </div>

               <div class="col-sm-4" v-show="paid_channel == 'transfer' ">
                <label for="bank">ช่องทาง</label>
                <select name="bank" id="bank" class="form-control">
                    <option value="kbank">กสิกรไทย</option> 
                    <option value="ktb">กรุงไทย</option>
                    <option value="tmb">ทหารไทย</option>
                    <option value="scb">ไทยพานิชย์</option>
                    <option value="bbl">กรุงเทพ</option>
                </select>
        </div>
                
        </div>

        <div class="form-group">
               
                        <div class="col-sm-4">
                                <label for="paid_slip">ยอดเงิน</label>
                                <input type="number" name="paid_total" class="form-control" id="paid_total" value="" placeholder="ยอดเงิน">
                        </div>
                        
                </div>

        <div class="form-group">
               
                <div class="col-sm-4">
                        <label for="paid_slip">Slip / เอกสารยืนยัน</label>
			<input type="file" name="paid_slip" class="form-control" id="paid_slip" value="" placeholder="เอกสารยืนยัน">
                </div>
                
                <div class="col-sm-4">
                        <label for="paid_date">เลขที่ใบเสร็จรับเงิน</label>
			<input type="text" name="receipt_no" class="form-control" id="receipt_no" value="" v-model="receipt_no">
                </div>
                
        </div>

        <div class="form-group">
               
                <div class="col-sm-4">
                       <label for="who_operate">จ่ายแบบ <small>(ย้อนหลัง,ปกติ,บางส่วน)</small></label>
                       {{-- <input type="text" name="payment_type" class="form-control" id="payment_type" value=""> --}}
                       <select name="payment_type" id="payment_type" class="form-control">
                        <option value="Yearly">รายปี</option>
                        <option value="Monthly">รายเดือน</option>
                    </select>
                </div>
                <div class="col-sm-4">
                       <label for="who_operate">หมายเหตุ </label>
                       <input type="text" name="note" class="form-control" id="note" value="">
                </div>
                
                <div class="col-sm-4">
                        <label for="who_operate">ชื่อพนักงานที่ปิดยอดได้</label>
                        <input type="text" name="who_operate" class="form-control" id="who_operate" value="">
                </div>
                
        
                
        </div>

        <div class="box-footer">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    @stop
    
    @push('js-footer')
    @endpush
    
    
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