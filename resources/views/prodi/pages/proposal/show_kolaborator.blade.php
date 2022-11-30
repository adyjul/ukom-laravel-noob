@extends('layouts.master')



@section('page_title', 'Detail Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('prodi.proposal.index')], 'Detail'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('styles')
    <style>
        .bg-body-white {
            background-color: white;
            border-radius: 10px;
        }

        .border-10px {
            border-radius: 10px;
        }

        .select2-container {
            width: 100% !important;
        }

        .table td,
        .table th {
            border-bottom: 1px solid #e1e6e9;
        }

    </style>
@endpush



@php

$status;
$class;
if ($data['obj']->validation_status == 1) {
    $status = 'pending';
    $class = 'bg-primary';
} elseif ($data['obj']->validation_status == 2) {
    $status = 'ditolak';
    $class = 'bg-danger';
} elseif ($data['obj']->validation_status == 3) {
    $status = 'direvisi';
    $class = 'bg-warning';
} else {
    $status = 'diterima';
    $class = 'bg-success';
}

@endphp


@section('content')
    @if (in_array($data['obj']->validation_status, [2, 3]))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-{{ $data['obj']->validation_status == 2 ? 'danger' : 'warning' }}" role="alert">
                    <h3 class="alert-heading h4 my-2">Proposal {{ $data['obj']->validation_status_text }}</h3>
                    <p class="mb-0">{{ $data['obj']->validation_message }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="bg-body-white mb-5 shadow content-title {{ $status }} " style="position: relative;overflow:hidden">
        <div class="content content-full">
            <div class="py-3 text-center" style="position: relative;z-index: 1;">
                <h1 class="mb-2">
                    {{ $data['obj']['name'] }}
                </h1>
                <hr style="width: 28rem;">
                <h2 class="h4 font-w400 text-muted mb-0">
                    <span class="badge text-white shadow {{ $class }}"
                        style="font-size: 15px;">{{ $data['obj']->validation_status_text }}</span>
                </h2>
            </div>
            @if ($data['obj']->validation_status == 1)
                <i class="fa fa-history bg-icon {{ $status }}"></i>
            @elseif ($data['obj']->validation_status == 2)
                <i class="fas fa-times-circle bg-icon {{ $status }}"></i>
            @elseif ($data['obj']->validation_status == 3)
                <i class="fas fa-edit bg-icon {{ $status }}"></i>
            @else
                <i class="fas fa-check-circle bg-icon {{ $status }}"></i>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="js-wizard-simple block  shadow border-10px">
                <!-- Step Tabs -->
                <ul class="nav nav-tabs nav-tabs-block nav-justified {{ $status }}" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step1" data-toggle="tab">Data Proposal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step2" data-toggle="tab">Data Dosen Perguruan
                            Tinggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step4" data-toggle="tab">Data Dosen Praktisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step3" data-toggle="tab">Data DUDI</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;">
                    <!-- Step 1 -->


                    <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">

                        <form action="{{ route('prodi.proposal.ajaxstore.file.proposal') }}" method="post"
                            enctype="multipart/form-data" id="form_proposal"
                            class="{{ $data['obj']->proposal_files == null && $data['obj']->proposal == null ? 'd-block' : 'd-none' }}">
                            <div class="">
                                <input type="hidden" id="proposal" name="id" value="{{ $data['obj']['id'] }}">
                                <label for="">Nama Proposal <span class="text-danger ">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ $data['obj']->name }}">
                                </div>
                                <label for="">Proposal <span class="text-danger input_required">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file proposal_input">
                                        <input type="file" class="custom-file-input" id="proposal" name="proposal" required>
                                        <label class="custom-file-label" for="proposal">Pilih Proposal</label>
                                    </div>
                                </div>
                                <label for="">RPS <span class="text-muted input_required"
                                        style="font-style: italic;font-size: 13px;font-weight: 400;">( optional
                                        )</span></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="rps" name="rps">
                                        <label class="custom-file-label" for="rps">Pilih RPS</label>
                                    </div>
                                </div>
                                <label for="">Anggaran <span class="text-danger input_required">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="anggaran" name="anggaran">
                                        <label class="custom-file-label" for="anggaran">Pilih Anggaran</label>
                                    </div>
                                </div>
                                <small>Aturan:
                                    <ul>
                                        <li>Ukuran maksimal <strong>7MB</strong></li>
                                        <li>File <strong>Proposal</strong> dan <strong>RPS</strong> harus berupa pdf</li>
                                        <li>File <strong>Anggaran</strong> harus berformat excel</li>
                                    </ul>
                                </small>
                                <div class="btn_proposal">
                                    <button href="" class="btn btn-primary mr-auto mb-3" type="submit">Simpan</a>

                                </div>
                            </div>
                        </form>

                        @if ($data['obj']->proposal != null && $data['obj']->proposal_files == null)

                            <div class="{{ $data['obj']->proposal_files == null && $data['obj']->proposal != null ? 'd-block' : 'd-none' }} lihat_file">
                                <div class="">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width: 20%;">Proposal</th>
                                                <td>
                                                    @if ($data['obj']->proposal_files == null && $data['obj']->proposal != null)
                                                        <a class="btn_history_proposal btn-preview_pdf"
                                                            href="{{ asset($data['obj']->proposal) }}" >Lihat File</a>
                                                        <i class="far fa-eye">

                                                    @endif
                                                    @if ($data['obj']->proposal_files != null)
                                                        <a class="btn_history_proposal"
                                                            href=""  data-toggle="modal" data-target="#modal_history">Lihat File</a>
                                                        <i class="far fa-eye">
                                                    @endif
                                                </td>
                                            </tr>

                                            @if ($data['obj']['rps'] != null)
                                                <tr>
                                                    <th>RPS</th>
                                                    <td>
                                                        <a class="btn-preview_pdf"
                                                            href="{{ asset($data['obj']['rps']) }}">Lihat
                                                            File</a>
                                                        <i class="far fa-eye">
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($data['obj']['anggaran'] != null)
                                                <tr>
                                                    <th>Anggaran</th>
                                                    <td>
                                                        <a class="btn-download-excel"
                                                            href="{{ asset($data['obj']['anggaran']) }}">Download
                                                            File</a>
                                                        <i class="fa fa-download">
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($data['obj']->validation_status == 4)
                                                <tr>
                                                    <th>Anggaran yang disetujui</th>
                                                    <td>Rp. {{ number_format($data['obj']->accepted_budget, 0, '', '.') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="">
                                        <button href="" class="btn btn-primary mr-auto mb-3 btn_ubah_proposal"
                                            type="submit">Ubah</button>
                                    </div>
                                </div>
                            </div>

                        @elseif($data['obj']->proposal_files != null)
                            <div class="{{ $data['obj']->proposal_files != null  ? 'd-block' : 'd-none' }} lihat_file">
                                <div class="">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width: 20%;">Proposal</th>
                                                <td>
                                                    @if ($data['obj']->proposal_files == null && $data['obj']->proposal != null)
                                                        <a class="btn_history_proposal btn-preview_pdf"
                                                            href="{{ asset($data['obj']->proposal) }}" >Lihat File</a>
                                                        <i class="far fa-eye">

                                                    @endif
                                                    @if ($data['obj']->proposal_files != null)
                                                        <a class="btn_history_proposal"
                                                            href=""  data-toggle="modal" data-target="#modal_history">Lihat File</a>
                                                        <i class="far fa-eye">
                                                    @endif
                                                </td>
                                            </tr>

                                            @if ($data['obj']['rps'] != null)
                                                <tr>
                                                    <th>RPS</th>
                                                    <td>
                                                        <a class="btn-preview_pdf"
                                                            href="{{ asset($data['obj']['rps']) }}">Lihat
                                                            File</a>
                                                        <i class="far fa-eye">
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($data['obj']['anggaran'] != null)
                                                <tr>
                                                    <th>Anggaran</th>
                                                    <td>
                                                        <a class="btn-download-excel"
                                                            href="{{ asset($data['obj']['anggaran']) }}">Download
                                                            File</a>
                                                        <i class="fa fa-download">
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($data['obj']->validation_status == 4)
                                                <tr>
                                                    <th>Anggaran yang disetujui</th>
                                                    <td>Rp. {{ number_format($data['obj']->accepted_budget, 0, '', '.') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="">
                                        <button href="" class="btn btn-primary mr-auto mb-3 btn_ubah_proposal"
                                            type="submit">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <!-- END Step 1 -->

                    <!-- Step 2 -->
                    <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                        <div class="form-group">
                            <div class="ml-auto card-tools mb-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-prodi"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-vcenter" id="table-dosen"
                                    style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Dosen Prodi</th>
                                            <th style="width: 40%;">NIDN</th>
                                            <th class="text-center" style="width: 20%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Step 2 -->

                    <!-- Step 3 -->
                    <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                        <div class="ml-auto card-tools mb-3">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-dudi"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" id="table-dudi"
                                style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Nama Industri</th>
                                        <th style="width: 30%;">Bidang Industri</th>
                                        <th style="width: 50%;">Alamat</th>
                                        <th style="width: 30%;">Direktur</th>
                                        <th style="width: 30%;">CP</th>
                                        <th style="width: 30%;">MOU</th>
                                        <th style="width: 30%;">Website</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Step 3 -->


                    {{-- Step 4 --}}
                    <div class="tab-pane" id="wizard-simple-step4" role="tabpanel">
                        <div class="ml-auto card-tools mb-3">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-praktisi"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" id="table-dosen-praktisi"
                                style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Nama Lengpkap</th>
                                        <th style="width: 40%;">Jabatan/Posisi`</th>
                                        <th class="text-center" style="width: 20%;">Phone</th>
                                        <th style="width: 40%;">Email</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- end Step 4 --}}



                </div>
            </div>
        </div>
    </div>
    @if ($data['obj']->validation_status == '4')
        <div class="row">
            <div class="col-md-12">
                <div class="block block-bordered" id="card_registered_user">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">List Pendaftar</h3>
                    </div>
                    <div class="block-content">
                        <div class="col-md-12">
                            Kuota: <strong>{{ config('proposal_registration.quota') }}</strong> Peserta
                            <hr>
                            Rangkuman:
                            <ul>
                                <li>Pending: {{ $data['registered_user_count']['pending'] }}</li>
                                <li>Ditolak: {{ $data['registered_user_count']['reject'] }}</li>
                                <li>Diterima: {{ $data['registered_user_count']['accept'] }}</li>
                            </ul>
                            <hr>
                            @if ($data['registered_user_count']['accept'] > 0)
                                <a href="{{ route('prodi.proposal.createPDF', ['id' => $data['obj']->id]) }}"
                                    target="_blank" class="btn btn-info">
                                    <i class="fa fa-download"></i>
                                    Data Peserta Diterima
                                </a>
                                <hr>
                            @endif
                        </div>

                        <table class="table table-bordered table-striped" id="table-registered-user">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <input name="select_all" type="checkbox">
                                    </th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Asal Univ</th>
                                    <th>Status Pendaftaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['registered_user'] as $registered_user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="registration_id" name="registration_id[]"
                                                value="{{ $registered_user->id }}">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $registered_user->mahasiswa->user->name }}</td>
                                        <td>{{ $registered_user->mahasiswa->university['name'] }}</td>
                                        <td>{{ $registered_user->validation_status_text }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-detail-pendaftar" data-toggle="tooltip"
                                                data-placement="top" title="Lihat Detail Pendaftar"
                                                data-id="{{ $registered_user->mahasiswa_id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @if (in_array($registered_user->validation_status, [0, 1]))
                                                <a class="btn btn-success _btn_act" data-toggle="tooltip"
                                                    data-placement="top" title="Terima"
                                                    href="{{ route('prodi.proposal.user.registration.accept', ['id' => $registered_user->id]) }}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif
                                            @if (in_array($registered_user->validation_status, [0, 2]))
                                                <a class="btn btn-danger _btn_act" data-toggle="tooltip"
                                                    data-placement="top" title="Tolak"
                                                    href="{{ route('prodi.proposal.user.registration.reject', ['id' => $registered_user->id]) }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row my-3">
                            <div class="col-md-12">
                                <button class="btn btn-sm bg-amethyst btn-batch-registraiton text-light"
                                    data-action="{{ route('prodi.proposal.user.batch.registration.accept', ['id' => $data['obj']->id]) }}"
                                    data-title="Yakin Terima Kumpulan Pendaftar?"><i class="fa fa-check"></i> Terima
                                    Pendaftar
                                    Yang
                                    Dicentang</button>
                                <button class="btn btn-sm bg-smooth btn-batch-registraiton text-light"
                                    data-action="{{ route('prodi.proposal.user.batch.registration.reject', ['id' => $data['obj']->id]) }}"
                                    data-title="Yakin Tolak Kumpulan Pendaftar?"><i class="fa fa-times"></i>
                                    Tolak Pendaftar Yang
                                    Dicentang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

<div class="row">

    @include('layouts.parts.frontend.ceklist')
    <div class="col-md-12">
        <div class="block block-rounded block-mode-hidden content-title-left {{ $status }}" style="">
            <div class="block-header">
                <h3 class="block-title">Riwayat Proposal</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-border">
                    @include('layouts.general_informations.userResponsibleStampInTable', [
                        'data' => $data['obj'],
                    ])
                </table>
            </div>
        </div>
    </div>
</div>



@endsection


{{-- modal preview PDF --}}

@push('modals')
    <div class="modal fade" id="modal_preview_pdf" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="height: 95% !important;">
            <div class="modal-content" style="height: 100% !important;">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body h-100">
                    <div id="preview_pdf_div" class="h-100 w-100"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush


{{-- Modal data prodi --}}
@push('modals')
    <div class="modal fade" id="modal-data-prodi" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Tambah Data Dosen</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('prodi.proposal.ajaxstore.dosen') }}" method="post" id="form_dosen">
                        <div class="block-content font-size-sm">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="prodi_lecture_name">Dosen Prodi <span
                                        class="text-danger">*</span></label>
                                <select class="dosen_prodi w-100" id="prodi_lecture_name" name="prodi_lecture_name">
                                </select>
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="prodi_lecture_name">NIDN<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="nidn_dosen" disabled class="form-control">
                            </div>
                            {{-- <div class="form-gorup mb-3">
                                <label for="prodi_instructure_name">Instruktur dari Prodi <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="prodi_instructure_name" name="prodi_instructure_name"
                                    class="form-control" value="{{ old('prodi_instructure_name') }}">
                            </div> --}}
                            <div class="">
                                <button class="btn btn-primary mr-auto mb-3" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush


{{-- Modal data dudi --}}
@push('modals')
    <div class="modal fade" id="modal-data-dudi" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Data DUDI</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('prodi.proposal.ajaxstore.dudi') }}" method="post" id="form_dudi">
                        <div class="block-content font-size-sm">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="dudi_name">Pilih DUDI<span
                                        class="text-danger">*</span></label>
                                <select class="dudi_name w-100" id="dudi_name" name="dudi_name">
                                </select>
                            </div>
                            <div class="">
                                <button class="btn btn-primary mr-auto mb-3" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush



{{-- Modal data praktisi --}}
@push('modals')
    <div class="modal fade" id="modal-data-praktisi" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Tambah Dosen DUDI</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('prodi.proposal.ajaxstore.dosen.praktisi') }}" method="post"
                        id="form_praktisi">
                        <div class="block-content font-size-sm">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="name_praktisi1">Nama Lengkap<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="name_praktisi1" name="name_praktisi" class="form-control">
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="jabatan_praktisi1">Jabatan/Posisi<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="jabatan_praktisi1" class="form-control" name="jabatan_praktisi">
                            </div>
                            <div class="form-gorup mb-3" id="selectDUDI">
                                <label class="w-100" for="dudi_praktisi1">DUDI<span
                                        class="text-danger">*</span></label>
                                <select class="dudi_praktisi w-100" id="dudi_praktisi1" name="dudi_praktisi">
                                </select>
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="email_praktisi1">Email<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="email_praktisi1" class="form-control" name="email_praktisi">
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="contact_praktisi1">Kontak/WhatsApp<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="contact_praktisi1" class="form-control" name="contact_praktisi">
                            </div>
                            <div class="">
                                <button class="btn btn-primary mr-auto mb-3" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush


{{-- Modal data praktisi edit --}}
@push('modals')
    <div class="modal fade" id="modal-data-praktisi-edit" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Update Data Dosen Praktisi</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('prodi.proposal.ajaxupdate.dosen.praktisi') }}" method="put"
                        id="form_praktisi2">
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="id_praktisi" id="id_praktisi2">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="name_praktisi2">Nama Lengkap<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="name_praktisi2" name="name_praktisi" class="form-control">
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="jabatan_praktisi2">Jabatan/Posisi<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="jabatan_praktisi2" class="form-control" name="jabatan_praktisi">
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="dudi_praktisi2">DUDI<span
                                        class="text-danger">*</span></label>
                                <select class="dudi_praktisi w-100" id="dudi_praktisi2" name="dudi_praktisi">
                                </select>
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="email_praktisi2">Email<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="email_praktisi2" class="form-control" name="email_praktisi">
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="contact_praktisi2">Kontak/WhatsApp<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="contact_praktisi2" class="form-control" name="contact_praktisi">
                            </div>
                            <div class="">
                                <button class="btn btn-primary mr-auto mb-3" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal detail pendaftar --}}
@push('modals')
    <div class="modal fade" id="modal-detail-pendaftar" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Detail Pendaftar</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm">
                        <div class="row">
                            <div class="col-md-12" id="content">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush


{{-- Modal hisoty proposal --}}
@push('modals')

<div class="modal fade" id="modal_history" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">History Proposal</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm">
                        <div class="row">
                            <div class="col-md-12" id="content">
                                 <table class="table table-bordered table-striped table-vcenter" id="table-history"
                                style="width: 100% !important;">
                                @php

                                @endphp
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40%;">Tanggal diubah</th>
                                        <th class="text-center" style="width: 40%;">File</th>
                                    </tr>
                                </thead>
                                @if ($data['obj']->proposal_files != null)
                                    <tbody>
                                        @foreach ($data['obj']->proposal_files as $item)

                                            <tr class="text-center">
                                                <th>{{ Carbon\Carbon::createFromFormat("Y-m-d H:i:s",$item['uploaded_at'],'Asia/Jakarta')->translatedFormat('d, D F Y - H:i') }}</th>
                                                <th>
                                                    <a href="{{ asset($item['path']) }}" class="btn btn-primary btn_download_proposal"><i class="fas fa-file-download mb-1 mr-1"></i> Download</a>
                                                    <a href="{{ asset($item['path']) }}" class="btn btn-success btn-preview_pdf" data-dismiss="modal"><i class="fas far fa-eye mr-1"></i> Lihat</a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endpush



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
        integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).on('click', '.btn-preview_pdf', function() {
            event.preventDefault()
            let targetFile = $(this).attr("href")
            PDFObject.embed(targetFile, "#preview_pdf_div");
            $("#modal_preview_pdf").modal("show")
        })

    </script>
@endpush



@push('scripts')
    <script>
        $(document).on(
            'submit',
            "._form_with_confirm",
            function(event) {
                event.preventDefault()
                Swal.fire({
                    title: $(this).data("title"),
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        loader.show()
                        // const formData = new FormData();
                        // const inputs = $(this).find('input,select,textarea').each((idx, el) => {
                        //     formData.append(`${$(el).attr('name')}`, ` ${$(el).val()}`);
                        // })

                        fetch($(this).attr('action'), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                // body: formData
                                body: new FormData(this)
                            })
                            .then(resp => resp.json())
                            .then(data => {
                                if (data.code != 200) {
                                    throw data.message;
                                }
                                Toast.success(data.message);
                                $($(this).data("table")).DataTable().ajax.reload()
                            })
                            .catch(err => Toast.error(err))
                            .finally(() => loader.hide())
                    }
                })
            })
    </script>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@include('layouts.data_tables.basic_data_tables')

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-download-excel', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                Swal.fire({
                    icon: 'warning',
                    title: 'File akan di download',
                    text: 'Tekan Ok untuk melanjutkan',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            })

            $(document).on('click', '.btn_download_proposal', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                Swal.fire({
                    icon: 'warning',
                    title: 'File akan di download',
                    text: 'Tekan Ok untuk melanjutkan',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            })

            $(document).on('click', '.btn_ubah_proposal', function() {
                $('#form_proposal').removeClass('d-none');
                $('.lihat_file').addClass('d-none');
                $('.lihat_file').removeClass('d-block');
                $('.proposal_input input').attr('required', false);
                $('.input_required').remove();
                $('.btn_proposal').append(
                    '<button href="" class="btn_batal_ubah btn btn-danger mr-auto ml-3 mb-3" type="submit">Batal Ubah</a>'
                )
            })



            $(document).on('click', '.btn_batal_ubah', function() {
                $('#form_proposal').addClass('d-none');
                $('.lihat_file').removeClass('d-none');
                $('.lihat_file').addClass('d-block');
                $(this).remove();
            })

            $('#table-dosen').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('prodi.proposal.ajaxdatatable.dosen', ['proposal_id' => $data['obj']['id']]) }}",
                columns: [{
                        data: 'dosen.nama_dan_gelar',
                        name: 'dosen.nama_dan_gelar',
                    },
                    {
                        data: 'nidn',
                        name: 'nidn',
                        className: "text-center",
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    }
                ]
            });

            $('#table-dosen-praktisi').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('prodi.proposal.ajaxdatatable.dosen.praktisi', ['proposal_id' => $data['obj']['id']]) }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'position',
                        name: 'position',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    }
                ]
            });

            $('#table-dudi').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('prodi.proposal.ajaxdatatable.dudi', ['proposal_id' => $data['obj']['id']]) }}",
                columns: [{
                        data: 'dudi.name',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.field',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.address',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.director_name',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.cp_name',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.mou',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'dudi.website',
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    }
                ]
            });


            function select(id, url) {
                $(`#${id}`).select2({
                    minimumInputLength: 2,
                    theme: 'bootstrap4',
                    ajax: {
                        url,
                        dataType: 'json',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: function(term) {
                            return (JSON.stringify({
                                searchString: term.term
                            }))
                        },
                        processResults: function(data, page) {
                            return {
                                results: data.data
                            }
                        }
                    }
                })
            }

            function selectDUDI(id, url) {
                $(`#${id}`).select2({
                    theme: 'bootstrap4',
                    ajax: {
                        url,
                        dataType: 'json',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: function(term) {
                            return (JSON.stringify({
                                searchString: term.term
                            }))
                        },
                        processResults: function(data, page) {
                            return {
                                results: data.data
                            }
                        }
                    }
                })
            }





            $('#nidn_dosen').val(" ")
            var nidn = '';

            select('prodi_lecture_name', '{{ route('prodi.proposal.ajax.select2.dosen.prodi') }}');
            select('user_name', '{{ route('prodi.proposal.ajax.select2.kolaborator') }}');
            selectDUDI('dudi_name', '{{ route('prodi.proposal.ajax.select2.dudi') }}');
            selectDUDI('selectDUDI #dudi_praktisi1', '{{ route('prodi.proposal.ajax.select2.dudi') }}');
            selectDUDI('modal-data-praktisi-edit #dudi_praktisi2',
                '{{ route('prodi.proposal.ajax.select2.dudi') }}');
            $(document).on('change', '#prodi_lecture_name', function() {
                var value = $(this).val()
                nidn = value;
                $('#nidn_dosen').val(value)
            }).trigger("change");

            $(document).on('change', '#user_name', function() {
                var value = $(this).val()
                $()
            }).trigger("change");



            $(document).on('change', 'input[type="file"]', function(e) {
                var fileName = e.target.files[0].name;
                $(this).next().html(fileName);
            });

            $(document).on('submit', '#form_dosen', function(e) {
                e.preventDefault();
                var url = $(this).attr('action')
                var id = "{{ $data['obj']['id'] }}";
                loader.show();
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            id,
                            nidn
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diinput',
                            })
                            $('#table-dosen').DataTable().ajax.reload();
                        } else {
                            throw result.message
                        }

                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: err,
                        })
                    })
                    .finally(() => {
                        $('.modal').modal('hide');
                        loader.hide();
                        $('#prodi_lecture_name').val("").trigger('change');
                    })
            })

            $(document).on('submit', '#form_proposal', function(e) {
                e.preventDefault();
                var url = $(this).attr('action')
                var id = "{{ $data['obj']['id'] }}";
                var formData = new FormData(this);

                loader.show();
                $.ajax({
                    type: 'POST',
                    url,
                    data: formData,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        this.reset();
                        if (data.code == 200) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Data Berhasil Diinput',
                                })
                                .then((result) => {
                                    location.reload();
                                })
                            // $('#main-table').DataTable().draw()
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: data.message,
                            })
                            // $('#main-table').DataTable().draw()
                        }

                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: data.responseJSON.message,
                        })
                    },
                    complete: function(data) {
                        loader.hide()
                    }
                });
            })



            $(document).on('submit', '#form_praktisi', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var id = "{{ $data['obj']['id'] }}";
                loader.show();
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            proposal_id: id,
                            name: $('#modal-data-praktisi #name_praktisi1').val(),
                            position: $('#modal-data-praktisi #jabatan_praktisi1').val(),
                            dudi_id: $('#modal-data-praktisi #dudi_praktisi1').val(),
                            email: $('#modal-data-praktisi #email_praktisi1').val(),
                            phone: $('#modal-data-praktisi #contact_praktisi1').val(),
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diinput',
                            })
                            $('#table-dosen-praktisi').DataTable().ajax.reload();
                        } else {
                            throw result.message
                        }

                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: err,
                        })
                    })
                    .finally(() => {
                        $('.modal').modal('hide');
                        loader.hide();
                        $('#dudi_praktisi1').val("").trigger('change');
                        $('#modal-data-praktisi #name_praktisi1').val(null);
                        $('#modal-data-praktisi #jabatan_praktisi1').val(null);
                        $('#modal-data-praktisi #dudi_praktisi1').val(null);
                        $('#modal-data-praktisi #email_praktisi1').val(null);
                        $('#modal-data-praktisi #contact_praktisi1').val(null);
                    })
            })


            $(document).on('submit', '#form_dudi', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var id = "{{ $data['obj']['id'] }}";
                loader.show();
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            id,
                            dudi_id: $('#dudi_name').val()
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diinput',
                            }).then(() =>{
                                location.reload();
                            })
                            $('#table-dudi').DataTable().ajax.reload();
                        } else {
                            throw result.message
                        }

                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: err,
                        })
                    })
                    .finally(() => {
                        $('.modal').modal('hide');
                        loader.hide();
                        $('#dudi_name').val("").trigger('change');
                    })
            })

            $(document).on('click', '.btn-edit-dosen-praktisi', function(e) {
                e.preventDefault()
                let id = $(this).attr('data-id');
                let url = "{{ route('prodi.proposal.ajaxdetail.dosen.praktisi', ['id' => '__id']) }}";
                url = url.replace('__id', id);
                loader.show();
                $('#modal-data-praktisi-edit').modal('show');
                fetch(url)
                    .then(response => response.json())
                    .then(result => {
                        idItem = result.data.id;
                        rs = result.data;
                        $("#modal-data-praktisi-edit #dudi_praktisi2").append($(
                            "<option selected='selected'></option>").val(rs.dudi.id).text(rs
                            .dudi.name)).trigger('change');
                        $('#modal-data-praktisi-edit #name_praktisi2').val(rs.name);
                        $('#modal-data-praktisi-edit #id_praktisi2').val(rs.id);
                        $('#modal-data-praktisi-edit #jabatan_praktisi2').val(rs.position)
                        // $('#modal-data-praktisi-edit #dudi_praktisi').val(rs.)
                        $('#modal-data-praktisi-edit #email_praktisi2').val(rs.email)
                        $('#modal-data-praktisi-edit #contact_praktisi2').val(rs.phone)
                    })
                    .catch(err => console.log('gagal'))
                    .finally(() => {
                        loader.hide()
                    })
            })

            $(document).on('submit', '#form_praktisi2', function(e) {
                e.preventDefault();
                let url = "{{ route('prodi.proposal.ajaxupdate.dosen.praktisi') }}"
                var id = "{{ $data['obj']['id'] }}";
                loader.show();
                fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            id: $('#modal-data-praktisi-edit #id_praktisi2').val(),
                            name: $('#modal-data-praktisi-edit #name_praktisi2').val(),
                            position: $('#modal-data-praktisi-edit #jabatan_praktisi2').val(),
                            dudi_id: $('#modal-data-praktisi-edit #dudi_praktisi2').val(),
                            email: $('#modal-data-praktisi-edit #email_praktisi2').val(),
                            phone: $('#modal-data-praktisi-edit #contact_praktisi2').val(),
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diinput',
                            })
                            $('#table-dosen-praktisi').DataTable().ajax.reload();
                        } else {
                            throw result.message
                        }

                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: err,
                        })
                    })
                    .finally(() => {
                        $('.modal').modal('hide');
                        loader.hide();
                    })
            })



        })
    </script>
@endpush

@include('layouts.button.general_action_button')

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#table-registered-user").DataTable();

            $("[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('.registration_id').prop('checked', true);
                } else {
                    $('.registration_id').prop('checked', false);
                }
            });

            $(".btn-batch-registraiton").click(function() {
                $checkedRegistration = $('.registration_id:checked');
                if ($checkedRegistration.length == 0) {
                    Swal.fire({
                        'icon': 'error',
                        'title': 'Tidak ada pendaftar yang dipilih'
                    })
                    return false;
                }

                Swal.fire({
                    title: $(this).data("title"),
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let registered_id = [];
                        $.each($($checkedRegistration), function() {
                            registered_id.push($(this).val());
                        });

                        fetch($(this).data('action'), {
                                method: 'post',
                                headers: {
                                    "Content-Type": "application/json",
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                body: JSON.stringify({
                                    registered_id: registered_id
                                })
                            })
                            .then(resp => resp.json())
                            .then(data => {
                                if (data.status === true) {
                                    // window.scrollTo(0,0);
                                    location.reload(false);
                                } else {
                                    throw (data.message)
                                }
                            })
                            .catch(err => {
                                Toast.error(err);
                            })
                    }
                })


                event.preventDefault();
                return false;
            });

            $(document).on('click', '.btn-detail-pendaftar', function() {
                const id = $(this).data('id');

                let url = "{{ route('prodi.proposal.ajaxdetail.pendaftar', ['id' => '__id']) }}";
                url = url.replace('__id', id);

                loader.show()
                fetch(url)
                    .then(resp => resp.json())
                    .then(data => {
                        $("#modal-detail-pendaftar").modal('show')
                        let content = `
                        <table class="table">
                                    <tr>
                                        <th style="width: 10%">Nama</th>
                                        <td style="width: 40%">${data.data.user.name}</td>
                                        <th style="width: 10%">No. telepon</th>
                                        <td style="width: 40%">${data.data.user.phone}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>${data.data.birth_place}</td>
                                        <th>Tanggal Lahir</th>
                                        <td>${data.data.profile.birth_date}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>${data.data.profile.sex == 'l' ? 'Laki-laki':'Perempuan'}</td>
                                        <th>Agama</th>
                                        <td>${data.data.profile.religion_id}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td colspan="3">${data.data.full_address}</td>
                                    </tr>
                                    <tr>
                                        <th>NIM</th>
                                        <td>${data.data.profile.nim}</td>
                                        <th>Universitas</th>
                                        <td>${data.data.university.name} - ${data.data.university.address}</td>
                                    </tr>
                                </table>`;
                        $("#modal-detail-pendaftar #content").html(content)
                    })
                    .catch(err => Toast.error(err))
                    .finally(() => loader.hide())

            });
        });
    </script>
@endpush
