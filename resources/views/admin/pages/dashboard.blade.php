@extends('layouts.master')

@section('page_title', 'Dashboard')

{{-- @section('page_sub_title', 'Ini adalah sub title dashboard') --}}

@section('breadcrumb')
    @php
    $breadcrumbs = ['Home', ['Dashboard', route('admin.dashboard.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
@endpush

@section('content')
    <div class="content mx-0 w-100">
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">User Prodi</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['user_prodi'] }}</div>
                    </div>
                </a>
                <a class="block block-rounded block-link-pop border-left border-info border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Slider</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['slider'] }}</div>
                    </div>
                </a>
                <a class="block block-rounded block-link-pop border-left border-warning border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Pengumuman</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['announcement'] }}</div>
                    </div>
                </a>
                <a class="block block-rounded block-link-pop border-left border-success border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Download</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['download'] }}</div>
                    </div>
                </a>
            </div>
            {{-- <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Proposal Belum Validasi</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['proposal_not_validation_yet'] }}</div>
                    </div>
                </a>
            </div> --}}
            {{-- <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x"
                    href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Proposal Ditolak</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['proposal_reject'] }}</div>
                    </div>
                </a>
            </div> --}}
            {{-- <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x"
                    href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Proposal Diterima</div>
                        <div class="font-size-h2 font-w400 text-dark">{{ $data['proposal_accept'] }}</div>
                    </div>
                </a>
            </div> --}}
            <div class="col-6 col-md-9 col-lg-6">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Proposal</h3>
                        <div class="block-options">
                        </div>
                    </div>
                    <div class="block-content block-content-full text-center">
                        <div class="py-3">
                            <!-- Pie Chart Container -->
                            <canvas id="pie-chart-proposal"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- <script src="{{ asset('oneUI/js/sparkline.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/chart.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/dashboard.min.js') }}"></script> --}}

    <script src="{{ asset('oneUI') }}/js/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="{{ asset('oneUI') }}/js/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="{{ asset('oneUI') }}/js/plugins/chart.js/Chart.bundle.min.js"></script>

    <script>
        let proposalChartData = {
            labels: @json($data['proposal_validation_status']),
            datasets: [{
                data: @json($data['proposal_counter']),
                backgroundColor: [
                    "rgba(171, 0, 125, 1)",
                    "rgba(247, 5, 5, 0.8)",
                    "rgba(250, 219, 125, 1)",
                    "rgba(117, 176, 235, 1)"
                ],
                hoverBackgroundColor: [
                    "rgba(171, 0, 125, .75)",
                    "rgba(210, 14, 14, 0.8)",
                    "rgba(250, 219, 125, .75)",
                    "rgba(117, 176, 235, .75)"
                ],
            }],
        }

        new Chart($("#pie-chart-proposal"), {
            type: "pie",
            data: proposalChartData,
        })
    </script>
@endpush
