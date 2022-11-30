@extends('layouts.master')

@section('page_title', 'Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('prodi.proposal.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('oneUI/css/sweetalert2.min.css') }}">
@endpush

@push('styles')
    <style>
        /* #main-table_filter {
                            display: none;
                        } */

        .card-custom {
            border-style: none;
            cursor: pointer;
            background-color: #c6d7e6 !important;
        }

        .card-custom.active {
            transition: .2s all ease-in-out;
            background-color: #30c78d !important;
            color: white;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <div data-menu="proposal-saya" class="card select_card_menu card-custom active">
                <div class="d-flex justify-content-center">
                    <p class="my-4 mb-0 font-weight-bold"> <i class="fas fa-book mx-2"></i>Proposal Saya</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div data-menu="proposal-kolaborasi" class="card select_card_menu card-custom">
                <div class="d-flex justify-content-center">
                    <p class="my-4 mb-0 font-weight-bold"> <i class="fas fa-book-medical mx-2"></i>Proposal Kolaborasi</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12" id="proposal-saya">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">Data Proposal Saya</h3>
                    <div class="ml-auto card-tools">
                        @can('create Prodi_Menu_Proposal')
                            <a class="btn btn-primary btn_tambah" data-toggle="modal" data-target="#modal-data-proposal"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                        @endcan
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" id="main-table"
                            style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Course</th>
                                    <th>Status Validasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        @include('layouts.data_tables.th_general_select', [
                                            'table_id' => 'main-table',
                                            'col' => 1,
                                            'options' => App\Models\Master\Proposal::VALIDATION_STATUS,
                                        ])
                                    </th>
                                    <th>
                                        @include('layouts.data_tables.th_status', [
                                            'model' => $data['model'],
                                            'table_id' => 'main-table',
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
            <div class="modal modal_add fade" id="modal-data-proposal" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="modal-block-popout" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Halaman Tambah COE</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('prodi.proposal.storeName') }}" method="post" id="form_proposal">
                                <div class="block-content font-size-sm">
                                    <div class="form-group mb-3">
                                        <label for="prodi">Nama COE <span class="text-danger">*</span></label>
                                        <input type="text" id="proposal" class="form-control" name="nama_proposal">
                                    </div>
                                    
                                    <div class="">
                                        <button class="btn btn-primary btn-submit-name mr-auto mb-3"
                                            type="submit">Simpan</button>
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

            <div class="modal modal_edit fade" id="modal-data-proposal" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="modal-block-popout" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Tambah List Proposal</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('prodi.proposal.updateName', ['id' => '__id']) }}" method="post"
                                id="form_proposal_update">
                                <div class="block-content font-size-sm">

                                    <div class="form-group mb-3">
                                        <label for="prodi">Nama COE <span class="text-danger">*</span></label>
                                        <input type="text" id="proposal" class="form-control" name="nama_proposal">
                                    </div>
                                    <div class="">
                                        <button class="btn btn-primary btn-submit-name-edit mr-auto mb-3"
                                            type="submit">Simpan</button>
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
        </div>


        <div class="col-md-12" id="proposal-kolaborasi" style="display: none">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">Data Proposal Kolaborasi</h3>

                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="width: 100%">
                        <table class="table table-bordered table-striped table-vcenter" id="proposal_kolaborasi"
                            style="width: 100% !important;">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama COE</th>
                                    <th>Status Validasi</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        @include('layouts.data_tables.th_general_select', [
                                            'table_id' => 'proposal_kolaborasi',
                                            'col' => 1,
                                            'options' => App\Models\Master\Proposal::VALIDATION_STATUS,
                                        ])
                                    </th>
                                    <th>
                                        @include('layouts.data_tables.th_status', [
                                            'model' => $data['model'],
                                            'table_id' => 'proposal_kolaborasi',
                                        ])
                                    </th>
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


@push('scripts')
    <script>
        $('.select_card_menu').click(function() {
            $('.select_card_menu').removeClass('active');
            $(this).addClass('active');
            var value = $(this).attr("data-menu");
            if (value == "proposal-saya") {
                $(`#${value}`).show()
                $('#proposal-kolaborasi').hide()
            } else {
                $(`#${value}`).show()
                $('#proposal-saya').hide()
            }

        })
    </script>
@endpush


@push('scripts')
    <script src="{{ asset('oneUI/js/sweetalert2.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#main-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url()->full() !!}',
                columns: [{
                        data: 'name',
                    },
                    {
                        data: 'validation_status',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'status',
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

            $('#proposal_kolaborasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('prodi.proposal.ajaxdatatable.list.collab.proposal') }}',
                columns: [{
                        data: 'name',
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

            $(document).on('click', '.btn_tambah', function(e) {
                $('.modal_add').modal('show');
                $('.modal_add #proposal').val("")
            })

            $(document).on('submit', '#form_proposal', function(e) {
                e.preventDefault()
                var url = "{{ route('prodi.proposal.storeName') }}";
                loader.show();

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            nama_proposal: $("#proposal").val(),
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diinput',
                            })
                            $('#main-table').DataTable().draw()
                        } else {
                            throw data.mesage
                        }
                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: 'error',
                            title: err,
                        })
                    })
                    .finally(() => {
                        $('.modal_add').modal('hide');
                        loader.hide();
                    })
            })

            $(document).on('click', '.btn_hapus', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Anda Yakin Untuk Mengahapus ?',
                    text: "Klik iya untuk melanjutkan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Saya Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        loader.show()
                        $.ajax({
                            url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Data Berhasil Dihapus',
                                    })
                                    $('#main-table').DataTable().draw()
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Data Gagal Dihapus',
                                    })
                                    $('#main-table').DataTable().draw()
                                }
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data Gagal Dihapus',
                                })
                            },
                            complete: function(data) {
                                loader.hide()
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.btn_restore', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Anda Yakin Untuk Mengembalikan ?',
                    text: "Klik iya untuk melanjutkan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        loader.show()
                        $.ajax({
                            url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Data Berhasil Dikembalikan',
                                    })
                                    $('#main-table').DataTable().draw()
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Data Gagal Dikembalikan',
                                    })
                                    $('#main-table').DataTable().draw()
                                }
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data Gagal Dihapus',
                                })
                            },
                            complete: function(data) {
                                loader.hide()
                            }
                        });
                    }
                })
            });

            var idItem = '';

            $(document).on('click', '.btn_edit', function(e) {
                e.preventDefault()
                let url = $(this).attr('href');
                loader.show();
                $('.modal_edit').modal('show');
                fetch(url)
                    .then(response => response.json())
                    .then(result => {
                        idItem = result.data.id
                        $('.modal_edit #proposal').val(result.data.name)
                    })
                    .catch(err => console.log('gagal'))
                    .finally(() => {
                        loader.hide()
                    })
            })

            $(document).on('submit', '#form_proposal_update', function(e) {
                e.preventDefault()
                var url = $(this).attr('action');
                url = url.replace('__id', idItem);
                loader.show();
                fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            nama_proposal: $(".modal_edit #proposal").val(),
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diupdate',
                            })
                            $('#main-table').DataTable().draw()
                        } else {
                            throw data.mesage
                        }

                    })
                    .catch((err) => {
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

        });
    </script>
@endpush

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
