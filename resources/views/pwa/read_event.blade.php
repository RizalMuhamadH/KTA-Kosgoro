@extends('layouts.pwa')

@section('body')
    <header>
        <nav class="center">
            <div class="nav-wrapper">
              <div class="col s12">
                    <a href="{{route('pwa.index')}}" class="breadcrumb">Home</a>
                    <a href="{{route('pwa.news')}}" class="breadcrumb">News</a>
              </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h5 class="center"> {{$event->title }} </h5>
            <img src="https://app.kosgoro57.id/storage/article/{{$event->id}}/{{$event->thumbnail}}" onerror="this.src='https://app.kosgoro57.id/assets/pwa/img/img_default.png'" class="img-article">
            <article>{!! $event->body !!}}</article>
        </div>
    </main>
    {{-- <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
              © {{date('Y')}}
            </div>
        </div>
    </footer> --}}
@endsection