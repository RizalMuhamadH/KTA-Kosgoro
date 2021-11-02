@extends('layouts.pwa')

@section('body')
    <div class="container">
        {{-- @if(session()->has('message'))
            <div class="card red darken-1">
                <div class="card-content white-text center">
                    <p>{{session()->get('message')}} </p>
                </div>
            </div>
        @endif --}}
        <h6 class="kosgoro-text text-darken-1 top-head"> <b>Masuk</b></h6>
        <span class="text-grey">
            Masuk menggunakan email terlebih dahulu
        </span>
        <div class="input-field col">
            <input placeholder="Email" id="email" type="email" class="validate">
        </div>

        <div class="center">
            <button class="btn bottom btn-small kosgoro-bg pwa_generate" type="button">
                Masuk
            </button>
        </div>
    </div>
@endsection

@push('page-javascript')
    <script>
        $(document).ready(function(){
            $(".pwa_generate").on('click',function(){
                email = $("#email").val();
                $.ajax({
                    url: "{{env('APP_URL')}}/generate_otp",
                    data: {
                        email: email,
                        phone_number: null,
                        api: true,
                        _token: "{{csrf_token()}}"
                    },
                    dataType: 'JSON',
                    method: 'POST',
                    success:function(data){
                        if(data.code == "400"){
                            Swal.fire("Error!", "Data Tidak Ditemukan", "error");
                        }else{
                            Swal.fire("Succes!",data.message,'success');
                            window.location.href = '/pwa/otp/'+email;
                        }
                    }
                })
            });
        })
    </script>
@endpush
