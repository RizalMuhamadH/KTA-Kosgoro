@extends('layouts.pwa')

@section('body')
    <div class="row">
        <div class="top" style="background-image: url('{{asset('assets/pwa/img/kta-top-orange.png')}}'); background-size:cover; background-repeat:no-repeat">

            <div class="container">
                <a class="left white-text menu" href="{{route('pwa.update',['id'    => $data->id])}}">
                    <i class="material-icons sidenav-trigger">assignment_ind</i></a>
                </a>
                <span class="right white-text menu" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="material-icons sidenav-trigger">exit_to_app</i></a>
                    <form id="logout-form" action="{{ route('pwa.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </span>
                {{-- <a href="#" class="waves-effect waves-light top-head-button-profile white-text"><i class="material-icons sidenav-trigger" data-target="side-menu">menu</i></a>
                <ul id="side-menu" class="sidenav side-menu">
                    <li><a href="{{route('pwa.index')}}" class="waves-effect">Home</a></li>
                    <li><div class="divider"></div></li>
                    <li><a href="/pages/contact.html" class="waves-effect">
                        <i class="material-icons">assignment_ind</i>Update Data</a>
                    </li>
                    <li><div class="divider"></div></li>
                    <li>
                        <a href="/pages/contact.html" class="waves-effect">
                        <i class="material-icons">exit_to_app</i>Logout</a>
                    </li>
                </ul> --}}
            </div>
            <img src="{{asset('assets/pwa/img/kta-top-white.png')}}" alt="" class="front"/>
            <img src="{{asset('assets/pwa/img/logo.png')}}" class="logo-profile"/>
        </div>
        <div class="container card-between">
            <div class="card card-round">
                <div class="card-content">
                    <div class="row">
                        <div class="col s3">
                            <img src="{{asset('storage/data_member/'.$data->id.'/'.$data->photo)}}" onerror="this.src='{{asset('assets/pwa/img/photo-default.png')}}'" alt="" class="profile-pict"/>
                        </div>
                        <div class="col s9">
                            <span>{{$data->no_member}}</span> <br>
                            <span class="profile-name">{{$data->name}}</span> <br>
                            <span>{{$data->SubDistrict['name']}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <span class="profile-name">Kartu Anggota</span>
            <div class="card card-kta card-round" style="background-image: url('{{asset('assets/pwa/img/kta-background.png')}}'); ">
                <div class="card-content">
                    <div class="row">
                        <div class="col s3">
                            
                        </div>
                        <div class="col s9">
                            <img class="img-right" src="{{asset('assets/pwa/img/logo-kta.png')}}"><br>
                            <span>{{$data->no_member}} </span> <br>
                            <span class="profile-name">{{$data->name}} </span> <br>
                            <span>{{$data->SubDistrict['name']}}</span> <br>
                            <span>
                                @if($data->status == "0")
                                    Belum Diverifikasi
                                @elseif($data->status == "1")
                                    Sudah Terverifikasi
                                @elseif($data->status == "2")
                                    Blocked
                                @endif
                            </span>
                            <img src="{{asset('storage/data_member/'.$data->id.'/'.$data->qrcode)}}" onerror="this.src='{{asset('assets/pwa/img/qrcode-default.png')}}'" alt="" class="img-left"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="center container">
        <a class="btn-small btn-register btn-large kosgoro-bg">
            Cetak Kartu Anggota
        </a>
    </div> --}}
@endsection

@push('page-javascript')
    <script>
        var id = "{{$data->id}}";
        $(document).ready(function(){
            $('.side-menu').sidenav();
        })
        @if($data->no_member == null){
            Swal.fire({
                title: "Important",
                text: "Silahkan Lengkapi Profile Anda Terlebih Dahulu",
                showCancelButton: false,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                allowOutsideClick: false,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/pwa/register/'+id;
                }
            });

        }
        @endif
    </script>
@endpush
