@extends('layouts.main')

@section('page_title')
    Event
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1> Event </h1>
        </div>
        @if(session('message'))
            <script>
                Swal.fire({
                    title: "Information",
                    text: {{session('message')}},
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                    allowOutsideClick: false,
                });
            </script>
        @endif
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-info">
                    List Event
                </h4>
                <form class="card-header-form mr-2">
                    <select class="form-control form-control-sm category" name="category">
                        <option value="All" selected> All Category </option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->name}} </option>
                        @endforeach
                    </select>
                </form>
                <div class="card-header-action">
                    <a class="btn btn-success" type="button" href="{{route('events.create')}}"> <i class="fas fa-pen-alt"> </i> New Event</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table_event w-100">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Title </th>
                            <th> Category </th>
                            <th> Start Date </th>
                            <th> End Date </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <form action="{{ route('events.delete') }}" method="POST" id="form_delete_event"
        style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="id_event_delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        </div>
    </form>

    <form action="{{ route('events.recover') }}" method="POST" id="form_recover_event"
        style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="id_event_recover">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
        </div>
    </form>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            var table_event = $(".table_event").DataTable({
                destroy: true,
                processing: true,
                ajax: {
                    url: "{{env('APP_URL')}}/events/datatables",
                    method: "GET",
                    dataType: "JSON",
                    data:{
                        category:function(){
                            return $(".category").val();
                        }
                    }
                },
                columns: [
                    {data: null},
                    { data: "title" },
                    { data: "category.name"},
                    { data: "start_date"},
                    { data: "end_date"},
                    { data:  'null',render:function(data,type,row){
                        button_return = "<div class='btn-group'>";
                        button_return = button_return + "<button class='btn btn-info btn_edit' title='Edit Event' data-id='"+row.id+"'> <i class='fas fa-pen'> </i> </button>";
                        button_return = button_return + "<button class='btn btn-danger btn_delete' title='Delete Event' data-id='"+row.id+"'> <i class='fas fa-trash text-dark'> </i> </button>";
                        return button_return;
                    }}
                ]
            });

            table_event.on('order.dt search.dt', function() {
                table_event.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $(".category").change(function(){
                table_event.ajax.reload();
            })

            $(".table_event").on('click','.btn_edit',function(){
                window.location.href = "{{env('APP_URL')}}/events/detail/"+$(this).data('id');
            });

            $(".table_event").on('click', ".btn_delete", function() {
                $("#id_event_delete").val($(this).data('id'));
                form_url = "{{env('APP_URL')}}/events/delete";
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
                                data: $("#form_delete_event").serialize(),
                                success: function(result) {
                                    if (result[0].code) {
                                        Swal.fire("Done!", result[0].message, result[0]
                                            .type);
                                    } else {
                                        Swal.fire("Error!", result[0].message, result[0]
                                            .type);
                                    }
                                    table_event.ajax.reload();
                                }
                            });
                        }
                        
                    });
            })

            $(".table_event").on('click', ".btn_recover", function() {
                $("#id_event_recover").val($(this).data('id'));
                form_url = "{{env('APP_URL')}}/events/recover";
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Data akan dikembalikan",
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
                                data: $("#form_recover_event").serialize(),
                                success: function(result) {
                                    if (result[0].code) {
                                        Swal.fire("Done!", result[0].message, result[0]
                                            .type);
                                    } else {
                                        Swal.fire("Error!", result[0].message, result[0]
                                            .type);
                                    }
                                    table_event.ajax.reload();
                                }
                            });
                        }
                        
                    });
            })
        })
    </script>
@endpush