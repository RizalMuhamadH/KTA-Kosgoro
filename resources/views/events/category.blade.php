@extends('layouts.main')

@section('page_title')
    Manage Category Event
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1> Category Event</h1>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-info">
                    List Category Event
                </h4>
                <div class="card-header-action">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#NewCategory">New Category</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100 text-center" id="table_category">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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

    <div id="NewCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">New Category</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('category-events.store')}}" action="POST" id="form_new_category">
                        @csrf 
                        <div class="form-group">
                            <label> Name </label>
                            <input type="text" class="form-control" name="name" required id="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn_save"> <i class="fas fa-save"> </i> Save </button>
                </div>
            </div>
        </div>
    </div>

    <div id="EditCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Edit Category</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('category-events.update')}}" action="POST" enctype="multipart/form-data" id="form_edit_category">
                        @csrf
                        <div class="form-group">
                            <label> Name </label>
                            <input type="text" class="form-control" name="name" required id="name_edit">
                        </div>      
                        <div class="laravel-input">
                            <input type="hidden" name="id" id="events_category_id_edit">
                            <input type="hidden" name="_method" value="PUT">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn_save_edit"> <i class="fas fa-save"> </i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('category-events.delete') }}" method="POST" id="form_delete_category"
        style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="id_category_delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        </div>
    </form>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            var table_category = $("#table_category").DataTable({
                destroy: true,
                processing: true,
                ajax: {
                    url: "{{env('APP_URL')}}/category-events/datatables",
                    method: "GET",
                    dataType: "JSON",
                },
                columns: [
                    {data: null},
                    { data: "name" },
                    { data:  'null',render:function(data,type,row){
                        button_return = "<div class='btn-group'>";
                        button_return = button_return + "<button class='btn btn-info btn_edit' title='Edit Category' data-id='"+row.id+"'> <i class='fas fa-pen'> </i> </button>";
                        button_return = button_return + "<button class='btn btn-danger btn_delete' title='Delete Category' data-id='"+row.id+"'> <i class='fas fa-trash text-dark'> </i> </button>";
                        return button_return;
                    }}
                ]
            });

            table_category.on('order.dt search.dt', function() {
                table_category.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


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
                            $.ajax({
                                url: $("#form_new_category").attr('action'),
                                method: 'POST',
                                dataType: 'JSON',
                                data: $("#form_new_category").serialize(),
                                success: function(res) {
                                    Swal.fire("Done!", res[0].message, res[0].type, 10);
                                    $("#NewCategory").modal('hide');
                                    $("#form_new_category")[0].reset();
                                    table_category.ajax.reload();
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


            $("#table_category").on('click','.btn_edit',function(){
                $.ajax({
                    url: "{{env('APP_URL')}}/category-events/detail/"+$(this).data('id'),
                    dataType: 'JSON',
                    method: 'GET',
                    success:function(data){
                        $("#name_edit").val(data.name);
                        $("#events_category_id_edit").val(data.id);
                        $("#EditCategory").modal('show');
                    }

                })
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
                            $.ajax({
                                url: "{{env('APP_URL')}}/category-events/update",
                                method: 'POST',
                                dataType: 'JSON',
                                data: $("#form_edit_category").serialize(),
                                success: function(res) {
                                    console.log(res);
                                    Swal.fire("Done!", res[0].message, res[0].type, 10);
                                    $("#EditCategory").modal('hide');
                                    $("#form_edit_category")[0].reset();
                                    table_category.ajax.reload();
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

            $("#table_category").on('click', ".btn_delete", function() {
                $("#id_category_delete").val($(this).data('id'));
                form_url = "{{env('APP_URL')}}/category-events/delete";
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Data yang sudah dihapus, tidak bisa dikembalikan",
                        showCancelButton: 'true',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form_url,
                                method: 'POST',
                                dataType: 'json',
                                data: $("#form_delete_category").serialize(),
                                success: function(result) {
                                    if (result[0].code) {
                                        Swal.fire("Done!", result[0].message, result[0]
                                            .type);
                                    } else {
                                        Swal.fire("Error!", result[0].message, result[0]
                                            .type);
                                    }
                                    table_category.ajax.reload();
                                }
                            });
                        }
                        
                    });
            })



        });
    </script>
@endpush