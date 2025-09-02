@extends('adminbackend.layouts.master')


@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Duty Officer</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Duty Report</a></li>
                                </ul>

                                <a href="{{ route('superadmin.add.report') }}" class="btn btn-sm btn-light mt-2 mt-md-0">
                                    + Add New Report
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-body py-2">
                    <div class="news-ticker-wrapper" style="overflow:hidden; white-space: nowrap;">
                        <div id="news-ticker" style="display: inline-block; padding-left: 100%; will-change: transform;">
                            <!-- News items will go here -->
                        </div>
                    </div>
                </div>
            </div> --}}




            <div class="row">
                <div class="col-md-12 col-lg-4">
                       <div class="card glass-card">
                        <div class="card-body text-center">
                            <i class="feather icon-mail text-c-green d-block f-40"></i>
                            <h4 class="m-t-20">Verified Reports</h4>
                            <!--<p class="m-b-20">Your main list is growing</p>-->
                            <span
                                style="
    display: inline-block;
    background-color: #42a116;
    color: white;
    width: 60px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    font-size: 20px;
    font-weight: bold;
    border-radius: 10px;
">
                                2
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                      <div class="card glass-card">
                        <div class="card-body text-center">
                            <i class="feather icon-twitter text-c-green d-block f-40"></i>
                            <h4 class="m-t-20">Pending Reports</h4>
                            <!--<p class="m-b-20">Your main list is growing</p>-->
                            <span
                                style="
    display: inline-block;
    background-color: #daae2b;
    color: white;
    width: 60px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    font-size: 20px;
    font-weight: bold;
    border-radius: 10px;
">
                                2
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card glass-card">
                        <div class="card-body text-center">
                            <i class="feather icon-briefcase text-c-red d-block f-40"></i>
                            <h4 class="m-t-20">Declined Reports</h4>
                            <!--<p class="m-b-20">This is your current active plan</p>-->
                            <span
                                style="
    display: inline-block;
    background-color: #eb0b0b;
    color: white;
    width: 60px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    font-size: 20px;
    font-weight: bold;
    border-radius: 10px;
">
                                2
                            </span>

                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <!-- Left And Right Fixed Columns start -->
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Duty Report</h5>
                        </div>
                        <div class="card-body">
                            <table id="left-right-fix" class="table stripe row-border order-column">
                                <thead>
                                    <tr>
                                        <th>Service No</th>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Dept/Dte</th>
                                        <th>Reporting Time</th>
                                        <th>Closing Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger</td>
                                        <td>Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>61</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Left And Right Fixed end -->
            </div>



        </div>





    </section>
@endsection
