<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        u.dotted{
            border-bottom: 1px dashed #999;
            text-decoration: none;
        }

        body {
            font-family: "THSarabunNew";
        }

        pre {
            display: block;
            padding: 3px 3px 3px 3px;
            margin: 0px;
            font-family: 'THSarabunNew';
            font-size: 22px;
            line-height: 18px;
            color: #000;
            font-weight: normal !important;
            font-style: normal !important;
            background-color: #fff;
            border: 0.5px solid #000;
            overflow-x: auto;
            border-radius: 1px;
        }

        .pre-last {
            display: block;
            padding: 3px 3px 3px 3px;
            margin: 0px;
            font-family: 'THSarabunNew';
            font-size: 22px;
            line-height: 18px;
            color: #000;
            font-weight: normal !important;
            font-style: normal !important;
            background-color: #fff;
            /*border: 0.5px solid #000;*/
            overflow-x: auto;
            /*border-radius: 1px;*/
        }



        table td {
            background-color: #fff;
            border: 0.5px solid #000;
            overflow-x: auto;
            border-radius: 1px;
        }

    </style>
</head>
<body>
<div style="height: 30px;"></div>
<br>

<div style="text-align: right;"><img src="{{public_path().'/images/wetrust-logo.png'}}" alt="DLT" width="250" height="52"></div>
<pre>
          <h3 style="text-align: center;">หนังสือรับรองการติดตั้งเครื่องบันทึกข้อมูลการเดินทางของรถ และอุปกรณ์บ่งชี้ผู้ขับรถ</h3>
    เลขที่หนังสือ WET-DLT {{$dlt_bookStock}} <br>
    บริษัท วี โกลเบิล จำกัด ที่อยู่ เลขที่  1237  ถนนพระยาสุเรนทร์  แขวงบางชัน  เขตคลองสามวา กรุงเทพมหานคร<br>
     รหัสไปรษณีย์ 10510
    โทรศัพท์ 02-040-8811 สายด่วน 064-245-9553 <br>
    ได้ติดตั้งเครื่องบันทึกข้อมูลการเดินทางของรถ และอุปกรณ์บ่งชี้ผู้ขับรถ รายละเอียดดังนี้


    การรับรองจากกรมการขนส่งทางบก เลขที<u class="dotted">     {{$gpsModelNumber}}      </u>
    ชนิด<u class="dotted">          {{$dlt_type}}          </u>แบบ<u class="dotted">         {{$pivot->gps_model}}      @if($pivot->gps_model == 'VT900')T @endif         </u>
    หมายเลขเครื่อง<u class="dotted">     {{$unit_id}}     </u>
    อุปกรณ์บ่งชี้ผู้ขับรถชนิด<u class="dotted">     WETRUST     </u>แบบ<u class="dotted">     WET-R1     </u>
    วันที่ติดตั้ง<u class="dotted">     {{$pivot_install_date}}     </u>
    ชื่อผู้ประกอบการขนส่ง/เจ้าของรถ<u class="dotted">     {{$dltCar->owner_name}}     </u>
    เลขทะเบียนรถ<u class="dotted">   {{$register_number}}   </u>   จังหวัด<u class="dotted">      {{$provinceText}}      </u>      ชนิดรถ<u class="dotted">   {{$dltCar->register_make}}   </u>                    .
    หมายเลขคัสซี<u class="dotted">          {{$dltCar->register_chassi}}          </u>
    หมายเหตุ<u class="dotted">                                                                                                              </u>



    ขอรับรองว่าเครื่องบันทึกข้อมูลการเดินทางของรถและอุปกรณ์บ่งชี้ผู้ขับรถดังกล่าวข้างต้นมีคุณลักษณะและระบบ
    การทำงานตามที่ได้รับรองจากกรมการขนส่งทางบกกรณีเครื่องบันทึกการเดินทางของรถและอุปกรณ์บ่งชี้
    ผู้ขับรถมีคุณลักษณะหรือระบบการทำงานไม่เป็นไปตามที่กรมการขนส่งทางบกได้ให้การรับรองหรือรายงานข้อมูล
    ไม่ตรงกับข้อเท็จจริงหรือไม่สามารถรายงานข้อมูลได้ตามที่กรมการขนส่งทางบกกำหนด
    บริษัท วี โกลเบิล จำกัด ยินยอมรับผิดชอบต่อความเสียหายทั้งหมดที่เกิดขึ้นต่อเจ้าของรถหรือ
    ผู้ประกอบการขนส่งที่ได้ซื้อหรือใช้บริการเครื่องบันทึกการเดินทางของรถและอุปกรณ์บ่งชี้ผู้ขับรถดังกล่าวทุกประการ


                                 ออกให้ ณ วันที่<u class="dotted">          {{$today}}          </u>
    <p></p>
    @if($sign == 1)
        <img src="{{public_path().'/images/wetrust-stamp.jpg'}}" alt="DLT" width="200" height="34"> ลงชื่อ<u class="dotted">           <img src="{{public_path().'/images/wetrust-sign.jpg'}}" alt="DLT" width="110" height="30">                          </u>

    @else
                                  ลงชื่อ<u class="dotted">                                                     </u>
    @endif
</pre>
<u class="dotted">    หมายเหตุ       </u>
๑ ชนิดและแบบของเครื่องบันทึกข้อมูลการเดินทางของรถและอุปกรณ์บ่งชี้ผู้ขับรถให้เป็นไปตามรายละเอียดที่ได้รับรองจากกรมการขนส่งทางบก <br>
๒ กรณีที่เป็นการติดตั้งเครื่องใหม่ทดแทนเครื่องเดิม ให้ระบุรายละเอียดของเครื่องบันทึกข้อมูลการเดินทางของรถและอุปกรณ์บ่งชี
ผู้ขับรถเครื่องเดิมในช่องหมายเหตุ เช่น ผู้ให้บริการรายเดิม ชนิดและแบบเดิม หมายเลขเครื่องเดิม

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div style="height: 80px"></div>

<pre>
    <h3 style="text-align: center;">ข้อมูลรายละเอียดรถที่ติดตั้งเครื่องบันทึกข้อมูลการเดินทางของรถ </h3>

                                                                                         วันที่<u class="dotted">                                         </u>
    ข้าพเจ้า<u class="dotted">     {{$dltCar->owner_name}}                                   </u>
    ที่อยู่<u class="dotted">     {{$dltCar->owner_address_one}}      {{$dltCar->owner_address_auto}}                   </u>

    ขอให้ข้อมูลรายละเอียดรถที่ติดตั้งเครื่องบันทึกข้อมูลการเดินทางของรถ ดังนี้


    <span style="font-weight: bold">ลักษณะรถ</span>
    (  ) รถที่ใช้ในการขนส่งผู้โดยสาร มาตรฐาน ( )1,  ( )2,  ( )3,  ( )4,  ( )6,  ( )7
    (  ) รถที่ใช้ในการขนส่งสัตว์หรือสิ่งของ ลักษณะ ( )1,  ( )2,  ( )3,  ( )5,  ( )9



    จำนวนเพลา<u class="dotted">                                        </u>กง<u class="dotted">                                        </u>ล้อยาง<u class="dotted">                                        </u>
    ประเภทขนส่ง (  ) ประจำทาง (  ) ไม่ประจำทาง (  ) ส่วนบุคคล<br>
    เลขทะเบียนรถ<u class="dotted">               {{$register_number}}                          </u>
    หมายเลขคัสซี<u class="dotted">               {{$dltCar->register_chassi}}                          </u>


    พร้อมนี้ได้แนบสำเนาหนังสือแสดงการจดทะเบียน (ถ้ามี) มาพร้อมนี้



                                                            (ลงชื่อ)...................................................................ผู้ประกอบการขนส่ง
                                                                   (...................................................................)

</pre>

<div style="height: 200px"></div>
<div style="height: 220px"></div>
<table>
    <tr>
        <td style="width: 150px; height: 100px; text-align: center;"><img src="{{public_path().'/images/dlt-logo.png'}}" alt="DLT" height=""></td>
        <td rowspan="2" style="width: 100px; height: 100px;">
            <pre style="border: none; padding-left: 5px"> ได้รับการรับรองจากกรมการขนส่งทางบก เลขที<u class="dotted">   {{$gpsModelNumber}}   </u><br>
ชนิด<u class="dotted">             {{$dlt_type}}            </u>แบบ<u class="dotted">            {{$pivot->gps_model}}     @if($pivot->gps_model == 'VT900')T @endif    </u> <br>
หมายเลขเครื่อง<u class="dotted">   {{$unit_id}}     </u><br>
ทะเบียน<u class="dotted">     {{$register_number}}     </u>   จังหวัด<u class="dotted">      {{$provinceText}}      </u><br>
หมายเลขคัสซี<u class="dotted">          {{$dltCar->register_chassi}}          </u><br>
ผู้ให้บริการติดตามรถ <u class="dotted">          บริษัท วีโกลเบิล จำกัด          </u>
วันที่ติดตั้ง<u class="dotted">     {{$pivot_install_date}}     </u>
</pre>
        </td>
    </tr>
    <tr>
        <td style="width: 100px; height: 100px; text-align: center;"><img src="{{public_path().'/images/wetrust-logo.png'}}" alt="DLT" width="130" height="27"></td>
    </tr>
</table>
</body>
</html>