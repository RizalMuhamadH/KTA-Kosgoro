@extends('layouts.pwa')

@section('body')
    <div class="row">
        <div class="top" style="background-image: url('https://app.kosgoro57.id/assets/pwa/img/kta-top-orange.png'); background-size:cover; background-repeat:no-repeat">

            <div class="container">
                <a class="left white-text menu " href="{{route('pwa.update',['id'    => $data->id])}}">
                    <i class="material-icons sidenav-trigger">assignment_ind</i></a>
                </a>
                <span class="right white-text menu" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="material-icons sidenav-trigger">exit_to_app</i></a>
                    <form id="logout-form" action="{{ route('pwa.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </span>
            </div>
            <img src="https://app.kosgoro57.id/assets/pwa/img/kta-top-white.png" alt="" class="front"/>
            <img src="https://app.kosgoro57.id/assets/pwa/img/logo.png" class="logo-profile"/>
        </div>
        <div class="container card-between">
            <div class="card card-round">
                <div class="card-content">
                    <div class="row">
                        <div class="col s3">
                            <img src="https://app.kosgoro57.id/storage/data_member/{{$data->id}}/{{$data->photo}}" alt="" class="profile-pict"/>
                        </div>
                        <div class="col s9">
                            <span>{{$data->no_member}}</span> <br>
                            <span class="profile-name">{{$data->name}}</span> <br>
                            <span>{{$data->Province['name']}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <span class="profile-name">Kartu Anggota</span>
            <div class="card card-kta card-round" style="background-image: url('https://app.kosgoro57.id/assets/pwa/img/kta-bg.png'); background-size:contain; background-repeat:no-repeat; background-position:left">
                <div class="card-content" >
                    <div class="row">
                        <div class="col s9 offset-s3 offset-m1 offset-l1">
                            <img class="img-right" src="https://app.kosgoro57.id/assets/pwa/img/logo-kta.png"><br>
                            <span>{{$data->no_member}} </span> <br>
                            <span class="profile-name">{{$data->name}} </span> <br>
                            <span>{{$data->Province['name']}} </span> <br>
                            <span>
                                @if($data->status == "0")
                                    Belum Diverifikasi
                                @elseif($data->status == "1")
                                    Sudah Terverifikasi
                                @elseif($data->status == "2")
                                    Blocked
                                @endif
                            </span>
                            <img src="https://app.kosgoro57.id/storage/data_member/{{$data->id}}/{{$data->qrcode}}"  alt="" class="img-left"  onerror="this.src='https://app.kasgoro57.id/assets/pwa/img/qrcode-default.png'"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="center container">
        <a class="btn-small btn-register btn-large kosgoro-bg btn-print" href="{{route('pwa.download_kta',['id' => $data->id])}}">
            Cetak Kartu Anggota
        </a>
    </div>
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

        $(".btn-profile").on('click',function(){

        })
    </script>
@endpush
