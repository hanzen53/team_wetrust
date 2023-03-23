@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ค้นหาข้อมูลลูกค้า</h3>
    </div>
    <div class="box-body">
        <form action="/crm/call-center" method="GET" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="ชื่อ,username,เบอร์โทร,line,email">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">ค้นหา</button>
                </span>
            </div>
        </form>
    </div>
</div>


@if(count($dltCustomer)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลลูกค้า DLT</h3>
    </div>
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
            @foreach($dltCustomer as $user)
            <tr>
                
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->tel}}</td>
                <td>{{$user->line_id}}</td>
                <td>{{$user->email}}</td>
                <td> <a href="/sale/show/{{$user->id}}"><button type="button" class="btn btn-success">ตรวจสอบข้อมูล</button></a></td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(count($usersV3)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลลูกค้า V3</h3>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>ชื่อ</th>
                <th>เบอร์โทร</th>
                <th>Line</th>
                <th>Email</th>
                {{-- <th>ดูข้อมูล</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($usersV3 as $user)
            <tr>
                
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->tel}}</td>
                <td>{{$user->line}}</td>
                <td>{{$user->email}}</td>
                {{-- <td> <a href="/user/ticket-list/{{$user->id}}"><button type="button" class="btn btn-success">ตรวจสอบข้อมูล</button></a></td> --}}
                
            </tr>
            @endforeach
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

@endsection