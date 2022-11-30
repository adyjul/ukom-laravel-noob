@extends('layouts.master')

@section('page_title', 'Dudi')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Dudi', route('prodi.dudi.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">List Dudi</h3>
                    <div class="ml-auto card-tools">
                        @can('create Prodi_Menu_Dudi')
                            <a class="btn btn-primary" href="{{ route('prodi.dudi.create') }}"><i class="fa fa-plus"
                                    aria-hidden="true"></i> Tambah</a>
                        @endcan
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="main-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Bidang</th>
                                <th>Nama Direktur</th>
                                <th>CP</th>
                                <th>MOU</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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
    </div>
@endsection

@include('layouts.data_tables.basic_data_tables')

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
                        data: 'field',
                    },
                    {
                        data: 'director_name',
                    },
                    {
                        data: 'cp_name',
                    },

                    {
                        data: 'mou',
                        searchable: false,
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
