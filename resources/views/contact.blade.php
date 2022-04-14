@extends('layouts.main')

@section('body')
    <main>
        <div class="container">
            <h5> Contact Us </h5>
            <span> Nomor Telepon :  (021) 72791957 </span> <br>
            <span> Email    :   admin@kosgoro.com </span> <br>
            <span> Alamat :  Gedung PPK Kosgoro 1957 Jl. Hanglekiu I No. 3, Kebayoran Baru, Jakarta Selatan,
                DKI Jakarta  
            </span><br>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2125828441226!2d106.79262061537004!3d-6.235685662801688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1408e6c4d71%3A0xdce23c3a08f54172!2sPPK%20KOSGORO%201957!5e0!3m2!1sen!2sid!4v1649925608836!5m2!1sen!2sid" width="auto" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
    </main>
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container orange-text">
                © {{date('Y')}}
            </div>
        </div>
    </footer>
@endsection