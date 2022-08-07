<!DOCTYPE html>
    <html lang="en" data-theme="mhoc">
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
        <footer class="p-4 bg-gray-800 text-white">
            <div class="footer items-center container mx-auto">
                <div class="items-center grid-flow-col">
                    <p>{{ config('app.name') }} version <livewire:current-version/></p>
                </div>
                <div class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg>
                    </a>
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg></a>
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg></a>
                </div>
            </div>
        </footer>
    </body>
    @yield('scripts')
    @livewireScripts
</html>
