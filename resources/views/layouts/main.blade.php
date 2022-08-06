<!DOCTYPE html>
    <html lang="en">
    <head>
        <!--Metadata-->
        <meta charset="UTF-8">
        @if (isset($_pageTitle))
            <title>{{ $_pageTitle }} | MHoC Moderation</title>
        @else
            <title>MHoC Moderation</title>
        @endif
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="https://commonslibrary.parliament.uk/wp-content/uploads/2016/08/Logo.png" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token()}} ">

        <!--Jquery-->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js">

        <!--Styles-->
        @vite(['resources/js/app.js'])

        <!--Flatpickr-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!--DataTables-->
        <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

        <!-- Livewire -->
        @livewireStyles

        <!--Custom styles-->
        {{--<style>
            body {
                /*background-color: #ededed;*/
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }

            body > .grid {
                height: 100%;
            }

            .footer.segment {
                padding: 2em 0em;
            }

            #site {
                flex: 1;
            }

            span.ui.mhoc.text, .ui.mhoc.header {
                color: rgb(0, 107, 60) !important;;
            }

            .ui.mhoc.button {
                background-color: rgb(0, 107, 60) !important;
                color: #fff;
                text-shadow: none;
                background-image: none;
                box-shadow: 0 0 0 0 rgb(34 36 38 / 15%) inset;
            }

            .ui.mhoc.button:hover {
                background-color: rgb(0, 90, 60) !important;
            }

            .ui.mhoc.button:active {
                background-color: rgb(0, 80, 60) !important;
            }
        </style>--}}
    </head>
    <body class="d-flex flex-column vh-100">
        <div id="site" class="flex-shrink-0">
            @if (session()->has('top-positive-msg') || session()->has('top-info-msg') || session()->has('top-negative-msg'))
                <div class="container" style="margin-top: 20px;">
                    @if (session()->has('top-positive-msg'))
                        <div class="ui positive message">
                            {{ session('top-positive-msg') }}
                        </div>
                    @endif
                    @if (session()->has('top-info-msg'))
                        <div class="ui info message">
                            {{ session('top-info-msg') }}
                        </div>
                    @endif
                    @if (session()->has('top-negative-msg'))
                        <div class="ui negative message">
                            {{ session('top-negative-msg') }}
                        </div>
                    @endif
                </div>
            @endif
            <div>
                @yield('content')
            </div>
        </div>
        <footer class="mt-auto py-4 text-bg-dark">
            <div class="container">
                <div class="d-flex flex-row">
                    <span>{{ config('app.name') }} Version <livewire:current-version/></span>
                </div>
            </div>
        </footer>
    </body>
    @yield('scripts')
    @livewireScripts
</html>
