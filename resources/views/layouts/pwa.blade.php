<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="{{asset('assets/pwa/img/logo.png')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link type="text/css" href="{{asset('assets/pwa/css/materialize.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/select2/css/select2-materialize.css')}}" type="text/css" rel="stylesheet">
    <link type="text/css" href="{{asset('assets/pwa/css/style.css')}}" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <script src="{{asset('assets/jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/jquery/jquery-ui.min.js')}}"> </script>
    <script type="text/javascript" src="{{asset('assets/pwa/js/materialize.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/select2/js/select2-materialize.js')}}"> </script>

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "80f72aa5-0a29-4b29-bf0e-46732c65720e",
            safari_web_id: "",
            notifyButton: {
                enable: true,
            },
            });
        });
    </script>
    <title>{{config('app.name')}}</title>
</head>
<body>
    @yield('body')
    @stack('page-javascript')
</body>
<script src="{{asset('sw.js')}}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
</html>
