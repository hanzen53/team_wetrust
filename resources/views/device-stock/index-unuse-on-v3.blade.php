@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">รวม {{$stock->total()}} IMEIs</h3>
        <div class="box-tools">
            <form action="/device-stock-unused-run-on-v3" method="GET">
                <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="search" class="form-control pull-right" placeholder="Search">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        
        <table id="ticket" class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">IMEI</th>
                    <th class="text-center">ทะเบียนรถ V3</th>
                    <th class="text-center">วันติดตั้ง</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stock as $index => $st)
                
                <tr>
                    <td class="text-center">{{$st->id}}</td>
                    <td class="text-center"><a href="/crm/car-owner?q={{$st->imei}}" target="_blank">{{$st->imei}}</a></td>
                    <td class="text-center">{{$st->name_v3}}</td>
                    <td class="text-center">{{$st->install_date}}</td>
                    <td class="text-center"><a href="/update-run-on-v3/{{$st->imei}}">ผูกเช้ากับรถแล้ว</a> | <a href="#" data-toggle="modal" data-target="#cancel-{{$st->imei}}">ลูกค้ายกเลิกแล้ว</a> </td>
                    
                </tr>



                <div class="modal fade" id="cancel-{{$st->imei}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form action="/device-stock-cancel" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">ยืนยันทำรายการยกเลิก </h4>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="form-group">
                                        <label for="customer_code" class="pull-left">IMEI</label>
                                    <input type="text" class="form-control" name="imei" id="imei" placeholder="imei" value="{{$st->imei}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_code" class="pull-left">หมายเหตุ</label>
                                        <input type="text" class="form-control" name="note" id="note" placeholder="Note" value="">
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        
        <div class="text-center">
            <?php echo $stock->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
        </div>
        
        
        
    </div><!-- /.box-body -->
</div>

@stop

@push('js-footer')

@endpush


@section('scripts')



@endsection