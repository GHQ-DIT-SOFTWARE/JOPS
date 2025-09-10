<!-- resources/views/duty-roster/password-list.blade.php -->
@php
use Carbon\Carbon;
@endphp
@extends('adminbackend.layouts.master')

@section('main')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Temporary Passwords for Duty Officers</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('duty-roster.index') }}">Duty Roster</a></li>
                                <li class="breadcrumb-item"><a href="#!">Password List</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Temporary Passwords for {{ Carbon::create($year, $month, 1)->format('F Y') }}</h5>
                    <p class="text-success"><i class="feather icon-check-circle"></i> Processed {{ $processedCount }} accounts</p>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="feather icon-info"></i> 
                        Please communicate these temporary passwords to the respective officers. 
                        They should change their password after first login.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Officer</th>
                                    <th>Service</th>
                                    <th>Unit</th>
                                    <th>Temporary Password</th>
                                    <th>Login Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($passwords as $item)
                                <tr>
                                    <td>{{ $item['officer'] }}</td>
                                    <td>{{ $item['arm_of_service'] }}</td>
                                    <td>{{ $item['unit'] }}</td>
                                    <td>
                                        <code class="bg-light p-1 rounded">{{ $item['temp_password'] }}</code>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $item['temp_password'] }}')">
                                            <i class="feather icon-copy"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <small>
                                            Service No: <strong>{{ explode('(', $item['officer'])[1] ?? '' }}</strong><br>
                                            Use temporary password for first login
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('duty-roster.index', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">
                            <i class="feather icon-arrow-left"></i> Back to Roster
                        </a>
                        <button class="btn btn-success" onclick="window.print()">
                            <i class="feather icon-printer"></i> Print List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Password copied to clipboard: ' + text);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection