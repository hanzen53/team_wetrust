@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [TimeSheet] ')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            {{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มการขาย </a></span>--}}
            <h3 class="box-title">เพิ่มข้อมูลชั่วโมงการทำงาน</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <form id="address" class="form-horizontal" role="form" method="POST" action="/time-sheet" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="form-group">
                    <label for="date" class="col-sm-2 control-label">วันที่</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="date" name="date" placeholder="วันที่">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-sm-2 control-label">เวลาเริ่ม</label>
                    <div class="col-sm-4">
                        <input type="time" class="form-control" id="date" name="date" placeholder="วันที่">
                    </div>
                    <label for="date" class="col-sm-1 control-label">เวลาจบ</label>
                    <div class="col-sm-4">
                        <input type="time" class="form-control" id="date" name="date" placeholder="วันที่">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-sm-2 control-label">รายละเอียดงาน</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="detail" id="detail" cols="30" rows="3"></textarea>
                    </div>
                </div>


                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

            </form>

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection