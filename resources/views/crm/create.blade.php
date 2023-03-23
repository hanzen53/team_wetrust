@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">แจ้งปัญหาไปยังผู้เกี่ยวข้อง</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form class="form-horizontal" role="form" method="POST" action="/user/ticket/create/" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div class="form-group">
                    <label for="car_license" class="col-sm-2 control-label">ทะเบียน</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="car_license" name="car_license" placeholder="ทะเบียน" value="{{$name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject" class="col-sm-2 control-label">เรื่อง</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="เรื่อง">
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">รายละเอียด</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="priority" class="col-sm-2 control-label">ลำดับความสำคัญ</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="priority">
                            @foreach($ticketPriority as $priority)
                                <option value="{{$priority->code}}">{{$priority->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="priority" class="col-sm-2 control-label">ส่งให้ทีม</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="team">
                            @foreach($ticketTeam as $team)
                                <option value="{{$team->code}}">{{$team->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="priority" class="col-sm-2 control-label">ระบุเจ้าหน้า</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="responder">
							<?php $teamName = '' ?>
                            @foreach($usersTeam as $responder)
                                @if ($responder->team == 'T01')
                                    <?php $teamName = 'Sale' ?>
                                @elseif ($responder->team == 'T02')
                                    <?php $teamName = 'Support sale' ?>
                                @elseif ($responder->team == 'T03')
                                    <?php $teamName = 'Admin DLT' ?>
                                @elseif ($responder->team == 'T04')
                                    <?php $teamName = 'Admin System' ?>
                                @elseif ($responder->team == 'T05')
                                    <?php $teamName = 'After sale service' ?>
                                @elseif ($responder->team == 'T06')
                                    <?php $teamName = 'Developer' ?>
                                @elseif ($responder->team == 'T07')
                                    <?php $teamName = 'Technician' ?>
                                @elseif ($responder->team == 'T08')
                                    <?php $teamName = 'PM' ?>
                                @elseif ($responder->team == 'T09')
                                    <?php $teamName = 'Accounting' ?>
                                @endif
                                <option value="{{$responder->id}},{{$responder->name}}"><strong> {{$responder->name}} </strong>({{$teamName}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">ภาพประกอบ</label>
                    <div class="col-sm-10">
                        <p>
                            <input type="file" class="form-control" name="file_1">
                        </p>
                        <p>
                            <input type="file" class="form-control" name="file_2">
                        </p>
                        <p>
                            <input type="file" class="form-control" name="file_3">
                        </p>
                    </div>
                </div>
                <input type="hidden" name="call_center_id" value="{{Auth::user()->id}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">

                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>

            </form>
        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 120,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak']
        });
    </script>
@endsection