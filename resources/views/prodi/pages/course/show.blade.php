@extends('layouts.master')



@section('page_title', 'Detail Course')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Course', route('prodi.course.index')], 'Detail'];
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

        .d-none-important{
            display: none !important;
        }

        .border-10px {
            border-radius: 10px;
        }

        .select2-container {
            width: 100% !important;
        }

        .note-editor.note-airframe, .note-editor.note-frame{
            width: 100%;
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
    $color;
    if ($data['course']->validation_status == 1) {
        $status = 'pending';
        $class = 'bg-primary';
        $color = '#5179d6';
    } elseif ($data['course']->validation_status == 2) {
        $status = 'ditolak';
        $class = 'bg-danger';
        $color = '#e56767';
    } elseif ($data['course']->validation_status == 3) {
        $status = 'direvisi';
        $class = 'bg-warning';
        $color = '#e5ae67';
    } else {
        $status = 'diterima';
        $class = 'bg-success';
        $color = '#30c78d';
    }

@endphp



    @section('content')
        @if (in_array($data['course']->validation_status, [2,3]))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header alert alert-{{ $data['course']->validation_status == 2 ? 'danger' : 'warning' }}">
                        <h3 class="block-title alert-heading">Pesan</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                                <i class="si si-pin"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p class="mt-0">{{ $data['course']->validation_message }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="js-wizard-simple block  shadow border-10px">
                    <!-- Step Tabs -->
                    <ul class="nav nav-tabs nav-tabs-block nav-justified {{ $status }}" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active h-100 d-flex justify-content-center align-items-center"
                                href="#wizard-simple-step1" data-toggle="tab">Data Course</a>
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

                    <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;" id="block_content">
                        <!-- Step 1 -->
                        @include('prodi.pages.course.layout_menu.data_course')
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        @include('prodi.pages.course.layout_menu.data_dosen')
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        @include('prodi.pages.course.layout_menu.data_praktisi')
                        <!-- END Step 3 -->


                        {{-- Step 4 --}}
                        @include('prodi.pages.course.layout_menu.data_dudi')

                        {{-- end Step 4 --}}



                    </div>
                </div>
            </div>
        </div>

        <div class="block block-rounded block-mode-hidden shadow "  style="border-left: 6px solid {{ $color }}">
            <div class="block-header">
                <h3 class="block-title">Detail Course {{ $data['course']->category_course == 2 ? '(Berjalan)' : '(Rintisan)' }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                        <i class="si si-pin"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-down"></i></button>

                </div>
            </div>
            <div class="block-content">
                {{-- <table class="table">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">Proposal</th>
                            <td>
                                <a class="btn_history_proposal btn-preview_pdf"
                                    href="{{ asset($data['course']->proposal) }}" >Lihat File</a>
                                <i class="far fa-eye">
                            </td>
                        </tr>
                        <tr>
                            <th>Capaian Mahasiswa</th>
                            <td>{{ $data['course']->student_achievement }}
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi Course</th>
                            <td>{{ $data['course']->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>Biaya Pendaftaran</th>
                            <td>Rp. {{ number_format($data['course']->cost, 0, '', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table> --}}

                <form action="{{ route('prodi.course.ajax.store.courseDetail') }}" method="POST" enctype="multipart/form-data"  id="form-store-detail-course">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="quota">Kuota</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="quota" name="quota"
                            placeholder="Kuota Peserta" min="1"
                            required value="{{ $data['course']->quota }}">
                        <input type="hidden" class="form-control" id="id" name="id"
                            value="{{ $data['course']->id }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="quota">Jam Pelajaran</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="lesson_hours" name="lesson_hours"
                            placeholder="Jam Pelajaran" min="1"
                            required value="{{ $data['course']->lesson_hours }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="">Tanggal Pendaftaran Peserta</label>
                    <div class="col-md-8">
                        <div class="input-daterange input-group" data-date-format="dd-mm-yyyy" data-week-start="1"
                            data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="registration_date_start"
                                name="registration_date_start" placeholder="Dari" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true"
                                value="{{ optional($data['course']['registration_date'])['registration_start'] }}" required>
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">
                                    <i class="fa fa-fw fa-arrow-right"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="registration_date_end"
                                name="registration_date_end" placeholder="Sampai" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true"
                                value="{{ optional($data['course']['registration_date'])['registration_end'] }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="">Tanggal Pelaksanaan Kegiatan Peserta</label>
                    <div class="col-md-8">
                        <div class="input-daterange input-group" data-date-format="dd-mm-yyyy" data-week-start="1"
                            data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="activity_date_start"
                                name="activity_date_start" placeholder="Dari" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true"
                                value="{{ optional($data['course']['activity_date'])['activity_start'] }}" required>
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">
                                    <i class="fa fa-fw fa-arrow-right"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="mahasiswa_activity_date_end"
                                name="activity_date_end" placeholder="Sampai" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true"
                                value="{{ optional($data['course']['activity_date'])['activity_end'] }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    @php
                        $note = ['Ukuran file maksimal 2MB', 'File harus berupa gambar', 'Disarankan menggunakan gambar berdimensi 3x1 (persegi panjang)'];
                    @endphp
                    <x-forms.input-image-with-preview img-preview-id="img_preview" label="Gambar Penunjang (banner)"
                    is-required="FALSE" input-name="image" :notes="$note" />
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <button class="btn btn-primary mb-3 mx-auto"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>

            </div>
        </div>

        @if($data['course']->validation_status == 4)
            <div class="block block-rounded block-mode-hidden shadow"  style="border-left: 6px solid {{ $color }}">
                <div class="block-header">
                    <h3 class="block-title">List Pendaftar</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                            <i class="si si-pin"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-down"></i></button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block block-bordered" id="card_registered_user">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">List Pendaftar</h3>
                                </div>
                                <div class="block-content">
                                    <div class="col-md-12">
                                        Kuota: <strong>{{ $data['course']->quota }}</strong> Peserta
                                        <hr>
                                        Rangkuman:
                                        <ul>
                                            <li>Pending: {{ $data['registered_user_count']['pending'] }}</li>
                                            <li>Ditolak: {{ $data['registered_user_count']['reject'] }}</li>
                                            <li>Diterima: {{ $data['registered_user_count']['accept'] }}</li>
                                        </ul>
                                        <hr>
                                        {{-- @if ($data['registered_user_count']['accept'] > 0)
                                            <a href="{{ route('prodi.proposal.createPDF', ['id' => $data['course']->id]) }}"
                                                target="_blank" class="btn btn-info">
                                                <i class="fa fa-download"></i>
                                                Data Peserta Diterima
                                            </a>
                                            <hr> --}}
                                        {{-- @endif --}}
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
                                                    <td>{{ $registered_user->mahasiswa->user->name ?? $registered_user->mahasiswa->nama_siswa }}</td>
                                                    <td>{{ $registered_user->mahasiswa->university['name'] ?? 'Universitas Muhammadiyah Malang'}}</td>
                                                    <td>{{ $registered_user->validation_status_text }}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-detail-pendaftar" data-toggle="tooltip"
                                                            data-placement="top" title="Lihat Detail Pendaftar"
                                                            data-id="{{ $registered_user->mahasiswa_id ?? $registered_user->nim }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        @if (in_array($registered_user->validation_status, [0, 1]))
                                                            <a class="btn btn-success _btn_act" data-toggle="tooltip"
                                                                data-placement="top" title="Terima"
                                                                href="{{ route('prodi.course.user.registration.accept', ['id' => $registered_user->id]) }}">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array($registered_user->validation_status, [0, 2]))
                                                            <a class="btn btn-danger _btn_act" data-toggle="tooltip"
                                                                data-placement="top" title="Tolak"
                                                                href="{{ route('prodi.course.user.registration.reject', ['id' => $registered_user->id]) }}">
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
                                                data-action="{{ route('prodi.course.user.batch.registration.accept', ['id' => $data['course']->id]) }}"
                                                data-title="Yakin Terima Kumpulan Pendaftar?"><i class="fa fa-check"></i> Terima
                                                Pendaftar
                                                Yang
                                                Dicentang</button>
                                            <button class="btn btn-sm bg-smooth btn-batch-registraiton text-light"
                                                data-action="{{ route('prodi.course.user.batch.registration.reject', ['id' => $data['course']->id]) }}"
                                                data-title="Yakin Tolak Kumpulan Pendaftar?"><i class="fa fa-times"></i>
                                                Tolak Pendaftar Yang
                                                Dicentang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    @endsection



{{-- dosen prodi --}}

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
                    <form action="{{ route('prodi.course.ajax.store.dosen') }}" method="post" id="form_dosen">
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


{{-- tambah dosen praktisi --}}
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
                    <form action="{{ route('prodi.course.ajax.store.dosen.dudi') }}" method="post"
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
                    <form action="{{ route('prodi.course.ajax.update.dosen.dudi') }}" method="put"
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

{{-- edit dosen praktisi --}}
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

{{-- data dudi --}}
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
                    <form action="{{ route('prodi.course.ajax.store.dudi') }}" method="post" id="form_dudi">
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


@include('layouts.select2.bootstrap4')
@include('layouts.data_tables.basic_data_tables')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('oneUI/js/config.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        $('.currency').maskMoney({
            thousands: '.',
            decimal: ',',
            affixesStay: false,
            precision: 0
        })
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

                        fetch($(this).attr('action'), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
      integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
          // $(document).on('click', '.btn-preview_pdf', function() {
          //     event.preventDefault()
          //     let targetFile = $(this).attr("href")
          //     PDFObject.embed(targetFile, "#preview_pdf_div");
          //     $("#modal_preview_pdf").modal("show")
          // })

          $('.custom-file input').on('change',function(e){
              var fileName = e.target.files[0].name;
              $(this).next('.custom-file-label').html(fileName);
          })

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

      </script>
@endpush

{{-- data dosen --}}
@push('scripts')
    <script>
        $('#table-dosen').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('prodi.course.ajax.datatable.dosen', ['course_id' => $data['course']->id]) }}",
            columns: [
                {
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

        $('#nidn_dosen').val(" ")
        var nidn = '';

        select('prodi_lecture_name', '{{ route('prodi.proposal.ajax.select2.dosen.prodi') }}',1);

        $(document).on('change', '#prodi_lecture_name', function() {
            var value = $(this).val()
            nidn = value;
            $('#nidn_dosen').val(value)
        }).trigger("change");

        $(document).on('submit', '#form_dosen', function(e) {
            e.preventDefault();
            var url = $(this).attr('action')
            var id = "{{ $data['course']->id }}";
            $('#table-dosen').DataTable().ajax.reload();
            loader.show();
            postDataWithJsonStringify(url,{
                id,nidn
            })
            .then((success) =>{
                swal.fire({
                    'icon' : 'success',
                    'title' : success.message
                }).then(()=>{
                    $('#table-dosen').DataTable().ajax.reload();
                })
            })
            .catch((err)=>{
                swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => {
                loader.hide();
                $('.modal').modal('hide');
                $('#prodi_lecture_name').val("").trigger('change');
            })
        })

    </script>
@endpush

{{-- data dosen dudi --}}
@push('scripts')
    <script>
         $('#table-dosen-praktisi').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('prodi.course.ajax.datatable.dosen.dudi', ['course_id' => $data['course']['id']]) }}",
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

        selectDUDI('selectDUDI #dudi_praktisi1', '{{ route('prodi.course.ajax.select2.dudi') }}');
        selectDUDI('modal-data-praktisi-edit #dudi_praktisi2','{{ route('prodi.course.ajax.select2.dudi') }}');
        $(document).on('submit', '#form_praktisi', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var id = "{{ $data['course']['id'] }}";
                loader.show();
                postDataWithJsonStringify(url,{
                    course_id: id,
                    name: $('#modal-data-praktisi #name_praktisi1').val(),
                    position: $('#modal-data-praktisi #jabatan_praktisi1').val(),
                    dudi_id: $('#modal-data-praktisi #dudi_praktisi1').val(),
                    email: $('#modal-data-praktisi #email_praktisi1').val(),
                    phone: $('#modal-data-praktisi #contact_praktisi1').val(),
                })
                .then(result => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Diinput',
                    })
                    $('#table-dosen-praktisi').DataTable().ajax.reload();

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

            $(document).on('click', '.btn-edit-dosen-praktisi', function(e) {
                e.preventDefault()
                let id = $(this).attr('data-id');
                let url = "{{ route('prodi.course.ajax.detail.dosen.dudi', ['id' => '__id']) }}";
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
                let url = "{{ route('prodi.course.ajax.update.dosen.dudi') }}"
                var id = "{{ $data['course']['id'] }}";
                loader.show();

                postDataWithJsonStringify(url,{
                    id: $('#modal-data-praktisi-edit #id_praktisi2').val(),
                    name: $('#modal-data-praktisi-edit #name_praktisi2').val(),
                    position: $('#modal-data-praktisi-edit #jabatan_praktisi2').val(),
                    dudi_id: $('#modal-data-praktisi-edit #dudi_praktisi2').val(),
                    email: $('#modal-data-praktisi-edit #email_praktisi2').val(),
                    phone: $('#modal-data-praktisi-edit #contact_praktisi2').val(),
                })
                .then(result => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Diinput',
                    })
                    $('#table-dosen-praktisi').DataTable().ajax.reload();
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
    </script>
@endpush

{{-- data dudi --}}
@push('scripts')
    <script>

        $('#table-dudi').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('prodi.course.ajax.datatable.dudi', ['course_id' => $data['course']['id']]) }}",
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

        selectDUDI('dudi_name', '{{ route('prodi.course.ajax.select2.dudi') }}');

        $(document).on('submit', '#form_dudi', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var id = "{{ $data['course']['id'] }}";
            loader.show();
            postDataWithJsonStringify(url,{
                id,
                dudi_id: $('#dudi_name').val()
            })
            .then(result => {
                Swal.fire({
                    icon: 'success',
                    title: 'Data Berhasil Diinput',
                }).then(() =>{
                    $('#table-dudi').DataTable().ajax.reload();
                })
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


         $('#form_course_validation').submit(function() {
        event.preventDefault();
        var form1 = $(this)[0];
        let formData = new FormData(form1);
        loader.show();
        postDataWithPromise(form1.action,formData)
            .then((result)=>{
                Swal.fire({
                    icon: 'success',
                    title: result.message,
                }).then(() =>{
                    window.location.reload()
                })
            })
            .catch(err => {
                Swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => loader.hide())

    });

    $('#form-store-detail-course').submit(function() {
        event.preventDefault();
        var form1 = $(this)[0];
        let formData = new FormData(form1);
        loader.show();
        postDataWithPromise(form1.action,formData)
            .then((result)=>{
                Swal.fire({
                    icon: 'success',
                    title: result.message,
                })
            })
            .catch(err => {
                Swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => loader.hide())

    });

    </script>
@endpush



@include('layouts.button.general_action_button')


