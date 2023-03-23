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
        
        <form id="address" class="form-horizontal" role="form" method="GET" action="/payment-list-old" enctype="multipart/form-data">
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
                {{-- <label for="content" class="col-sm-1 control-label">ปี</label>
                <div class="col-sm-2">
                    <select name="filter-year" id="filter-year" class="form-control">
                        <option value="0000" @if(Request::get('filter-year') == '0000') selected @endif>ทุกปี</option>
                        <option value="2013" @if(Request::get('filter-year') == '2013') selected @endif>2013</option>
                        <option value="2014" @if(Request::get('filter-year') == '2014') selected @endif>2014</option>
                        <option value="2015" @if(Request::get('filter-year') == '2015') selected @endif>2015</option>
                        <option value="2016" @if(Request::get('filter-year') == '2016') selected @endif>2016</option>
                        <option value="2017" @if(Request::get('filter-year') == '2017') selected @endif>2017</option>
                        <option value="2018" @if(Request::get('filter-year') == '2018') selected @endif>2018</option>
                        <option value="2019" @if(Request::get('filter-year') == '2019') selected @endif>2019</option>
                        <option value="2020" @if(Request::get('filter-year') == '2020') selected @endif>2020</option>
                    </select>
                </div> --}}
                
                <label for="content" class="col-sm-2 control-label">จากข้อมูล</label>
                <div class="col-sm-2">
                    <select name="from_field" id="from_field" class="form-control">
                        <option value="0" @if(Request::get('from_field') == 0) selected @endif>วันติดที่ติดตั้ง</option>
                        <option value="1" @if(Request::get('from_field') == 1) selected @endif>วันที่ครบกำหนดชำระ</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success">ค้นหา</button>
            </div>
        </form>
    </div>
</div>

@if(count($paymentSoon) > 0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title"> รวม ({{count($paymentSoon)}}) รายการ</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-margin">
                <thead>
                    <tr>
                        <th class="tableNoWrap text-center">ID</th>
                        <th class="tableNoWrap text-center">IMEI</th>
                        <th class="tableNoWrap text-center">ทำเบียน</th>
                        <th class="tableNoWrap text-center">ตัวแทน</th>
                        <th class="tableNoWrap text-center">ลูกค้า</th>
                        <th class="tableNoWrap text-center">วันติดที่ติดตั้ง</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentSoon as $index => $st)
                    
                    <tr>
                        <td class="tableNoWrap text-center">{{$st->id}}</td>
                        <td class="tableNoWrap text-center">{{$st->unit_id}}</a></td>
                        <td class="tableNoWrap text-center">{{$st->installed_on_car}}</a></td>
                        <td class="tableNoWrap text-center">{{$st->agent_name}}</td>
                        <td class="tableNoWrap text-center">{{$st->customer_name}}</td>
                        <td class="tableNoWrap text-center">{{Carbon::parse($st->install_date)->format('d-m-Y')}}</td>
                    </tr>
                    
        
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
    @endif


@if(count($unKeyDeviceData) > 0)
<div class="box box-solid box-danger">
    <div class="box-header">
        <h3 class="box-title"> ยังไม่ Key รวม ({{count($unKeyDeviceData)}}) รายการ</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-margin">
                <thead>
                    <tr>
                        <th class="tableNoWrap text-center">ID</th>
                        <th class="tableNoWrap text-center">IMEI</th>
                        <th class="tableNoWrap text-center">ทำเบียน</th>
                        <th class="tableNoWrap text-center">SIM</th>
                        <th class="tableNoWrap text-center">วันติดที่ติดตั้ง</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unKeyDeviceData as $index => $st)
                    
                    <tr>
                        <td class="tableNoWrap text-center">{{$st->id}}</td>
                        <td class="tableNoWrap text-center">{{$st->uniqueId}}</a></td>
                        <td class="tableNoWrap text-center">{{$st->name}}</a></td>
                        <td class="tableNoWrap text-center">{{$st->sim_phone_no}}</td>
                        <td class="tableNoWrap text-center">{{Carbon::parse($st->install_date)->format('d-m-Y')}}</td>
                    </tr>
                    
        
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endif
    
    @stop
    
    @push('js-footer')
    @endpush
    
    
    @section('scripts')
    @endsection