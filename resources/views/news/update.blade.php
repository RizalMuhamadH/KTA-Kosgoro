@extends('layouts.main')

@section('page_title')
    Update Article
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1> 
                Update Article
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
        <form method="POST" action="{{route('news.update')}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" required minlength="10" maxlength="40" value="{{old('title', $data->title)}}">
                                @error('title')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> Description </label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" required minlength="10" maxlength="140" value="{{old('description', $data->description)}}">
                                @error('description')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> Body </label>
                                <textarea class="summernote @error('body') is-invalid @enderror" name="body">  </textarea>
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
                                        <input type="text" class="form-control @error('source') is-invalid @enderror" name="source" required minlength="10" maxlength="40" value="{{old('source', $data->description)}}">
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
                                        <input type="url" class="form-control @error('source_link') is-invalid @enderror" name="source_link" required minlength="10" maxlength="40" value="{{old('source_link', $data->source_link)}}">
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
                                <label> Current Thumbnail </label>
                                <img src='{{asset("storage/article/$data->id/$data->thumbnail")}}' class="w-100">
                                <label> Thumbnail </label>
                                <div id="image-preview" class="image-preview w-100">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="thumbnail" accept="image/png, image/jpg, image/jpeg" id="image-upload" value='{{old("thumbnail")}}'>
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
                                        <option value="{{$category->id}}" @if($category->id == old('category',$data->category_id)) selected @endif> {{$category->name}} </option>
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
                                            <option value="0" @if(old('featured',$data->featured) == 1) selected @endif > No </option>
                                            <option value="1" @if(old('featured',$data->featured) == 2)  selected @endif> Yes </option>
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
                                        @php
                                            if($data->status == "Draft"){
                                                $status = 1;
                                            }else{
                                                $status = 2;
                                            }
                                        @endphp
                                        <select class="form-control @error('status') is-invalid @enderror" name="status">
                                            <option value="1" @if(old('status',$status) == 1) selected @endif> Draft </option>
                                            <option value="2" @if(old('status',$status) == 2) selected @endif> Published </option>
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
                                <input type="hidden" class="form-control" value="{{$data->id}}" name="id" readonly required>
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
        body_text = '{!! $data->body !!}';
        $(document).ready(function(){
            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false,                // Default: false
                success_callback: null          // Default: null
            });

            $(".summernote").summernote("code", body_text);
        })
    </script>
@endpush