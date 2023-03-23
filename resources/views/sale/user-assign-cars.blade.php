@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')
<link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
@stop

@section('content')



<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-car"></i> เลือกรถที่ต้องการ
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12 col-xs-12 invoice-col">
            <!-- Table row -->
            <form action="/parent-user-assign-car/{{$id}}?sub-user={{Request::get('sub-user')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="hidden-print"><input type="checkbox" id="selectAll" /> Select Car ID</th>
                                    <th>IMEI</th>
                                    <th>วันที่ติดตั้ง</th>
                                    <th>ทะเบียน</th>
                                    <th>หมายเลขตัวถัง</th>
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
                                    <td class="hidden-print"><input type="checkbox" id="{{$car['id']}}" name="devices[]" value="{{@$car['unit_id']}}"/> {{$car['id']}}</td>
                                    <td class="align-middle">{{@$car['unit_id']}}</td>
                                    <td class="align-middle">{{@$car['install_date']}}</td>
                                    <td class="align-middle">{{$car['register_name']}}</td>
                                    <td class="align-middle">{{$car['register_chassi']}}</td>
                                </tr>
                                
                                <!-- /.modal -->
                                @endforeach
                                
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                
                <button class="btn btn-success pull-right" type="submit" >โยนรถให้ User</button>
            </form>
        </div>
    </div>
    <!-- /.row -->
    
</section>
<!-- /.content -->
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