@extends('adminbackend.layouts.master')

@section('main')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />

    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">User Management</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('superadmin.dashboard') }}"><i class="feather icon-users"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Users</a></li>
                                </ul>

                                <a href="{{ route('superadmin.users.create') }}"
                                    class="btn btn-sm btn-light mt-2 mt-md-0">
                                    + Add New User
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        {{-- Title and Button in Responsive Flex Layout --}}
                        {{-- <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-2 mb-md-0">All Users</h4>

                            <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">
                                Add New User
                            </a>
                        </div> --}}

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- DataTable --}}
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service No</th>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('superadmin.users.ajax') }}',
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'service_no',
                name: 'service_no'
            },
            {
                data: 'rank', // ✅ This now matches the addColumn('rank') in controller
                name: 'rank',
                orderable: false, // Computed column - can't sort by database
                searchable: false  // Computed column - can't search by database
            },
            {
                data: 'fname',
                name: 'fname'
            },
            { 
                data: 'unit_name', 
                name: 'units.unit' // This can stay searchable/sortable since it's from join
            },
            {
                data: 'role',
                name: 'role',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
});
    </script>
@endsection
