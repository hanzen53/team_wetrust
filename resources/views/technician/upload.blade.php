@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'Upload files')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Upload ภาพถ่ายการติดตั้ง</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form id="my-awesome-dropzone" action="/upload-data" class="dropzone" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="dz-message">
                    <div class="icon"><span class="s7-cloud-upload"></span></div>
                    <h2>ลากไฟล์ภาพลงที่นี้ หรือ คลิกที่ นี่</h2><span class="note">(สามารถเลือกได้หลายๆไฟล์พร้อมๆกัน)</span>
                </div>
                <input type="hidden" name="imei" value="kokarat">
                <input type="hidden" name="who_upload" value="{{Auth::user()->id}}">
                <input type="hidden" name="prefix" value="">
                <input type="hidden" name="save_to_path" value="">
            </form>
        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')
    <script src="{{asset('js/dropzone.js')}}"></script>
@endpush


@section('scripts')

@endsection