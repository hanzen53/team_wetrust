@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">ข้อมูลลูกค้า</h3>
            <div class="box-tools">
                {{--<form action="/sale/dashboard" method="get">--}}
                {{--<div class="input-group input-group-sm" style="width: 300px;">--}}
                    {{--<input type="text" name="q" class="form-control pull-right" placeholder="Search">--}}

                    {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--</form>--}}
            </div>
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
                            <th class="text-center">หมายเลขบัตรประชาชน / เลขผู้เลขภาษษี</th>
                            <th class="text-center">ดูข้อมูล</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($unKey as $sold)
                            <tr>

                                <th class="text-center">{{$i}}</th>
                                <td class="text-center"> {{$sold->citizen_id}}</td>
                                <td class="text-center"><a href="/sale/un-key/{{$sold->citizen_id}}"><button class="btn btn-xs bg-olive margin"><i class="fa fa-eye text-white" aria-hidden="true"></i> ดูข้อมูล</button></a></td>
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