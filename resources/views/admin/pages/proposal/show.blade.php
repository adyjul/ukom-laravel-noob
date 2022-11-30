@extends('layouts.master')

@section('page_title', 'Detail Proposal - ' . $data['obj']->name)

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')], 'Detail'];
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
            <div class="js-wizard-simple block shadow border-10px">
                <!-- Step Tabs -->
                <ul class="nav nav-tabs nav-tabs-block {{ $status }} nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step1" data-toggle="tab">Data Proposal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step2" data-toggle="tab">Data Dosen Perguruan
                            Tinggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step4" data-toggle="tab">Data Dosen Praktisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step3" data-toggle="tab">Data DUDI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step5" data-toggle="tab">Validasi/Kategori</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;">
                    <!-- Step 1 -->
                    <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">
                        <div class="{{ $data['obj']->proposal_files == null && $data['obj']->proposal == null ? 'd-block' : 'd-none' }} text-center" style="align-items: center">
                            <h1>belum mengupload proposal</h1>
                        </div>


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

                                </div>
                            </div>
                        @endif

                    </div>
                    <!-- END Step 1 -->

                    <!-- Step 2 -->
                    <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                        <div class="form-group">
                            {{-- <div class="ml-auto card-tools mb-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-prodi"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-vcenter" id="table-dosen"
                                    style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Dosen Prodi</th>
                                            <th style="width: 40%;">NIDN</th>
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
                        {{-- <div class="ml-auto card-tools mb-3">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-dudi"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                        </div> --}}
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
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Step 3 -->

                    <!-- Step 4-->
                    <div class="tab-pane" id="wizard-simple-step4" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" id="table-dosen-praktisi"
                                style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Nama Lengpkap</th>
                                        <th style="width: 40%;">Jabatan/Posisi`</th>
                                        <th class="text-center" style="width: 20%;">Phone</th>
                                        <th style="width: 40%;">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Step 4-->

                    {{-- START Step 5 --}}

                    <div class="tab-pane" id="wizard-simple-step5" role="tabpanel">
                        <form action="{{ route('admin.proposal.update.status', ['id' => $data['obj']->id]) }}"
                            id="form-update_status" method="post">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="category_proposal_id">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="kategori w-100" id="category_proposal_id" name="category_proposal_id"
                                    required>
                                    @foreach ($data['category_proposal'] as $category_proposal)
                                        <option value="{{ $category_proposal->id }}"
                                            {{ $category_proposal->id == $data['obj']->category_proposal_id ? 'selected' : '' }}>
                                            {{ $category_proposal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="validation_status">Status <span
                                        class="text-danger">*</span></label>
                                <select class="status w-100" id="validation_status" name="validation_status" required>
                                    @foreach ($data['validation_status'] as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ $data['obj']->validation_status == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group" id="form_alasan" style="display: none">
                                <label for="alasan">Catatan</label>
                                <textarea class="form-control" id="alasan" name="validation_message" rows="3"
                                    maxlength="2000">{{ $data['obj']->validation_message }}</textarea>
                            </div>


                            <div class="form-gorup mb-3 form_anggaran">
                                <label class="w-100" for="accepted_budget">Anggaran yang disetujui <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="accepted_budget" id="accepted_budget" class="form-control currency"
                                    value="{{ number_format($data['obj']->accepted_budget, 0, '', '.') }}"
                                    data-prefix="Rp ">
                            </div>

                            <button type="submit" class="btn btn-primary my-2">Simpan</button>
                        </form>
                    </div>
                    {{-- END Step 5 --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('layouts.parts.frontend.ceklist')
        <div class="col-md-12">
            <div class="block block-bordered" id="card_registered_user">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Riwayat Proposal</h3>
                </div>
                <div class="block-content">
                    <table class="table table-border">
                        @include(
                            'layouts.general_informations.userResponsibleStampInTable',
                            ['data' => $data['obj']]
                        )
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@include('layouts.data_tables.basic_data_tables')

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
                                 <table class="table table-bordered table-striped table-vcenter" id="table-dosen-praktisi"
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
    <script src="{{ asset('oneUI') }}/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[maxlength]').maxlength({
                alwaysShow: true,
                warningClass: "badge badge-warning",
                limitReachedClass: "badge badge-danger",
                placement: 'bottom',
            });

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


            $('.currency').maskMoney({
                thousands: '.',
                decimal: ',',
                affixesStay: false,
                precision: 0
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
                ]
            });

            function selectShort(id) {
                $(`#${id}`).select2({
                    theme: 'bootstrap4',
                    placeholder: 'Pilih Item'
                })
            }

            selectShort('category_proposal_id');
            selectShort('validation_status');

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


            $('#nidn_dosen').val(" ")
            var nidn = '';

            select('prodi_lecture_name', '{{ route('prodi.proposal.ajax.select2.dosen.prodi') }}');
            select('dudi_name', '{{ route('prodi.proposal.ajax.select2.dudi') }}');

            $(document).on('change', '#prodi_lecture_name', function() {
                var value = $(this).val()
                nidn = value;
                $('#nidn_dosen').val(value)
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
                            })
                            $('#main-table').DataTable().ajax.reload();
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

            $("#form-update_status").submit(async function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let checkvalue = [];
                $.each($("input[name='checklist']"), function(){
                    if($(this).prop("checked")){
                        checkvalue.push($(this).val());
                    }else{
                        checkvalue.push("");
                    }
                });
                var objectData = {
                    "category_proposal_id": $('#category_proposal_id').val(),
                    "validation_status": $('#validation_status').val(),
                    "accepted_budget": $("#accepted_budget").val(),
                    "checklist" : checkvalue
                };

                $('#validation_status').on('change', function() {
                    if (["2", "3"].includes($("#validation_status").val())) {
                        objectData["validation_message"] = $('#alasan').val();
                    } else {
                        $('#form_alasan').css('display', 'none');
                        $('.form_anggaran').removeClass('d-block');
                    }
                }).trigger('change')

                if ($('#alasan').val() == null || $('#alasan').val() == ' ') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Alasan harus diisi',
                    })
                }

                sendForm(url, objectData)


            })


            $('#validation_status').on('change', function() {
                if (["2", "3"].includes($("#validation_status").val())) {
                    $('#form_alasan').css('display', 'block');
                    $('.form_anggaran').css('display', 'none');
                } else {
                    $('#form_alasan').css('display', 'none');
                    $('.form_anggaran').css('display', 'block');
                }
            }).trigger('change')



            function sendForm(url, data) {
                loader.show()
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.code == 200) {
                            Swal.fire({
                                    icon: 'success',
                                    title: result.message,
                                })
                                .then((result) => {
                                    location.reload();
                                })
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
                    .finally(() => loader.hide())
            }

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
                ]
            });

        })
    </script>
@endpush
