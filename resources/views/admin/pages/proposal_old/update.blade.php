@extends('layouts.master')

@section('page_title', 'Edit Proposal')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')], ['Detail', route('admin.proposal.show', ['id' => $data['obj']->id])], 'Edit'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Edit Proposal
                </div>
                <form action="{{ route('admin.proposal.update', ['id' => $data['obj']->id]) }}" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h3>Data Proposal</h3>
                        <div class="form-group">
                            <label for="category">Kategori <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-control">
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($data['categories'] as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ $data['obj']->category_proposal_id == $k ? 'selected' : '' }}>
                                        {{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="">Proposal
                            <span class="text-danger">*</span>
                            <a href="{{ asset($data['obj']->proposal) }}"
                                class="btn btn-rounded bg-flat text-light btn-preview_pdf" data-toggle="tooltip"
                                data-placement="top" title="Lihat Proposal Lama"><i class="fa fa-eye"></i></a>
                        </label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="proposal" name="proposal">
                                <label class="custom-file-label" for="proposal">Pilih Proposal</label>
                            </div>
                        </div>
                        <label for="">RPS
                            <span class="text-danger">*</span>
                            <a href="{{ asset($data['obj']->rps) }}"
                                class="btn btn-rounded bg-flat text-light btn-preview_pdf" data-toggle="tooltip"
                                data-placement="top" title="Lihat RPS Lama"><i class="fa fa-eye"></i></a>
                        </label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="rps" name="rps">
                                <label class="custom-file-label" for="rps">Pilih RPS</label>
                            </div>
                        </div>
                        <small>Aturan:
                            <ul>
                                <li>Ukuran maksimal 2MB</li>
                                <li>File harus berupa pdf</li>
                                <li>Kosongkan jika tidak ingin merubah Proposal atau RPS</li>
                            </ul>
                        </small>
                        <hr>
                        <h3>Data Prodi dan Dudi</h3>
                        <div class="form-gorup mb-3">
                            <label for="prodi">Nama Prodi <span class="text-danger">*</span></label>
                            <input type="text" id="prodi" disabled class="form-control"
                                value="{{ $data['prodi']->nama_depart }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="kaprodi">Nama KaProdi <span class="text-danger">*</span></label>
                            <input type="text" id="kaprodi" disabled class="form-control"
                                value="{{ $data['kaprodi']->namaDosen . $data['kaprodi']->gelarLengkap }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="dudi_name">Nama Dudi <span class="text-danger">*</span></label>
                            <input type="text" id="dudi_name" name="dudi_name" class="form-control"
                                value="{{ $data['obj']->dudi['name'] }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="dudi_field">Bidang Dudi <span class="text-danger">*</span></label>
                            <input type="text" id="dudi_field" name="dudi_field" class="form-control"
                                value="{{ $data['obj']->dudi['field'] }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="prodi_lecture_name">Dosen Prodi <span class="text-danger">*</span></label>
                            <input type="text" id="prodi_lecture_name" name="prodi_lecture_name" class="form-control"
                                value="{{ $data['obj']->prodi['lecture'] }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="dudi_lecture">Dosen Dudi <span class="text-danger">*</span></label>
                            <input type="text" id="dudi_lecture" name="dudi_lecture" class="form-control"
                                value="{{ $data['obj']->dudi['lecture'] }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="prodi_instructure_name">Instruktur dari Prodi <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="prodi_instructure_name" name="prodi_instructure_name"
                                class="form-control" value="{{ $data['obj']->prodi['instructure'] }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="dudi_instructure_name">Instruktur dari Dudi <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="dudi_instructure_name" name="dudi_instructure_name"
                                class="form-control" value="{{ $data['obj']->dudi['instructure'] }}">
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', 'input[type="file"]', function(e) {
                var fileName = e.target.files[0].name;
                $(this).next().html(fileName);
            });
        })
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
