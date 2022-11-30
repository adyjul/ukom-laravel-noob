@extends('layouts.master')

@section('page_title', 'Laporan Jumlah Proposal Prodi')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Laporan', 'Jumlah Proposal Prodi'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="block" id="block-main">
                <div class="block-header block-header-default">
                    <h5 class="block-title">Jumlah Proposal Prodi</h5>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="form-group col-md-4 mb-0">
                            <div class="input-group mb-3">
                                <input type="text" class="js-datepicker form-control" id="tahun_upload" name="tahun_upload"
                                    data-autoclose="true" data-today-highlight="true" data-date-format="yy"
                                    placeholder="Tahun Upload Proposal">
                                {{-- <div class="input-group-append">
                                    <button class="btn btn-success" id="btn-search-year"><i class="fa fa-search"
                                            aria-hidden="true"></i></button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div id="div-pilihan-laporan" style="display: none">
                        <hr>
                        <h5>Pilihan Laporan</h5>
                        <ul>
                            <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.has.been.upload', ['year' => '__year']) }}"
                                    class="li-lihat-data" data-title="Program Studi yang Sudah Upload Proposal">Prodi Sudah
                                    Upload Proposal</a></li>
                            <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.not.upload.yet', ['year' => '__year']) }}"
                                    class="li-lihat-data" data-title="Program Studi yang Belum Upload Proposal">Prodi Belum
                                    Upload Proposal</a></li>
                            <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.get.data.by.validation.status', ['year' => '__year', 'valdiation_status' => '4']) }}"
                                    class="li-lihat-data" data-title="Program Studi Dengan Proposal Status Diterima">Prodi
                                    Status Diterima</a></li>
                            <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.get.data.by.validation.status', ['year' => '__year', 'valdiation_status' => '2']) }}"
                                    class="li-lihat-data" data-title="Program Studi Dengan Proposal Status Ditolak">Prodi
                                    Status Ditolak</a></li>
                            <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.get.data.by.validation.status', ['year' => '__year', 'valdiation_status' => '3']) }}"
                                    class="li-lihat-data" data-title="Program Studi Dengan Proposal Status Revisi">Prodi
                                    Status Revisi</a></li>
                            @foreach ($data['category_proposal'] as $category_proposal)
                                <li><a href="{{ route('admin.laporan.jumlah-proposal-prodi.get.data.by.category', ['year' => '__year', 'category' => $category_proposal->id]) }}"
                                        class="li-lihat-data">Prodi Status {{ $category_proposal->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="div-table-laporan" style="display: none">
                        <hr>
                        <h5>Laporan</h5>
                        <table class="table table-bordered" id="table-main">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Prodi</th>
                                    <th>Jumlah Proposal</th>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('oneUI') }}/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
@endpush

@include('layouts.data_tables.basic_data_tables')
@include('layouts.images_viewer.lightbox')
@include('layouts.data_tables.data_tables_button')

@push('scripts')
    <script src="{{ asset('oneUI') }}/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            const $block_main = $("#block-main");
            const $tahun_upload = $("#tahun_upload");
            const $btn_search_year = $("#btn-search-year");
            const $div_pilih_laporan = $("#div-pilihan-laporan");
            const $div_table_laporan = $("#div-table-laporan");
            const $li_lihat_data = $(".li-lihat-data");
            const $table_main = $("#table-main");

            $(".js-datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $($tahun_upload).change(function() {
                const val = $(this).val();
                $div_table_laporan.hide();
                if (!['', null, undefined].includes(val))
                    $($div_pilih_laporan).show();
                else
                    $($div_pilih_laporan).hide();

            });

            $($btn_search_year).click(function() {
                let year = $tahun_upload.val();
                if (['', null, undefined].includes(year)) {
                    Toast.error('Error', 'Tahun wajib diisi!');
                    return;
                }
            });

            $($li_lihat_data).click(function() {
                event.preventDefault();
                One.block('state_loading', $block_main);
                $div_table_laporan.show();
                $(`#${$table_main.attr('id')}`).DataTable().clear().destroy();
                let url = $(this).attr("href");
                url = url.replace('__year', $tahun_upload.val());
                const title = $(this).data('title') + " Tahun " + $tahun_upload.val();
                fetch(url)
                    .then(resp => resp.json())
                    .then(data => {
                        let innerTable = "";

                        let i = 1;
                        Object.keys(data.prodi).forEach(function(id) {
                            innerTable += `<tr>
                                    <td>${i++}</td>
                                    <td>${data.prodi[id]}</td>
                                    <td>${data.proposal_counter[id]}</td>
                                </tr>`;
                        });

                        $(`#${$table_main.attr('id')} tbody`).html(innerTable);
                    })
                    .catch(err => {
                        Toast.error(err);
                    })
                    .finally(() => {
                        One.block('state_normal', $block_main);
                        $(`#${$table_main.attr('id')}`).dataTable({
                            pageLength: 10,
                            lengthMenu: [
                                [5, 10, 15, 20],
                                [5, 10, 15, 20]
                            ],
                            autoWidth: !1,
                            buttons: [{
                                    extend: "copy",
                                    title,
                                    className: "btn btn-sm btn-alt-primary"
                                }, {
                                    extend: "csv",
                                    title,
                                    className: "btn btn-sm btn-alt-primary"
                                }, {
                                    extend: "print",
                                    title,
                                    className: "btn btn-sm btn-alt-primary"
                                },
                                {
                                    extend: 'excelHtml5',
                                    title,
                                    className: "btn btn-sm btn-alt-primary"
                                },
                                {
                                    extend: 'pdfHtml5',
                                    title,
                                    className: "btn btn-sm btn-alt-primary"
                                }
                            ],
                            dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                        })
                    });
                return;
            });



        });
    </script>
@endpush
