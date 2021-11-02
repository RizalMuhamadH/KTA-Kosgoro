@extends('layouts.main')

@section('page_title')
    Dashboard
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-user-astronaut"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admin</h4>
                        </div>
                        <div class="card-body">
                            <span id="admin_count"> </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Verified Members</h4>
                        </div>
                        <div class="card-body">
                            <span id="verified_user_count"> </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Unverified Members</h4>
                        </div>
                        <div class="card-body">
                            <span id="unverified_user_count"> </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Blocked Members</h4>
                        </div>
                        <div class="card-body">
                            <span id="blocked_user_count"> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: "{{env('APP_URL')}}/complementary/getDashoardData",
                dataType: "JSON",
                method: "GET",
                success:function(data){
                    $("#admin_count").text(data.count_admin);
                    $("#verified_user_count").text(data.count_verified_user);
                    $("#unverified_user_count").text(data.count_unverified_user);
                    $("#blocked_user_count").text(data.count_blocked_user);
                }
            })
        })
    </script>
@endpush
