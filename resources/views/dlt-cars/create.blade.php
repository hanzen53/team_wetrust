@extends('adminlte::page')

@push('css-head')
    <link rel="stylesheet" href="{{asset('/js//jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
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
                <input type="hidden" name="prefix" value="{{$dlt_customer_id}}">
                <input type="hidden" name="save_to_path" value="dlt-cars">
            </form>
        </div><!-- /.box-body -->
    </div>

    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">เพิ่มรถเข้าระบบ</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

			@include('flash/error')

            <form id="address" class="form-horizontal" role="form" method="POST" action="/dlt-car-add/{{$dlt_customer_id}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <h3 class="box-title">รายการจดทะเบียน <small class="text-danger">* จำเป็นต้องกรอก</small></h3>
                <hr>

                <div class="form-group">
                    {{--<label for="register_name" class="col-sm-1 control-label text-danger">เลขทะเบียน *</label>--}}
                    <div class="col-sm-4">
                        <label class="text-danger text-muted">ห้ามมีขีดถ้าน้อยกว่า 7 ตัวให้เติม 0 ข้างหน้าให้ครบ  นข-4363 -> 0นข4363</label>
                        <input type="text" class="form-control text-danger" name="register_name" placeholder="เลขทะเบียน" value="{{old('register_name')}}">
                    </div>

                    <div class="col-sm-4">
                        <label for="register_chassi" class="control-label text-danger">เลขตัวถังรถ</label>
                        <input type="text" class="form-control" id="register_chassi" name="register_chassi" placeholder="Chassi" value="{{old('register_chassi')}}">
                    </div>

                    <div class="col-sm-4">
                        <label for="register_make" class="control-label text-danger">ยี่ห้อรถ</label>
                        {{--<input type="text" class="form-control" name="register_make" placeholder="ยี่ห้อรถ" value="{{old('register_make')}}">--}}
						<select name="register_make" id="register_make" class="form-control select2">
							@foreach($car_maker as $maker)
								<option value="{{$maker->maker}}">{{$maker->maker}}</option>
							@endforeach
						</select>
                    </div>

                </div>

                <div class="form-group">

                    <div class="col-sm-6">
                        {{--<input type="text" class="form-control" id="register_province" name="register_province" placeholder="จังหวัด" value="{{old('register_province')}}">--}}
                        <label for="register_province" class="control-label text-danger">จังหวัด</label>
                        <select name="register_province" id="register_province" class="form-control select2" style="width: 100%;">
                            <option value="1">กรุงเทพมหานคร</option>
                            <option value="805">กระบี่</option>
                            <option value="701">กาญจนบุรี</option>
                            <option value="406">กาฬสินธุ์</option>
                            <option value="604">กำแพงเพชร</option>
                            <option value="405">ขอนแก่น</option>
                            <option value="205">จันทบุรี</option>
                            <option value="202">ฉะเชิงเทรา</option>
                            <option value="203">ชลบุรี</option>
                            <option value="100">ชัยนาท</option>
                            <option value="300">ชัยภูมิ</option>
                            <option value="800">ชุมพร</option>
                            <option value="500">เชียงราย</option>
                            <option value="502">เชียงใหม่</option>
                            <option value="901">ตรัง</option>
                            <option value="206">ตราด</option>
                            <option value="602">ตาก</option>
                            <option value="200">นครนายก</option>
                            <option value="702">นครปฐม</option>
                            <option value="403">นครพนม</option>
                            <option value="305">นครราชสีมา</option>
                            <option value="804">นครศรีธรรมราช</option>
                            <option value="607">นครสวรรค์</option>
                            <option value="107">นนทบุรี</option>
                            <option value="906">นราธิวาส</option>
                            <option value="504">น่าน</option>
                            <option value="309">บึงกาฬ</option>
                            <option value="304">บุรีรัมย์</option>
                            <option value="106">ปทุมธานี</option>
                            <option value="707">ประจวบคีรีขันธ์</option>
                            <option value="201">ปราจีนบุรี</option>
                            <option value="904">ปัตตานี</option>
                            <option value="105">พระนครศรีอยุธยา</option>
                            <option value="503">พะเยา</option>
                            <option value="803">พังงา</option>
                            <option value="900">พัทลุง</option>
                            <option value="605">พิจิตร</option>
                            <option value="603">พิษณุโลก</option>
                            <option value="706">เพชรบุรี</option>
                            <option value="606">เพชรบูรณ์</option>
                            <option value="507">แพร่</option>
                            <option value="806">ภูเก็ต</option>
                            <option value="407">มหาสารคาม</option>
                            <option value="409">มุกดาหาร</option>
                            <option value="501">แม่ฮ่องสอน</option>
                            <option value="301">ยโสธร</option>
                            <option value="905">ยะลา</option>
                            <option value="408">ร้อยเอ็ด</option>
                            <option value="801">ระนอง</option>
                            <option value="204">ระยอง</option>
                            <option value="703">ราชบุรี</option>
                            <option value="102">ลพบุรี</option>
                            <option value="506">ลำปาง</option>
                            <option value="505">ลำพูน</option>
                            <option value="401">เลย</option>
                            <option value="303">ศรีสะเกษ</option>
                            <option value="404">สกลนคร</option>
                            <option value="902">สงขลา</option>
                            <option value="903">สตูล</option>
                            <option value="108">สมุทรปราการ</option>
                            <option value="705">สมุทรสงคราม</option>
                            <option value="704">สมุทรสาคร</option>
                            <option value="207">สระแก้ว</option>
                            <option value="104">สระบุรี</option>
                            <option value="101">สิงห์บุรี</option>
                            <option value="601">สุโขทัย</option>
                            <option value="700">สุพรรณบุรี</option>
                            <option value="802">สุราษฎร์ธานี</option>
                            <option value="306">สุรินทร์</option>
                            <option value="400">หนองคาย</option>
                            <option value="308">หนองบัวลำภู</option>
                            <option value="103">อ่างทอง</option>
                            <option value="307">อำนาจเจริญ</option>
                            <option value="402">อุดรธานี</option>
                            <option value="600">อุตรดิตถ์</option>
                            <option value="608">อุทัยธานี</option>
                            <option value="302">อุบลราชธานี</option>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <label for="register_type" class="control-label text-danger">ประเภท</label>
                        {{--<input type="text" class="form-control" name="register_type" placeholder="ประเภท" value="{{old('register_type')}}">--}}
                        <select class="form-control select2" name="register_type" id="register_type">
                            <option value="0000">0000	รถส่วนบุคล</option>
                            <option value="1000">1000	รถโดยสาร ไม่ได้ระบุมาตรฐานรถและประเภทการขนส่ง</option>
                            <option value="1101">1101	รถโดยสาร มาตรฐาน 1 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1102">1102	รถโดยสาร มาตรฐาน 1 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1111">1111	รถโดยสาร มาตรฐาน 1 ก ส่วนบุคคล</option>
                            <option value="1112">1112	รถโดยสาร มาตรฐาน 1 ข ส่วนบุคคล</option>
                            <option value="1121">1121	รถโดยสาร มาตรฐาน 1 ก ไม่ประจำทาง</option>
                            <option value="1122">1122	รถโดยสาร มาตรฐาน 1 ข ไม่ประจำทาง</option>
                            <option value="1131">1131	รถโดยสาร มาตรฐาน 1 ก ประจำทาง</option>
                            <option value="1132">1132	รถโดยสาร มาตรฐาน 1 ข ประจำทาง</option>
                            <option value="1201">1201	รถโดยสาร มาตรฐาน 2 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1202">1202	รถโดยสาร มาตรฐาน 2 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1203">1203	รถโดยสาร มาตรฐาน 2 ค ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1204">1204	รถโดยสาร มาตรฐาน 2 ง ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1205">1205	รถโดยสาร มาตรฐาน 2 จ ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1211">1211	รถโดยสาร มาตรฐาน 2 ก ส่วนบุคคล</option>
                            <option value="1212">1212	รถโดยสาร มาตรฐาน 2 ข ส่วนบุคคล</option>
                            <option value="1213">1213	รถโดยสาร มาตรฐาน 2 ค ส่วนบุคคล</option>
                            <option value="1214">1214	รถโดยสาร มาตรฐาน 2 ง ส่วนบุคคล</option>
                            <option value="1215">1215	รถโดยสาร มาตรฐาน 2 จ ส่วนบุคคล</option>
                            <option value="1221">1221	รถโดยสาร มาตรฐาน 2 ก ไม่ประจำทาง</option>
                            <option value="1222">1222	รถโดยสาร มาตรฐาน 2 ข ไม่ประจำทาง</option>
                            <option value="1223">1223	รถโดยสาร มาตรฐาน 2 ค ไม่ประจำทาง</option>
                            <option value="1224">1224	รถโดยสาร มาตรฐาน 2 ง ไม่ประจำทาง</option>
                            <option value="1225">1225	รถโดยสาร มาตรฐาน 2 จ ไม่ประจำทาง</option>
                            <option value="1231">1231	รถโดยสาร มาตรฐาน 2 ก ประจำทาง</option>
                            <option value="1232">1232	รถโดยสาร มาตรฐาน 2 ข ประจำทาง</option>
                            <option value="1233">1233	รถโดยสาร มาตรฐาน 2 ค ประจำทาง</option>
                            <option value="1234">1234	รถโดยสาร มาตรฐาน 2 ง ประจำทาง</option>
                            <option value="1235">1235	รถโดยสาร มาตรฐาน 2 จ ประจำทาง</option>
                            <option value="1301">1301	รถโดยสาร มาตรฐาน 3 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1302">1302	รถโดยสาร มาตรฐาน 3 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1303">1303	รถโดยสาร มาตรฐาน 3 ค ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1304">1304	รถโดยสาร มาตรฐาน 3 ง ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1305">1305	รถโดยสาร มาตรฐาน 3 จ ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1306">1306	รถโดยสาร มาตรฐาน 3 ฉ ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1311">1311	รถโดยสาร มาตรฐาน 3 ก ส่วนบุคคล</option>
                            <option value="1312">1312	รถโดยสาร มาตรฐาน 3 ข ส่วนบุคคล</option>
                            <option value="1313">1313	รถโดยสาร มาตรฐาน 3 ค ส่วนบุคคล</option>
                            <option value="1314">1314	รถโดยสาร มาตรฐาน 3 ง ส่วนบุคคล</option>
                            <option value="1315">1315	รถโดยสาร มาตรฐาน 3 จ ส่วนบุคคล</option>
                            <option value="1316">1316	รถโดยสาร มาตรฐาน 3 ฉ ส่วนบุคคล</option>
                            <option value="1321">1321	รถโดยสาร มาตรฐาน 3 ก ไม่ประจำทาง</option>
                            <option value="1322">1322	รถโดยสาร มาตรฐาน 3 ข ไม่ประจำทาง</option>
                            <option value="1323">1323	รถโดยสาร มาตรฐาน 3 ค ไม่ประจำทาง</option>
                            <option value="1324">1324	รถโดยสาร มาตรฐาน 3 ง ไม่ประจำทาง</option>
                            <option value="1325">1325	รถโดยสาร มาตรฐาน 3 จ ไม่ประจำทาง</option>
                            <option value="1326">1326	รถโดยสาร มาตรฐาน 3 ฉ ไม่ประจำทาง</option>
                            <option value="1331">1331	รถโดยสาร มาตรฐาน 3 ก ประจำทาง</option>
                            <option value="1332">1332	รถโดยสาร มาตรฐาน 3 ข ประจำทาง</option>
                            <option value="1333">1333	รถโดยสาร มาตรฐาน 3 ค ประจำทาง</option>
                            <option value="1334">1334	รถโดยสาร มาตรฐาน 3 ง ประจำทาง</option>
                            <option value="1335">1335	รถโดยสาร มาตรฐาน 3 จ ประจำทาง</option>
                            <option value="1336">1336	รถโดยสาร มาตรฐาน 3 ฉ ประจำทาง</option>
                            <option value="1401">1401	รถโดยสาร มาตรฐาน 4 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1402">1402	รถโดยสาร มาตรฐาน 4 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1403">1403	รถโดยสาร มาตรฐาน 4 ค ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1404">1404	รถโดยสาร มาตรฐาน 4 ง ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1405">1405	รถโดยสาร มาตรฐาน 4 จ ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1406">1406	รถโดยสาร มาตรฐาน 4 ฉ ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1411">1411	รถโดยสาร มาตรฐาน 4 ก ส่วนบุคคล</option>
                            <option value="1412">1412	รถโดยสาร มาตรฐาน 4 ข ส่วนบุคคล</option>
                            <option value="1413">1413	รถโดยสาร มาตรฐาน 4 ค ส่วนบุคคล</option>
                            <option value="1414">1414	รถโดยสาร มาตรฐาน 4 ง ส่วนบุคคล</option>
                            <option value="1415">1415	รถโดยสาร มาตรฐาน 4 จ ส่วนบุคคล</option>
                            <option value="1416">1416	รถโดยสาร มาตรฐาน 4 ฉ ส่วนบุคคล</option>
                            <option value="1421">1421	รถโดยสาร มาตรฐาน 4 ก ไม่ประจำทาง</option>
                            <option value="1422">1422	รถโดยสาร มาตรฐาน 4 ข ไม่ประจำทาง</option>
                            <option value="1423">1423	รถโดยสาร มาตรฐาน 4 ค ไม่ประจำทาง</option>
                            <option value="1424">1424	รถโดยสาร มาตรฐาน 4 ง ไม่ประจำทาง</option>
                            <option value="1425">1425	รถโดยสาร มาตรฐาน 4 จ ไม่ประจำทาง</option>
                            <option value="1426">1426	รถโดยสาร มาตรฐาน 4 ฉ ไม่ประจำทาง</option>
                            <option value="1431">1431	รถโดยสาร มาตรฐาน 4 ก ประจำทาง</option>
                            <option value="1432">1432	รถโดยสาร มาตรฐาน 4 ข ประจำทาง</option>
                            <option value="1433">1433	รถโดยสาร มาตรฐาน 4 ค ประจำทาง</option>
                            <option value="1434">1434	รถโดยสาร มาตรฐาน 4 ง ประจำทาง</option>
                            <option value="1435">1435	รถโดยสาร มาตรฐาน 4 จ ประจำทาง</option>
                            <option value="1436">1436	รถโดยสาร มาตรฐาน 4 ฉ ประจำทาง</option>
                            <option value="1501">1501	รถโดยสาร มาตรฐาน 5 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1502">1502	รถโดยสาร มาตรฐาน 5 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1511">1511	รถโดยสาร มาตรฐาน 5 ก ส่วนบุคคล</option>
                            <option value="1512">1512	รถโดยสาร มาตรฐาน 5 ข ส่วนบุคคล</option>
                            <option value="1521">1521	รถโดยสาร มาตรฐาน 5 ก ไม่ประจำทาง</option>
                            <option value="1522">1522	รถโดยสาร มาตรฐาน 5 ข ไม่ประจำทาง</option>
                            <option value="1531">1531	รถโดยสาร มาตรฐาน 5 ก ประจำทาง</option>
                            <option value="1532">1532	รถโดยสาร มาตรฐาน 5 ข ประจำทาง</option>
                            <option value="1601">1601	รถโดยสาร มาตรฐาน 6 ก ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1602">1602	รถโดยสาร มาตรฐาน 6 ข ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1611">1611	รถโดยสาร มาตรฐาน 6 ก ส่วนบุคคล</option>
                            <option value="1612">1612	รถโดยสาร มาตรฐาน 6 ข ส่วนบุคคล</option>
                            <option value="1621">1621	รถโดยสาร มาตรฐาน 6 ก ไม่ประจำทาง</option>
                            <option value="1622">1622	รถโดยสาร มาตรฐาน 6 ข ไม่ประจำทาง</option>
                            <option value="1631">1631	รถโดยสาร มาตรฐาน 6 ก ประจำทาง</option>
                            <option value="1632">1632	รถโดยสาร มาตรฐาน 6 ข ประจำทาง</option>
                            <option value="1700">1700	รถโดยสาร มาตรฐาน 7 ไม่ได้ระบุประเภทการขนส่ง</option>
                            <option value="1710">1710	รถโดยสาร มาตรฐาน 7 ส่วนบุคคล</option>
                            <option value="1720">1720	รถโดยสาร มาตรฐาน 7 ไม่ประจำทาง</option>
                            <option value="2000">2000	รถบรรทุก ไม่ได้ระบุลักษณะและประเภทรถ</option>
                            <option value="2100">2100	รถบรรทุก ลักษณะ 1 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2110">2110	รถบรรทุก ลักษณะ 1 ส่วนบุคคล</option>
                            <option value="2120">2120	รถบรรทุก ลักษณะ 1 ไม่ประจำทาง</option>
                            <option value="2200">2200	รถบรรทุก ลักษณะ 2 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2210">2210	รถบรรทุก ลักษณะ 2 ส่วนบุคคล</option>
                            <option value="2220">2220	รถบรรทุก ลักษณะ 2 ไม่ประจำทาง</option>
                            <option value="2300">2300	รถบรรทุก ลักษณะ 3 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2310">2310	รถบรรทุก ลักษณะ 3 ส่วนบุคคล</option>
                            <option value="2320">2320	รถบรรทุก ลักษณะ 3 ไม่ประจำทาง</option>
                            <option value="2400">2400	รถบรรทุก ลักษณะ 4 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2410">2410	รถบรรทุก ลักษณะ 4 ส่วนบุคคล</option>
                            <option value="2420">2420	รถบรรทุก ลักษณะ 4 ไม่ประจำทาง</option>
                            <option value="2500">2500	รถบรรทุก ลักษณะ 5 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2510">2510	รถบรรทุก ลักษณะ 5 ส่วนบุคคล</option>
                            <option value="2520">2520	รถบรรทุก ลักษณะ 5 ไม่ประจำทาง</option>
                            <option value="2600">2600	รถบรรทุก ลักษณะ 6 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2610">2610	รถบรรทุก ลักษณะ 6 ส่วนบุคคล</option>
                            <option value="2620">2620	รถบรรทุก ลักษณะ 6 ไม่ประจำทาง</option>
                            <option value="2700">2700	รถบรรทุก ลักษณะ 7 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2710">2710	รถบรรทุก ลักษณะ 7 ส่วนบุคคล</option>
                            <option value="2720">2720	รถบรรทุก ลักษณะ 7 ไม่ประจำทาง</option>
                            <option value="2800">2800	รถบรรทุก ลักษณะ 8 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2810">2810	รถบรรทุก ลักษณะ 8 ส่วนบุคคล</option>
                            <option value="2820">2820	รถบรรทุก ลักษณะ 8 ไม่ประจำทาง</option>
                            <option value="2900">2900	รถบรรทุก ลักษณะ 9 ไม่ได้ระบุประเภทรถ</option>
                            <option value="2910">2910	รถบรรทุก ลักษณะ 9 ส่วนบุคคล</option>
                            <option value="2920">2920	รถบรรทุก ลักษณะ 9 ไม่ประจำทาง</option>
                        </select>
                    </div>

                </div>
                <hr class="text-danger">

                <div class="form-group">

                    <label for="register_chassi_position" class="col-sm-2 control-label">เลขตัวรถอยู่ที่</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_chassi_position" placeholder="เลขตัวรถอยู่ที่" value="{{old('register_chassi_position')}}">
                    </div>
                    <label for="register_date" class="col-sm-2 control-label">วันจดทะเบียน</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control datepicker" id="register_date" name="register_date" placeholder="วันจดทะเบียน" value="{{old('register_date')}}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="register_engine_type" class="col-sm-2 control-label">ชนิดเชื้อเพลิง</label>
                    <div class="col-sm-3">
                        {{--<input type="text" class="form-control" id="register_engine_type" name="register_engine_type" placeholder="ชนิดเชื้อเพลิง" value="{{old('register_engine_type')}}">--}}
                        <select name="register_engine_type" id="register_engine_type" class="form-control">
                            <option value="ดีเซล">ดีเซล</option>
                            <option value="เบนชิน">เบนชิน</option>
                            <option value="CNG/NGV">CNG/NGV</option>
                            <option value="CNG/ดีเซล">CNG/ดีเซล</option>
                            <option value="CNG/เบนชิน">CNG/เบนชิน</option>
                            <option value="LPG">LPG</option>
                        </select>
                    </div>
                    <label for="register_code_verify" class="col-sm-2 control-label">รหัสตรวจสภาพ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_code_verify" placeholder="รหัสตรวจสภาพ" value="{{old('register_code_verify')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_standard" class="col-sm-2 control-label">ลักษณะมาตรฐาน</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_standard" name="register_standard" placeholder="ลักษณะมาตรฐาน" value="{{old('register_engine_type')}}">
                    </div>
                    {{--<label for="register_make" class="col-sm-2 control-label">ยี่ห้อรถ</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="register_make" placeholder="ยี่ห้อรถ" value="{{old('register_make')}}">--}}
                    {{--</div>--}}
					<label for="register_total_weight" class="col-sm-2 control-label">น้ำหนักรวม</label>
					<div class="col-sm-3">
						<input type="number" class="form-control" name="register_total_weight" placeholder="น้ำหนักรวม" value="{{old('register_total_weight')}}">
					</div>
                </div>

                <div class="form-group">
                    <label for="register_model" class="col-sm-2 control-label">แบบ / รุ่น</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_model" name="register_model" placeholder="แบบ / รุ่น" value="{{old('register_model')}}">
                    </div>
                    <label for="register_color" class="col-sm-2 control-label">สีรถ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_color" placeholder="สีรถ" value="{{old('register_color')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_engine_make" class="col-sm-2 control-label">ยี่ห้อเครื่องยนต์</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_make" name="register_engine_make" placeholder="ยี่ห้อเครื่องยนต์" value="{{old('register_engine_make')}}">
                    </div>
                    <label for="register_engine_number" class="col-sm-2 control-label">เลขเครื่องยนต์</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="register_engine_number" placeholder="เลขเครื่องยนต์" value="{{old('register_engine_number')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_engine_number_position" class="col-sm-2 control-label">เลขเครื่องยนต์อยู่ที่</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_number_position" name="register_engine_number_position" placeholder="เลขเครื่องยนต์อยู่ที่" value="{{old('register_engine_number_position')}}">
                    </div>
                    <label for="register_engine_total_piston" class="col-sm-2 control-label">จำนวนลูกสูบ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_engine_total_piston" placeholder="จำนวนลูกสูบ" value="{{old('register_engine_total_piston')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_engine_total_horse_power" class="col-sm-2 control-label">จำนวนแรงม้า</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="register_engine_total_horse_power" name="register_engine_total_horse_power" placeholder="จำนวนแรงม้า" value="{{old('register_engine_total_horse_power')}}">
                    </div>
                    <label for="register_shaft" class="col-sm-2 control-label">จำนวนเพลา</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_shaft" placeholder="จำนวนเพลา" value="{{old('register_shaft')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_wheels" class="col-sm-2 control-label">จำนวนล้อ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="register_wheels" name="register_wheels" placeholder="จำนวนล้อ" value="{{old('register_wheels')}}">
                    </div>
                    <label for="register_rubbers" class="col-sm-2 control-label">จำนวนยาง</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_rubbers" placeholder="จำนวนยาง" value="{{old('register_rubbers')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_car_weight" class="col-sm-2 control-label">น้ำหนักรถ</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_car_weight" placeholder="น้ำหนักรถ" value="{{old('register_car_weight')}}">
                    </div>
                    <label for="register_sit_passenger" class="col-sm-2 control-label">จำนวนผู้โดยสารนั่ง</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_sit_passenger" placeholder="จำนวนผู้โดยสารนั่ง" value="{{old('register_sit_passenger')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="register_standup_passenger" class="col-sm-2 control-label">จำนวนผู้โดยสารยืน</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_standup_passenger" placeholder="จำนวนผู้โดยสารยืน" value="{{old('register_standup_passenger')}}">
                    </div>
                    <label for="register_total_load_weight" class="col-sm-2 control-label">น้ำหนักบรรทุก/ลงเพลา</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="register_total_load_weight" placeholder="จำนวนผู้โดยสารนั่ง" value="{{old('register_total_load_weight')}}">
                    </div>
                </div>

                <h3 class="box-title">เจ้าของรถ</h3>
                <hr>

                <div class="form-group">
                    <label for="owner_name" class="col-sm-2 control-label">ผู้ประกอบการขนส่ง</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="owner_name" placeholder="ผู้ประกอบการขนส่ง" value="{{old('owner_name')}}">
                    </div>
                    <label for="owner_start_date" class="col-sm-2 control-label">วันที่ครอบครองรถ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" name="owner_start_date" placeholder="วันที่ครอบครองรถ" value="{{old('owner_start_date')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_card_id" class="col-sm-2 control-label">หนังสือแสดงการจดทะเบียน/บัตรประจำตัว</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_card_id" placeholder="หนังสือแสดงการจดทะเบียน/บัตรประจำตัว" value="{{old('owner_card_id')}}">
                    </div>
                    <label for="owner_nationality" class="col-sm-1 control-label">สัญชาติ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_nationality" placeholder="สัญชาติ" value="{{old('owner_nationality')}}">
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
                        <input name="owner_address_one" class="form-control" type="text" value="{{old('owner_address_one')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <input id="address_auto" class="form-control" type="text" name="owner_address_auto" value="{{old('owner_address_auto')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_transport_type" class="col-sm-2 control-label">ประกอบการขนส่งประเภท</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="owner_transport_type" placeholder="ประกอบการขนส่งประเภท" value="{{old('owner_transport_type')}}">
                    </div>
                    <label for="owner_authorized_code" class="col-sm-2 control-label">ใบอนุญาตเลขที่</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_authorized_code" placeholder="ใบอนุญาตเลขที่" value="{{old('owner_authorized_code')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="owner_authorized_expire_date" class="col-sm-2 control-label">วันสิ้นสุดใบอนุญาต</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control datepicker" name="owner_authorized_expire_date" placeholder="วันสิ้นสุดใบอนุญาต" value="{{old('owner_authorized_expire_date')}}">
                    </div>
                    <label for="owner_has_ownership" class="col-sm-2 control-label">มีสิทธิ์ครอบครองและใช้รถ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="owner_has_ownership" placeholder="มีสิทธิ์ครอบครองและใช้รถ" value="{{old('owner_has_ownership')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ownership_name" class="col-sm-2 control-label">ผู้ถือกรรมสิทธิ์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ownership_name" placeholder="ผู้ถือกรรมสิทธิ์" value="{{old('ownership_name')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">เลขที่ตั้ง ,ซอย , ถนน</label>
                    <div class="col-sm-4">
                        <input name="ownership_address_one" class="form-control" type="text" value="{{old('ownership_address_one')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="search" class="col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <input id="address_auto" class="form-control" type="text" name="ownership_address_auto" value="{{old('ownership_address_auto')}}">
                    </div>
                </div>

                {{--<hr>--}}

                {{--<div class="form-group">--}}
                    {{--<label for="content" class="col-sm-2 control-label">เอกสารเล่มจดทะเบียน</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<p>--}}
                            {{--<input type="file" class="form-control" name="book_file_path">--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <input type="hidden" name="owner_id" value="{{$dlt_customer_id}}">
                <button type="submit" class="btn btn-success btn-group-justified">บันทึกข้อมูล</button>

            </form>

        </div><!-- /.box-body -->
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

    {{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
    <script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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