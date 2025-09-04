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

                                <a href="{{ route('superadmin.reports.addreport') }}"
                                    class="btn btn-sm btn-light mt-2 mt-md-0">
                                    + Add New Report
                                </a>
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
                            <h1>Pending Reports</h1>
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
                                                    <a href="{{ route('dland.reports.view', $report->id) }}"
                                                        class="btn btn-primary btn-sm">View</a>
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
