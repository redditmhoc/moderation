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
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
        <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>

        <!--Flatpickr-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!--DataTables-->
        <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.semanticui.min.css">
        <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

        <!--Custom styles-->
        <style>
            body {
                background-color: #ededed;
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

            .mhoc-green-text {
                color: rgb(0, 107, 60) !important;;
            }
        </style>
    </head>
    <body>
        <div id="site">
            @yield('content')
        </div>
        <div id="footer" class="ui inverted vertical footer segment">
            <div class="ui container">
                <div class="ui stackable inverted divided equal height stackable grid">
                    <div class="eight wide column">
                        MHoC Moderation version {{ config('app.version') }}
                    </div>
                    <div class="eight wide column">
                        <a href="" class="ui inverted button">
                            <i class="github icon"></i>
                            GitHub
                        </a>
                        <a href="" class="ui inverted button">
                            <i class="flag icon"></i>
                            Report issue or bug
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    @yield('scripts')
</html>
