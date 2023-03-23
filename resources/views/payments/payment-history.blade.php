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

{{-- 
    <div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">เลือกเงื่อนไขในการค้นหา</h3>
    </div>
    <div class="box-body">
        
        <form id="address" class="form-horizontal" role="form" method="GET" action="/payment-history" enctype="multipart/form-data">
            <div class="form-group">
                <label for="content" class="col-sm-1 control-label">วัน</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="filter-date">
                </div>
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
               
                <label for="content" class="col-sm-2 control-label hidden-md hidden-lg"></label>
                <div class="col-sm-2">
                <button type="submit" class="btn btn-success btn-block">ค้นหา</button>
                </div>
            </div>
            
           
        </form>
    </div>
</div> 
--}}

@if(count($payments)> 0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">รายการสรุปการชำระ </h3>
    </div>
    <div class="box-body">

        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-margin">
                <thead>
                    <tr>
                        <th class="tableNoWrap text-center">ID</th>
                        <th class="tableNoWrap text-center">Invoice ID</th>
                        <th class="tableNoWrap text-center">ชื่อลูกค้า</th>
                        <th class="tableNoWrap text-center">จำนวน IMEI</th>
                        <th class="tableNoWrap text-center">ยอดเงิน</th>
                        <th class="tableNoWrap text-center">วันครบกำหนดชำระ</th>
                        <th class="tableNoWrap text-center">พนักงานที่ออกบิล</th>
                        <th class="tableNoWrap text-center">หมายเหตุ</th>
                        <th class="tableNoWrap text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $st)
                    
                    <tr >
                        <td class="tableNoWrap text-center">{{$st->id}}</td>
                        <td class="tableNoWrap text-center">{{$st->invoice_id}}</td>
                        <td class="tableNoWrap text-center">{{$st->cs_name}}</td>
                        <td class="tableNoWrap text-center">{{$st->total_imei}}</td>
                        <td class="tableNoWrap text-center">{{number_format($st->total_price)}}</td>
                        <td class="tableNoWrap text-center">{{$st->due_date}}</td>
                                      
                        <td class="tableNoWrap text-center">{{$st->user_name}}</td>  
                        <td class="tableNoWrap text-center">{{$st->note}}</td>                   
                        <td class="tableNoWrap text-center">
                            <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-success">ดูข้อมูล</button>
                            <button type="button" class="btn btn-danger">ลบ</button>
                          </div>
                        </td>                  
                       
                    </tr>
                    
    
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                <?php echo $payments->appends(['filter-month' => urldecode(Request::get('filter-month'))])->render(); ?>
            </div>
        </div>
    </div>
    
    
    @endif
    
    @stop
    
    @push('js-footer')
    @endpush
    
    
    @section('scripts')
    @endsection