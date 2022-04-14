@extends('layouts.pwa')

@section('body')
    <header>
        <nav class="center">
            <div class="nav-wrapper">
              <div class="col s12">
                    <a href="{{route('pwa.index')}}" class="breadcrumb">Home</a>
                    <a href="{{route('pwa.events')}}" class="breadcrumb">Events</a>
              </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h5> Kegiatan Terkini </h5>
            @foreach($events as $row)
                <a href="{{route('pwa.read_event',[
                        'category'  => $row->category['slug'],
                        'id'        => $row->id,
                        'slug'      => $row->slug
                    ])}}"> 
                    <div class="col s12">
                        <div class="card">
                            <div class="row">
                                <div class="col s5">
                                    <div class="card-image">
                                        <img src="https://app.kosgoro57.id/storage/events/{{$row->id}}/{{$row->thumbnail}}" onerror="this.src='https://app.kosgoro57.id/assets/pwa/img/img_default.png'">
                                    </div>
                                </div>
                                <div class="col s7">
                                    <div class="card-content">
                                        <p>{{$row->title}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach 
        </div>
    </main>
    <footer class="main-footer">
        {{$events->links('vendor.pagination.simple-default')}}
        {{-- <div class="footer-copyright">
            <div class="container">
              © {{date('Y')}}
            </div>
        </div> --}}
    </footer>
@endsection