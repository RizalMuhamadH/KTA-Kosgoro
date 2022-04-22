@extends('layouts.pwa')

@section('body')
    <header>
        <nav class="center">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{route('pwa.index')}}" class="breadcrumb">Beranda</a>
              </div>
            </div>
        </nav>
                    
    </header>
    <main>
        <div class="container">
            <div class="row">
                <a href="{{route('pwa.profile',['email' => Auth::user()->email])}}">
                    <div class="col s4 menu_click">
                        <div class="center card card-round dashboard-menu">
                            <i class="material-icons">account_circle</i>
                            <p class="menu-caption" style="word-wrap: break-word;">Keanggotaan</p>
                        </div>
                    </div>
                </a>
                <a href="{{route('pwa.news')}}">
                    <div class="col s4 ">
                        <div class="center card card-round dashboard-menu">
                            <i class="material-icons">newspaper</i>
                            <p class="menu-caption" style="word-wrap: break-word;" >News</p>
                        </div>
                    </div>
                </a>
                <a href="{{route('pwa.events')}}">
                    <div class="col s4 ">
                        <div class="center card card-round dashboard-menu">
                            <i class="material-icons">event</i>
                            <p class="menu-caption" style="word-wrap: break-word;">Events</p>
                        </div>
                    </div>
                </a>
                {{-- <div class="col s4 ">
                    <div class="center card card-round dashboard-menu">
                        <i class="material-icons">qr_code_scanner</i>
                        <p class="menu-caption">QR Code</p>
                      </div>
                </div> --}}
                
                <div class="col s4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="center card card-round dashboard-menu">
                        <i class="material-icons red-text">exit_to_app</i>
                        <p class="menu-caption" style="word-wrap: break-word;">Logout</p>
                    </div>
                      
                    <form id="logout-form" action="{{ route('pwa.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                
            </div>
            {{-- <div class="row">
                <div class="col s4" >
                    <div class="card card-round" style="height: 12.5vh">
                        <div class="card-content">
                            <a class="orange-text center" href="{{route('pwa.index')}}">
                                <i class="material-icons text-center   sidenav-trigger">home</i></a>
                                Beranda
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card card-round" style="height: 12.5vh">
                        <div class="card-content">
                            <a class="orange-text center" href="{{route('pwa.index')}}">
                                <i class="material-icons text-center sidenav-trigger">account_circle</i></a>
                                Keanggotaan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card card-round" style="height: 12.5vh">
                        <div class="card-content">
                            <a class="orange-text center" href="{{route('pwa.index')}}">
                                <i class="material-icons text-center sidenav-trigger">newspaper</i></a>
                                News
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card card-round" style="height: 12.5vh">
                        <div class="card-content">
                            <a class="orange-text center" href="{{route('pwa.index')}}">
                                <i class="material-icons text-center sidenav-trigger">event</i></a>
                                Event
                            </a>
                        </div>
                    </div>
                </div>
                
            </div> --}}
        </div>
    </main>
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container black-text">
                © {{date('Y')}} - Kosgoro
            </div>
        </div>
    </footer>
    
@endsection