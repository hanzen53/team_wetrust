@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-file-text-o"></i> เอกสารแจ้งเตือน
                <small class="pull-right">วันที่ {{\Carbon\Carbon::now()->format('d/m/Y')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
       
        เรียน <strong>{{$customer->name}}</strong> <br/>
        <p>สิ่งที่แนบ : กฎระเบียบข้อบังคับตามแบบกรมการขนส่งทางบก</p>
        <p>การแจ้งเรื่อง : ขอระงับการส่งข้อมูล GPS ให้กับกรมการขนส่งทางบก</p>
        บริษัท วี โกลเบิล จำกัด เป็นผู้ให้บริการระบบ GPS ได้ตรวจสอบพบว่ารถในครอบครองของท่าน <br/>
        ยังไม่ได้ชำระค่าบริการให้กับทางบริษัทฯ ซึ่งทางบริษัทได้มีการตรวจสอบพบว่า รถทะเบียนรถที่แนบท้ายเอกสาร เกินกำหนดการชำระค่าบริการ<br/>
        <p></p>
             ในฐานะบริษัทซึ่งเป็นผู้ให้บริการระบบ GPS และมีหน้าที่รับผิดชอบในการส่งข้อมูลการเดินรถที่ถูกต้องครบถ้วน และรวดเร็วให้กับกรมการขนส่งทางบก <br>
        จึงเรียนแจ้งให้ท่านท่านเจ้าของรถทะเบียนรถดังกล่าวทราบว่า ทางบริษัทจะยื่นข้อมูลเพื่อดำเนินการระงับการส่งสัญญาณ GPS <br>
        ให้กับกรมการขนส่งทางบกภายใน 7 วันหลังจากวันที่แจ้ง เรื่องติดตามทวงถามค่าบริการระบบ GPS <br>
        <p></p>
        หากท่านมีความประสงค์ที่จะใช้ระบบติดตาม GPS โปรดติดต่อเพื่อชำระค่าบริการระบบ GPS และค่าบริการต่อสัญญาณ 500 บาท <br>
        ได้ที่แผนกบัญชี ใน วันจันทร์-เสาร์ ตั้งแต่เวลา 8.00-17.00 น.
        <p></p>
        จึงเรียนมาเพื่อทราบ  และขออภัยหากท่านได้ชำระเรียบร้อยแล้ว
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p class="text-right" style="margin-right:10%">
            ............................................................... <br>
                  ผู้บริหาร <br>
            บริษัท วี โกลเบิล จำกัด
        </p>
        
    </div>
    <!-- /.row -->
    
</section>
<!-- /.content -->

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-car"></i> ข้อมูลรถที่ค้างชำระ {{count($cars)}} คัน
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12 col-xs-12 invoice-col">
            <!-- Table row -->

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
                                    {{--<th>จังหวัด</th>--}}
                                    {{--<th>ยี่ห้อ</th>--}}
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
                                </tr>
                                
                                @php
                                $totalPrice += $car['price'];
                                @endphp
                                @endforeach
                                @endif
                           
                                <tr>
                                    <td colspan="5">รวมยอดเงิน</td>
                                    <td class=""> {{number_format($car['price'],2)}} บาท</td>
                                </tr>
                    
                            </tbody>
                        </table>
                        
                    </div>
                    <!-- /.col -->
                </div>

        </div>
    </div>
    <!-- /.row -->
    
</section>
<!-- /.content -->
@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection