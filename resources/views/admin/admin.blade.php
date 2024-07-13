<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="AEUTNA"/>
        <meta name="author" content="RAMANANA Thu Ming Thierry" />
        <title>@yield('titre', "A.E.U.T.N.A") | AntaTech Solutions</title>
        @yield('styles')
        @include('admin.layouts.styles')
    </head>
    <body class="sb-nav-fixed">
        @include('admin.layouts.nav')

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('admin.layouts.sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                      @yield('contenu')
                    </div>
                </main>
                @include('admin.layouts.footer')
            </div>
        </div>
        @include('admin.layouts.script')
        @yield('script')
    </body>
</html>
