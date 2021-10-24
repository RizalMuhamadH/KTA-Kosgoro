@extends('layouts.main')

@section('page_title')
    Manage Members
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1> Members</h1>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-danger">
                    Advanced Filtering Member
                </h4>
                <div class="card-header-action">
                    <a data-collapse="#filter-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="collapse" id="filter-collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Province </label>
                                <select class="form-control province">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kota / Kabupaten </label>
                                <select class="form-control district">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kecamatan </label>
                                <select class="form-control sub_district">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kelurahan / Desa </label>
                                <select class="form-control village">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Position Member </label>
                                <select class="form-control position">
                                    <option value="All" selected> All </option>
                                    @foreach ($positions as $position)
                                        <option value="{{$position->id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Status Member </label>
                                <select class="form-control status">
                                    <option value="All" selected> All </option>
                                    <option value="0"> Unverified </option>
                                    <option value="1"> Verified </option>
                                    <option value="2"> Blocked </option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-info">
                    List Member
                </h4>
                <div class="card-header-action">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#NewMember">New Member</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="table_member">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Anggota</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telephone</th>
                                <th>Province</th>
                                <th>Kota / Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan / Desa</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div id="NewMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">New Member</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('members.store')}}" action="POST" enctype="multipart/form-data" id="form_new_member">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Name </label>
                                    <input type="text" class="form-control" name="name" required id="name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Email </label>
                                    <input type="email" class="form-control" name="email" required id="email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Phone </label>
                                    <input type="text" class="form-control" minlength="10" maxlength="13" name="phone" required id="phone">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> NIK </label>
                                    <input type="text" class="form-control" minlength="16" maxlength="16" name="nik" required id="nik">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Province </label>
                                    <select class="form-control province_form" name="province">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kota / Kabupaten </label>
                                    <select class="form-control district_form" name="district">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kecamatan </label>
                                    <select class="form-control sub_district_form" name="sub_district">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kelurahan / Desa </label>
                                    <select class="form-control village_form" name="village">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <label> Post Code </label>
                                <input type="text" class="form-control" name="post_code" required>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Address </label>
                                    <textarea class="form-control" name="address"> </textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Position Member </label>
                                    <select class="form-control position" name="position">
                                        <option value="" disabled selected> Select Position </option>
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn_save"> <i class="fas fa-save"> </i> Save </button>
                </div>
            </div>
        </div>
    </div>

    <div id="DetailMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Detail Member</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> No Member </label>
                                <input type="text" class="form-control" readonly required id="no_member_detail">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Name </label>
                                <input type="text" class="form-control" readonly required id="name_detail">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Email </label>
                                <input type="email" class="form-control" readonly required id="email_detail">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Phone </label>
                                <input type="text" class="form-control" readonly required id="phone_detail">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> NIK </label>
                                <input type="text" class="form-control" readonly required id="nik_detail">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Province </label>
                                <input type="text" class="form-control" id="province_detail" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kota / Kabupaten </label>
                                <input type="text" class="form-control" id="district_detail" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kecamatan </label>
                                <input type="text" class="form-control" id="sub_district_detail" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Kelurahan / Desa </label>
                                <input type="text" class="form-control" id="village_detail" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label> Post Code </label>
                            <input type="text" class="form-control" readonly id="post_code_detail" required>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Address </label>
                                <textarea class="form-control" readonly id="address_detail"> </textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Position Member </label>
                                <input type="text" class="form-control" id="position_detail" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Photo </label>
                                <image src="" class="img-fluid" id="photo_detail">

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label> Photo KTP </label>
                                <image src="" class="img-fluid" id="id_card_detail">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="EditMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Edit Member</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('members.update')}}" action="POST" enctype="multipart/form-data" id="form_edit_member">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Name </label>
                                    <input type="text" class="form-control" name="name" required id="name_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Email </label>
                                    <input type="email" class="form-control" name="email" required id="email_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Phone </label>
                                    <input type="text" class="form-control" minlength="10" maxlength="13" name="phone" required id="phone_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> NIK </label>
                                    <input type="text" class="form-control" minlength="16" maxlength="16" name="nik" required id="nik_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Province </label>
                                    <select class="form-control province_edit" name="province">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kota / Kabupaten </label>
                                    <select class="form-control district_edit" name="district">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kecamatan </label>
                                    <select class="form-control sub_district_edit" name="sub_district">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Kelurahan / Desa </label>
                                    <select class="form-control village_edit" name="village">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <label> Post Code </label>
                                <input type="text" class="form-control" name="post_code" required id="post_code_edit">
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Address </label>
                                    <textarea class="form-control" name="address" id="address_edit"> </textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Position Member </label>
                                    <select class="form-control position" name="position" id="position_edit">
                                        <option value="" disabled selected> Select Position </option>
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Photo </label>
                                    <input type="file" class="form-control form-control-file" name="photo" accept="image/*" id="photo_edit">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label> Photo KTP </label>
                                    <input type="file" class="form-control form-control-file" name="id_card" accept="image/*" id="id_card_edit">
                                </div>
                            </div>
                            <div class="laravel-input">
                                <input type="hidden" name="id" id="member_id_edit">
                                <input type="hidden" name="_method" value="PUT">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn_save_edit"> <i class="fas fa-save"> </i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="VerifiedMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Verified Member</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('members.change_status')}}" action="POST" id="form_verified_member">
                        @csrf
                        <input type="hidden" name="id" id="verified_member_id">
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label> Custom Number Member? </label>
                            <select class="form-control" name="option" id="custom_no_member">
                                <option value="1"> Yes </option>
                                <option value="0" selected> No </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Current No Member </label>
                            <input type="text" class="form-control" id="current_no_member" name="no_member" required readonly>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn_save_verified"> <i class="fas fa-save"> </i> Verified </button>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('members.change_status') }}" method="POST" id="form_change_status" style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="change_status_id">
            <input type="hidden" name="status" id="status_change">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
        </div>
    </form>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            const auth_user = "{{Auth::user()->position_id}}";
            var generated_no_member = "{{date('Y.dm.')}}";
            var image_source = "{{asset('storage/data_member')}}";
            var table_member = $("#table_member").DataTable({
                destroy: true,
                dom: "Bfrtip",
                buttons: [
                    "colvis",
                    {
                        extend: "excel",
                        title: "Data Member",
                        autoFilter: true,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9]
                        }
                    }
                ],
                columnDefs: [{ orderable: false, targets: [0] }],
                order: [[1, "asc"]],
                processing: true,
                ajax: {
                    url: "{{route('members.datatables')}}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        province_id: function() {
                            return $(".province").val();
                        },
                        district_id: function() {
                            return $(".district").val();
                        },
                        sub_district_id: function() {
                            return $(".sub_district").val();
                        },
                        village_id: function() {
                            return $(".village").val();
                        },
                        position_id: function() {
                            return $(".position").val();
                        },
                        status: function() {
                            return $(".status").val();
                        }
                    }
                },
                columns: [
                    {
                        data: null,
                    },
                    { data: "no_member" },
                    { data: "name" },
                    { data: "email" },
                    { data: "phone" },
                    { data: "province.name" },
                    { data: "district.name" },
                    { data: "sub_district.name" },
                    { data: "village.name" },
                    { data:  'null',render:function(data,type,row){
                        if(row.status == "0"){
                            return "Unverified";
                        }else if(row.status == "1"){
                            return "Verified"
                        }else if(row.status == "2"){
                            return "Blocked"
                        }
                    }},
                    { data:  'null',render:function(data,type,row){
                        if(auth_user == "1"){
                            if(row.position_id != "1"){
                                button_return = "<div class='btn-group'>";
                                button_return = button_return + "<button class='btn btn-info btn_detail' title='Detail Member' data-id='"+row.id+"'> <i class='fas fa-eye'> </i> </button>";
                                button_return = button_return + "<button class='btn btn-warning btn_edit' title='Edit Member' data-id='"+row.id+"'> <i class='fas fa-pen'> </i> </button>";
                                if(row.status == "0"){
                                    button_return = button_return + "<button class='btn btn-success btn_verified' title='Verified Member' data-id='"+row.id+"'> <i class='fas fa-check'> </i> </button>";
                                    button_return = button_return + "<button class='btn btn-danger btn_block' title='Block Member' data-id='"+row.id+"'> <i class='fas fa-lock'> </i> </button>";
                                }else if(row.status == "1"){
                                    button_return = button_return + "<button class='btn btn-danger btn_block' title='Block Member' data-id='"+row.id+"'> <i class='fas fa-lock'> </i> </button>";
                                }else if(row.status == "2"){
                                    button_return = button_return + "<button class='btn btn-success btn_unblock' title='Unblock Member' data-id='"+row.id+"'> <i class='fas fa-lock-open'> </i> </button>";
                                }
                                button_return = button_return + "</div>";
                                return button_return;
                            }else{
                                return "Uneditable";
                            }
                        }else if(auth_user == "2"){
                            if(row.position_id != "3"){
                                button_return = "<div class='btn-group'>";
                                button_return = button_return + "<button class='btn btn-info btn_detail' title='Detail Member' data-id='"+row.id+"'> <i class='fas fa-eye'> </i> </button>";
                                button_return = button_return + "<button class='btn btn-warning btn_edit' title='Edit Member' data-id='"+row.id+"'> <i class='fas fa-pen'> </i> </button>";
                                if(row.status == "0"){
                                    button_return = button_return + "<button class='btn btn-success btn_verified' title='Verified Member' data-id='"+row.id+"'> <i class='fas fa-check'> </i> </button>";
                                    button_return = button_return + "<button class='btn btn-danger btn_block' title='Block Member' data-id='"+row.id+"'> <i class='fas fa-lock'> </i> </button>";
                                }else if(row.status == "1"){
                                    button_return = button_return + "<button class='btn btn-danger btn_block' title='Block Member' data-id='"+row.id+"'> <i class='fas fa-lock'> </i> </button>";
                                }else if(row.status == "2"){
                                    button_return = button_return + "<button class='btn btn-success btn_unblock' title='Unblock Member' data-id='"+row.id+"'> <i class='fas fa-lock-open'> </i> </button>";
                                }
                                button_return = button_return + "</div>";
                                return button_return;
                            }else{
                                return "Uneditable";
                            }

                        }
                    }}
                ]
            });

            table_member.on('order.dt search.dt', function() {
                table_member.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


            $(".province, .district, .sub_district, .village, .position, .status").on('change',function(){
                table_member.ajax.reload();
            });

            $(".province").select2({
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Province',
                ajax:{
                    url: "{{route('getProvince')}}",
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
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Kota / Kabupaten',
                ajax:{
                    url: "{{route('getDistrict')}}",
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
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Kecamatan',
                ajax:{
                    url: "{{route('getSubDistrict')}}",
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
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Kelurahan / Desa',
                ajax:{
                    url: "{{route('getVillage')}}",
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

            $(".province_form").select2({
                theme: 'bootstrap4',
                minimumInputLength: 1,
                allowClear: true,
                placeholder: 'Masukan Keyword Province',
                dropdownParent: $("#NewMember"),
                ajax:{
                    url: "{{route('getProvince')}}",
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

            $(".district_form").select2({
                theme: 'bootstrap4',
                minimumInputLength: 1,
                allowClear: true,
                placeholder: 'Masukan Keyword Kota / Kabupaten',
                dropdownParent: $("#NewMember"),
                ajax:{
                    url: "{{route('getDistrict')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            province_id: $(".province_form").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".sub_district_form").select2({
                minimumInputLength: 1,
                allowClear: true,
                theme: 'bootstrap4',
                placeholder: 'Masukan Keyword Kecamatan',
                dropdownParent: $("#NewMember"),
                ajax:{
                    url: "{{route('getSubDistrict')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            district_id: $(".district_form").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".village_form").select2({
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Kelurahan / Desa',
                dropdownParent: $("#NewMember"),
                ajax:{
                    url: "{{route('getVillage')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            sub_district_id: $(".sub_district_form").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".province_edit").select2({
                theme: 'bootstrap4',
                minimumInputLength: 1,
                allowClear: true,
                placeholder: 'Masukan Keyword Province',
                dropdownParent: $("#EditMember"),
                ajax:{
                    url: "{{route('getProvince')}}",
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

            $(".district_edit").select2({
                theme: 'bootstrap4',
                minimumInputLength: 1,
                allowClear: true,
                placeholder: 'Masukan Keyword Kota / Kabupaten',
                dropdownParent: $("#EditMember"),
                ajax:{
                    url: "{{route('getDistrict')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            province_id: $(".province_edit").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".sub_district_edit").select2({
                minimumInputLength: 1,
                allowClear: true,
                theme: 'bootstrap4',
                placeholder: 'Masukan Keyword Kecamatan',
                dropdownParent: $("#EditMember"),
                ajax:{
                    url: "{{route('getSubDistrict')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            district_id: $(".district_edit").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".village_edit").select2({
                minimumInputLength: 1,
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Masukan Keyword Kelurahan / Desa',
                dropdownParent: $("#EditMember"),
                ajax:{
                    url: "{{route('getVillage')}}",
                    dataType: 'json',
                    data: function(params){
                        return{
                            keywords: params.term,
                            cms: true,
                            sub_district_id: $(".sub_district_edit").val(),
                        }
                    },processResults:function(data){
                        return{
                            results:data
                        }
                    }
                }
            })

            $(".btn_save").on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Data akan ditambahkan.",
                        showCancelButton: 'true',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            var form = $("#form_new_member")[0];
                            var formData = new FormData(form);
                            $.ajax({
                                url: $("#form_new_member").attr('action'),
                                method: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(res) {
                                    Swal.fire("Done!", res.message, res.type, 10);
                                    $("#NewMember").modal('hide');
                                    $("#form_new_member")[0].reset();
                                    table_member.ajax.reload();
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

            $("#table_member").on('click','.btn_detail',function(){
                $.ajax({
                    url: "{{route('members.detail')}}",
                    dataType: 'JSON',
                    method: 'GET',
                    data: {id: $(this).data('id'), cms:true},
                    success:function(data){
                        dir_image = image_source;
                        dir_image = dir_image + "/"+data.id+"/";

                        $("#no_member_detail").val(data.no_member);
                        $("#name_detail").val(data.name);
                        $("#email_detail").val(data.email);
                        $("#phone_detail").val(data.phone);
                        $("#nik_detail").val(data.nik);
                        $("#province_detail").val(data.province.name);
                        $("#district_detail").val(data.district.name);
                        $("#sub_district_detail").val(data.sub_district.name);
                        $("#village_detail").val(data.village.name);
                        $("#post_code_detail").val(data.post_code);
                        $("#address_detail").text(data.address);
                        $("#position_detail").val(data.position.name);
                        $("#DetailMember").modal('show');
                        $("#photo_detail").attr('src',dir_image+data.photo);
                        $("#id_card_detail").attr('src',dir_image+data.id_card_photo);
                    }

                })
            })

            $("#table_member").on('click','.btn_edit',function(){
                $.ajax({
                    url: "{{route('members.detail')}}",
                    dataType: 'JSON',
                    method: 'GET',
                    data: {id: $(this).data('id'), cms:true},
                    success:function(data){
                        dir_image = image_source;
                        dir_image = dir_image + "/"+data.id+"/";

                        $("#no_member_edit").val(data.no_member);
                        $("#name_edit").val(data.name);
                        $("#email_edit").val(data.email);
                        $("#phone_edit").val(data.phone);
                        $("#nik_edit").val(data.nik);
                        $('.province_edit').append("<option value='"+data.province.id+"' selected>"+data.province.name+"</option");
                        $(".district_edit").append("<option value='"+data.district.id+"' selected>"+data.district.name+"</option");
                        $(".sub_district_edit").append("<option value='"+data.sub_district.id+"' selected>"+data.sub_district.name+"</option");
                        $(".village_edit").append("<option value='"+data.village.id+"' selected>"+data.village.name+"</option");
                        $(".district_edit, .sub_district_edit, .village_edit").attr('disabled',true);
                        $("#post_code_edit").val(data.post_code);
                        $("#address_edit").text(data.address);
                        $("#position_edit").val(data.position_id);
                        $("#member_id_edit").val(data.id);
                        $("#EditMember").modal('show');
                    }

                })
            })

            $(".province_edit").on('change',function(){
                $(".district_edit, .sub_district_edit, .village_edit").attr('disabled',false);
                $(".district_edit, .sub_district_edit, .village_edit").empty();
            });

            $(".btn_save_edit").on('click', function(e) {
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
                            $(".district_edit, .sub_district_edit, .village_edit").attr('disabled',false);
                            var form = $("#form_edit_member")[0];
                            var formData = new FormData(form);
                            $.ajax({
                                url: $("#form_edit_member").attr('action'),
                                method: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(res) {
                                    console.log(res);
                                    Swal.fire("Done!", res.message, res.type, 10);
                                    $("#EditMember").modal('hide');
                                    $("#form_edit_member")[0].reset();
                                    table_member.ajax.reload();
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


            $("#table_member").on('click','.btn_verified',function(){
                $.ajax({
                    url: "{{route('members.detail')}}",
                    dataType: 'JSON',
                    method: 'GET',
                    data: {id: $(this).data('id'), cms:true},
                    success:function(data){
                        generated_no_member = generated_no_member+data.id
                        $("#current_no_member").val(generated_no_member);
                        $("#verified_member_id").val(data.id);
                        $("#VerifiedMember").modal('show');
                    }

                })
            });

            $("#custom_no_member").on('change',function(){
                if($(this).val() == "1"){
                    $("#current_no_member").val('');
                    $("#current_no_member").attr('readonly',false);
                }else if($(this).val() == "0"){
                    $("#current_no_member").val(generated_no_member);
                    $("#current_no_member").attr('readonly',true);
                }
            })

            $(".btn_save_verified").on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda akan memverifikasi member ini.",
                        showCancelButton: 'true',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: $("#form_verified_member").attr('action'),
                                method: 'POST',
                                dataType: 'JSON',
                                data: $("#form_verified_member").serialize(),
                                success: function(res) {
                                    Swal.fire("Done!", res.message, res.type, 10);
                                    $("#VerifiedMember").modal('hide');
                                    table_member.ajax.reload();
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

            // $("#table_member").on('click', ".btn_verified", function() {
            //     $("#change_status_id").val($(this).data('id'));
            //     $("#status_change").val(1);
            //     Swal.fire({
            //             title: "Apakah anda yakin?",
            //             text: "Anda akan memverifikasi data",
            //             showCancelButton: 'true',
            //             icon: "warning",
            //             buttons: true,
            //             dangerMode: true,
            //             allowOutsideClick: false,
            //         })
            //         .then((result) => {
            //             if (result.isConfirmed) {
            //                 $.ajax({
            //                     url: $("#form_change_status").attr('action'),
            //                     method: 'POST',
            //                     dataType: 'json',
            //                     data: $("#form_change_status").serialize(),
            //                     success: function(result) {
            //                         if (result[0].code) {
            //                             Swal.fire("Done!", result[0].message, result[0]
            //                                 .type);
            //                         } else {
            //                             Swal.fire("Error!", result[0].message, result[0]
            //                                 .type);
            //                         }
            //                         table_member.ajax.reload();
            //                     }
            //                 });
            //             }
            //         });
            // })

            $("#table_member").on('click', ".btn_block", function() {
                $("#change_status_id").val($(this).data('id'));
                $("#status_change").val(2);
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda akan melakukan block pada member ini",
                        showCancelButton: 'true',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: $("#form_change_status").attr('action'),
                                method: 'POST',
                                dataType: 'json',
                                data: $("#form_change_status").serialize(),
                                success: function(res) {
                                    if (res.code) {
                                        Swal.fire("Done!", res.message, res
                                            .type);
                                    } else {
                                        Swal.fire("Error!", res.message, res
                                            .type);
                                    }
                                    table_member.ajax.reload();
                                }
                            });
                        }
                    });
            })
            ;
            $("#table_member").on('click', ".btn_unblock", function() {
                $("#change_status_id").val($(this).data('id'));
                $("#status_change").val(3);
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda akan melakukan unblock pada member ini",
                        showCancelButton: 'true',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: $("#form_change_status").attr('action'),
                                method: 'POST',
                                dataType: 'json',
                                data: $("#form_change_status").serialize(),
                                success: function(res) {
                                    if (res.code) {
                                        Swal.fire("Done!", res.message, res
                                            .type);
                                    } else {
                                        Swal.fire("Error!", res.message, res
                                            .type);
                                    }
                                    table_member.ajax.reload();
                                }
                            });
                        }
                    });
            })



        });
    </script>
@endpush
