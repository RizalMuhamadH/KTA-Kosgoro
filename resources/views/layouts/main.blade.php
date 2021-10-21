<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>{{ config('app.name', 'Laravel') }} &mdash; @yield('page_title')</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{asset('assets/bootstrap/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.min.css')}}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{asset('assets/stisla/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assets/stisla/css/components.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datatables/datatables.min.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    </head>

    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <form class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        </ul>
                    </form>
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{asset('storage/data_member/'.Auth::user()->id.'/'.Auth::user()->photo)}}" onerror="this.src='{{asset('assets/stisla/img/avatar/avatar-1.png')}}'" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar">
                    <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Stisla</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">St</a>
                    </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Dashboard</li>
                            <li> <a href="{{route('home')}}" class="nav-link active"><i class="fas fa-home"></i><span>Dashboard</span></a> </li>
                            <li class="menu-header">Manage </li>
                            <li><a class="nav-link" href="{{route('members.index')}}"><i class="far fa-user"></i> <span>Members</span></a></li>
                        </ul>
                    </aside>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    @yield('section')
                </div>
                <footer class="main-footer">
                    <div class="footer-left">
                        Copyright &copy; {{date("Y")}} <div class="bullet"></div> Kosgoro
                    </div>
                    <div class="footer-right">
                        1.0
                    </div>
                </footer>
            </div>
        </div>

        <!-- General JS Scripts -->
        <script src="{{asset('assets/jquery/jquery-3.3.1.min.js')}}"></script>
        <script src="{{asset('assets/popper/popper.min.js')}}"></script>
        <script src="{{asset('assets/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/nicescroll/jquery.nicescroll.min.js')}}"></script>
        <script src="{{asset('assets/moment/moment.min.js')}}"></script>
        <script src="{{asset('assets/datatables/datatables.min.js')}}"> </script>
        <script src="{{asset('assets/stisla/js/stisla.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Template JS File -->
        <script src="{{asset('assets/stisla/js/scripts.js')}}"></script>



        <script>
            function hanyaAngka(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 190)
                    return false;
                return true;
            }

        function hanyaHuruf(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
                if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 123) && charCode != 32)
                return false;
            return true;
        }

        function HurufAngka(e){
            var regex = new RegExp("^[a-zA-Z0-9 ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }

            e.preventDefault();
            return false;
        }
        </script>

        @stack('custom_js')
    <!-- Page Specific JS File -->
    </body>
</html>
