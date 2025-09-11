@extends('adminbackend.layouts.master')

@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Form Wizard</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Form Components</a></li>
                                <li class="breadcrumb-item"><a href="#!">Form Wizard</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">

                    <div class="tab-content" id="myTabContent">
                        <!-- Main content -->
                        <div class="tab-pane fade show active" id="user1" role="tabpanel" aria-labelledby="user1-tab">
                            <div class="row mb-n4">
                                <div class="col-xl-12 col-md-12">
                                    <div class="card user-card user-card-2 support-bar1 shape-right">
                                        <div class="card-header border-0 p-2 pb-0">
                                            <div class="cover-img-block bg-color"
                                                style="width: 100%; height: 300px; overflow: hidden;">
                                                <img src="{{ asset('upload/cover.jpg') }}" alt=""
                                                    class="img-fluid h-100 w-100">
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="user-about-block text-center">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto col pr-0">
                                                                {{-- Always show default logo image --}}
                                                                <img class="img-radius img-fluid wid-80"
                                                                    src="{{ asset('upload/logo2.png') }}" alt="User image">
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <h3 class="mb-1 mt-3">{{ $user->display_rank }} {{ $user->fname }}
                                                            </h3>

                                                            <p class="mb-3 text-muted">{{ $user->role_name }}</p>
                                                            <p class="mb-3 text-muted">{{ $user->email }}</p>

                                                        </div>
                                                    </div>
                                                    <div class="col col-auto">
                                                        <a href="{{ route('profile.edit') }}" style="float: right"
                                                            class="btn btn-rounded btn-success mb-5"> Edit Profile</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row text-center">
                                                <div class="col">
                                                    <h6 class="mb-1">Arm of Service</h6>
                                                    <p class="mb-0">{{ $user->arm_of_service }}</p>
                                                </div>
                                                <div class="col">
                                                    <h6 class="mb-1">Unit</h6>
                                                    <p class="mb-0">{{ $user->unit?->unit ?? 'N/A' }}</p>

                                                </div>
                                                <div class="col">
                                                    <h6 class="mb-1">Mobile No</h6>
                                                    <p class="mb-0">{{ $user->phone }}</p>
                                                </div>
                                                <div class="col">
                                                    <h6 class="mb-1">Gender</h6>
                                                    <p class="mb-0">{{ $user->gender }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.content -->

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content-wrapper -->
@endsection
