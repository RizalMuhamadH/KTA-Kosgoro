<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; {{ config('app.name', 'Laravel') }} </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/stisla/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/stisla/css/components.css')}}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{asset('assets/logo/logo.png')}}"  alt="logo" width="120" class="shadow-light rounded-circle">
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4> {{ __('Login') }} </h4>
                                <div class="card-header-action">
                                    <button type="button" class="btn btn-danger btn_back after_clicked">
                                        <i class="fas fa-arrow-left"> </i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                @if(session()->has('message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <strong>{{session()->get('message')}} </strong>
                                </div>
                                @endif
                                <form method="POST" action="{{route('member_login')}}">
                                    @csrf
                                    <input type="hidden" name="cms" readonly value="true">
                                    <ul class="nav nav-pills before_clicked" id="myTab3" role="tablist">
                                        {{-- <li class="nav-item w-50 text-center">
                                          <a class="nav-link " id="phone_number-tab" data-toggle="tab" href="#phone_number" role="tab" aria-controls="phone_number" aria-selected="true">Phone Number</a>
                                        </li> --}}
                                        {{-- <li class="nav-item w-50 text-center">
                                          <a class="nav-link active show" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">Email</a>
                                        </li> --}}
                                    </ul>
                                    <div class="tab-content before_clicked" id="myTabContent2">
                                        <div class="tab-pane fade" id="phone_number" role="tabpanel" aria-labelledby="phone_number-tab">
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">+62</div>
                                                    </div>
                                                    <input id="phone_form" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autofocus>
                                                </div>

                                                @error('phone_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="tab-pane fade active show" id="email" role="tabpanel" aria-labelledby="email-tab">
                                            <div class="form-group">
                                                <label for="email">{{ __('E-Mail Address') }}</label>
                                                <input id="email_form" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group after_clicked">
                                        <label> OTP </label>
                                        <input type="text" id="otp" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-lg btn-block generate_otp">
                                            Generate OTP
                                        </button>
                                        <span class="text-danger text-sm timer after_clicked">Anda Bisa Mereset OTP Dalam Waktu <span class="text-danger text-sm" id="counter"> </span></span>
                                        <button type="submit" class="btn btn-success btn-lg btn-block after_clicked btn_login mt-2" tabindex="4">
                                            {{ __('Login') }}
                                        </button>

                                    </div>

                                </form>
                            </div>



                        </div>

                        <div class="simple-footer">
                            Copyright &copy; Kosgoro {{date("Y")}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{asset('assets/jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/stisla/js/stisla.js')}}"></script>

    <!-- Template JS File -->
    <script src="{{asset('assets/stisla/js/scripts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function(){
            $(".after_clicked").hide();


            $(".generate_otp").on('click',function(){
                reset_otp();
                email = $("#email_form").val();
                phone_number = $("#phone_form").val();
                $(".after_clicked").show('slow');
                $("#email_form").attr('readonly',true);
                $("#phone_form").attr('readonly',true);
                $("#otp").val('');
                $(".before_clicked").hide('slow');

                $.ajax({
                    url: "{{env('APP_URL')}}/generate_otp",
                    data: {
                        email: email,
                        phone_number: phone_number,
                        _token: "{{csrf_token()}}"
                    },
                    dataType: 'JSON',
                    method: 'POST',
                    success:function(data){
                        if(data.code == "400"){
                            Swal.fire("Error!", "Data Tidak Ditemukan", "error");
                        }
                    }
                })
            });


            $(".btn_back").on('click',function(){
                $(".after_clicked").hide('slow');
                $("#email_form, #phone_form").attr('readonly',false);
                $("#email_form, #phone_form, #otp").val('');
                $(".before_clicked").show('slow');
            })

            function reset_otp(){
                $(".btn_login").removeClass('mt-2');
                $(".btn_login").addClass('mt-5');
                $(".timer").show();
                $(".generate_otp").attr('disabled',true);
                var timeleft = 30;

                var downloadTimer = setInterval(function function1(){
                    $("#counter").html(timeleft);
                    timeleft -= 1;
                    if(timeleft <= 0){
                        clearInterval(downloadTimer);
                        $(".btn_login").removeClass('mt-5');
                        $(".btn_login").addClass('mt-2');
                        $(".timer").hide('slow');
                        $(".generate_otp").attr('disabled',false);
                    }
                }, 1000);

            }
        })
    </script>
</body>

