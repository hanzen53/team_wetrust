@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'แจ้งเตือน')

@section('content_header')
    
@stop

@section('content')
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-exclamation-triangle"></i> เอกสารแจ้งเตือนตัดสัญญาณ
                    <small class="pull-right">วันที่ลงข้อมูล {{\Carbon\Carbon::now()->format('d/m/Y H:i')}}</small>
                </h2>
            </div>

        </div>

        <div class="row invoice-info">
            <div class="col-sm-7 col-xs-6 invoice-col">
                <address>
                    <strong class="hidden-print">บริษัท</strong><br>
                    <hr class="hidden-print">
                    <strong>บริษัท วี โกเบิล จำกัด </strong><br>
                    ที่อยู่ : 1237 ถนนพระยาสุเรนทร์ แขวงบางชัน เขตคลองสามวา <br>
                    จังหวัดกรุงเทพมหานคร 10510<br>
                    โทรศัพท์.063-3438559<br>
                </address>
            </div>

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

    </section>


    <section class="invoice">

        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-car"></i> ข้อมูลรถ
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
                                    <th class="hidden-print"><input type="checkbox" id="selectAll" /> Select Car ID</th>
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
                                            <td class="hidden-print"><input type="checkbox" id="{{$car['id']}}" name="selected[]" value="{{$car['id']}}"/> {{$car['id']}}</td>
                                            <td class="align-middle">{{$indexKey+1}}</td>
                                            <td class="align-middle">{{@$car['unit_id']}}</td>
                                            <td class="align-middle">{{@$car['install_date']}}</td>
                                            <td class="align-middle">{{$car['register_name']}}</td>
                                            <td class="align-middle">{{$car['register_chassi']}}</td>
                                            <td class="align-middle">{{@$car['price']}}</td>
                                        </tr>

                                        @php
                                            $totalPrice += $car['price'];
                                        @endphp
                                    @endforeach

                                @endif

                                </tbody>
                            </table>

                            @if(Request::get('action') == 'invoice')
                            <h4 class="pull-right">จำนวนรถที่ต้องชำระค่าบริการ: {{count($cars)}} คัน ราคารวม: {{number_format($totalPrice)}} บาท</h4>
                            @elseif(Request::get('action') == 'warning')
                            <h4 class="pull-right">จำนวนรถที่แจ้งเตือน {{count($cars)}} คัน</h4>
                            @elseif(Request::get('action') == 'danger')
                            <h4 class="pull-right">จำนวนรถที่แจ้งยกเลิก {{count($cars)}} คัน</h4>
                            @endif 
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </section>
@stop

@push('js-footer')

@endpush


@section('scripts')
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>


    <script>


        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน

        $('div.alert').delay(5000).slideUp(700);
    </script>

    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 120,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak']
        });
    </script>

    <script>
        $('#selectAll').click(function (e) {
            $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        });
    </script>

@endsection