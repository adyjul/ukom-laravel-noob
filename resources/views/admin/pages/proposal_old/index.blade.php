@extends('layouts.master')

@section('page_title', 'Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <style>
        #main-table_filter {
            display: none;
        }

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">List Proposal</h3>
                    <div class="ml-auto card-tools">
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="main-table">
                        <thead>
                            <tr>
                                <th>Kategori Proposal</th>
                                <th>Proposal</th>
                                <th>RPS</th>
                                <th>Status Validasi</th>
                                <th>Prodi</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <th>@include(
                                    'layouts.data_tables.th_general_select',
                                    [
                                        'table_id' => 'main-table',
                                        'col' => 0,
                                        'options' => App\Models\Master\CategoryProposal::pluck(
                                            'name',
                                            'id'
                                        ),
                                    ]
                                )
                                </th>
                                <th></th>
                                <th></th>
                                <th>
                                    @include(
                                        'layouts.data_tables.th_general_select',
                                        [
                                            'table_id' => 'main-table',
                                            'col' => 3,
                                            'options' => App\Models\Master\Proposal::VALIDATION_STATUS,
                                        ]
                                    )
                                </th>
                                <th>
                                    @include(
                                        'layouts.data_tables.th_general_select',
                                        [
                                            'table_id' => 'main-table',
                                            'col' => 4,
                                            'options' => App\Models\MAA\ProgramStudi::pluck(
                                                'nama_depart',
                                                'kode'
                                            ),
                                        ]
                                    )
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
                        data: 'category_proposal_id',
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'proposal',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'rps',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'validation_status',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    },
                    {
                        data: 'prodi_id',
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

