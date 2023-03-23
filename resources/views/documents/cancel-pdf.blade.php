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
            border: 0px solid #000;
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



        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 0.5px solid black;
        }

    </style>
</head>
<body>
        @php 
        use Carbon\Carbon;
        @endphp
{{-- <div style="height: 30px;"></div> --}}
<div style="text-align: center;">
    <img src="{{public_path().'/images/wetrust-logo.png'}}" alt="DLT" width="250" height="52">
    <br>
    ที่อยู่บริษัท  1237  ถนนพระยาสุเรนทร์   แขวงบางชัน  เขตคลองส–ามวา  กรุงเทพฯ 10510 

</div>
<pre>
        <div style="padding-left : 450px;">{{Carbon::now()->format('d/m/Y')}}</div>
การแจ้งเรื่อง : ขอยกเลิกการใช้ GPS <br>
เรียน ท่านผู้ใช้ระบบ GPS<br>
<div style="height: 10px;"></div>
        บริษัท วี โกลเบิล จำกัด เป็นผู้ให้บริการระบบ GPS ซึ่งได้รับแจ้งจากท่านเจ้าของรถมีความประสงค์ที่จะขอเลิก
ใช้ระบบ GPS ที่ติดตั้งกับทางบริษัท ซึ่งในฐานะที่บริษัทเป็นผู้ให้บริการและมีหน้าที่รับผิดชอบ 
ในการส่งข้อมูลการเดินรถที่ถูกต้องครบถ้วน และรวดเร็วให้กับกรมการขนส่งทางบก 
จึงขอให้ท่านยืนยันความประสงค์ในการเลิกระบบ GPS พร้อมเซ็นต์ชื่อกำกับ และ ส่งเอกสารเลิกใช้ระบบ GPS 
คืนบริษัทภายใน 3 วัน เพื่อบริษัทจะได้ดำเนินการแจ้งกับทางกรมการขนส่งทางบกในการเลิกใช้ระบบ GPS 
และขอลบข้อมูลออกจากระบบ GPS ของบริษัท 
<br>
<br>
        จึงเรียนมาเพื่อทราบ และโปรดดำเนินการ



<h3>ยกเลิก {{count($cars)}} คัน</h3>
<table>
    <thead>
        <tr>
            <td style="text-align: center; padding: 5px; width:100px">IMEI</td>
            <td style="text-align: center; padding: 5px; width:100px">วันที่ติดตั้ง</td>
            <td style="text-align: center; padding: 5px; width:100px">ทะเบียน</td>
            <td style="text-align: center; padding: 5px; width:200px">หมายเลขตัวถัง</td>
           
        </tr>
    </thead>
    <tbody>
        @php
            $totalPrice = 0;
        @endphp
        @foreach ($cars as $car)
        <tr>
                <td style="text-align: center; padding: 5px">{{$car['unit_id']}}</td>
                <td style="text-align: center; padding: 5px">{{$car['install_date']}}</td>
                <td style="text-align: center; padding: 5px">{{$car['register_name']}}</td>
                <td style="text-align: center; padding: 5px">{{$car['register_chassi']}}</td>
               
        </tr>

        @endforeach
   
    </tbody>
  
    </table>

    <h3>จากผู้ประกอบการ: {{$customer->name}} </h3>
<br>
ลงชื่อ <u class="dotted">                                      </u>   
                   ผู้ขอยกเลิก
 <p></p>
 <p></p>
                                                                                     <img src="{{public_path().'/images/wetrust-stamp.jpg'}}" alt="DLT" width="200" height="34"> 
                                                                                  ลงชื่อ<u class="dotted">           <img src="{{public_path().'/images/wetrust-sign.jpg'}}" alt="DLT" width="110" height="30"></u>  
                                                                                        นางสาวทรรศนีย์จนั ทะสาร                                                
                                                                                             กรรมการผู่้จัดการ
                                                                                            บริษัท วี โกลเบิล จำกัด
                                                                                                              
                                                                                                                                                                                                                                                                                                                             บริษัท วี โกลเบิล จำกัด                                                                      
</pre>
</body>
</html>