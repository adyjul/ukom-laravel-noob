@extends('layouts.master')

@section('page_title', 'Tambah Download File')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Download File', route('admin.master.download.index')], 'Tambah'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tambah Download File Baru
                </div>
                <form action="{{ route('admin.master.download.createPost') }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama File <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama file"
                                value="{{ old('name') }}" required>
                        </div>
                        <label for="">File <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_file" name="file" required>
                                <label class="custom-file-label" for="input_file">Pilih file</label>
                            </div>
                        </div>
                        <small>Aturan:
                            <ul>
                                <li>Ukuran maksimal 2MB</li>
                                <li>File harus berupa gambar/pdf/word/excel</li>
                            </ul>
                        </small>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('layouts.wysiwyg.summernote')
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
