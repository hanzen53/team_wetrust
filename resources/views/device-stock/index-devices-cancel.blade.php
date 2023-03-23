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


<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">IMEI ที่ยกเลิก รวม {{$deviceCanceled->total()}} รายการ</h3>
        <div class="box-tools">
            <form action="/device-canceled" method="GET">
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
        <p>
            <a href="#" data-toggle="modal" data-target="#add-new-cancel"><button type="button" name="" id="" class="btn btn-danger btn-lg btn-block">เพิ่มรายการยกเลิก</button></a>
        </p>
        
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-margin">
                <thead>
                    <tr>
                        <th class="text-center tableNoWrap">ID.</th>
                        <th class="text-center tableNoWrap">IMEI</th>
                        <th class="text-center tableNoWrap">Phone no</th>
                        <th class="text-center tableNoWrap">Operator</th>
                        <th class="text-center tableNoWrap">รุ่น</th>
                        <th class="text-center tableNoWrap">ตัวแทน</th>
                        <th class="text-center tableNoWrap">ชื่อลูกค้า</th>
                        <th class="text-center tableNoWrap">วันที่ยกเลิก</th>
                        <th class="text-center tableNoWrap">เหตุผลที่ยกเลิก</th>
                        <th class="text-center tableNoWrap">ดึง SIM กลับ</th>
                        <th class="text-center tableNoWrap">ลบ Master file</th>
                        <th class="text-center tableNoWrap">พนักงาน</th>
                        <th class="text-center tableNoWrap">แก้ไข</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach($deviceCanceled as $index => $st)
                    
                    <tr>
                        <td class="text-center tableNoWrap">{{$st->id}}</td>
                        <td class="text-center tableNoWrap">{{$st->imei}}</td>
                        <td class="text-center tableNoWrap">{{$st->sim_no}}</td>
                        <td class="text-center tableNoWrap">{{$st->sim_operator}}</td>
                        <td class="text-center tableNoWrap">{{$st->gps_model}}</td>
                        <td class="text-center tableNoWrap">{{$st->agent}}</td>
                        <td class="text-center tableNoWrap">{{$st->customer_name}}</td>
                        <td class="text-center tableNoWrap">{{$st->cancel_date}}</td>
                        <td class="text-center tableNoWrap">{{$st->note}}</td>
                        <td class="text-center tableNoWrap">
                            @if($st->rollback_sim == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="text-center tableNoWrap">
                            @if($st->delete_masterfile == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </td>
                        <td class="text-center tableNoWrap">{{$st->staff_name}}</td>
                        <td class="text-center tableNoWrap">{{$st->staff_name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-center tableNoWrap">
            <?php echo $deviceCanceled->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
        </div>
        
        
        
        

        <!-- Modal -->
        <div class="modal fade" id="add-new-cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <form action="/device-canceled" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ยืนยันรายการเพิ่มรายการยกเลิก</span></h4>
                </div>
                <div class="modal-body">

                    
                    <div class="form-group">
                        <label for="name" class="pull-left">ทะเบียนรถ</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ทะเบียนรถ">
                    </div>
                    
                    <div class="form-group">
                        <label for="imei" class="pull-left">IMEI</label>
                        <input type="text" class="form-control" name="imei" id="imei" placeholder="IMEI">
                    </div>
                    
                    <div class="form-group">
                         <label for="car_type" class="pull-left">ประเภทรถ <small class="text-red">รถบ้าน / รถ DLT</small></label>
                         {{-- <input type="text" class="form-control" name="car_type" id="car_type" placeholder="ประเภทรถ"> --}}
                         <select name="car_type" id="car_type" class="form-control">
                             <option value="dlt">รถ DLT</option>
                             <option value="home">รถบ้าน</option>
                         </select>
                    </div>
                    

                    <div class="form-group">
                      <label for="note" class="pull-left">วันที่ยกเลิก</label>
                      <input type="date" class="form-control" name="cancel_date" id="cancel_date" placeholder="เบอร์โทร">
                  </div>
                  
                  
                  <div class="form-group">
                      <label for="note" class="pull-left">หมายเหตุ / สาเหตุที่ยกเลิก</label>
                      <input type="text" class="form-control" name="note" id="note" placeholder="หมายเหตุ">
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
</div><!-- /.box-body -->
</div>

@stop

@push('js-footer')

@endpush


@section('scripts')



@endsection