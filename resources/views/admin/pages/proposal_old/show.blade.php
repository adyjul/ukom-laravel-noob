@extends('layouts.master')

@section('page_title', 'Detail Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')], ['Detail', route('admin.proposal.show', ['id' => $data['obj']->id])]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Attribute Proposal
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $data['obj']->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Proposal</th>
                            <td>
                                <a href="{{ asset($data['obj']->proposal) }}"
                                    class="btn btn-rounded bg-flat text-light btn-preview_pdf"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <th>RPS</th>
                            <td>
                                <a href="{{ asset($data['obj']->rps) }}"
                                    class="btn btn-rounded bg-flat text-light btn-preview_pdf"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Dudi</th>
                            <td>{{ $data['obj']->dudi['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Bidang Dudi</th>
                            <td>{{ $data['obj']->dudi['field'] }}</td>
                        </tr>
                        <tr>
                            <th>Dosen Dudi</th>
                            <td>{{ $data['obj']->dudi['lecture'] }}</td>
                        </tr>
                        <tr>
                            <th>Instruktur Dudi</th>
                            <td>{{ $data['obj']->dudi['instructure'] }}</td>
                        </tr>
                        <tr>
                            <th>Dosen Prodi</th>
                            <td>{{ $data['obj']->prodi['lecture'] }}</td>
                        </tr>
                        <tr>
                            <th>Instuktur Prodi</th>
                            <td>{{ $data['obj']->prodi['instructure'] }}</td>
                        </tr>
                        <tr>
                            <th>Status Validasi</th>
                            <td>{{ $data['obj']->validation_status_text }}</td>
                        </tr>
                        @if (in_array($data['obj']->validation_status, [2, 3]))
                            <tr>
                                <th>Pesan Validasi</th>
                                <td>{{ $data['obj']->validation_message }}</td>
                            </tr>
                        @endif
                        @include(
                            'layouts.general_informations.userResponsibleStampInTable',
                            ['data' => $data['obj']]
                        )
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Aksi
                </div>
                <div class="row card-body d-flex justify-content-center">
                    <div class="col-md-12 d-flex justify-content-center mb-3">
                        <a href="{{ route('admin.proposal.edit', ['id' => $data['obj']->id]) }}"
                            class="btn btn-app btn-info"><i class="fas fa-pen"></i> Edit</a>
                    </div>

                    @if ($data['obj']->validation_status != 4)
                        <div class="col-md-3">
                            <x-forms.form-put action="{{ route('admin.proposal.validation') }}"
                                class="_form_with_confirm" data-title="Yakin Terima Proposal?">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <input type="hidden" name="validation_status" value="4">
                                <button class="btn btn-sm btn-success" type="submit">
                                    <i class="fas fa-check"></i>
                                    Terima</button>
                            </x-forms.form-put>
                        </div>
                    @endif

                    @if ($data['obj']->validation_status != 3)
                        <div class="col-md-3">
                            <x-forms.form-put action="{{ route('admin.proposal.validation') }}"
                                class="_form_with_confirm_message" data-title="Masukkan Alasan Revisi">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <input type="hidden" name="validation_status" value="3">
                                <button class="btn btn-sm btn-warning" type="submit">
                                    <i class="fas fa-question"></i>
                                    Revisi</button>
                            </x-forms.form-put>
                        </div>
                    @endif

                    @if ($data['obj']->validation_status != 2)
                        <div class="col-md-3">
                            <x-forms.form-put action="{{ route('admin.proposal.validation') }}"
                                class="_form_with_confirm_message" data-title="Masukkan Alasan Tolak">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <input type="hidden" name="validation_status" value="2">
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-times"></i>
                                    Tolak</button>
                            </x-forms.form-put>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

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
