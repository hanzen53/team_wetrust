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
                <i class="fa fa-user"></i> ใบวางบิล
                <small class="pull-right">วันที่ลงข้อมูล {{\Carbon\Carbon::now()->format('d/m/Y H:i')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
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
    <!-- /.row -->
    
</section>
<!-- /.content -->

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-car"></i> ข้อมูลรถ
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
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
                                    $totalPrice = (int)$totalCars*2500;
                                    @endphp
                                    @foreach($cars as $indexKey => $car)
                                    <tr>
                                        <td class="hidden-print"><input type="checkbox" id="{{$car['id']}}" name="selected[]" value="{{$car['id']}}"/> {{$car['id']}}</td>
                                        <td class="align-middle">{{$indexKey+1}}</td>
                                        <td class="align-middle">{{@$car['unit_id']}}</td>
                                        <td class="align-middle">{{@$car['install_date']}}</td>
                                        <td class="align-middle">{{@$car['register_name']}}</td>
                                        <td class="align-middle">{{@$car['register_chassi']}}</td>
                                        <td class="align-middle"><input type="text" name="price[]" id="" value="2500"></td>
                                        <td class="align-middle"><input type="text" name="for_year[]" id="" value="{{ $year }}"></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    
                    </div>
                   

                    <div class="form-group">
                        <select name="document-type" id="" class="form-control">
                                <option value="invoice">สร้าง Invoice ออกเอกสารชำระค่าบริการ</option>
                                <option value="warning">สร้างเอกสารแจ้งเตือน</option>
                                <option value="cancel">สร้างเอกสารแจ้งยกเลิก</option>
                        </select>
                </div>
                <div class="form-group">
                    
                        <button class="btn btn-success btn-block" type="submit" value="invoice">สร้างเอกสาร</button>
                </div>
                </div>


           
                
                {{-- <button class="btn btn-warning" type="submit" name="action" value="warning">สร้างเอกสารแจ้งเตือน</button>
                <button class="btn btn-danger" type="submit" name="action" value="danger">สร้างเอกสารแจ้งยกเลิก</button> --}}
            </form>
        </div>
    </div>
    <!-- /.row -->
    
</section>


<section class="invoice">
    <div class="row">

        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-sticky-note-o"></i> Note
            </h2>
            
            <form action="/dlt-customer-note" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="">
                        <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                    </div>
                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                    
                    
                </div>
                
                <div class="form-group">
                    <button class="btn btn-success pull-right" type="submit">ส่งข้อมูล</button>
                </div>
                
            </form>
        </div>
    </div>
    
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="cs-{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form action="/confirm-customer" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">ยืนยันข้อมูลลูกค้า </h4>
                    </div>
                    <div class="modal-body">
                        
                        กรุณาตรวจสอบข้อมูลให้ครบถ้วนการบันทึกข้อมูลจะบันทึก <h1>{{Request::user()->name}} </h1>ว่าเป็นผู้ยืนยันข้อมูล
                        <input type="hidden" value="{{$customer->id}}" name="customer_id">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
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
<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>
<script src="{{asset('js/dropzone.js')}}"></script>

<script>
    $.Thailand({
        database: '/js/jquery.Thailand.js/database/db.json',
        
        
        //
        onDataFill: function(data){
            console.info('Data Filled', data);
            var html =  'ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
            //                $('#addressAuto').prepend('<div class="alert alert-success">' + html + '</div>');
            $('input[name="owner_address_auto"]').val(html);
            $('input[name="ownership_address_auto"]').val(html);
        },
        
        
        $search: $('#address [name="search"]'),
        $name: $('#address [name="name"]'),
    });
    
    
    $('#address [name="search"]').change(function(){
        console.log('Search', this.value);
    });
    
    $('#register_province').select2();
    $('#register_type').select2();
    $('#register_make').select2();
    
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