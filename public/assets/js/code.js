$(function () {
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                )
            }
        })
    });

});



$(function () {
    $(document).on('click', '#ApproveBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Change This To Unserviceable?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change To Unserviceable!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Unserviceable  Approved!!',
                    'success'
                )
            }
        })
    });

});

$(function () {
    $(document).on('click', '#UnserBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Change This To Serviceability?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change To Serviceability!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Change!',
                    'Serviceability approved!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#serBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Change This To Unserviceability?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change To Unserviceability!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Change!',
                    ' Unserviceability  approved!',
                    'success'
                )
            }
        })
    });

});

$(function () {
    $(document).on('click', '#AvailableEletronicBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "Unavailable?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,Change Availablity!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Available!',
                    'Avaialability Changed!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#UnAvailableEletronicBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "Available?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,Change Availablity!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'available!',
                    'Unavailability Changed!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#AvailableGeneralBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "Unavailable?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,Change Availablity!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Unavailable!',
                    'Avaialability Changed!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#UnAvailableGeneralBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "Available?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,Change Availablity!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Available!',
                    'Unavailability Changed!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#ElecLoanBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Approve This Status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve Status!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Status  Approved!!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#ElecreturnBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Approve This Status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve Status!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Status  Approved!!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#GeneraloanBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Approve This Status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve Status!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Status  Approved!!',
                    'success'
                )
            }
        })
    });

});

$(function () {
    $(document).on('click', '#GeneralreturnBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Approve This Status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve Status!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Status  Approved!!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#AcceptBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Approve This Personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve Personal!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Approved!',
                    ' Personal  Approved!!',
                    'success'
                )
            }
        })
    });

});


// $(function () {
//     $(document).on('click', '#RepaBtn', function (e) {
//         e.preventDefault();
//         var link = $(this).attr("href");
//         Swal.fire({
//             title: 'Are you sure?',
//             text: "You Want To Repatriate This Personal?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, Repatriate Personal!'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.href = link
//                 Swal.fire(
//                     'Repatriated!',
//                     ' Personal  Repatriated!!',
//                     'success'
//                 )
//             }
//         })
//     });

// });

$(function () {
    $(document).on('click', '#RepatriatedBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Repatriate This Personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Repatriate Personals!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Repatriated!',
                    ' Personals  Repatriated!!',
                    'success'
                )
            }
        })
    });

});


$(function () {
    $(document).on('click', '#CancelBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Cancel This Personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel Personal!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Cancelled!',
                    'Personal  Cancelled!',
                    'success'
                )
            }
        })
    });

});
$(function () {
    $(document).on('click', '#RescheduleBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Reschedule This Personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Reschedule Personal!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Rescheduled!',
                    'Personal  Rescheduled!',
                    'success'
                )
            }
        })
    });

});

$(function () {
    $(document).on('click', '#ReturnedBtn', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure?',
            text: "Personel Returned?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Personel Returned!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Returned!',
                    'Personel Returned!',
                    'success'
                )
            }
        })
    });

});
