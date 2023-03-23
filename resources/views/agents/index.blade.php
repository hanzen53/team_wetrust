@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')


<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title"><a href="/agents/create"><span class="text-bold"><i class="fa fa-plus"></i> เพิ่ม ตัวแทน</span></a></h3>
        <div class="box-tools">
            <form action="/agents" method="GET">
                <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="search" class="form-control pull-right" placeholder="Search">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        
        <div class="box-body">
            <div class="table-responsive">
                <table id="ticket" class="table table-striped table-bordered no-margin">
                    <thead>
                        <tr>
                            
                            <th class="text-center">ID</th>
                            <th class="text-center">ชื่อตัวแทน</th>
                            <th class="text-center">Phone no</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $index => $st)
                        
                        <tr>
                            <td class="text-center">{{$st->id}}</td>
                            <td class="text-center">{{$st->agent_name}}</td>
                            <td class="text-center">{{$st->tel}}</td>
                            <td class="text-center">
                                <a href="/agent/show/{{$st->id}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <p></p>
                
                <div class="center-block dataTables_paginate paging_simple_numbers">
                    <?php echo $agents->appends(['search' => urldecode(Request::get('search'))])->render(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

@stop

@push('js-footer')

@endpush


@section('scripts')



@endsection