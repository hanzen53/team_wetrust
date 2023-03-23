<html>

<head>
    <title>Realtime</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #map{
            position: inherit;
            top: 0;
            left: 0; 
            width: 100%;
            height: 600px;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <div class="card bg-light mb-3">
        <div class="card-header"><h5 id="status"></h5></div>
        <div class="card-body">
            <h5 class="card-title">คนขับ:  <span id="driver"></span></h5>
            <h5 class="card-title">ความเร็ว: <span id="speed"></span> Km/h</h5>
            <h5 class="card-title">เวลา: <span id="utc_ts"></span></h5>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet-src.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.js"></script>
    <script>
        var carIcon = L.icon({
            iconUrl: 'http://lite.wetrustgps.com/images/device_icons/rotating/2.png',
        });

        var map = L.map('map'),

            trail = {
                type: 'Feature',
                properties: {
                    id: 1
                },
                geometry: {
                    type: 'LineString',
                    coordinates: []
                }
            },


            realtime = L.realtime(function(success, error) {
                fetch('https://api01.wetrustgps.com:7899/geo-realtime/' + <?php echo $imei; ?>)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        var trailCoords = trail.geometry.coordinates;
                        trailCoords.push(data.geometry.coordinates);
                        trailCoords.splice(0, Math.max(0, trailCoords.length - 5));
                        console.log(trailCoords)

                        if(data.driver === ''){
                            var driver = '-';
                        }else{
                            var driver = data.driver;
                        }

                        document.getElementById('driver').innerHTML =  driver;
                        document.getElementById('speed').innerHTML =  data.speed;
                        document.getElementById('utc_ts').innerHTML =  data.utc_ts;
                        document.getElementById('status').innerHTML =  'สถานะรถ: <small>'+data.status+'</small>';
                        success({
                            type: 'FeatureCollection',
                            features: [data, trail]
                        });
                    })
                    .catch(error);
            }, {
                interval: 3000
            }).addTo(map);

        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> Powered by <a href="https://wetrustgps.com">WetrustGPS</a>'
        }).addTo(map);


        realtime.on('update', function() {
            map.fitBounds(realtime.getBounds(), {
                maxZoom: 13
            });
        });
    </script>
</body>

</html>