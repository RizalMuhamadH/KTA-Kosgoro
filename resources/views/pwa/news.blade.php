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
            <h5> Berita Terkini </h5>
            @foreach($news as $row)
                <a href="{{route('pwa.read_news',[
                    'category'  => $row->category['slug'],
                    'id'        => $row->id,
                    'slug'      => $row->slug
                ])}}">   
                    <div class="col s12">
                        <div class="card">
                            <div class="row">
                                <div class="col s5">
                                    <div class="card-image">
                                        <img src="https://app.kosgoro57.id/storage/article/{{$row->id}}/{{$row->thumbnail}}" style="height:10vh; display:block; width:100%; object-fit:cover" onerror="this.src='https://app.kosgoro57.id/assets/pwa/img/img_default.png'">
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
        {{$news->links('vendor.pagination.simple-default')}}
        {{-- <div class="footer-copyright">
            <div class="container">
              © {{date('Y')}}
            </div>
          </div> --}}
    </footer>
@endsection