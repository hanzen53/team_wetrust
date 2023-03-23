<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WetrustGPS CheckMe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <style>
        body {
            background: #007bff;
        }

        #pictureUrl {
            display: block;
            margin: 0 auto
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        div.text-center {
            text-align: center;
            padding-top: 5px;
        }

        .card-footer {
            position: relative;
            margin-top: -150px;
            /* negative value of footer height */
            height: 150px;
            clear: both;
            padding-top: 20px;
        }

        #mapid {
            /* position: absolute;
            top: 0;
            left: 0; */
            width: 100%;
            height: 300px;
        }

        #mapid_android {
            /* position: absolute;
            top: 0;
            left: 0; */
            width: 100%;
            height: 300px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="card text-center text-white bg-primary">
            <div class="card-header">
                WetrustGPS Check Me.
            </div>
            <div class="card-body">
                <img id="pictureUrl" width="25%" class="rounded-circle">
                <br>
                <strong><span id="displayName" class="text-center"></span></strong>
                <span class="muted" id="statusMessage"></span>

                <div class="">
                    <div class="text-center">
                        <div v-if="os === 'android'">
                            <button id="btnScanCode" type="button" class="btn btn-primary btn-lg" onclick="scanCode();">Scan เพื่อตรวจสอบข้อมูล</button>
                            <p></p>
                            <p>
                                <strong>
                                    <span id="carName"></span>
                                </strong>
                                <br>
                                <strong>
                                    <span id="carImei"></span>
                                </strong>
                                <br>
                                <strong>
                                    <span id="driver"></span>
                                </strong>
                                <br>
                                <strong>
                                    <span id="utc_ts"></span>
                                </strong>
                                <br>
                                <strong>
                                    <span id="acc"></span>
                                </strong>
                                <br>
                                <strong>
                                    <span id="num_sats"></span>
                                </strong>

                            </p>
                        </div>
                        <div v-else>

                            <div class="row justify-content-center">
                                <input type="text" placeholder="หมายเลขเครื่อง" v-model="imei">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" v-on:click="iosCheck()">ตรวจสอบ</button>
                                </span>
                            </div>

                            <p></p>
                            <p v-if="device_id != ''">
                                <strong>
                                    <span>ทะเบียน : @{{ carName }}</span>
                                </strong>
                                <br>
                                <strong>
                                    <span>IMEI : @{{ device_id }}</span>
                                </strong>
                                <br>
                                <strong>
                                    <span>คนขับ : @{{ driver }}</span>
                                </strong>
                                <br>
                                <strong>
                                    <span>เวลาอุปกรณ์ : @{{ utc_ts }}</span>
                                </strong>
                                <br>
                                <strong>
                                    <span>Acc : @{{ acc }}</span>
                                </strong>
                                <br>
                                <strong>
                                    <span>จำนวนดาวเทียมที่รับ : @{{ num_sats }}</span>
                                </strong>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="os === 'android'">
            <div id="mapid_android"></div>
        </div>
        <div v-else>
            <div id="mapid"></div>
        </div>


        <!-- <div class="card-footer text-white bg-primary text-center">
            2 days ago
        </div> -->
    </div>


    <script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.25.3/moment.min.js"></script>

    <script>
        // var imei = '359857082657974';

        // axios.get('https://api01.wetrustgps.com:7899/api/devices/show/'+imei)
        // .then(function (response) {
        //     // handle successg
        //     console.log(response);

        //     var driver = '';
        //     if(response.data.last_know_position[0].driver_id != " "){
        //         driver = response.data.last_know_position[0].driver_id;
        //     }else{
        //         driver = '-' 
        //     }

        //     var acc = ''
        //     if(response.data.last_know_position[0].acc == 0){
        //         acc = 'ปิด' 
        //     }else{
        //         acc = 'เปิด' 
        //     }

        //     var lat = response.data.last_know_position[0].lat;
        //     // console.log(lat);
        //     var lon = response.data.last_know_position[0].lon;
        //     // console.log(lon);



        //     document.getElementById('carName').innerHTML = 'ทะเบียน : ' + response.data.device_name;
        //     document.getElementById('carImei').innerHTML = 'IMEI : ' + response.data.device_id;
        //     document.getElementById('driver').innerHTML = 'คนขับ : ' + driver;
        //     document.getElementById('utc_ts').innerHTML = 'เวลาอุปกรณ์ : ' + moment(response.data.last_know_position[0].utc_ts).format('DD/MM/YYYY');
        //     document.getElementById('utc_ts').innerHTML = 'Acc : ' + acc;



        //     var mymap = L.map('mapid')
        //     .setView([lat,lon], 19);

        //     var carIcon = L.icon({
        //         iconUrl: 'http://lite.wetrustgps.com/images/device_icons/rotating/2.png',
        //         // shadowUrl: 'leaf-shadow.png',
        //         // iconSize:     [38, 95], // size of the icon
        //         // shadowSize:   [50, 64], // size of the shadow
        //         // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        //         // shadowAnchor: [4, 62],  // the same for the shadow
        //         // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        //     });

        //     L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        //         maxZoom: 19,
        //         attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>, ' +'Powered by © <a href="https://www.wetrustgps.com/">WetrustGPS</a>',
        //         id: 'mapbox/streets-v11',
        //         tileSize: 512,
        //         zoomOffset: -1
        //     }).addTo(mymap);

        //     L.marker([lat,lon],{icon: carIcon})
        //     .addTo(mymap)
        //     .bindPopup("<h2>"+response.data.device_name+"</h2><br />")

        // })





        function runApp() {
            liff.getProfile().then(profile => {
                document.getElementById("pictureUrl").src = profile.pictureUrl;
                // document.getElementById("userId").innerHTML = '<b>UserId:</b> ' + profile.userId;
                document.getElementById("displayName").innerHTML = 'สวัสดีค่ะคุณ : ' + profile.displayName;
                // document.getElementById("statusMessage").innerHTML = '<b>StatusMessage:</b> ' + profile.statusMessage;
                // document.getElementById("getDecodedIDToken").innerHTML = '<b>Email:</b> ' + liff.getDecodedIDToken().email;
            }).catch(err => console.error(err));
        }
        liff.init({
            liffId: "1594385570-GkQPdEy6"
        }, () => {
            if (liff.isLoggedIn()) {
                runApp()

                var app = new Vue({
                    el: '#app',
                    data() {
                        return {
                            os: liff.getOS(),
                            imei: '',
                            carName: '',
                            device_id: '',
                            driver: '',
                            utc_ts: '',
                            acc: '',
                            num_sats: '',
                        }
                    },
                    methods: {
                        iosCheck(value) {

                            var imei = this.imei
                            var self = this;

                            // console.log(imei)

                            axios.get('https://api01.wetrustgps.com:7899/api/devices/show/' + imei)
                                .then(function(response) {

                                    var acc = ''
                                    if (response.data.last_know_position[0].acc == 0) {
                                        acc = 'ปิด'
                                    } else {
                                        acc = 'เปิด'
                                    }

                                    var lat = response.data.last_know_position[0].lat;
                                    console.log(lat);
                                    var lon = response.data.last_know_position[0].lon;
                                    console.log(lon);

                                    console.log(response)
                                    self.carName = response.data.device_name;
                                    self.device_id = response.data.device_id;
                                    self.acc = acc;
                                    self.driver = response.data.last_know_position[0].driver_id;
                                    self.num_sats = response.data.last_know_position[0].num_sats;
                                    self.utc_ts = moment(response.data.last_know_position[0].utc_ts).format('DD/MM/YYYY HH:mm');


                                    var realtimeLink = 'https://team.wetrustgps.com/realtime-tracking/' + response.data.device_id;

                                    var mymap = L.map('mapid')
                                        .setView([lat, lon], 19);

                                    var carIcon = L.icon({
                                        iconUrl: 'http://lite.wetrustgps.com/images/device_icons/rotating/2.png',
                                    });

                                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                                        maxZoom: 19,
                                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>, ' + 'Powered by © <a href="https://www.wetrustgps.com/">WetrustGPS</a>',
                                        id: 'mapbox/streets-v11',
                                        tileSize: 512,
                                        zoomOffset: -1
                                    }).addTo(mymap);

                                    L.marker([lat, lon], {
                                            icon: carIcon
                                        })
                                        .addTo(mymap)
                                        .bindPopup('<a href="' + realtimeLink + '"><h2>กดเพื่อดู Realtime</h2></a>')

                                })
                        }
                    },
                })
            } else {
                liff.login();
            }
        }, err => console.error(err.code, error.message));


        function scanCode() {

            if (!liff.isInClient()) {
                liff.login();
            } else {
                if (liff.scanCode) {
                    liff.scanCode().then(result => {

                        var imei = result.value;
                        axios.get('https://api01.wetrustgps.com:7899/api/devices/show/' + imei)
                            .then(function(response) {
                                // handle successg
                                console.log(response);

                                var driver = '';
                                if (response.data.last_know_position[0].driver_id != " ") {
                                    driver = response.data.last_know_position[0].driver_id;
                                } else {
                                    driver = '-'
                                }

                                var acc = ''
                                if (response.data.last_know_position[0].acc == 0) {
                                    acc = 'ปิด'
                                } else {
                                    acc = 'เปิด'
                                }

                                var lat = response.data.last_know_position[0].lat;
                                // console.log(lat);
                                var lon = response.data.last_know_position[0].lon;

                                // alert(lat+','+lon)



                                document.getElementById('carName').innerHTML = 'ทะเบียน : ' + response.data.device_name;
                                document.getElementById('carImei').innerHTML = 'IMEI : ' + response.data.device_id;
                                document.getElementById('driver').innerHTML = 'คนขับ : ' + driver;
                                document.getElementById('utc_ts').innerHTML = 'เวลาอุปกรณ์ : ' + moment(response.data.last_know_position[0].utc_ts).format('DD/MM/YYYY HH:mm');
                                document.getElementById('acc').innerHTML = 'Acc : ' + acc;
                                document.getElementById('num_sats').innerHTML = 'จำนวนดาวเทียมที่รับ : ' + response.data.last_know_position[0].num_sats;
                                // document.getElementById('os').innerHTML = 'OS : ' + liff.getOS();


                                var realtimeLink = 'https://team.wetrustgps.com/realtime-tracking/' + response.data.device_id;

                                var mymap_android = L.map('mapid_android')
                                    .setView([lat, lon], 19);

                                var carIcon = L.icon({
                                    iconUrl: 'http://lite.wetrustgps.com/images/device_icons/rotating/2.png',
                                    // shadowUrl: 'leaf-shadow.png',
                                    // iconSize:     [38, 95], // size of the icon
                                    // shadowSize:   [50, 64], // size of the shadow
                                    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
                                    // shadowAnchor: [4, 62],  // the same for the shadow
                                    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                                });

                                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                                    maxZoom: 19,
                                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>, ' + 'Powered by © <a href="https://www.wetrustgps.com/">WetrustGPS</a>',
                                    id: 'mapbox/streets-v11',
                                    tileSize: 512,
                                    zoomOffset: -1
                                }).addTo(mymap_android);

                                L.marker([lat, lon], {
                                        icon: carIcon
                                    })
                                    .addTo(mymap_android)
                                    //.bindPopup("<h2>"+response.data.device_name+"</h2><br />")
                                    .bindPopup('<a href="' + realtimeLink + '"><h2>กดเพื่อดู Realtime</h2></a>')


                            })

                    }).catch(err => {
                        // document.getElementById('scanCode').textContent = "scanCode failed!";
                        document.getElementById('scanCode').textContent = err;
                    });
                }
            }
        }
    </script>
</body>

</html>