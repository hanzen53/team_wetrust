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
            <form action="/device-stock-used" method="GET">
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
                    {{--<th class="text-center">ID</th>--}}
                    <th class="text-center">ID</th>
                    {{--<th class="text-center">User</th>--}}
                    <th class="text-center">IMEI</th>
                    <th class="text-center">Phone no</th>
                    <th class="text-center">ทะเบียนรถ V3</th>
                    <th class="text-center">เจ้าของ V3</th>
                    <th class="text-center">Operator</th>
                    {{--<th class="text-center">ผู้ผลิต</th>--}}
                    <th class="text-center">รุ่น</th>
                    {{--<th class="text-center">DLT ชนิด</th>--}}
                    {{--<th class="text-center">DLT แบบ</th>--}}
                    
                    <th class="text-center">วันที่นำเข้า</th>
                    <th class="text-center">ตัวแทน</th>
                    <th class="text-center">ผูกกับรถแล้ว</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stock as $index => $st)
                
                <tr>
                    <td class="text-center">{{$st->id}}</td>
                    <td class="text-center">{{$st->unit_id}}</td>
                    <td class="text-center">{{$st->phone_number}}</td>

                    <td class="text-center">{{$st->phone_number}}</td>
                    <td class="text-center">{{$st->phone_number}}</td>
                    
                    <td class="text-center">{{$st->operator}}</td>
                    {{--<td class="text-center"> {{$st->make}}</td>--}}
                    <td class="text-center">{{$st->gps_model}}</td>
                    {{--<td class="text-center">{{$st->dlt_type}}</td>--}}
                    {{--<td class="text-center">{{$st->dlt_style}}</td>--}}
                    
                    <td class="text-center">{{\Carbon\Carbon::parse($st->created_at)->format('d/m/y H:m')}}</td>
                    <td class="text-center">{{$st->agent_name}}</td>
                    <td class="text-center">
                        @if($st->used == 1)
                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                        @else
                        <i class="fa fa-times text-red" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/device-stock/show/{{$st->id}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                    
                </tr>
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