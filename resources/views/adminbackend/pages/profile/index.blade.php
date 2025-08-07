@extends('admin.layouts.master')
@section('title')
    Account Setting
@endsection

@section('content')
    <div class="user-profile user-card mb-4">
        <div class="card-header border-0 p-0 pb-0">
            <div class="cover-img-block">
                <div class="overlay"></div>
                <div class="change-cover">
                    <div class="dropdown">
                        <a class="drp-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="icon feather icon-camera"></i></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><i class="feather icon-upload-cloud mr-2"></i>upload
                                new</a>
                            <a class="dropdown-item" href="#"><i class="feather icon-image mr-2"></i>from photos</a>
                            <a class="dropdown-item" href="#"><i class="feather icon-film mr-2"></i> upload video</a>
                            <a class="dropdown-item" href="#"><i class="feather icon-trash-2 mr-2"></i>remove</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body py-0">
            <div class="user-about-block m-0">
                <div class="row">
                    <div class="col-md-4 text-center mt-n5">
                        <div class="change-profile text-center">
                            <div class="dropdown w-auto d-inline-block">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="profile-dp">
                                        <div class="position-relative d-inline-block">
                                            <img class="img-radius img-fluid wid-100" src="assets/images/user/avatar-5.jpg"
                                                alt="User image">
                                        </div>
                                        <div class="overlay">
                                            <span>change</span>
                                        </div>
                                    </div>
                                    <div class="certificated-badge">
                                        <i class="fas fa-certificate text-c-blue bg-icon"></i>
                                        <i class="fas fa-check front-icon text-white"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-upload-cloud mr-2"></i>upload new</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-image mr-2"></i>from
                                        photos</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-shield mr-2"></i>Protact</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-trash-2 mr-2"></i>remove</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-1">Lary Doe</h5>
                        <p class="mb-2 text-muted">UI/UX Designer</p>
                    </div>
                    <div class="col-md-8 mt-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-globe mr-2 f-18"></i>www.phoenixcoded.net</a>
                                <div class="clearfix"></div>
                                <a href="mailto:demo@domain.com"
                                    class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-mail mr-2 f-18"></i>demo@domain.com</a>
                                <div class="clearfix"></div>
                                <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-phone mr-2 f-18"></i>+1 9999-999-999</a>
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <i class="feather icon-map-pin mr-2 mt-1 f-18"></i>
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">4289 Calvin Street</p>
                                        <p class="mb-0 text-muted">Baltimore, near MD Tower Maryland,</p>
                                        <p class="mb-0 text-muted">Maryland (21201)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-reset active" id="profile-tab" data-toggle="tab" href="#profile"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="feather icon-user mr-2"></i>Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-reset" id="gallery-tab" data-toggle="tab" href="#gallery"
                                    role="tab" aria-controls="gallery" aria-selected="false"><i
                                        class="feather icon-image mr-2"></i>Photo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-reset" id="contact-tab" data-toggle="tab" href="#contact"
                                    role="tab" aria-controls="contact" aria-selected="false"><i
                                        class="feather icon-phone mr-2"></i>Change Password</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-reset" id="signature-tab" data-toggle="tab" href="#signature"
                                    role="tab" aria-controls="signature" aria-selected="false"><i
                                        class="feather icon-phone mr-2"></i>Signature</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-2">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Personal details</h5>
                            </div>
                            <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                                <person></person>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        <div class="row text-center">
                            <photo></photo>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Change Password</h5>
                                    </div>
                                    <div class="card-body border-top pro-dont-edit collapse show" id="pro-dont-edit-1">
                                        <security></security>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
