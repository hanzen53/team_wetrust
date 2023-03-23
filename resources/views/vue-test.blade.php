<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel + Vue</title>
    </head>
    <body>
        <div id="app">
            <vueleaflet></vueleaflet>
        </div>
        <script type="text/javascript" src="js/app.js"></script>
    </body> 
</html>