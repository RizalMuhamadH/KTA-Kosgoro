@extends('layouts.pwa')

@section('body')
<div class="container">
    <div class="top-head-button">
        <a href="#" class="waves-effect waves-light" onclick="window.history.back()"><i class="material-icons">arrow_back</i></a>
    </div>
    <h6 class="kosgoro-text text-darken-1"> <b>Daftar</b></h6>
    <form class="col s12" method="POST" id="form_add_member" action="{{route('members.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="laravel-input">
            <input type="hidden" name="api" value="true" readonly>
            <input type="hidden" name="id" value="{{$data->id}}" readonly>
            <input type="hidden" name="email" id="email" value="{{$data->email}}" readonly>
        </div>
        <div class="input-field ">
            <label for="nik">NIK</label>
            <input type="text" id="nik" name="nik" required class="validate" minlength="16" maxlength="16" />
        </div>
        <div class="input-field">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="name" id="nama_lengkap" required class="validate" />
        </div>
        <div class="input-field">
            <label for="telepon">Telepon</label>
            <input type="text" name="phone" id="telepon" required class="validate" minlength="10" maxlength="13" />
        </div>
        <div class="input-field">
            <label for="alamat">Alamat</label>
            <input type="text" name="address" id="alamat" required class="validate" />
        </div>
        <div class="input-field">
            <select id="province" name="province" class="province">
                <option value="" disabled selected>Pilih Provinsi Anda</option>
            </select>
        </div>
        <div class="input-field">
            <select id="district" name="district" class="district">
                <option value="" disabled selected>Pilih Kabupaten/Kota Anda</option>
            </select>
        </div>
        <div class="input-field">
            <select id="sub_district" name="sub_district" class="sub_district">
                <option value="" disabled selected>Pilih Kecamatan Anda</option>

            </select>
        </div>
        <div class="input-field">
            <select id="vilalge" name="village" class="village center">
                <option value="" selected>Pilih Desa Anda</option>
            </select>
        </div>
        <div class="input-field ">
            <label for="post_code">Kode Pos</label>
            <input type="text" name="post_code" id="post_code" class="validate" />
        </div>
        <div class="file-field input-field">
            <div class="btn">
              <span>Pas Photo</span>
              <input type="file" name="photo" accept="image/*" class="validate">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
        </div>
        <div class="file-field input-field">
            <div class="btn">
              <span>Photo KTP</span>
              <input type="file" name="id_card" accept="image/*" class="validate">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>

    </form>

    <div class="center">
        <a class="btn-small btn-register btn-large kosgoro-bg btn_save_profile">
            Simpan
        </a>
    </div>
</div>

@endsection

@push('page-javascript')
    <script>
        $(document).ready(function(){
            // $('select').formSelect();
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
                            var form = $("#form_add_member")[0];
                            var formData = new FormData(form);
                            $.ajax({
                                url: "{{env('APP_URL')}}/members/store",
                                method: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(res) {
                                    if(res.code == 500){
                                        Swal.fire("Error!", "Periksa Kembali Data Anda", 'error', 10);
                                    }else{
                                        Swal.fire("Done!", res.message, res.type, 10);
                                        window.location.href = '/pwa/profile/'+$("#email").val();
                                    }
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

            $(".province").on('change',function(){
                $(".district, .sub_district, .village").empty();
            });

            $(".district").on('change',function(){
                $(".sub_district, .village").empty();
            });

            $(".sub_district").on('change',function(){
                $(".village").empty();
            });

            $(".province").sm_select({
                show_placeholder:true,
                minimumInputLength: 1,
                placeholder: 'Masukan Keyword Province',
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

            $(".district").select2({
                show_placeholder:true,
                minimumInputLength: 1,
                placeholder: 'Masukan Keyword Kota / Kabupaten',
                ajax:{
                    url: "{{env('APP_URL')}}/complementary/getDistrict",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            province_id: $(".province").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".sub_district").select2({
                show_placeholder:true,
                minimumInputLength: 1,
                placeholder: 'Masukan Keyword Kecamatan',
                ajax:{
                    url: "{{env('APP_URL')}}/complementary/getSubDistrict",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            district_id: $(".district").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".village").select2({
                show_placeholder:true,
                minimumInputLength: 1,
                placeholder: 'Masukan Keyword Kelurahan / Desa',
                ajax:{
                    url: "{{env('APP_URL')}}/complementary/getVillage",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            sub_district_id: $(".sub_district").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })


        })
    </script>
@endpush
