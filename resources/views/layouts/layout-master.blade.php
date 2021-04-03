<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="back-end squee steak" />
        <meta name="author" content="winda" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('web-title')</title>
        <link rel="icon" href="{{ asset('assets/img/icons_steaks.png') }}" type="image" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            /* responsive font size */
            html {
                font-size: 14px !important;
            }
            @media screen and (min-width: 320px) {
                html {
                    font-size: calc(14px + 6 * ((100vw - 320px) / 680)) !important;
                }

                h1, .h1 {
                    font-size: 5vw
                }

                p, th, td {
                    font-size: 3vw
                }
            }
            @media screen and (min-width: 1000px) {
                html {
                    font-size: 14px !important;
                }
                h1, .h1 {
                    font-size: 3vw
                }

                p, th, td {
                    font-size: 1vw
                }
            }

            @media screen and (min-width: 1360px) {
                html {
                    font-size: 16px !important;
                }
                h1, .h1 {
                    font-size: 2vw
                }
                p, th, td {
                    font-size: 1vw
                }
            }

            @media screen and (min-width: 1980px) {
                html {
                    font-size: 16px !important;
                }
                h1, .h1 {
                    font-size: 8vw
                }
                p, th, td {
                    font-size: 1vw
                }
            }
        </style>
        @yield('web-style')
    </head>
    <body class="sb-nav-fixed">
        @include('layouts.display-items.navbar-top')
        <div id="layoutSidenav">
            @include('layouts.display-items.navbar-side')
            <div id="layoutSidenav_content">
                <main>
                    @yield('web-content')
                </main>
                @include('layouts.display-items.footer')
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script> --}}
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script> --}}

        {{-- script sendiri --}}
        {{-- stack can be appended as many times as needed
            https://laravel.com/docs/8.x/blade#stacks
            --}}
        @stack('js')
    </body>

</html>
