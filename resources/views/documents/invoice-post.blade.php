@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'WetrustGPS')

@section('content')

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-user"></i> ใบวางบิล เลขที่ {{ $invoiceID }}
                    <small class="pull-right">วันที่ลงข้อมูล {{\Carbon\Carbon::now()->format('d/m/Y')}}</small>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-7 col-xs-6 invoice-col">

                <address>
                    <strong class="hidden-print">บริษัท</strong><br>
                    <hr class="hidden-print">
                    <strong>บริษัท วี โกลเบิล จำกัด </strong><br>
                    ที่อยู่ : 1237 ถนนพระยาสุเรนทร์ แขวงบางชัน  <br>
                    เขตคลองสามวา จังหวัดกรุงเทพมหานคร 10510<br>
                    โทรศัพท์.063-3438559<br>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-5 col-xs-6 invoice-col">

                <address>
                    <strong class="hidden-print">ลูกค้า</strong><br>
                    <hr class="hidden-print">
                    <strong>{{$customer->name}}</strong><br>
                    ชื่อผู้ประกอบการ : {{$customer->business_name}}<br>
                    โทรศัพท์: {{$customer->tel}}<br>
                    ที่อยู่ : {{$customer->address_one}} {{$customer->address_auto}}
                </address>

            </div>
        </div>
    </section>

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-car"></i> ข้อมูลรถที่ค้างชำระ {{count($cars)}} คัน
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-12 col-xs-12 invoice-col">
                <form action="{{Request::url()}}" method="post">
                    @csrf
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                {{-- <th class="hidden-print"><input type="checkbox" id="selectAll" /> Select Car ID</th> --}}
                                <th>ID</th>
                                <th>IMEI</th>
                                <th>วันที่ติดตั้ง</th>
                                <th>ทะเบียน</th>
                                <th>หมายเลขตัวถัง</th>
                                <th>ค่าบริการ</th>

                            </tr>
                            </thead>
                            <tbody>
                                
                                    @if($cars)
                                    @php
                                    $totalCars = count($cars);
                                    $totalPrice = 0;
                                    @endphp
                                    @foreach($cars as $indexKey => $car)
                                    <tr>
                                        {{-- <td class="hidden-print"><input type="checkbox" id="{{$car['id']}}" name="selected[]" value="{{$car['id']}}"/> {{$car['id']}}</td> --}}
                                        <td class="align-middle">{{$indexKey+1}}</td>
                                        <td class="align-middle">{{@$car['unit_id']}}</td>
                                        <td class="align-middle">{{@$car['install_date']}}</td>
                                        <td class="align-middle">{{$car['register_name']}}</td>
                                        <td class="align-middle">{{$car['register_chassi']}}</td>
                                        {{--<td class="align-middle">{{$car['register_province']}}</td>--}}
                                        {{--<td class="align-middle">{{$car['register_make']}}</td>--}}
                                        <td class="align-middle">{{@$car['price']}}</td>
                                        <td class="align-middle">{{@$car['for_year']}}</td>
                                    </tr>
                                    
                                    @php
                                    $totalPrice += $car['price'];
                                    @endphp
                                    @endforeach
                                    @endif
                               
                                    <tr>
                                        <td colspan="5">รวมยอดเงิน</td>
                                        <td class=""> {{number_format($totalPrice,2)}} บาท</td>
                                    </tr>
                        
                                </tbody>
                        </table>

        
                    </div>
                </div>
                </form>
            </div>
        </div>


    </section>

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="page-header">
                   ข้อมูลการชำระเงิน
                </h4>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-12 col-xs-12 invoice-col">
                1. ชำระผ่านบัญชีธนาคาร กรุงไทย ชื่อบัญชี บจ. วีโกลเบิล เลขที่บัญชี <strong>9865718782</strong>   <br>
                2. Scan QR Code ด้านล่างผ่าน Application ของทุกธนาคาร
                <p></p>
                <img src='http://team.wetrustgps.com:3000/static/images_qrcode/<?php echo $invoiceID?>.png' alt="">
            </div>
        </div>


    </section>
@stop

@push('js-footer')

@endpush


@section('scripts')
 
@endsection