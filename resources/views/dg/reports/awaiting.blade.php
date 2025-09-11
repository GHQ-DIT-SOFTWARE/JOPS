@extends('adminbackend.layouts.master')


@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">DG Reports</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Awaiting Approval</a></li>
                                </ul>

                                <!--marquee-->
                                <div class="card" style="width: 100%;">
                                    <div class="card-body py-2">
                                        <marquee behavior="scroll" direction="left" scrollamount="5"
                                            class="text-deep-brown">
                                            <b> Breaking: New policy update released. •
                                                Reminder: Submit duty reports by end of day. •
                                                Incoming mails processed successfully. •
                                                Outgoing mails dispatch scheduled for tomorrow.</b>
                                        </marquee>
                                    </div>
                                </div>



                                {{-- <a href="{{ route('superadmin.reports.addreport') }}"
                                    class="btn btn-sm btn-light mt-2 mt-md-0">
                                    + Add New Report
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Cards -->
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 1.png') }}" width="75" height="75"
                                        alt="">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Pending Reports</h6>
                                    <h4>{{ $pendingCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 5.png') }}" width="75" height="75"
                                        alt="">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Awaiting Approval</h6>
                                    <h4>{{ $awaitingApprovalCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 3.png') }}" width="75" height="75"
                                        alt="">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Approved Reports</h6>
                                    <h4>{{ $approvedCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <!-- Left And Right Fixed Columns start -->
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1>Reports Awaiting DG Approval</h1>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="left-right-fix" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Reported By</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $report)
                                            <tr>
                                                <td>{{ $report->id }}</td>
                                                <td>{{ $report->user->fname ?? 'N/A' }}</td>
                                                <td>{{ $report->status }}</td>
                                                <td>
                                                    <a href="{{ route('dg.reports.view', $report->id) }}"
                                                        class="btn btn-primary btn-sm">Review</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Left And Right Fixed end -->
            </div>



        </div>





    </section>
@endsection
