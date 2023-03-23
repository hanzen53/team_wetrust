@extends('adminlte::page')

@push('css-head')
    <link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
@endpush

@section('title', ' [Sale] ')

@section('content_header')

@stop

@section('content')

	<div class="box box-solid box-primary">
		<div class="box-header">
			<h3 class="box-title">Upload ภาพ</h3>
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
				<input type="hidden" name="prefix" value="{{$dltCar->owner_id}}">
				<input type="hidden" name="car_id" value="{{$dltCar->id}}">
				<input type="hidden" name="save_to_path" value="dlt-cars">
			</form>
		</div><!-- /.box-body -->
	</div>


	<div class="box box-solid box-primary">
		<div class="box-header">
			<h3 class="box-title">ภาพที่เกี่ยวข้อง</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-xs-12 table-responsive">
					@foreach($images as $indexKey => $img)
						<div class="row">
							<div class="col-sm-1">{{$indexKey+1}}</div>
							<div class="col-sm-2"><a href="{{url($img->path)}}" target="_blank"><img src="{{asset($img->path)}}" alt="" width="80" height="80"></a></div>
							<div class="col-sm-7">{{$img->path}}</div>
							<div class="col-sm-2">{{$img->created_at}}</div>
						</div>
					@endforeach
				</div>
				<!-- /.col -->
			</div>
		</div><!-- /.box-body -->
	</div>


    <div class="box box-solid box-primary">
        <div class="box-header">
            {{--<span class="pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> <a href="/sale/create"> เพิ่มรถเข้าระบบ </a></span>--}}
            <h3 class="box-title">รายการจดทะเบียน</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <form id="address" class="form-horizontal" role="form" method="POST" action="/dlt-car-update/{{$dltCar->id}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                {{-- <h3 class="box-title">รายการจดทะเบียน</h3> --}}
                <hr>
                <div class="form-group">
					<label for="register_name" class="col-sm-2 control-label">เลขทะเบียน</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="register_name" placeholder="เลขทะเบียน" value="{{$dltCar->register_name}}">
					</div>
                    <label for="register_date" class="col-sm-2 control-label">วันจดทะเบียน</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control datepicker" id="register_date" name="register_date" placeholder="วันจดทะเบียน" value="{{$dltCar->register_date}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_province" class="col-sm-2 control-label">จังหวัด</label>
                    <div class="col-sm-3">
                        <select name="register_province" id="register_province" class="form-control select2" style="width: 100%;">
                            <option value="1" @if($dltCar->register_province == 1) selected @endif>กรุงเทพมหานคร</option>
                            <option value="805 @if($dltCar->register_province == 805) selected @endif">กระบี่</option>
                            <option value="701 @if($dltCar->register_province == 701) selected @endif">กาญจนบุรี</option>
                            <option value="406 @if($dltCar->register_province == 406) selected @endif">กาฬสินธุ์</option>
                            <option value="604" @if($dltCar->register_province == 604) selected @endif>กำแพงเพชร</option>
                            <option value="405" @if($dltCar->register_province == 405) selected @endif>ขอนแก่น</option>
                            <option value="205" @if($dltCar->register_province == 205) selected @endif>จันทบุรี</option>
                            <option value="202" @if($dltCar->register_province == 202) selected @endif>ฉะเชิงเทรา</option>
                            <option value="203" @if($dltCar->register_province == 203) selected @endif>ชลบุรี</option>
                            <option value="100" @if($dltCar->register_province == 100) selected @endif>ชัยนาท</option>
                            <option value="300" @if($dltCar->register_province == 300) selected @endif>ชัยภูมิ</option>
                            <option value="800" @if($dltCar->register_province == 800) selected @endif>ชุมพร</option>
                            <option value="500" @if($dltCar->register_province == 500) selected @endif>เชียงราย</option>
                            <option value="502" @if($dltCar->register_province == 502) selected @endif>เชียงใหม่</option>
                            <option value="901" @if($dltCar->register_province == 901) selected @endif>ตรัง</option>
                            <option value="206" @if($dltCar->register_province == 206) selected @endif>ตราด</option>
                            <option value="602" @if($dltCar->register_province == 602) selected @endif>ตาก</option>
                            <option value="200" @if($dltCar->register_province == 200) selected @endif>นครนายก</option>
                            <option value="702" @if($dltCar->register_province == 702) selected @endif>นครปฐม</option>
                            <option value="403" @if($dltCar->register_province == 403) selected @endif>นครพนม</option>
                            <option value="305" @if($dltCar->register_province == 305) selected @endif>นครราชสีมา</option>
                            <option value="804" @if($dltCar->register_province == 804) selected @endif>นครศรีธรรมราช</option>
                            <option value="607" @if($dltCar->register_province == 607) selected @endif>นครสวรรค์</option>
                            <option value="107" @if($dltCar->register_province == 107) selected @endif>นนทบุรี</option>
                            <option value="906" @if($dltCar->register_province == 906) selected @endif>นราธิวาส</option>
                            <option value="504" @if($dltCar->register_province == 504) selected @endif>น่าน</option>
                            <option value="309" @if($dltCar->register_province == 309) selected @endif>บึงกาฬ</option>
                            <option value="304" @if($dltCar->register_province == 304) selected @endif>บุรีรัมย์</option>
                            <option value="106" @if($dltCar->register_province == 106) selected @endif>ปทุมธานี</option>
                            <option value="707" @if($dltCar->register_province == 707) selected @endif>ประจวบคีรีขันธ์</option>
                            <option value="201" @if($dltCar->register_province == 201) selected @endif>ปราจีนบุรี</option>
                            <option value="904" @if($dltCar->register_province == 904) selected @endif>ปัตตานี</option>
                            <option value="105" @if($dltCar->register_province == 105) selected @endif>พระนครศรีอยุธยา</option>
                            <option value="503" @if($dltCar->register_province == 503) selected @endif>พะเยา</option>
                            <option value="803" @if($dltCar->register_province == 803) selected @endif>พังงา</option>
                            <option value="900" @if($dltCar->register_province == 900) selected @endif>พัทลุง</option>
                            <option value="605" @if($dltCar->register_province == 605) selected @endif>พิจิตร</option>
                            <option value="603" @if($dltCar->register_province == 603) selected @endif>พิษณุโลก</option>
                            <option value="706" @if($dltCar->register_province == 706) selected @endif>เพชรบุรี</option>
                            <option value="606" @if($dltCar->register_province == 606) selected @endif>เพชรบูรณ์</option>
                            <option value="507" @if($dltCar->register_province == 607) selected @endif>แพร่</option>
                            <option value="806" @if($dltCar->register_province == 806) selected @endif>ภูเก็ต</option>
                            <option value="407" @if($dltCar->register_province == 407) selected @endif>มหาสารคาม</option>
                            <option value="409" @if($dltCar->register_province == 409) selected @endif>มุกดาหาร</option>
                            <option value="501" @if($dltCar->register_province == 501) selected @endif>แม่ฮ่องสอน</option>
                            <option value="301" @if($dltCar->register_province == 301) selected @endif>ยโสธร</option>
                            <option value="905" @if($dltCar->register_province == 905) selected @endif>ยะลา</option>
                            <option value="408" @if($dltCar->register_province == 408) selected @endif>ร้อยเอ็ด</option>
                            <option value="801" @if($dltCar->register_province == 801) selected @endif>ระนอง</option>
                            <option value="204" @if($dltCar->register_province == 204) selected @endif>ระยอง</option>
                            <option value="703" @if($dltCar->register_province == 703) selected @endif>ราชบุรี</option>
                            <option value="102" @if($dltCar->register_province == 102) selected @endif>ลพบุรี</option>
                            <option value="506" @if($dltCar->register_province == 506) selected @endif>ลำปาง</option>
                            <option value="505" @if($dltCar->register_province == 505) selected @endif>ลำพูน</option>
                            <option value="401" @if($dltCar->register_province == 401) selected @endif>เลย</option>
                            <option value="303" @if($dltCar->register_province == 303) selected @endif>ศรีสะเกษ</option>
                            <option value="404" @if($dltCar->register_province == 404) selected @endif>สกลนคร</option>
                            <option value="902" @if($dltCar->register_province == 902) selected @endif>สงขลา</option>
                            <option value="903" @if($dltCar->register_province == 903) selected @endif>สตูล</option>
                            <option value="108" @if($dltCar->register_province == 108) selected @endif>สมุทรปราการ</option>
                            <option value="705" @if($dltCar->register_province == 705) selected @endif>สมุทรสงคราม</option>
                            <option value="704" @if($dltCar->register_province == 707) selected @endif>สมุทรสาคร</option>
                            <option value="207" @if($dltCar->register_province == 207) selected @endif>สระแก้ว</option>
                            <option value="104" @if($dltCar->register_province == 104) selected @endif>สระบุรี</option>
                            <option value="101" @if($dltCar->register_province == 101) selected @endif>สิงห์บุรี</option>
                            <option value="601" @if($dltCar->register_province == 601) selected @endif>สุโขทัย</option>
                            <option value="700" @if($dltCar->register_province == 700) selected @endif>สุพรรณบุรี</option>
                            <option value="802" @if($dltCar->register_province == 802) selected @endif>สุราษฎร์ธานี</option>
                            <option value="306" @if($dltCar->register_province == 306) selected @endif>สุรินทร์</option>
                            <option value="400" @if($dltCar->register_province == 400) selected @endif>หนองคาย</option>
                            <option value="308" @if($dltCar->register_province == 308) selected @endif>หนองบัวลำภู</option>
                            <option value="103" @if($dltCar->register_province == 103) selected @endif>อ่างทอง</option>
                            <option value="307" @if($dltCar->register_province == 307) selected @endif>อำนาจเจริญ</option>
                            <option value="402" @if($dltCar->register_province == 402) selected @endif>อุดรธานี</option>
                            <option value="600" @if($dltCar->register_province == 600) selected @endif>อุตรดิตถ์</option>
                            <option value="608" @if($dltCar->register_province == 608) selected @endif>อุทัยธานี</option>
                            <option value="302" @if($dltCar->register_province == 302) selected @endif>อุบลราชธานี</option>
                        </select>
                    </div>
					<label for="register_type" class="col-sm-2 control-label">ประเภท</label>
					<div class="col-sm-3">
						{{--<input type="text" class="form-control" name="register_type" placeholder="ประเภท" value="{{$dltCar->register_type}}">--}}
						<select class="form-control select2" name="register_type" id="register_type">
							<option value="0000"  @if($dltCar->register_type == 0000) selected @endif>0000	รถส่วนบุคล</option>
							<option value="1000"  @if($dltCar->register_type == 1000) selected @endif>1000	รถโดยสาร ไม่ได้ระบุมาตรฐานรถและประเภทการขนส่ง</option>
							<option value="1101"  @if($dltCar->register_type == 1101) selected @endif>1101	รถโดยสาร มาตรฐาน 1 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1102"  @if($dltCar->register_type == 1102) selected @endif>1102	รถโดยสาร มาตรฐาน 1 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1111"  @if($dltCar->register_type == 1111) selected @endif>1111	รถโดยสาร มาตรฐาน 1 ก ส่วนบุคคล</option>
							<option value="1112"  @if($dltCar->register_type == 1112) selected @endif>1112	รถโดยสาร มาตรฐาน 1 ข ส่วนบุคคล</option>
							<option value="1121"  @if($dltCar->register_type == 1121) selected @endif>1121	รถโดยสาร มาตรฐาน 1 ก ไม่ประจำทาง</option>
							<option value="1122"  @if($dltCar->register_type == 1122) selected @endif>1122	รถโดยสาร มาตรฐาน 1 ข ไม่ประจำทาง</option>
							<option value="1131"  @if($dltCar->register_type == 1131) selected @endif>1131	รถโดยสาร มาตรฐาน 1 ก ประจำทาง</option>
							<option value="1132"  @if($dltCar->register_type == 1132) selected @endif>1132	รถโดยสาร มาตรฐาน 1 ข ประจำทาง</option>
							<option value="1201"  @if($dltCar->register_type == 1201) selected @endif>1201	รถโดยสาร มาตรฐาน 2 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1202"  @if($dltCar->register_type == 1202) selected @endif>1202	รถโดยสาร มาตรฐาน 2 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1203"  @if($dltCar->register_type == 1203) selected @endif>1203	รถโดยสาร มาตรฐาน 2 ค ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1204"  @if($dltCar->register_type == 1204) selected @endif>1204	รถโดยสาร มาตรฐาน 2 ง ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1205"  @if($dltCar->register_type == 1205) selected @endif>1205	รถโดยสาร มาตรฐาน 2 จ ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1211"  @if($dltCar->register_type == 1211) selected @endif>1211	รถโดยสาร มาตรฐาน 2 ก ส่วนบุคคล</option>
							<option value="1212"  @if($dltCar->register_type == 1212) selected @endif>1212	รถโดยสาร มาตรฐาน 2 ข ส่วนบุคคล</option>
							<option value="1213"  @if($dltCar->register_type == 1213) selected @endif>1213	รถโดยสาร มาตรฐาน 2 ค ส่วนบุคคล</option>
							<option value="1214"  @if($dltCar->register_type == 1214) selected @endif>1214	รถโดยสาร มาตรฐาน 2 ง ส่วนบุคคล</option>
							<option value="1215"  @if($dltCar->register_type == 1215) selected @endif>1215	รถโดยสาร มาตรฐาน 2 จ ส่วนบุคคล</option>
							<option value="1221"  @if($dltCar->register_type == 1221) selected @endif>1221	รถโดยสาร มาตรฐาน 2 ก ไม่ประจำทาง</option>
							<option value="1222"  @if($dltCar->register_type == 1222) selected @endif>1222	รถโดยสาร มาตรฐาน 2 ข ไม่ประจำทาง</option>
							<option value="1223"  @if($dltCar->register_type == 1223) selected @endif>1223	รถโดยสาร มาตรฐาน 2 ค ไม่ประจำทาง</option>
							<option value="1224"  @if($dltCar->register_type == 1224) selected @endif>1224	รถโดยสาร มาตรฐาน 2 ง ไม่ประจำทาง</option>
							<option value="1225"  @if($dltCar->register_type == 1225) selected @endif>1225	รถโดยสาร มาตรฐาน 2 จ ไม่ประจำทาง</option>
							<option value="1231"  @if($dltCar->register_type == 1231) selected @endif>1231	รถโดยสาร มาตรฐาน 2 ก ประจำทาง</option>
							<option value="1232"  @if($dltCar->register_type == 1232) selected @endif>1232	รถโดยสาร มาตรฐาน 2 ข ประจำทาง</option>
							<option value="1233"  @if($dltCar->register_type == 1233) selected @endif>1233	รถโดยสาร มาตรฐาน 2 ค ประจำทาง</option>
							<option value="1234"  @if($dltCar->register_type == 1234) selected @endif>1234	รถโดยสาร มาตรฐาน 2 ง ประจำทาง</option>
							<option value="1235"  @if($dltCar->register_type == 1235) selected @endif>1235	รถโดยสาร มาตรฐาน 2 จ ประจำทาง</option>
							<option value="1301"  @if($dltCar->register_type == 1301) selected @endif>1301	รถโดยสาร มาตรฐาน 3 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1302"  @if($dltCar->register_type == 1302) selected @endif>1302	รถโดยสาร มาตรฐาน 3 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1303"  @if($dltCar->register_type == 1303) selected @endif>1303	รถโดยสาร มาตรฐาน 3 ค ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1304"  @if($dltCar->register_type == 1304) selected @endif>1304	รถโดยสาร มาตรฐาน 3 ง ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1305"  @if($dltCar->register_type == 1305) selected @endif>1305	รถโดยสาร มาตรฐาน 3 จ ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1306"  @if($dltCar->register_type == 1306) selected @endif>1306	รถโดยสาร มาตรฐาน 3 ฉ ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1311"  @if($dltCar->register_type == 1311) selected @endif>1311	รถโดยสาร มาตรฐาน 3 ก ส่วนบุคคล</option>
							<option value="1312"  @if($dltCar->register_type == 1312) selected @endif>1312	รถโดยสาร มาตรฐาน 3 ข ส่วนบุคคล</option>
							<option value="1313"  @if($dltCar->register_type == 1313) selected @endif>1313	รถโดยสาร มาตรฐาน 3 ค ส่วนบุคคล</option>
							<option value="1314"  @if($dltCar->register_type == 1314) selected @endif>1314	รถโดยสาร มาตรฐาน 3 ง ส่วนบุคคล</option>
							<option value="1315"  @if($dltCar->register_type == 1315) selected @endif>1315	รถโดยสาร มาตรฐาน 3 จ ส่วนบุคคล</option>
							<option value="1316"  @if($dltCar->register_type == 1316) selected @endif>1316	รถโดยสาร มาตรฐาน 3 ฉ ส่วนบุคคล</option>
							<option value="1321"  @if($dltCar->register_type == 1321) selected @endif>1321	รถโดยสาร มาตรฐาน 3 ก ไม่ประจำทาง</option>
							<option value="1322"  @if($dltCar->register_type == 1322) selected @endif>1322	รถโดยสาร มาตรฐาน 3 ข ไม่ประจำทาง</option>
							<option value="1323"  @if($dltCar->register_type == 1323) selected @endif>1323	รถโดยสาร มาตรฐาน 3 ค ไม่ประจำทาง</option>
							<option value="1324"  @if($dltCar->register_type == 1324) selected @endif>1324	รถโดยสาร มาตรฐาน 3 ง ไม่ประจำทาง</option>
							<option value="1325"  @if($dltCar->register_type == 1325) selected @endif>1325	รถโดยสาร มาตรฐาน 3 จ ไม่ประจำทาง</option>
							<option value="1326"  @if($dltCar->register_type == 1326) selected @endif>1326	รถโดยสาร มาตรฐาน 3 ฉ ไม่ประจำทาง</option>
							<option value="1331"  @if($dltCar->register_type == 1331) selected @endif>1331	รถโดยสาร มาตรฐาน 3 ก ประจำทาง</option>
							<option value="1332"  @if($dltCar->register_type == 1332) selected @endif>1332	รถโดยสาร มาตรฐาน 3 ข ประจำทาง</option>
							<option value="1333"  @if($dltCar->register_type == 1333) selected @endif>1333	รถโดยสาร มาตรฐาน 3 ค ประจำทาง</option>
							<option value="1334"  @if($dltCar->register_type == 1334) selected @endif>1334	รถโดยสาร มาตรฐาน 3 ง ประจำทาง</option>
							<option value="1335"  @if($dltCar->register_type == 1335) selected @endif>1335	รถโดยสาร มาตรฐาน 3 จ ประจำทาง</option>
							<option value="1336"  @if($dltCar->register_type == 1336) selected @endif>1336	รถโดยสาร มาตรฐาน 3 ฉ ประจำทาง</option>
							<option value="1401"  @if($dltCar->register_type == 1401) selected @endif>1401	รถโดยสาร มาตรฐาน 4 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1402"  @if($dltCar->register_type == 1402) selected @endif>1402	รถโดยสาร มาตรฐาน 4 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1403"  @if($dltCar->register_type == 1403) selected @endif>1403	รถโดยสาร มาตรฐาน 4 ค ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1404"  @if($dltCar->register_type == 1404) selected @endif>1404	รถโดยสาร มาตรฐาน 4 ง ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1405"  @if($dltCar->register_type == 1405) selected @endif>1405	รถโดยสาร มาตรฐาน 4 จ ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1406"  @if($dltCar->register_type == 1406) selected @endif>1406	รถโดยสาร มาตรฐาน 4 ฉ ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1411"  @if($dltCar->register_type == 1411) selected @endif>1411	รถโดยสาร มาตรฐาน 4 ก ส่วนบุคคล</option>
							<option value="1412"  @if($dltCar->register_type == 1412) selected @endif>1412	รถโดยสาร มาตรฐาน 4 ข ส่วนบุคคล</option>
							<option value="1413"  @if($dltCar->register_type == 1413) selected @endif>1413	รถโดยสาร มาตรฐาน 4 ค ส่วนบุคคล</option>
							<option value="1414"  @if($dltCar->register_type == 1414) selected @endif>1414	รถโดยสาร มาตรฐาน 4 ง ส่วนบุคคล</option>
							<option value="1415"  @if($dltCar->register_type == 1415) selected @endif>1415	รถโดยสาร มาตรฐาน 4 จ ส่วนบุคคล</option>
							<option value="1416"  @if($dltCar->register_type == 1416) selected @endif>1416	รถโดยสาร มาตรฐาน 4 ฉ ส่วนบุคคล</option>
							<option value="1421"  @if($dltCar->register_type == 1421) selected @endif>1421	รถโดยสาร มาตรฐาน 4 ก ไม่ประจำทาง</option>
							<option value="1422"  @if($dltCar->register_type == 1422) selected @endif>1422	รถโดยสาร มาตรฐาน 4 ข ไม่ประจำทาง</option>
							<option value="1423"  @if($dltCar->register_type == 1423) selected @endif>1423	รถโดยสาร มาตรฐาน 4 ค ไม่ประจำทาง</option>
							<option value="1424"  @if($dltCar->register_type == 1424) selected @endif>1424	รถโดยสาร มาตรฐาน 4 ง ไม่ประจำทาง</option>
							<option value="1425"  @if($dltCar->register_type == 1425) selected @endif>1425	รถโดยสาร มาตรฐาน 4 จ ไม่ประจำทาง</option>
							<option value="1426"  @if($dltCar->register_type == 1426) selected @endif>1426	รถโดยสาร มาตรฐาน 4 ฉ ไม่ประจำทาง</option>
							<option value="1431"  @if($dltCar->register_type == 1431) selected @endif>1431	รถโดยสาร มาตรฐาน 4 ก ประจำทาง</option>
							<option value="1432"  @if($dltCar->register_type == 1432) selected @endif>1432	รถโดยสาร มาตรฐาน 4 ข ประจำทาง</option>
							<option value="1433"  @if($dltCar->register_type == 1433) selected @endif>1433	รถโดยสาร มาตรฐาน 4 ค ประจำทาง</option>
							<option value="1434"  @if($dltCar->register_type == 1434) selected @endif>1434	รถโดยสาร มาตรฐาน 4 ง ประจำทาง</option>
							<option value="1435"  @if($dltCar->register_type == 1435) selected @endif>1435	รถโดยสาร มาตรฐาน 4 จ ประจำทาง</option>
							<option value="1436"  @if($dltCar->register_type == 1436) selected @endif>1436	รถโดยสาร มาตรฐาน 4 ฉ ประจำทาง</option>
							<option value="1501"  @if($dltCar->register_type == 1501) selected @endif>1501	รถโดยสาร มาตรฐาน 5 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1502"  @if($dltCar->register_type == 1502) selected @endif>1502	รถโดยสาร มาตรฐาน 5 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1511"  @if($dltCar->register_type == 1511) selected @endif>1511	รถโดยสาร มาตรฐาน 5 ก ส่วนบุคคล</option>
							<option value="1512"  @if($dltCar->register_type == 1512) selected @endif>1512	รถโดยสาร มาตรฐาน 5 ข ส่วนบุคคล</option>
							<option value="1521"  @if($dltCar->register_type == 1521) selected @endif>1521	รถโดยสาร มาตรฐาน 5 ก ไม่ประจำทาง</option>
							<option value="1522"  @if($dltCar->register_type == 1522) selected @endif>1522	รถโดยสาร มาตรฐาน 5 ข ไม่ประจำทาง</option>
							<option value="1531"  @if($dltCar->register_type == 1531) selected @endif>1531	รถโดยสาร มาตรฐาน 5 ก ประจำทาง</option>
							<option value="1532"  @if($dltCar->register_type == 1532) selected @endif>1532	รถโดยสาร มาตรฐาน 5 ข ประจำทาง</option>
							<option value="1601"  @if($dltCar->register_type == 1601) selected @endif>1601	รถโดยสาร มาตรฐาน 6 ก ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1602"  @if($dltCar->register_type == 1602) selected @endif>1602	รถโดยสาร มาตรฐาน 6 ข ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1611"  @if($dltCar->register_type == 1611) selected @endif>1611	รถโดยสาร มาตรฐาน 6 ก ส่วนบุคคล</option>
							<option value="1612"  @if($dltCar->register_type == 1612) selected @endif>1612	รถโดยสาร มาตรฐาน 6 ข ส่วนบุคคล</option>
							<option value="1621"  @if($dltCar->register_type == 1621) selected @endif>1621	รถโดยสาร มาตรฐาน 6 ก ไม่ประจำทาง</option>
							<option value="1622"  @if($dltCar->register_type == 1622) selected @endif>1622	รถโดยสาร มาตรฐาน 6 ข ไม่ประจำทาง</option>
							<option value="1631"  @if($dltCar->register_type == 1631) selected @endif>1631	รถโดยสาร มาตรฐาน 6 ก ประจำทาง</option>
							<option value="1632"  @if($dltCar->register_type == 1632) selected @endif>1632	รถโดยสาร มาตรฐาน 6 ข ประจำทาง</option>
							<option value="1700"  @if($dltCar->register_type == 1700) selected @endif>1700	รถโดยสาร มาตรฐาน 7 ไม่ได้ระบุประเภทการขนส่ง</option>
							<option value="1710"  @if($dltCar->register_type == 1710) selected @endif>1710	รถโดยสาร มาตรฐาน 7 ส่วนบุคคล</option>
							<option value="1720"  @if($dltCar->register_type == 1720) selected @endif>1720	รถโดยสาร มาตรฐาน 7 ไม่ประจำทาง</option>
							<option value="2000"  @if($dltCar->register_type == 2000) selected @endif>2000	รถบรรทุก ไม่ได้ระบุลักษณะและประเภทรถ</option>
							<option value="2100"  @if($dltCar->register_type == 2100) selected @endif>2100	รถบรรทุก ลักษณะ 1 ไม่ได้ระบุประเภทรถ</option>
							<option value="2110"  @if($dltCar->register_type == 2110) selected @endif>2110	รถบรรทุก ลักษณะ 1 ส่วนบุคคล</option>
							<option value="2120"  @if($dltCar->register_type == 2120) selected @endif>2120	รถบรรทุก ลักษณะ 1 ไม่ประจำทาง</option>
							<option value="2200"  @if($dltCar->register_type == 2200) selected @endif>2200	รถบรรทุก ลักษณะ 2 ไม่ได้ระบุประเภทรถ</option>
							<option value="2210"  @if($dltCar->register_type == 2210) selected @endif>2210	รถบรรทุก ลักษณะ 2 ส่วนบุคคล</option>
							<option value="2220"  @if($dltCar->register_type == 2220) selected @endif>2220	รถบรรทุก ลักษณะ 2 ไม่ประจำทาง</option>
							<option value="2300"  @if($dltCar->register_type == 2300) selected @endif>2300	รถบรรทุก ลักษณะ 3 ไม่ได้ระบุประเภทรถ</option>
							<option value="2310"  @if($dltCar->register_type == 2310) selected @endif>2310	รถบรรทุก ลักษณะ 3 ส่วนบุคคล</option>
							<option value="2320"  @if($dltCar->register_type == 2320) selected @endif>2320	รถบรรทุก ลักษณะ 3 ไม่ประจำทาง</option>
							<option value="2400"  @if($dltCar->register_type == 2400) selected @endif>2400	รถบรรทุก ลักษณะ 4 ไม่ได้ระบุประเภทรถ</option>
							<option value="2410"  @if($dltCar->register_type == 2410) selected @endif>2410	รถบรรทุก ลักษณะ 4 ส่วนบุคคล</option>
							<option value="2420"  @if($dltCar->register_type == 2420) selected @endif>2420	รถบรรทุก ลักษณะ 4 ไม่ประจำทาง</option>
							<option value="2500"  @if($dltCar->register_type == 2500) selected @endif>2500	รถบรรทุก ลักษณะ 5 ไม่ได้ระบุประเภทรถ</option>
							<option value="2510"  @if($dltCar->register_type == 2510) selected @endif>2510	รถบรรทุก ลักษณะ 5 ส่วนบุคคล</option>
							<option value="2520"  @if($dltCar->register_type == 2520) selected @endif>2520	รถบรรทุก ลักษณะ 5 ไม่ประจำทาง</option>
							<option value="2600"  @if($dltCar->register_type == 2600) selected @endif>2600	รถบรรทุก ลักษณะ 6 ไม่ได้ระบุประเภทรถ</option>
							<option value="2610"  @if($dltCar->register_type == 2610) selected @endif>2610	รถบรรทุก ลักษณะ 6 ส่วนบุคคล</option>
							<option value="2620"  @if($dltCar->register_type == 2620) selected @endif>2620	รถบรรทุก ลักษณะ 6 ไม่ประจำทาง</option>
							<option value="2700"  @if($dltCar->register_type == 2700) selected @endif>2700	รถบรรทุก ลักษณะ 7 ไม่ได้ระบุประเภทรถ</option>
							<option value="2710"  @if($dltCar->register_type == 2710) selected @endif>2710	รถบรรทุก ลักษณะ 7 ส่วนบุคคล</option>
							<option value="2720"  @if($dltCar->register_type == 2720) selected @endif>2720	รถบรรทุก ลักษณะ 7 ไม่ประจำทาง</option>
							<option value="2800"  @if($dltCar->register_type == 2800) selected @endif>2800	รถบรรทุก ลักษณะ 8 ไม่ได้ระบุประเภทรถ</option>
							<option value="2810"  @if($dltCar->register_type == 2810) selected @endif>2810	รถบรรทุก ลักษณะ 8 ส่วนบุคคล</option>
							<option value="2820"  @if($dltCar->register_type == 2820) selected @endif>2820	รถบรรทุก ลักษณะ 8 ไม่ประจำทาง</option>
							<option value="2900"  @if($dltCar->register_type == 2900) selected @endif>2900	รถบรรทุก ลักษณะ 9 ไม่ได้ระบุประเภทรถ</option>
							<option value="2910"  @if($dltCar->register_type == 2910) selected @endif>2910	รถบรรทุก ลักษณะ 9 ส่วนบุคคล</option>
							<option value="2920"  @if($dltCar->register_type == 2920) selected @endif>2920	รถบรรทุก ลักษณะ 9 ไม่ประจำทาง</option>
						</select>
					</div>
                </div>

                <div class="form-group">
                    <label for="register_engine_type" class="col-sm-2 control-label">ชนิดเชื้อเพลิง</label>
                    <div class="col-sm-3">
                        <select name="register_engine_type" id="register_engine_type" class="form-control">
                            <option value="ดีเซล" @if($dltCar->register_engine_type == 'ดีเซล') selected @endif>ดีเซล</option>
                            <option value="เบนชิน" @if($dltCar->register_engine_type == 'เบนชิน') selected @endif>เบนชิน</option>
                            <option value="CNG/NGV" @if($dltCar->register_engine_type == 'CNG/NGV') selected @endif>CNG/NGV</option>
                            <option value="CNG/ดีเซล" @if($dltCar->register_engine_type == 'CNG/ดีเซล') selected @endif>CNG/ดีเซล</option>
                            <option value="CNG/เบนชิน" @if($dltCar->register_engine_type == 'CNG/เบนชิน') selected @endif>CNG/เบนชิน</option>
                            <option value="LPG" @if($dltCar->register_engine_type == 'LPG') selected @endif>LPG</option>
                        </select>
                        {{--<input type="text" class="form-control" id="register_engine_type" name="register_engine_type" placeholder="ชนิดเชื้อเพลิง" value="{{$dltCar->register_engine_type}}">--}}
                    </div>
					<label for="register_code_verify" class="col-sm-2 control-label">รหัสตรวจสภาพ</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="register_code_verify" placeholder="รหัสตรวจสภาพ" value="{{$dltCar->register_code_verify}}">
					</div>

                </div>

                <div class="form-group">
                    <label for="register_standard" class="col-sm-2 control-label">ลักษณะมาตรฐาน</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_standard" name="register_standard" placeholder="ลักษณะมาตรฐาน" value="{{$dltCar->register_standard}}">
                    </div>
                    <label for="register_make" class="col-sm-2 control-label">ยี่ห้อรถ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_make" placeholder="ยี่ห้อรถ" value="{{$dltCar->register_make}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_model" class="col-sm-2 control-label">แบบ / รุ่น</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_standard" name="register_model" placeholder="แบบ / รุ่น" value="{{$dltCar->register_model}}">
                    </div>
                    <label for="register_color" class="col-sm-2 control-label">สีรถ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_color" placeholder="สีรถ" value="{{$dltCar->register_color}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_chassi" class="col-sm-2 control-label">เลขตัวรถเลขตัวรถ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_chassi" name="register_chassi" placeholder="เลขตัวรถ" value="{{$dltCar->register_chassi}}">
                    </div>
                    <label for="register_chassi_position" class="col-sm-2 control-label">เลขตัวรถอยู่ที่</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_chassi_position" placeholder="เลขตัวรถอยู่ที่" value="{{$dltCar->register_chassi_position}}">
                    </div>
                </div>
                <hr>

				<div class="form-group">
                    <label for="register_engine_make" class="col-sm-2 control-label">ยี่ห้อเครื่องยนต์</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_make" name="register_engine_make" placeholder="ยี่ห้อเครื่องยนต์" value="{{$dltCar->register_engine_make}}">
                    </div>
                    <label for="register_engine_number" class="col-sm-2 control-label">เลขเครื่องยนต์</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_engine_number" placeholder="เลขเครื่องยนต์" value="{{$dltCar->register_engine_number}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_engine_number_position" class="col-sm-2 control-label">เลขเครื่องยนต์อยู่ที่</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_number_position" name="register_engine_number_position" placeholder="เลขเครื่องยนต์อยู่ที่" value="{{$dltCar->register_engine_number_position}}">
                    </div>
                    <label for="register_engine_total_piston" class="col-sm-2 control-label">จำนวนลูกสูบ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_engine_total_piston" placeholder="จำนวนลูกสูบ" value="{{$dltCar->register_engine_total_piston}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_engine_total_horse_power" class="col-sm-2 control-label">จำนวนแรงม้า</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_total_horse_power" name="register_engine_total_horse_power" placeholder="จำนวนแรงม้า" value="{{$dltCar->register_engine_total_horse_power}}">
                    </div>
                    <label for="register_shaft" class="col-sm-2 control-label">จำนวนเพลา</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_shaft" placeholder="จำนวนเพลา" value="{{$dltCar->register_shaft}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_wheels" class="col-sm-2 control-label">จำนวนล้อ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="register_wheels" name="register_wheels" placeholder="จำนวนล้อ" value="{{$dltCar->register_wheels}}">
                    </div>
                    <label for="register_rubbers" class="col-sm-2 control-label">จำนวนยาง</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_rubbers" placeholder="จำนวนยาง" value="{{$dltCar->register_rubbers}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_car_weight" class="col-sm-2 control-label">น้ำหนักรถ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_car_weight" placeholder="น้ำหนักรถ" value="{{$dltCar->register_car_weight}}">
                    </div>
                    <label for="register_sit_passenger" class="col-sm-2 control-label">จำนวนผู้โดยสารนั่ง</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_sit_passenger" placeholder="จำนวนผู้โดยสารนั่ง" value="{{$dltCar->register_sit_passenger}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_standup_passenger" class="col-sm-2 control-label">จำนวนผู้โดยสารยืน</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_standup_passenger" placeholder="จำนวนผู้โดยสารยืน" value="{{$dltCar->register_standup_passenger}}">
                    </div>
                    <label for="register_total_load_weight" class="col-sm-2 control-label">น้ำหนักบรรทุก/ลงเพลา</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_total_load_weight" placeholder="จำนวนผู้โดยสารนั่ง" value="{{$dltCar->register_total_load_weight}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_total_weight" class="col-sm-2 control-label">น้ำหนักรวม</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_total_weight" placeholder="น้ำหนักรวม" value="{{$dltCar->register_total_weight}}">
                    </div>
                </div>

                <h3 class="box-title">เจ้าของรถ</h3>
                <hr>

                <div class="form-group">
                    <label for="owner_name" class="col-sm-2 control-label">ผู้ประกอบการขนส่ง</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="owner_name" placeholder="ผู้ประกอบการขนส่ง" value="{{$dltCar->owner_name}}">
                    </div>
                    <label for="owner_start_date" class="col-sm-2 control-label">วันที่ครอบครองรถ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" name="owner_start_date" placeholder="วันที่ครอบครองรถ" value="{{$dltCar->owner_start_date}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_card_id" class="col-sm-2 control-label">หนังสือแสดงการจดทะเบียน/บัตรประจำตัว</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_card_id" placeholder="หนังสือแสดงการจดทะเบียน/บัตรประจำตัว" value="{{$dltCar->owner_card_id}}">
                    </div>
                    <label for="owner_nationality" class="col-sm-1 control-label">สัญชาติ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_nationality" placeholder="สัญชาติ" value="{{$dltCar->owner_nationality}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">ค้นที่อยู่</label>
                    <div class="col-sm-10">
                        <input name="search" class="form-control" type="text" placeholder="กรอกอย่างใดอย่างหนึ่ง ตำบล, อำเภอ, จังหวัด หรือ รหัสไปรษณีย์">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">เลขที่ตั้ง ,ซอย , ถนน</label>
                    <div class="col-sm-4">
                        <input name="owner_address_one" class="form-control" type="text" value="{{$dltCar->owner_address_one}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <input id="address_auto" class="form-control" type="text" name="owner_address_auto" value="{{$dltCar->owner_address_auto}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_transport_type" class="col-sm-2 control-label">ประกอบการขนส่งประเภท</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="owner_transport_type" placeholder="ประกอบการขนส่งประเภท" value="{{$dltCar->owner_transport_type}}">
                    </div>
                    <label for="owner_authorized_code" class="col-sm-2 control-label">ใบอนุญาตเลขที่</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_authorized_code" placeholder="ใบอนุญาตเลขที่" value="{{$dltCar->owner_authorized_code}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_authorized_expire_date" class="col-sm-2 control-label">วันสิ้นสุดใบอนุญาต</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control datepicker" name="owner_authorized_expire_date" placeholder="วันสิ้นสุดใบอนุญาต" value="{{$dltCar->owner_authorized_expire_date}}">
                    </div>
                    <label for="owner_has_ownership" class="col-sm-2 control-label">มีสิทธิ์ครอบครองและใช้รถ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_has_ownership" placeholder="มีสิทธิ์ครอบครองและใช้รถ" value="{{$dltCar->owner_has_ownership}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ownership_name" class="col-sm-2 control-label">ผู้ถือกรรมสิทธิ์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ownership_name" placeholder="ผู้ถือกรรมสิทธิ์" value="{{$dltCar->ownership_name}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">เลขที่ตั้ง ,ซอย , ถนน</label>
                    <div class="col-sm-4">
                        <input name="ownership_address_one" class="form-control" type="text" value="{{$dltCar->ownership_address_one}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <input id="address_auto" class="form-control" type="text" name="ownership_address_auto" value="{{$dltCar->ownership_address_auto}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">เอกสารเล่มจดทะเบียน</label>
                    <div class="col-sm-10">
                        <p>
                            <input type="file" class="form-control" name="book_file_path">
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">ดูข้อมูล</label>
                    <div class="col-sm-10">
                       <ul>
                           <li><a href="{{asset($dltCar->book_file_path)}}" target="_blank"><i class="fa fa-eye text-green" aria-hidden="true"></i> ดูไฟล์ </a></li>
                       </ul>
                    </div>
                </div>

                <input type="hidden" name="owner_id" value="{{$dltCar->owner_id}}">
                <button type="submit" class="btn btn-success pull-right">บันทึกข้อมูล</button>
            </form>

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
	{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
	<script type="text/javascript" src="{{asset('js/datepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.th.min.js')}}"></script>
	<script src="{{asset('js/dropzone.js')}}"></script>

	<script>
		$.Thailand({
			database: '/js/jquery.Thailand.js/database/db.json',


//
			onDataFill: function(data){
				console.info('Data Filled', data);
				var html =  'ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
//                $('#addressAuto').prepend('<div class="alert alert-success">' + html + '</div>');
				$('input[name="owner_address_auto"]').val(html);
				$('input[name="ownership_address_auto"]').val(html);
			},


			$search: $('#address [name="search"]'),
			$name: $('#address [name="name"]'),
		});


		$('#address [name="search"]').change(function(){
			console.log('Search', this.value);
		});

		$('#register_province').select2();
		$('#register_type').select2();
		$('#register_make').select2();

		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayBtn: true,
			language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
			thaiyear: true              //Set เป็นปี พ.ศ.
		}).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน

		$('div.alert').delay(5000).slideUp(700);
	</script>
@endsection