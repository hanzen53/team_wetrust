@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            {{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>--}}
            <h3 class="box-title">ข้อมูลชั่วโมงการทำงาน</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
                <div class="box box-success">
                    {{--<div class="box-header">--}}
                        {{--<h3 class="box-title">ข้อมูลที่พบ</h3>--}}
                    {{--</div><!-- /.box-header -->--}}
                    <table class="table table-striped table-responsive">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">วัน</th>
                            <th class="text-center">เวลาเริ่ม</th>
                            <th class="text-center">เวลาจบ</th>
                            <th class="text-center">รวมเวลา</th>
                            <th class="text-center">รายละเอียดงาน</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($workingTime as $time)
                            <tr>

                                <th class="text-center">{{$i}}</th>
                                <td class="text-center">{{$time->date}}</td>
                                <td class="text-center">{{$time->start_time}}</td>
                                <td class="text-center">{{$time->end_time}}</td>
                                <td class="text-center">{{$time->total_time}}</td>
                                <td class="text-center">{{$time->detail}}</td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                        </tbody>
                    </table>
                </div>


        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection