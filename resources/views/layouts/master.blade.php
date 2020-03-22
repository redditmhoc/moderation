<!DOCTYPE html>
<html lang="en">
<head>
    <!--Meta-->
    <meta charset="UTF-8">
    <title>@yield('title')MHoC Speakership  </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://commonslibrary.parliament.uk/wp-content/uploads/2016/08/Logo.png" type="image/x-icon">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!--Fomantic UI-->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.4/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.4/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/se/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/se/dt-1.10.18/datatables.min.js"></script>
    <script src="{{asset('js/utility.js')}}"></script>
    <script src="{{asset('js/create-action.js')}}"></script>
    <style type="text/css">
        body {
          background-color: #ededed;
        }
        body > .grid {
          height: 100%;
        }

      </style>
</head>
<body>
    @yield('content')
</body>
</html>
