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

<div style="text-align: center;">
    <img src="{{public_path().'/images/wetrust-logo.png'}}" alt="DLT" width="250" height="52">
    <br>
    ที่อยู่บริษัท  1237  ถนนพระยาสุเรนทร์   แขวงบางชัน  เขตคลองสามวา  กรุงเทพฯ 10510

</div>

<pre>
<br>
ที่ ต.2019/0077                                                                                          {{Carbon::now()->format('d/m/Y')}} <br/>
เรียน ท่านเจ้าของรถผู้ใช้บริการระบบ GPS<br>
เรื่อง : ขอระงับการส่งข้อมูล GPS ให้กับกรมการขนส่งทางบก <br>
สิ่งที่แนบ : 1. กฎระเบียบข้อบังคับตามแบบกรมการขนส่งทางบก <br>
              2. ใบแจ้งค่าชำระบริการ

<br>
<br>
        บริษัท วี โกลเบิล จำกัด เป็นผู้ให้บริการระบบ GPS ได้ตรวจสอบพบว่ารถในครอบครองของท่าน
หมายเลขทะเบียน {{$cars[0]['register_name']}} ติดตั้งเมื่อวันที่ {{$cars[0]['install_date']}} ยังไม่ได้ชำระค่าบริการ
ให้กับทางบริษัทฯ และเลยกำหนดการชำระค่าบริการนานแล้ว

<br>
<br>
ในฐานะบริษัทฯ ซึ่งเป็นผู้ให้บริการระบบ GPS ติดตามรถ และมีหน้าที่รับผิดชอบในการส่งข้อมูลการเดินรถที่ถูกต้อง 
ครบถ้วน และรวดเร็ว หากท่านไม่มาชำระค่าบริการ ทางบริษัทฯจำเป็นต้องระงับการส่งสัญญาณ  GPS    
ภายใน 7 วันหลังจากวันที่แจ้ง หากท่านมีความประสงค์ที่จะใช้ระบบติดตาม GPS ต่อ  
ขอให้ท่านติดต่อเพื่อชำระค่าบริการระบบ GPS   และค่าบริการต่อสัญญาณเพิ่ม 500 บาท   
ได้ที่แผนกการเงิน ในวันจันทร์ – วันเสาร์   ตั้งแต่เวลา 8.00-17.00 น. หรือดำเนินการตามเอกสารที่แนบ
<br>
<br>
       จึงเรียนมาเพื่อทราบ  และขออภัยหากท่านได้ชำระเรียบร้อยแล้ว


        <br>
        <br>
        <br>







                                                    <img src="{{public_path().'/images/wetrust-stamp.jpg'}}" alt="DLT" width="200" height="34"> ลงชื่อ<u class="dotted">           <img src="{{public_path().'/images/wetrust-sign.jpg'}}" alt="DLT" width="110" height="30"></u>  
                                                                                            นางสาวทรรศนีย์ จันทะสาร                                          
                                                                                               กรรมการผู้จัดการ
                                                                                            บริษัท วี โกลเบิล จำกัด
<p style="text-align: center;">
        ติดต่อแผนกบัญชี    โทร. 02-040-8811 / 063-3438559 
</p>                                                                                                                

<br>
<br>
<br>
<br>                
<br>
<br>
<br>
<br>                                                                                                                                                                                                                                                                                                                                   บริษัท วี โกลเบิล จำกัด                                                                      
</pre>
<div style="height: 10px"></div>
<h2>ข้อมูลรถที่ค้างชำระ {{count($cars)}} คัน</h2>
<table>
    <thead>
        <tr>
            <td style="text-align: center; padding: 5px; width:100px">IMEI</td>
            <td style="text-align: center; padding: 5px; width:100px">วันที่ติดตั้ง</td>
            <td style="text-align: center; padding: 5px; width:100px">ทะเบียน</td>
            <td style="text-align: center; padding: 5px; width:200px">หมายเลขตัวถัง</td>
            <td style="text-align: center; padding: 5px; width:100px">ค่าบริการ</td>
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
                <td style="text-align: center; padding: 5px">{{$car['price']}}</td>
        </tr>
        @php
            $totalPrice += $car['price'];
        @endphp
        @endforeach
        <tr>
                <td style="text-align: center; padding: 5px" colspan="4">รวมยอดเงิน</td>
                <td style="text-align: center; padding: 5px"> {{number_format($totalPrice,2)}} บาท</td>
         </tr>
    </tbody>
  
    </table>
</body>
</html>