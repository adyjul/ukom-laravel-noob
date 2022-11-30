@extends('layouts.master')

@section('page_title', 'Dashboard')

@section('page_sub_title', 'Ini adalah sub title dashboard')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Home', ['Dashboard', route('admin.dashboard.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <style>
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }

        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        .timeline-steps .timeline-step-muted {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 6.1rem;
                position: absolute;
                left: 8.8rem;
                top: .3125rem
            }

            .timeline-steps .timeline-step-muted:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #5f6672;
                width: 6.1rem;
                position: absolute;
                left: 8.8rem;
                top: .3125rem
            }

            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 6.1rem;
                position: absolute;
                right: 8.8rem;
                top: .3125rem
            }

            .timeline-steps .timeline-step-muted:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #5f6672;
                width: 6.1rem;
                position: absolute;
                right: 8.8rem;
                top: .3125rem
            }
        }

        .timeline-steps .timeline-content {
            width: 14rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #3b82f6
        }

        .timeline-steps .timeline-content .inner-circle-muted {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #a0a9b6
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: #3b82f6;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }

        .timeline-steps .timeline-content .inner-circle-muted:before {
            content: "";
            background-color: #5f6672;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }

        .icon-content i{
            font-size: 1.5rem;
            color: white;
            margin-top: 0.5rem
        }

        .text-content .title{
            font-weight: 900;
        }

        .card.bg-primary{
            border: none;
        }

    </style>
@endpush

@section('content')
    <div class="col-12">
        <div class="card shadow-lg bg-primary p-3">
            <div class="content-card d-flex">
                <div class="icon-content">
                    <i class="fas fa-user-plus mr-4"></i>
                </div>
                <div class="text-content">
                    <h5 class="mb-0 text-white title">Tanggal Daftar Akun</h5>
                    <p class="mb-0 text-white">18 Maret 2022</p>
                </div>
            </div>
        </div>
        <div class="card shadow-lg bg-primary p-3 my-4">
            <div class="content-card d-flex">
                <div class="icon-content">
                    <i class="fas fa-file-upload mr-4"></i>
                </div>
                <div class="text-content">
                    <h5 class="mb-0 text-white title">Tanggal Upload Proposal</h5>
                    <p class="mb-0 text-white">18 Maret 2022</p>
                </div>
            </div>
        </div>
        <div class="card shadow-lg bg-primary p-3">
            <div class="content-card d-flex">
                <div class="icon-content">
                    <i class="fas fa-check mr-4"></i>
                </div>
                <div class="text-content">
                    <h5 class="mb-0 text-white title">Proses Seleksi</h5>
                    <p class="mb-0 text-white">10 April s/d 20 Mei 2022</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('oneUI/js/sparkline.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/chart.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/dashboard.min.js') }}"></script>
@endpush
