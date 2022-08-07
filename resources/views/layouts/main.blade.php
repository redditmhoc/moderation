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

        <!--Jquery and Fomantic UI-->
{{--        <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>--}}
{{--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>--}}

        <!--Styles-->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!--Flatpickr-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!--DataTables-->
        <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.semanticui.min.css">
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
    <body class="flex flex-col h-screen">
        <div id="site" class="flex-grow">
            @if (session()->has('top-positive-msg') || session()->has('top-info-msg') || session()->has('top-negative-msg'))
                <div class="ui container" style="margin-top: 20px;">
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
        <footer class="text-sm text-gray-100 bg-gray-800">
            <div class="lg:mx-auto lg:max-w-6xl py-6 px-14">
                <div class="flex flex-row space-x-5">
                    <a class="hover:underline" href="#">{{ config('app.name') }} Version <livewire:current-version/></a>
                </div>
            </div>
        </footer>
    </body>
    @yield('scripts')
    @livewireScripts
</html>
