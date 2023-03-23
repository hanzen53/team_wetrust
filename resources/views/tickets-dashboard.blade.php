@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">งานทั้งหมด</h3>
        <div class="box-tools">
            <form action="/tasks/dashboard" method="GET">
                <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="q" class="form-control pull-right" placeholder="Search">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        
        {{-- <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div> --}}
        
        
        {{--<div class="box-header">--}}
            {{--<h3 class="box-title">ข้อมูลที่พบ</h3>--}}
            {{--</div><!-- /.box-header -->--}}
            <table id="ticket" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        {{--<th class="text-center">ID</th>--}}
                        <th class="text-center">ID</th>
                        {{--<th class="text-center">User</th>--}}
                        <th class="text-center">Name</th>
                        <th class="text-center">Problem</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Status</th>
                        {{--<th class="text-center">Team</th>--}}
                        <th class="text-center">Poster</th>
                        <th class="text-center">Responder</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $ticket_open = 0?>
                    <?php $ticket_processing = 0?>
                    <?php $ticket_close = 0?>
                    @foreach($tickets as $index => $ticket)
                    
                    <tr>
                        {{--<th class="text-center">{{$index+1}}</th>--}}
                        <td class="text-center">{{$ticket->id}}</td>
                        {{--<td class="text-center">{{$ticket->users->username}}</td>--}}
                        <td class="text-center">{{$ticket->car_license}}</td>
                        <td class="text-center"> {{$ticket->subject}}</td>
                        <td class="text-center">
                            @if($ticket->priority == 'P01')
                            <i class="fa fa-smile-o fa-2x text-success" aria-hidden="true"></i>
                            {{--<span class="label label-info">น้อย</span> --}}
                            @elseif($ticket->priority == 'P02')
                            <i class="fa fa-meh-o fa-2x text-warning" aria-hidden="true"></i>
                            {{--<span class="label label-warning">ปานกลาง</span> --}}
                            @else
                            <i class="fa fa-frown-o fa-2x text-danger" aria-hidden="true"></i>
                            {{--<span class="label label-danger">สูง</span> --}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($ticket->status == 'S01')
                            <?php $ticket_open = $ticket_open+1?>
                            <span class="label label-danger">เปิด</span>
                            @elseif($ticket->status == 'S02')
                            <?php $ticket_processing = $ticket_processing+1?>
                            <span class="label label-primary">กำลังดำเนินการ</span>
                            @elseif($ticket->status == 'S03')
                            <?php $ticket_close = $ticket_close+1?>
                            <span class="label label-success">ปิด</span>
                            @endif
                        </td>
                        
                        <td class="text-center">{{$ticket->call_center_name}}</td>
                        <td class="text-center">{{$ticket->responder_name}}</td>
                        <td class="text-center">{{\Carbon\Carbon::parse($ticket->created_at)->format('d/m/y H:m')}}</td>
                        <td class="text-center">
                            <a href="/user/ticket/detail/{{$ticket->id}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-center">
                <?php echo $tickets->appends(['q' => urldecode(Request::get('q'))])->render(); ?>
            </div>
            
            
            
        </div><!-- /.box-body -->
    </div>
    
    @stop
    
    @push('js-footer')
    
    @endpush
    
    
    @section('scripts')
    <script>
        $(document).ready(function() {
            $('#ticket').DataTable({
                "lengthMenu": [50,100,200,500,1000],
            });
        })
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
    
    <script>
        
        var ctx = document.getElementById("myChart");
        
        // For a pie chart
        var myChart = new Chart(ctx,{
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?php echo $ticket_open;?>, <?php echo $ticket_processing;?>,<?php echo $ticket_close;?>],
                    backgroundColor: [
                    "Red",
                    "Blue",
                    "Green"
                    ],
                    label: 'Tickets'
                }],
                labels: [
                "ยังไม่ดำเนินการ (<?php echo $ticket_open;?>) " ,
                "อยู่ระหว่างดำเนินการ (<?php echo $ticket_processing;?>) " ,
                "ปิดงานแล้ว (<?php echo $ticket_close;?>) " ,
                ]
            },
            options: {
                responsive: true
            }
        });
        
    </script>
    @endsection