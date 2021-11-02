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
                            <a href="#" class="dropdown-item has-icon btn_change_profile">
                                <i class="far fa-user"></i> Profile
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
                        <a href="index.html">Kosgoro</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">KG</a>
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

            <div id="ModalProfile" hidden class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="my-modal-title">Edit Profile</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('members.update')}}" action="POST" enctype="multipart/form-data" id="form_update_profile">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Name </label>
                                            <input type="text" class="form-control" name="name" required value="{{Auth::user()->name}}" onkeypress="return hanyaHuruf(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="email" class="form-control" name="email" required value="{{Auth::user()->email}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Phone </label>
                                            <input type="text" class="form-control" minlength="10" maxlength="13" name="phone" required value="{{Auth::user()->phone}}" onkeypress="return hanyaAngka(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> NIK </label>
                                            <input type="text" class="form-control" minlength="16" maxlength="16" name="nik" required value="{{Auth::user()->nik}}" onkeypress="return hanyaAngka(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Province </label>
                                            <select class="form-control province_profile" name="province">
                                                <option value="{{Auth::user()->province_id}}" selected> {{Auth::user()->Province['name']}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Kota / Kabupaten </label>
                                            <select class="form-control district_profile" name="district">
                                                <option value="{{Auth::user()->district_id}}" selected> {{Auth::user()->District['name']}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Kecamatan </label>
                                            <select class="form-control sub_district_profile" name="sub_district">
                                                <option value="{{Auth::user()->sub_district_id}}" selected> {{Auth::user()->SubDistrict['name']}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Kelurahan / Desa </label>
                                            <select class="form-control village_profile" name="village">
                                                <option value="{{Auth::user()->village_id}}"> {{Auth::user()->Village['name']}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label> Post Code </label>
                                        <input type="text" class="form-control" name="post_code" required  value="{{Auth::user()->post_code}}" onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Address </label>
                                            <textarea class="form-control" name="address"> {{Auth::user()->address}} </textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Position Member </label>
                                            <select class="form-control position" name="position" id="position_edit">
                                                <option value="" disabled selected> Select Position </option>
                                                @foreach ($positions as $position)
                                                    <option value="{{$position->id}}" @if(Auth::user()->position_id == $position->id) selected @endif>{{$position->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Photo </label>
                                            <input type="file" class="form-control form-control-file" name="photo" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label> Photo KTP </label>
                                            <input type="file" class="form-control form-control-file" name="id_card" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="laravel-input">
                                        <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="_method" value="PUT">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success btn_save_profile"> <i class="fas fa-save"> </i> Save</button>
                        </div>
                    </div>
                </div>
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
            $(document).ready(function(){
                $(".btn_change_profile").on('click',function(){
                    $("#ModalProfile").attr('hidden',false);
                    $("#ModalProfile").modal('show');
                });

                $(".province_profile").select2({
                    theme: 'bootstrap4',
                    minimumInputLength: 1,
                    allowClear: true,
                    placeholder: 'Masukan Keyword Province',
                    dropdownParent: $("#ModalProfile"),
                    ajax:{
                        url: "{{env('APP_URL')}}/complementary/getProvince",
                        dataType: 'json',
                        data: function(params){
                            return{
                                keywords: params.term,
                                cms: true,
                            }
                        },processResults:function(data){
                            return{
                                results:data
                            }
                        }
                    }
                });

                $(".district_profile").select2({
                    theme: 'bootstrap4',
                    minimumInputLength: 1,
                    allowClear: true,
                    placeholder: 'Masukan Keyword Kota / Kabupaten',
                    dropdownParent: $("#ModalProfile"),
                    ajax:{
                        url: "{{env('APP_URL')}}/complementary/getDistrict",
                        dataType: 'json',
                        data: function(params){
                            return{
                                keywords: params.term,
                                cms: true,
                                province_id: $(".province_profile").val(),
                            }
                        },processResults:function(data){
                            return{
                                results:data
                            }
                        }
                    }
                })

                $(".sub_district_profile").select2({
                    minimumInputLength: 1,
                    allowClear: true,
                    theme: 'bootstrap4',
                    placeholder: 'Masukan Keyword Kecamatan',
                    dropdownParent: $("#ModalProfile"),
                    ajax:{
                        url: "{{env('APP_URL')}}/complementary/getSubDistrict",
                        dataType: 'json',
                        data: function(params){
                            return{
                                keywords: params.term,
                                cms: true,
                                district_id: $(".district_profile").val(),
                            }
                        },processResults:function(data){
                            return{
                                results:data
                            }
                        }
                    }
                })

                $(".village_profile").select2({
                    minimumInputLength: 1,
                    theme: 'bootstrap4',
                    allowClear: true,
                    placeholder: 'Masukan Keyword Kelurahan / Desa',
                    dropdownParent: $("#ModalProfile"),
                    ajax:{
                        url: "{{env('APP_URL')}}/complementary/getVillage",
                        dataType: 'json',
                        data: function(params){
                            return{
                                keywords: params.term,
                                cms: true,
                                sub_district_id: $(".sub_district_profile").val(),
                            }
                        },processResults:function(data){
                            return{
                                results:data
                            }
                        }
                    }
                })

                $(".province_profile").on('change',function(){
                    $(".district_profile, .sub_district_profile, .village_profile").attr('disabled',false);
                    $(".district_profile, .sub_district_profile, .village_profile").empty();
                });

                $(".btn_save_profile").on('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                            title: "Apakah anda yakin?",
                            text: "Data akan diupdate.",
                            showCancelButton: 'true',
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                            allowOutsideClick: false,
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $(".district_profile, .sub_district_profile, .village_profile").attr('disabled',false);
                                var form = $("#form_update_profile")[0];
                                var formData = new FormData(form);
                                $.ajax({
                                    url: "{{env('APP_URL')}}/members/update",
                                    method: 'POST',
                                    dataType: 'JSON',
                                    processData: false,
                                    contentType: false,
                                    data: formData,
                                    success: function(res) {
                                        console.log(res);
                                        Swal.fire("Done!", res.message, res.type, 10);
                                        $("#ModalProfile").attr('hidden','true');
                                        $("#ModalProfile").modal('hide');
                                        location.reload();
                                    },
                                    error: function(result) {
                                        var response = JSON.parse(result.responseText)
                                        var message = '';
                                        $.each(response.errors, function(key, values) {
                                            $.each(values, function(key, value) {
                                                message = message + value +
                                                    "<br>";
                                            })
                                        })
                                        Swal.fire("Error!", message, 'error', 10);
                                    }
                                })
                            }
                        })
                });
            })





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
