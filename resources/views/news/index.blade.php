@extends('layouts.main')

@section('page_title')
    @php
        $status = ["","Draft","Published","Deleted"]
    @endphp
    {{$status[$type]}} Article
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>{{$status[$type]}} Articles </h1>
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
                    List {{$status[$type]}} Article
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
                    <a class="btn btn-success" type="button" href="{{route('news.create-update',['type' => 1])}}"> <i class="fas fa-pen-alt"> </i> New Article</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table_article w-100">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Title </th>
                            <th> Rubrik </th>
                            <th> Author </th>
                            <th> Published At </th>
                            <th> Updated At </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <form action="{{ route('news.delete') }}" method="POST" id="form_delete_news"
        style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="id_news_delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        </div>
    </form>

    <form action="{{ route('news.recover') }}" method="POST" id="form_recover_news"
        style="display: none">
        @csrf
        <div class="laravel_input">
            <input type="hidden" name="id" id="id_news_recover">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
        </div>
    </form>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            const type_article = "{{$type}}";
            var table_article = $(".table_article").DataTable({
                destroy: true,
                processing: true,
                ajax: {
                    url: "{{env('APP_URL')}}/news/datatables",
                    method: "GET",
                    dataType: "JSON",
                    data:{
                        status : type_article,
                        category:function(){
                            return $(".category").val();
                        }
                    }
                },
                columns: [
                    {data: null},
                    { data: "title" },
                    { data: "category.name"},
                    { data: "author.name"},
                    { data: "created_at"},
                    { data: "updated_at"},
                    { data:  'null',render:function(data,type,row){
                        if(type_article != 3){
                            button_return = "<div class='btn-group'>";
                            button_return = button_return + "<button class='btn btn-info btn_edit' title='Edit News' data-id='"+row.id+"'> <i class='fas fa-pen'> </i> </button>";
                            button_return = button_return + "<button class='btn btn-danger btn_delete' title='Delete News' data-id='"+row.id+"'> <i class='fas fa-trash text-dark'> </i> </button>";
                            return button_return;
                        }else{
                            button_return = "<div class='btn-group'>";
                            button_return = button_return + "<button class='btn btn-info btn_recover' title='Recover News' data-id='"+row.id+"'> <i class='fas fa-redo text-dark'> </i> </button>";
                            return button_return;
                        }
                    }}
                ]
            });

            table_article.on('order.dt search.dt', function() {
                table_article.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $(".category").change(function(){
                table_article.ajax.reload();
            })

            $(".table_article").on('click','.btn_edit',function(){
                window.location.href = "{{env('APP_URL')}}/news/detail/"+$(this).data('id');
            });

            $(".table_article").on('click', ".btn_delete", function() {
                $("#id_news_delete").val($(this).data('id'));
                form_url = "{{env('APP_URL')}}/news/delete";
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
                                data: $("#form_delete_news").serialize(),
                                success: function(result) {
                                    if (result[0].code) {
                                        Swal.fire("Done!", result[0].message, result[0]
                                            .type);
                                    } else {
                                        Swal.fire("Error!", result[0].message, result[0]
                                            .type);
                                    }
                                    table_article.ajax.reload();
                                }
                            });
                        }
                        
                    });
            })

            $(".table_article").on('click', ".btn_recover", function() {
                $("#id_news_recover").val($(this).data('id'));
                form_url = "{{env('APP_URL')}}/news/recover";
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Data akan dikembalikan sebagai Draft",
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
                                data: $("#form_recover_news").serialize(),
                                success: function(result) {
                                    if (result[0].code) {
                                        Swal.fire("Done!", result[0].message, result[0]
                                            .type);
                                    } else {
                                        Swal.fire("Error!", result[0].message, result[0]
                                            .type);
                                    }
                                    table_article.ajax.reload();
                                }
                            });
                        }
                        
                    });
            })
        })
    </script>
@endpush