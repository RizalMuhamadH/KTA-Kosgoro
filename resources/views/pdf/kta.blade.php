    <style>
        .container {
            margin: 0 0;
            max-width: 1280px;
            width: 90%;
        }
        .card {
            position: relative;
            margin: 0.5rem 0 1rem 0;
            background-color: #fff;
            -webkit-transition: -webkit-box-shadow .25s;
            transition: -webkit-box-shadow .25s;
            transition: box-shadow .25s;
            transition: box-shadow .25s, -webkit-box-shadow .25s;
            border-radius: 2px;
        }
       
        .profile-name{
            color: #E4831A;
            font-size: 17px;
        }

        .card-round{
            border-radius: 10px;
        }

        .card-kta{
            position: relative;
            background-size: cover;
            background-position: center;
            height: auto;
            overflow: hidden;
        }

        .card .card-content {
            padding: 12px;
            border-radius: 0 0 2px 2px;
        }

        .row {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .row .col {
            float: left;
            -webkit-box-sizing: border-box;
                    box-sizing: border-box;
            padding: 0 0.75rem;
            min-height: 1px;
        }

        .row .col.s3 {
            width: 25%;
            margin-left: auto;
            left: auto;
            right: auto;
        }

        .row .col.s9 {
            width: 75%;
            margin-left: auto;
            left: auto;
            right: auto;
        }

        .card-kta .img-right{
            display: block;
            position: absolute;
            right: 26%;
        }
        .card-kta .img-left{
            display: block;
            position: absolute;
            right: 10%;
            margin-top:90px;
            bottom: 0px;
            width: 40px;
        }
        
        @page{
            margin: 0;
            overflow-y: hidden;
            overflow-x: hidden;
        }
    </style>
   <div class="card card-kta card-round" style="background-image: url('{{public_path('assets/pwa/img/kta-background.png')}}'); ">
    <div class="card-content">
        <div class="row">
            <div class="col s3">
                
            </div>
            <div class="col s9">
                <img class="img-right" src="{{public_path('assets/pwa/img/logo-kta.png')}}"><br>
                <span>{{$data->no_member}} </span> <br>
                <span class="profile-name">{{$data->name}} </span> <br>
                <span>{{$data->SubDistrict['name']}}</span> <br>
                <span>
                    @if($data->status == "0")
                        Belum Diverifikasi
                    @elseif($data->status == "1")
                        Sudah Terverifikasi
                    @elseif($data->status == "2")
                        Blocked
                    @endif
                </span>
                <img src="{{public_path('assets/pwa/img/qrcode-default.png')}}" 
                    onerror="this.src='{{public_path('assets/pwa/img/qrcode-default.png')}}'" 
                    alt="" 
                    class="img-left"/>
            </div>
        </div>
    </div>
</div>


