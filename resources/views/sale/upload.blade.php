@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'Upload files')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">หมายเลขบัตรประชาชน / เลขประจำตัวผู้เสียภาษี</h3>
        </div><!-- /.box-header -->
        <div class="box-body">open
            <form  action="/sale/quick" method="GET">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="icon"><span class="s7-cloud-upload"></span></div>
                    <input type="text" name="citizen_id" class="form-control" value="{{ app('request')->input('citizen_id') }}">
                </div>

                <div class="form-group">
                <button type="submit" class="btn btn-success pull-right">เริ่มการส่งไฟล์</button>
                </div>
            </form>
        </div><!-- /.box-body -->
    </div>

    @if($uploadForm == true)
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Upload</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form id="my-awesome-dropzone" action="/sale/quick" class="dropzone" method="post" enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="dz-message">
                    <div class="icon"><span class="s7-cloud-upload"></span></div>
                    <h2>ลากไฟล์ภาพลงที่นี้ หรือ คลิกที่ นี่</h2><span class="note">(สามารถเลือกได้หลายๆไฟล์พร้อมๆกัน)</span>
                </div>
                <input type="hidden" name="who_upload" value="{{Auth::user()->id}}">
                <input type="hidden" name="citizen_id" value="{{ app('request')->input('citizen_id') }}">
            </form>
        </div><!-- /.box-body -->
    </div>
    @endif

@stop

@push('js-footer')
    <script src="{{asset('js/dropzone.js')}}"></script>
@endpush


@section('scripts')

@endsection