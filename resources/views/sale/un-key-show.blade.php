@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

    @foreach($unKey as $un)
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">ข้อมูลลูกค้า</h3>
            <div class="box-tools">
                <a href="/sale/mark-to-done/{{$un->id}}"> <button type="link" class="btn btn-success"><i class="fa fa-check-square-o"></i>บันทึกข้อมูลเรียบร้อยแล้ว</button></a>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
                <div class="box box-success">



                        <img src="{{asset($un->path)}}" alt="{{$un->file_name}}" class="img-responsive">



                </div>


        </div><!-- /.box-body -->
    </div>
    @endforeach

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection