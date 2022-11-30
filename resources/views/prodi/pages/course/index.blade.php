@extends('layouts.master')

@section('page_title', 'Course')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Course', route('prodi.course.index')]];
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
    <div class="col-md-12">
        <div class="card shadow" style="border: none">
            <div class="card-header d-flex">
                <div class="ml-auto card-tools">
                    <a class="btn btn-primary btn_tambah" data-toggle="modal" data-target="#modal-add-proposal"><i
                            class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="main-table" style="width: 100%">
                    <thead>
                        <tr>
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
                                            'options' => App\Models\Master\Course::VALIDATION_STATUS,
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
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal modal_add fade" id="modal-add-proposal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="modal-block-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Halaman Tambah Course</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('prodi.course.ajax.store.nameCourse') }}" method="post" id="form_post_course">
                    <div class="block-content font-size-sm">
                        <div class="form-group mb-3">
                            <label for="prodi">Nama Course <span class="text-danger">*</span></label>
                            <input type="text" id="proposal" class="form-control" name="name">
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
@endpush

@include('layouts.data_tables.basic_data_tables')


@push('scripts')
    <script src="{{ asset('oneUI/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/config.js') }}"></script>
@endpush



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
        integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

    $('#main-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url()->full() !!}',
            columns: [
                {
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


        $(document).on('click', '.btn-preview_pdf', function() {
            event.preventDefault()
            let targetFile = $(this).attr("href")
            PDFObject.embed(targetFile, "#preview_pdf_div");
            $("#modal_preview_pdf").modal("show")
        })

        $(document).on('submit','#form_post_course',function(e){
            e.preventDefault();
            var form1 = $(this)[0];
            let formData = new FormData(form1);
            loader.show();
            postDataWithPromise(form1.action,formData)
                .then((result)=>{
                    Swal.fire({
                        icon: 'success',
                        title: result.message,
                    }).then(() =>{
                        $('.modal_add').modal('hide');
                        $('#main-table').DataTable().draw()
                    })
                })
                .catch(err => {
                    Swal.fire({
                        'icon' : 'error',
                        'title' : err
                    })
                })
                .finally(() => loader.hide())

        })


        $(document).on('click', '.btn_tambah', function(e) {
            $('.modal_add').modal('show');
            $('.modal_add #proposal').val("")
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


    </script>
@endpush
