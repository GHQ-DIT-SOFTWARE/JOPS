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
                <!--marquee-->
                    <div class="card" style="width: 100%;">
                        <div class="card-body py-2">
                            <marquee behavior="scroll" direction="left" scrollamount="5" class="text-deep-brown">
                                <b> Breaking: New policy update released. •
                                    Reminder: Submit duty reports by end of day. •
                                    Incoming mails processed successfully. •
                                    Outgoing mails dispatch scheduled for tomorrow.</b>
                            </marquee>
                        </div>
                    </div>

            </div>
            <div class="row">
                <!-- Cards -->
                <div class="col-xl-3 col-md-6">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <!-- <i class="icon feather icon-book f-30 text-c-purple"></i> -->
                                    <img src="{{ asset('assets/images/vector 1.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Duty Report</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                   <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <!-- <i class="icon feather icon-navigation-2 f-30 text-c-green"></i> -->
                                    <img src="{{ asset('assets/images/vector 5.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Daily SITREP</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <!-- <i class="icon feather icon-users f-30 text-c-red"></i> -->
                                    <img src="{{ asset('assets/images/vector 3.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Incoming Mails</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <!-- <i class="icon feather icon-award f-30 text-c-blue"></i> -->
                                    <img src="{{ asset('assets/images/vector 4.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Outgoing Mails</h6>

                                </div>
                            </div>
                        </div>
                    </div>
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
