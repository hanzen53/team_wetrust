@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'Raw file')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">ข้อมูลดิบ</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form action="/raw-file-csv" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="unit_id" class="col-sm-1 control-label">IMEI</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="unit_id" name="unit_id" placeholder="IMEI" value="{{old('unit_id')}}">
                    </div>
                </div>



                <div class="form-group">
                    <label for="register_model" class="col-sm-1 control-label">ช่วงเวลา</label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control" name="daterange" value="" />
                    </div>
                </div>

                {{--<div class="form-group">--}}
                {{--<label for="register_color" class="col-sm-1 control-label">End time</label>--}}
                {{--<div class="col-sm-3">--}}
                {{--<input type="datetime-local" class="form-control" name="endTime" placeholder="End time" value="{{old('endTime')}}">--}}
                {{--</div>--}}
                {{--</div>--}}


                <button type="submit" class="btn btn-success">Submit</button>

            </form>

            @if(count($data)>0)
                <hr>
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">ข้อมูลที่พบ</h3>
                    </div><!-- /.box-header -->
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อ</th>
                            <th>เบอร์โทร</th>
                            <th>Line</th>
                            <th>Email</th>
                            <th>ดูข้อมูล</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            @endif

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')
    {{--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>--}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script type="text/javascript">
		$(function() {
			$('input[name="daterange"]').daterangepicker({
				"showDropdowns": true,
			}, function(start, end, label) {
				console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
			});
		});
    </script>
@endsection