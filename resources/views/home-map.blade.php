@extends('adminlte::page')

@push('css-head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <script src="{{asset('js/Leaflet.Polyline.SnakeAnim/L.Polyline.SnakeAnim.js')}}"></script>
@endpush

@section('title', 'AdminLTE')

@section('content_header')
@stop
<style>
    #map {
        height: 100%;
        width: 100%;
    }
</style>
@section('content')
    <div id="map"></div>
@stop

@push('js-footer')

@endpush


@section('scripts')
    <script>
        var map = L.map('map').setView([16.117553, 100.997716], 10);
        var positron = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        //        var geoJsonData = {
//            "type":"FeatureCollection", "crs":{
//                "type":"name", "properties":{
//                    "name":"urn:ogc:def:crs:OGC:1.3:CRS84" } }, "features":[
//                {
//                    "type":"Feature", "properties":{
//                    "latitude":21.159216, "longitude":-100.934121, "time":1, "id":"route1", "name":"Along route" }, "geometry":{
//                    "type":"Point", "coordinates":[
//                        -100.934121, 21.159216 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":20.527743, "longitude":-100.807746, "time":2, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -100.807746, 20.527743 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":20.951976, "longitude":-101.427837, "time":3, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.427837, 20.951976 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":21.018937, "longitude":-101.257851, "time":4, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.257851, 21.018937 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":19.768333, "longitude":-101.189444, "time":5, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.189444, 19.768333 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":19.283333, "longitude":-99.35, "time":6, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -99.35, 19.283333 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":20.095711, "longitude":-99.838028, "time":7, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -99.838028, 20.095711 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":19.768333, "longitude":-101.189444, "time":8, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.189444, 19.768333 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":19.989644, "longitude":-102.288057, "time":9, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -102.288057, 19.989644 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":20.291022, "longitude":-102.544298, "time":10, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -102.544298, 20.291022 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":20.674278, "longitude":-103.010037, "time":11, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -103.010037, 20.674278 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":22.176245, "longitude":-102.340678, "time":12, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -102.340678, 22.176245 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":22.769783, "longitude":-102.582096, "time":13, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -102.582096, 22.769783 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":22.931168, "longitude":-101.092904, "time":14, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.092904, 22.931168 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":23.127954, "longitude":-101.114198, "time":15, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -101.114198, 23.127954 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":23.644761, "longitude":-100.643697, "time":16, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -100.643697, 23.644761 ] } }, {
//                    "type":"Feature", "properties":{
//                        "latitude":23.821589, "longitude":-100.724147, "time":17, "id":"route1", "name":"Along route" }, "geometry":{
//                        "type":"Point", "coordinates":[
//                            -100.724147, 23.821589 ] } } ] };

       // console.log(geoJsonData);
//        var geoJsonObject = JSON.parse(geoJsonData),
//            features = geoJsonObject.features,
//            layers = [];
//
//        // Assume we have only point features in the GeoJSON.
//        for (var i = 0; i < features.length; i += 1) {
//            if (i) {
//                // Create a polyline between the previous point and the current one.
//                layers.push(L.polyline([
//                    swapLngLat(features[i - 1].geometry.coordinates),
//                    swapLngLat(features[i].geometry.coordinates)
//                ]));
//
//                // Add the current point.
//                layers.push(L.marker(swapLngLat(features[i].geometry.coordinates)));
//            } else {
//                // Add the initial point.
//                layers.push(L.marker(swapLngLat(features[i].geometry.coordinates)));
//            }
//        }
//
//        L.layerGroup(layers).addTo(map).snakeIn();
//
//        function swapLngLat(lngLatArray) {
//            return [
//                lngLatArray[1],
//                lngLatArray[0]
//            ];
//        }

    </script>
@endsection