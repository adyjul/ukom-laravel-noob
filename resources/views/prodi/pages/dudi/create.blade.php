@extends('layouts.master')

@section('page_title', 'Tambah Dudi')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Dudi', route('prodi.dudi.index')], 'Tambah'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <form action="{{ route('prodi.dudi.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data"
        id="main-form">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Dudi</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-gorup mb-3">
                            <label for="name">Nama <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="field">Bidang <span class="text-danger">*</span></label>
                            <input type="text" id="field" name="field" class="form-control" required
                                value="{{ old('field') }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="address">Alamat <span class="text-danger">*</span></label>
                            <textarea id="address" name="address" class="form-control" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="director_name">Direktur <span class="text-danger">*</span></label>
                            <input type="text" id="director_name" name="director_name" class="form-control" required
                                value="{{ old('director_name') }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="cp_name">CP <span class="text-danger">*</span></label>
                            <input type="text" id="cp_name" name="cp_name" class="form-control" required
                                value="{{ old('cp_name') }}">
                        </div>
                        <div class="form-gorup mb-3">
                            <label for="website">Laman Website <span class="text-danger">*</span></label>
                            <input type="text" id="website" name="website" class="form-control" required
                                value="{{ old('website') }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="has_mou" name="has_mou">
                            <label class="custom-control-label font-w400" for="has_mou">Sudah Memiliki MOU?</label>
                        </div>
                        <div id="div-mou" style="display: none">
                            <label for="">Uplaod MOU <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="mou" name="mou">
                                    <label class="custom-file-label" for="mou">Pilih MOU</label>
                                </div>
                            </div>
                            <small>Aturan:
                                <ul>
                                    <li>Ukuran maksimal 2MB</li>
                                    <li>File harus berupa pdf</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', 'input[type="file"]', function(e) {
                var fileName = e.target.files[0].name;
                $(this).next().html(fileName);
            });

            $('#has_mou').on('change', function() {
                if ($(this).is(":checked")) {
                    $("#div-mou").show()
                    $("#mou").attr('required', 'required')
                } else {
                    $("#div-mou").hide()
                    $("#mou").removeAttr('required')
                }
            }).trigger('change');
        })
    </script>
@endpush
