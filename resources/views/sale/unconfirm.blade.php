@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

{{-- <div class="box box-solid box-primary">
    <div class="box-body">
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div> --}}

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลลูกค้ารอยืนยันข้อมูล ({{$unConfirm->total()}})</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row-fluid">
            <form action="/confirm-customer" method="GET" enctype="multipart/form-data">
                {{-- {{csrf_field()}} --}}
                <form class="form-horizontal" role="form" method="GET" action="">
                    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}" />--}}
                    
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="ชื่อ,เบอร์โทร,line,email">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">ค้นหา</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
                
            </form>
        </div>
        
        <p></p>
        
        <div class="box box-success table-responsive">
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">ชื่อลูกค้า</th>
                        <th class="text-center">เบอร์โทรศัพท์</th>
                        <th class="text-center">วันที่นัดติดตั้ง</th>
                        <th class="text-center">บัตรประชาชน/เอกสารบริษัท</th>
                        {{-- <th class="text-center">เพิ่มรถ</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1?>
                    @foreach($unConfirm as $sold)
                    <tr>
                        
                        <th class="text-center">{{$sold->id}}</th>
                        <td class="text-center">{{$sold->name}}</td>
                        <td class="text-center"> {{$sold->tel}}</td>
                        <td class="text-center"> {{$sold->booking_install_date}}</td>
                        
                        <td class="text-center">
                            @if($sold->id_card == '') <i class="fa fa-eye text-red" aria-hidden="true"></i> ยังไม่ได้ upload file @else
                            <a href="{{asset($sold->id_card)}}" target="_blank"><i class="fa fa-eye text-green" aria-hidden="true"></i> ดูไฟล์ </a>@endif
                        </td>
                        {{-- <td class="text-center"><a href="/dlt-car-add/{{$sold->id}}"><button class="btn btn-xs bg-olive margin"><i class="fa fa-plus text-white" aria-hidden="true"></i> เพิ่มรถ</button></a></td> --}}
                        <td class="text-center"> <a href="/sale/show/{{$sold->id}}">Show</a> | <a href="/sale/update/{{$sold->id}}">Edit</a> </td>
                    </tr>
                    <?php $i++?>
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-center">
                <?php echo $unConfirm->appends(['q' => urldecode(Request::get('q'))])->render(); ?>
            </div>
        </div>
        
        
    </div><!-- /.box-body -->
</div>

@stop

@push('js-footer')

@endpush


@section('scripts')


<script>
    
    var ctx = document.getElementById("myChart");
    
    var myChart = new Chart(ctx,{
        type: 'pie',
        data: {
            datasets: [{
                data: [<?php echo $countConfirm;?>,<?php echo $countUnConfirm;?>],
                backgroundColor: [
                "Green",
                "Red",
                ],
                label: 'ลูกค้า'
            }],
            labels: [
            "ยืนยันไปแล้ว (<?php echo $countConfirm;?>)" ,
            "รอยืนยัน (<?php echo $countUnConfirm;?>) " ,
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    
</script>
@endsection