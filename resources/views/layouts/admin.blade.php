<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="api-token" content="{{auth()->user()->api_token}}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Environemnt Authority | North Western Province</title>
        @yield('styles')
    <body class="hold-transition sidebar-mini layout-fixed text-sm">
        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                @yield('navbar')
            </nav>
            <!-- Navbar -->
            <!-- Main Sidebar Container -->
            <!--  <aside class="main-sidebar sidebar-dark-primary elevation-4">-->
            <aside class="main-sidebar layout-fixed sidebar-dark-olive accent-navy">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                         style="opacity: .8">
                    <span class="brand-text font-weight-light">Environemnt MS</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    @yield('sidebar')
                    <!-- /.sidebar -->
                </div>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            <!-- /.content-wrapper -->
            <footer class="main-footer sidebar-dark-primary">
                @yield('footer')
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        @yield('scripts')
        @yield('pageScripts')
    </body>
</html>
