<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ !empty($nav_title) ? $nav_title : '' }} - GHQ(OPS)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/22b05698b3.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/ui/_buttons.scss') }}">




    <style>
        label {
            color: #39513b;
            font-weight: bold;
        }

        .breadcrumb-white .breadcrumb,
        .breadcrumb-white .breadcrumb-item,
        .breadcrumb-white .breadcrumb-item a,
        .breadcrumb-white .breadcrumb-item::before,
        .breadcrumb-white i.feather {
            color: #ffffff !important;
        }

        .breadcrumb-white .btn-outline-light {
            color: #ffffff;
            border-color: #ffffff;
        }

        .breadcrumb-white .btn-outline-light:hover {
            background-color: #ffffff;
            color: #000000;
        }
    </style>

</head>

<body>
    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Navigation menu -->
    @include('adminbackend.layouts.nav')

    <!-- Header -->
    @include('adminbackend.layouts.header')

    <!-- Main Content -->
    @yield('main')

    <!-- Required Js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('backend/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/menu-setting.min.js') }}"></script>

    <!-- notification Js -->
    <script src="{{ asset('backend/assets/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/ac-notification.js') }}"></script>


    <!-- DataTables -->
    <script src="{{ asset('backend/assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>




    <script type="text/javascript">
        $(function() {
            // Deletion confirmation
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete This Data?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    }
                });
            });

            // DataTable initialization
            $('#report-table').DataTable();

            // Toastr notifications
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                toastr[type]("{{ Session::get('message') }}");
            @endif
        });
    </script>

    <script>
    $(document).ready(function () {

        // Define your date range here
        const startDate = new Date("2025-08-01");
        const endDate = new Date("2025-08-07");

        // Format the date as "MONTH DAY, YEAR"
        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options).toUpperCase(); // Example: "AUGUST 1, 2025"
        }

        // Set the text
        const formattedStart = formatDate(startDate);
        const formattedEnd = formatDate(endDate);

        const periodText = `DUTY OFFICER'S FOR THE PERIOD OF ${formattedStart} - ${formattedEnd}`;
        $("#current-date-time").text(periodText);

    });
</script>


</body>

</html>
