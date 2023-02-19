<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="{{url('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <script src="{{url('assets/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
        <script src="{{url('assets/js/sb-admin-2.min.js')}}"></script>
        <script src="{{url('assets/vendor/chart.js/Chart.min.js')}}"></script>
        <script src="{{url('assets/js/demo/chart-area-demo.js')}}"></script>
        <script src="{{url('assets/js/demo/chart-pie-demo.js')}}"></script>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <script src="{{ mix('js/app.js') }}" defer></script>
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-light">
        <div id="wrapper">
            @livewire('navigation-menu')

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <div class="card">
                        <div class="card-body">
                            {{ $header }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="container my-5">
            {{ $slot }}
        </main>

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
