@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <span class="pull-left">
                {{-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">ลบข้อมูลนี้</button></span> --}}
            <h3 class="box-title">ยืนยันการลบ</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
        <h1 class="text-center">เพิ่มรายการแจ้งลบ IMEI {{$imei->unit_id}} สมบูรณ์</h1>

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')
@endsection