@extends('adminbackend.layouts.master')


@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Duty Report</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- customar project  start -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-book f-30 text-c-purple"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Duty Report</h6>
                                    <h2 class="m-b-0">379</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-navigation-2 f-30 text-c-green"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Daily SITREP</h6>
                                    <h2 class="m-b-0">205</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-users f-30 text-c-red"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Incoming Mails</h6>
                                    <h2 class="m-b-0">5984</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-award f-30 text-c-blue"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Outgoing Mails</h6>
                                    <h2 class="m-b-0">325</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-body py-2 text-center">
                    <h4 id="current-date-time" style="color: #000000"></h4>
                </div>
            </div>


            <div class="card">
        <div class="card-body">
            <div class="row align-items-center m-l-0">
                <div class="dt-responsive table-responsive" id="id" style="margin-right: 1em">
                    <table id="personnelsTable" class="table-striped table">
                        <thead>
                            <tr>
                                <th>Service No</th>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Dept/Dte</th>
                                <th>Contact</th>
                                
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
        </div>





    </section>
@endsection
