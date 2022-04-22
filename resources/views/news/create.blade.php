@extends('layouts.main')

@section('page_title')
    Create Article
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1> 
                
                Create Article
                
            </h1>
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
        <form method="POST" action="{{route('news.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" required minlength="10" maxlength="40" value="{{old('title')}}">
                                @error('title')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> Description </label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" required minlength="10" maxlength="140" value="{{old('description')}}">
                                @error('description')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> Body </label>
                                <textarea class="summernote @error('body') is-invalid @enderror" name="body"> {!! old('body') !!} </textarea>
                                @error('body')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label> Source </label>
                                        <input type="text" class="form-control @error('source') is-invalid @enderror" name="source" value="{{old('source')}}">
                                        @error('source')
                                            <div class="alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label> Source Link </label>
                                        <input type="url" class="form-control @error('source_link') is-invalid @enderror" name="source_link" value="{{old('source_link')}}">
                                        @error('source_link')
                                            <div class="alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label> Thumbnail </label>
                                <div id="image-preview" class="image-preview w-100">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="thumbnail" accept="image/png, image/jpg, image/jpeg" id="image-upload" value="{{old('thumbnail')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label> Category </label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category">
                                    <option value="" disabled selected> Choose Category </option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id == old('category')) selected @endif> {{$category->name}} </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label> Featured </label>
                                        <select class="form-control @error('featured') is-invalid @enderror" name="featured">
                                            <option value="0" @if(old('featured') == 1) selected @endif > No </option>
                                            <option value="1" @if(old('featured') == 2)  selected @endif> Yes </option>
                                        </select>
                                        @error('featured')
                                            <div class="alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label> Status </label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status">
                                            <option value="1" @if(old('status') == 1) selected @endif> Draft </option>
                                            <option value="2" @if(old('status') == 2) selected @endif> Published </option>
                                        </select>
                                        @error('status')
                                            <div class="alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> Author </label>
                                <input type="text" class="form-control" value="{{Auth::user()->name}}" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-right">
                <button type="submit" class="btn btn-success"> <i class="fas fa-save"> </i> Save </button>
            </div>
        </form>
    </section>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            var old_body = '{!! old("body") !!}';
            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false,                // Default: false
                success_callback: null          // Default: null
            });

            $(".summernote").summernote('code', old_body);
        })
    </script>
@endpush