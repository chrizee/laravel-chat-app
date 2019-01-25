<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel chat</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link href="{{ asset("css/app.css") }}" rel="stylesheet" />
    <link href="{{ asset("bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset("dist/css/AdminLTE.min.css") }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset("dist/css/skins/_all-skins.min.css") }}">
    <link rel="stylesheet" href="{{ asset("font-awesome/css/font-awesome.min.css") }}" >


</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div id="app" class="wrapper">
        <App />
    </div>
<script src="{{ asset("js/app.js") }}"></script>
<script src="{{ asset("plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<script src="{{ asset("bootstrap/js/bootstrap.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("dist/js/app.min.js") }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset("dist/js/pages/dashboard.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("dist/js/demo.js") }}"></script>
</body>
</html>
