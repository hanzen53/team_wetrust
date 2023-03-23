@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'CRM')

@section('content_header')

@stop

@section('content')

<style>
    .smallCell
    {
        padding: 10px;
        white-space: nowrap;
    }
</style>

<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ค้นหาข้อมูลลูกค้า</h3>
    </div>
    <div class="box-body">
        <div class="row-fluid">
            <form action="/sale/dashboard" method="GET" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="ชื่อ,เบอร์โทร,line,email">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">ค้นหา</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

@if(count($mySold)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลลูกค้า DLT</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th class="text-center smallCell">ID</th>
                        <th class="text-center smallCell">ชื่อลูกค้า</th>
                        <th class="text-center smallCell">เบอร์โทรศัพท์</th>
                        <th class="text-center smallCell">วันที่นัดติดตั้ง</th>
                        <th class="text-center smallCell">บัตรประชาชน/เอกสารบริษัท</th>
                        <th class="text-center smallCell">เพิ่มรถ</th>
                        <th class="text-center smallCell">ยืนยันข้อมูล</th>
                        <th class="text-center smallCell">พนักงาน</th>
                        <th class="text-center smallCell">วันที่ยืนยัน</th>
                        <th class="text-center smallCell">Action</th>
                    </tr>
                </thead>
                <tbody>
                 
                    @foreach($mySold as $sold)
                    <tr>
                        
                        <th class="text-center smallCell">{{$sold->id}}</th>
                        <td class="text-center smallCell">{{$sold->name}}</td>
                        <td class="text-center smallCell"> {{$sold->tel}}</td>
                        <td class="text-center smallCell"> {{$sold->booking_install_date}}</td>
                        
                        <td class="text-center smallCell">
                            @if($sold->id_card == '') <i class="fa fa-eye text-red" aria-hidden="true"></i> ยังไม่ได้ upload file @else
                                <a href="{{asset($sold->id_card)}}" target="_blank"><i class="fa fa-eye text-green" aria-hidden="true"></i> ดูไฟล์ </a>
                            @endif
                        </td>
                        <td class="text-center smallCell"><a href="/dlt-car-add/{{$sold->id}}"><button class="btn btn-xs bg-olive margin"><i class="fa fa-plus text-white" aria-hidden="true"></i> เพิ่มรถ</button></a></td>
                        
                        <th class="text-center smallCell">
                            @if($sold->confirm == 0) <i class="fa fa-times text-red" aria-hidden="true"></i> @else <i class="fa fa-check text-green" aria-hidden="true"></i> @endif
                        </th>
                        <td class="text-center smallCell">{{$sold->who_confirm_name}}</td>
                        <td class="text-center smallCell"> {{$sold->confirm_date}}</td>
                        <td class="text-center smallCell"> <a href="/sale/show/{{$sold->id}}">Show</a> | <a href="/sale/update/{{$sold->id}}">Edit</a> </td>
                        
                    </tr>
                  
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-center">
                <?php echo $mySold->appends(['q' => urldecode(Request::get('q'))])->render(); ?>
            </div>
        </div>
    </div>
</div>
@endif

@if(count($customerV3)>0)
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลลูกค้า V3</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th class="text-center smallCell">ID</th>
                        <th class="text-center smallCell">ชื่อลูกค้า</th>
                        <th class="text-center smallCell">เบอร์โทรศัพท์</th>
                        <th class="text-center smallCell">วันที่สร้างข้อมูล</th>
                        <th class="text-center smallCell">Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach($customerV3 as $csV3)
                    <tr>
                        
                        <th class="text-center smallCell">{{$csV3->id}}</th>
                        <td class="text-center smallCell">{{$csV3->name}}</td>
                        <td class="text-center smallCell"> {{$csV3->tel}}</td>
                        <td class="text-center smallCell"> {{\Carbon\Carbon::parse($csV3->created_at)->format('d/m/Y')}}</td>
                        <td class="text-center smallCell"> <a href="/sale/create?name={{$csV3->name}}&tel={{$csV3->tel}}&line_id={{$csV3->line}}&username={{$csV3->username}}&email={{$csV3->email}}">สร้างข้อมูลลูกค้า</a></td>

                    </tr>
                   
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-center">
                <?php echo $customerV3->appends(['q' => urldecode(Request::get('q'))])->render(); ?>
            </div>
        </div>
    </div>
</div>
@endif

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection