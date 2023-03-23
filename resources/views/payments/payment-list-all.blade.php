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

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">เลือกเงื่อนไขในการค้นหา</h3>
    </div>
    <div class="box-body">
        
        <form id="address" class="form-horizontal" role="form" method="GET" action="/payment-list-all" enctype="multipart/form-data">
            <div class="form-group">
                <label for="content" class="col-sm-1 control-label">เดือน</label>
                <div class="col-sm-2">
                    <select name="filter-month" id="filter-month" class="form-control">
                        <option value="00" @if(Request::get('filter-month') == '00') selected @endif>เลือกเดือน</option>
                        <option value="01" @if(Request::get('filter-month') == '01') selected @endif>JAN</option>
                        <option value="02" @if(Request::get('filter-month') == '02') selected @endif>FEB</option>
                        <option value="03" @if(Request::get('filter-month') == '03') selected @endif>MAR</option>
                        <option value="04" @if(Request::get('filter-month') == '04') selected @endif>APR</option>
                        <option value="05" @if(Request::get('filter-month') == '05') selected @endif>MAY</option>
                        <option value="06" @if(Request::get('filter-month') == '06') selected @endif>JUN</option>
                        <option value="07" @if(Request::get('filter-month') == '07') selected @endif>JUL</option>
                        <option value="08" @if(Request::get('filter-month') == '08') selected @endif>AUG</option>
                        <option value="09" @if(Request::get('filter-month') == '09') selected @endif>SEP</option>
                        <option value="10" @if(Request::get('filter-month') == '10') selected @endif>OCT</option>
                        <option value="11" @if(Request::get('filter-month') == '11') selected @endif>NOV</option>
                        <option value="12" @if(Request::get('filter-month') == '12') selected @endif>DEC</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="filter-year" id="filter-year" class="form-control">
                        <option value="0000" @if(Request::get('filter-year') == '0000') selected @endif>เลือกปี</option>
                        <option value="2016" @if(Request::get('filter-year') == '2016') selected @endif>2016</option>
                        <option value="2017" @if(Request::get('filter-year') == '2017') selected @endif>2017</option>
                        <option value="2018" @if(Request::get('filter-year') == '2018') selected @endif>2018</option>
                        <option value="2019" @if(Request::get('filter-year') == '2019') selected @endif>2019</option>
                        <option value="2020" @if(Request::get('filter-year') == '2020') selected @endif>2020</option>
                        
                    </select>
                </div>
               
                <label for="content" class="col-sm-2 control-label hidden-md hidden-lg"></label>
                <div class="col-sm-2">
                <button type="submit" class="btn btn-success btn-block">ค้นหา</button>
                </div>
            </div>
            
           
        </form>
    </div>
</div>

@if(count($paymentSoon)> 0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">รายการสรุปการชำระ </h3>
    </div>
    <div class="box-body">
        
        
        <div class="row">
            <div class="col-md-2">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">รวมทั้งหมด </h3>
                    </div>
                    <div class="box-body">
                        <h3 class="text-center"><a href="/payment-list-all?filter-month={{Request::get('filter-month')}}">({{count($paymentSoon)}}) IMEIs</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-solid box-success">
                    <div class="box-header">
                        <h3 class="box-title">ติดตั้งใหม่ ปีนี้</h3>
                    </div>
                    <div class="box-body">
                    <h3 class="text-center"><a href="{{Request::getRequestUri()}}&showInstallYear={{Carbon::now()->format('Y')}}">({{$installThisYear}}) IMEIs</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-solid box-success">
                    <div class="box-header">
                        <h3 class="box-title">IMEI ที่ชำระแล้ว</h3>
                    </div>
                    <div class="box-body">
                        <h3 class="text-center">({{$paidInThisYear}}) IMEIs</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-solid box-warning">
                    <div class="box-header">
                        <h3 class="box-title"> IMEI ค้างชำระรวม</h3>
                    </div>
                    <div class="box-body">
                    <h3 class="text-center"><a href="/payment-list?filter-month={{Request::get('filter-month')}}&filter-year=2019&from_field=1" target="_blank">({{count($paymentSoon) - $installThisYear -$paidInThisYear - $devieCancel}}) IMEIs</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-solid box-danger">
                    <div class="box-header">
                        <h3 class="box-title">ยกเลิก</h3>
                    </div>
                    <div class="box-body">
                    <h3 class="text-center"><a href="{{Request::url()}}?filter-month={{Request::get('filter-month')}}&listCancel=1">({{$devieCancel}}) IMEIs</a></h3>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-margin">
                <thead>
                    <tr>
                        <th class="tableNoWrap text-center">ID</th>
                        <th class="tableNoWrap text-center">IMEI</th>
                        <th class="tableNoWrap text-center">เครือข่าย</th>
                        <th class="tableNoWrap text-center">Phone no</th>
                        <th class="tableNoWrap text-center">วันหมดอายุ SIM</th>
                        <th class="tableNoWrap text-center">ตัวแทน</th>
                        <th class="tableNoWrap text-center">ลูกค้า</th>
                        <th class="tableNoWrap text-center">วันที่ติดตั้ง</th>
                        <th class="tableNoWrap text-center">วันที่ครบชำระ</th>
                        <th class="tableNoWrap text-center">จ่ายแบบ</th>
                        <th class="tableNoWrap text-center">รายปี 2015</th>
                        <th class="tableNoWrap text-center">รายปี 2016</th>
                        <th class="tableNoWrap text-center">รายปี 2017</th>
                        <th class="tableNoWrap text-center">รายปี 2018</th>
                        <th class="tableNoWrap text-center">รายปี 2019</th>
                        <th class="tableNoWrap text-center">รายปี 2020</th>
                        <th class="tableNoWrap text-center">สถานะการใช้งาน</th>
                        <th class="tableNoWrap text-center">บันทึกการชำระ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentSoon as $index => $st)
                    
                    <tr @if($st->paid_2019 == 1 && $st->customer_status == 1) class="success" @elseif($st->customer_status == 0) class="danger" @endif>
                        <td class="tableNoWrap text-center">{{$st->id}}</td>
                        <td class="tableNoWrap text-center"><a href="/device-stock/show/{{$st->id}}" target="_blank">{{$st->unit_id}}</a></td>
                        <td class="tableNoWrap text-center">{{$st->operator}}</td>
                        <td class="tableNoWrap text-center">{{$st->phone_number}}</td>
                        {{-- <td class="tableNoWrap text-center">{{$st->operator}}</td> --}}
                        <td class="tableNoWrap text-center"> {{Carbon::parse($st->sim_expire_date)->format('Y-m-d')}}</td>
                        {{-- <td class="tableNoWrap text-center"> {{$st->sim_last_paid}}</td> --}}
                        <td class="tableNoWrap text-center">{{$st->agent_name}}</td>
                        <td class="tableNoWrap text-center">
                            <a href="/sale/user-invoice/{{$st->customer_id}}?month={{Request::get('filter-month')}}&from_field=0" target="_blank">{{$st->customer_name}}</a> | 
                            <a href="/sale/show/{{$st->customer_id}}" target="_blank">ข้อมูลลูกค้า</a>
                        </td>
                        <td class="tableNoWrap text-center">{{\Carbon\Carbon::parse($st->install_date)->format('d-m-Y')}}</td>
                        <td class="tableNoWrap text-center"> {{\Carbon\Carbon::parse($st->next_billing)->format('d-m-Y')}}</td>
                        <td class="tableNoWrap text-center"> {{$st->payment_condition}}</td>
                       
                        <td class="tableNoWrap text-center"> 
                                @if($st->paid_2015 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center"> 
                                @if($st->paid_2016 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center"> 
                                @if($st->paid_2017 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center"> 
                                @if($st->paid_2018 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center"> 
                                @if($st->paid_2019 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center">
                                @if($st->paid_2020 == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="tableNoWrap text-center"> @if($st->customer_status == 'ยกเลิก') <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif</td>

                    <td class="tableNoWrap text-center"> <a href="/payment/{{$st->unit_id}}">เพิ่มการจ่ายเงิน</a></td>
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
        </div>
    </div>
    
    
    @endif
    
    @stop
    
    @push('js-footer')
    @endpush
    
    
    @section('scripts')
    @endsection