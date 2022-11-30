@extends('layouts.master')

@section('page_title', 'Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('oneUI/css/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="row">
        {{-- <div class="col-md-12">
            <div class="block block-bordered" id="block-proposal-registration-config">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Pengaturan Proposal</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="content_toggle"></button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="{{ route('admin.proposal.update.registration.config') }}" method="POST"
                        id="form-update-proposal-registration">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="quota">Kuota</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="quota" name="quota"
                                    placeholder="Kuota Peserta" min="1"
                                    value="{{ config('proposal_registration.quota') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="">Tanggal Pendaftaran Peserta</label>
                            <div class="col-md-8">
                                <div class="input-daterange input-group" data-date-format="dd-mm-yyyy" data-week-start="1"
                                    data-autoclose="true" data-today-highlight="true">
                                    <input type="text" class="form-control" id="mahasiswa_registration_date_start"
                                        name="mahasiswa_registration_date_start" placeholder="Dari" data-week-start="1"
                                        data-autoclose="true" data-today-highlight="true"
                                        value="{{ config('proposal_registration.registration_date.start') }}" required>
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text font-w600">
                                            <i class="fa fa-fw fa-arrow-right"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="mahasiswa_registration_date_end"
                                        name="mahasiswa_registration_date_end" placeholder="Sampai" data-week-start="1"
                                        data-autoclose="true" data-today-highlight="true"
                                        value="{{ config('proposal_registration.registration_date.end') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <button class="btn btn-primary mb-3 mx-auto"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">List Proposal</h3>
                    <div class="ml-auto card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table table-bordered table-striped table-vcenter" id="main-table"
                            style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Proposal</th>
                                    <th>Prodi</th>
                                    <th>Status Validasi</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th> @include('layouts.data_tables.th_general_select', [
                                        'table_id' => 'main-table',
                                        'col' => 1,
                                        'options' => App\Models\MAA\ProgramStudi::pluck('nama_depart', 'kode'),
                                        'model' => 'App\Models\Master\Proposal',
                                        'db_column' => 'prodi_id',
                                    ])</th>
                                    <th>
                                        @include('layouts.data_tables.th_general_select', [
                                            'table_id' => 'main-table',
                                            'col' => 2,
                                            'options' => App\Models\Master\Proposal::VALIDATION_STATUS,
                                        ])
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.data_tables.basic_data_tables')
@include('layouts.datepicker.bootstrap_datepicker')

@push('scripts')
    <script src="{{ asset('oneUI/js/sweetalert2.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // const $form_update_proposal_registration = $("#form-update-proposal-registration"),
            //     $block_proposal_registration_config = $("#block-proposal-registration-config");

            $('#main-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url()->full() !!}',
                columns: [{
                        data: 'name',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'prodi_id',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'validation_status',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    }
                ]
            });

            $(".input-daterange").datepicker({
                autoclose: true,
                todayHighlight: true,
            });

            // $($form_update_proposal_registration).submit(function() {
            //     event.preventDefault();
            //     One.block('state_loading', $block_proposal_registration_config);
            //     fetch($(this).attr('action'), {
            //             method: 'POST',
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //                 'ajax': "1"
            //             },
            //             body: new FormData(this)
            //         })
            //         .then(resp => resp.json())
            //         .then(data => {
            //             if (data.code != 200) {
            //                 throw data.message;
            //             }
            //             Toast.success(data.message);
            //         })
            //         .catch(err => Toast.error(err))
            //         .finally(() => One.block('state_normal', $block_proposal_registration_config));
            // });
        });
    </script>
@endpush
