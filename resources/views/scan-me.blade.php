
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Scan</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
        integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <style>
    body {
        font-family: 'Sarabun', sans-serif;
        font-size:10px;
        line-height: 1.4;

        
    }
    u.dotted {
        border-bottom: 1px dashed #999;
        text-decoration: none;
    }
    </style>
    <div class="container" style="margin-top:20px; width:350px">
        <div class="row" style="border:1pt solid black;">
            <div class="col-xs-6">
                <img src="https://team.wetrustgps.com/images/img-scan.png" class="img-responsive"
                    style="max-height:300px">
            </div>
            <div class="col-xs-6 text-center">
                <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{$imei}} " class="img-responsive"
                    style="max-height:235px; margin-top:10px;">
                <strong class="text-center">ID: {{$imei}}  </strong>
            </div>
        </div>

        <div class="row" style="border:1pt solid black;">
            <div class="col-xs-3">
                <p style="height:20px"></p>
                <img src="{{secure_asset('images/wt-dlt-logo.png')}}"  class="img-responsive" alt="">
            </div>
            <div class="col-xs-9">
                <p style="height:20px"></p>

                <p>
                    ได้รับการรับรองจากกรมขนส่งทางบกเลขที่ : <strong><u class="dotted">     {{$data['gpsModelNumber']}}      </u></strong><br>
                    ชนิด<u class="dotted">&nbsp;&nbsp;&nbsp;{{$data['dlt_type']}}&nbsp;&nbsp;&nbsp;</u>  แบบ  <u class="dotted">        {{$pivot->gps_model}}  </u> <br>
                    หมายเลขเครื่อง<u class="dotted">&nbsp;&nbsp;&nbsp;{{$data['unit_id']}}     </u><br>
                    เลขทะเบียนรถ<u class="dotted">&nbsp;&nbsp;&nbsp;{{$data['register_number']}} </u>&nbsp;&nbsp;&nbsp;
                    จังหวัด<u class="dotted">&nbsp;&nbsp;&nbsp;{{$data['provinceText']}}      </u><br>   
                    หมายเลขคัสซี<u class="dotted">&nbsp;&nbsp;&nbsp;{{$dltCar->register_chassi}} </u><br>      
                     
                    ผู้ให้บริการ<u class="dotted">&nbsp;&nbsp;&nbsp;  บริษัท วี โกลเบิล จำกัด </u><br>   
                    วันที่ติดตั้ง<u class="dotted">&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($pivot->install_date)->format('d/m/Y')}}     </u>   
               
                
                </p>

            </div>

        </div>

    </div>
</body>

</html>