<?php
use Illuminate\Support\Facades\Auth;
use \App\User;

$authLogin = Auth::user();
?>
@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-sm-8">

            @if (session('error'))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>  {{ session('error') }}<br><br>
                </div>
            @endif

            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{$ticket->subject}}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <p>
                        {!!html_entity_decode($ticket->content)!!}
                    </p>
                    @if(count($ticketImages)>0)
                        <hr>
                        <h3>Images</h3>
                        <ul>
                            @foreach($ticketImages as $image)
                                <li> <a href="{{asset($image->path)}}" target="_blanks">{{$image->file_name}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div><!-- /.box-body -->
            </div>

            @if(count($notes)>0)
                <div class="box box-solid box-info">
                    <div class="box-header">
                        <h3 class="box-title">รายการแก้ไข</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="direct-chat-messages">
                            @foreach($notes as $note)

                                <div class="direct-chat-msg @if($note->who_notes == $authLogin->id) right  @endif">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name  @if($note->who_notes != $authLogin->id) pull-left @else pull-right @endif">{{User::find($note->who_notes)->name}}</span>
                                        <span class="direct-chat-timestamp @if($note->who_notes != $authLogin->id) pull-right @else pull-left @endif">{{$note->created_at}}</span>
                                    </div><!-- /.direct-chat-info -->
                                    <img class="direct-chat-img" src="{{User::find($note->who_notes)->avatar}}" alt="message user image"><!-- /.direct-chat-img -->
                                    <div class="direct-chat-text">
                                        {!!html_entity_decode($note->content)!!}
                                    </div><!-- /.direct-chat-text -->
                                </div><!-- /.direct-chat-msg -->
                                <br>


                            @endforeach
                        </div><!--/.direct-chat-messages-->
                    </div><!-- /.box-body -->
                </div>
            @endif


            <div class="box box-solid box-success">
                <div class="box-header">
                    <h3 class="box-title">Note รายการแก้ไข</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST" action="/user/ticket/create/note/{{$ticket->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
                    </form>
                </div><!-- /.box-body -->
            </div>



        </div>
        <div class="col-sm-4">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Update สถานะ</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST" action="/user/ticket/update/{{$ticket->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="priority" class="col-sm-12 control-label">สถานะ</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="status">
                                    @foreach($ticketStatus as $status)
                                        <option value="{{$status->code}}" @if($status->code == $ticket->status) selected @endif>{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                        {{--<label for="subject" class="col-sm-12 control-label">เรื่อง</label>--}}
                        {{--<div class="col-sm-12">--}}
                        {{--<input type="text" class="form-control" id="subject" name="subject" placeholder="เรื่อง" value="{{$ticket->subject}}">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="content" class="col-sm-12 control-label">รายละเอียด</label>--}}
                        {{--<div class="col-sm-12">--}}
                        {{--<textarea class="form-control" name="content" id="content" cols="30" rows="10">{{$ticket->content}}</textarea>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="priority" class="col-sm-12 control-label">ลำดับความสำคัญ</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="priority">
                                    @foreach($ticketPriority as $priority)
                                        <option value="{{$priority->code}}" @if($priority->code == $ticket->priority) selected @endif>{{$priority->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="priority" class="col-sm-12 control-label">ส่งให้ทีม</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="team">
                                    @foreach($ticketTeam as $team)
                                        <option value="{{$team->code}}" @if($team->code == $ticket->team) selected @endif>{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priority" class="col-sm-12 control-label">ระบุเจ้าหน้า</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="responder">
                                    <option value="0">เลือกผู้รับผิดชอบงาน</option>
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

                        <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
                    </form>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>



@stop

@push('js-footer')

@endpush


@section('scripts')
@section('scripts')
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script>
		tinymce.init({
			selector: 'textarea',
			height: 110,
			theme: 'modern',
			plugins: [
				'advlist autolink lists link image charmap print preview hr anchor pagebreak']
		});
    </script>
@endsection