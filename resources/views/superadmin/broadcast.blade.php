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
                                        <a href="index.html"><i class="feather icon-radio"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Broadcast</a></li>
                                </ul>

                                {{-- <a href="{{ route('superadmin.reports.addreport') }}"
                                    class="btn btn-sm btn-light mt-2 mt-md-0">
                                    + Add New Report
                                </a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            


        </div>





    </section>
@endsection
