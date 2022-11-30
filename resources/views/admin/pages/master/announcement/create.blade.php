@extends('layouts.master')

@section('page_title', 'Tambah Pengumuman')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Pengumuman', route('admin.master.announcement.index')], 'Tambah'];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tambah Pengumuman Baru
                </div>
                <form action="{{ route('admin.master.announcement.createPost') }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Judul Pengumuman..." value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea name="body" id="summernote">{{ old('body') }}</textarea>
                        </div>
                        <hr>
                        <label for="">File Tambahan <span class="btn btn-sm btn-warning ml-3" id="btn_add_files"><i
                                    class="fa fa-plus"></i> Tambah File</span></label>
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Upload File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="files_tbody"></tbody>
                        </table>
                        <small>Aturan:
                            <ul>
                                <li>Maksimal 2MB tiap file</li>
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
            $('#summernote').summernote({
                placeholder: 'Tuliskan disini.',
                toolbar: [
                    ['style', ['style']],
                    ['fontname', ['fontname']],
                    ['font', ['bold', 'underline', 'italic', 'strikethrough', 'superscript',
                        'subscript', 'clear'
                    ]],
                    ['color', ['forecolor', 'backcolor']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });

            $('form').submit(function() {
                if ($('#summernote').summernote('isEmpty')) {
                    // alert('Isi / Body Tidak Boleh Kosong!')
                    Swal.fire({
                        title: "Isi Pengumuman Tidak Boleh Kosong",
                        icon: "error",
                    })
                    event.preventDefault();
                }
            })
            $(document).on('change', 'input[type="file"]', function(e) {
                var fileName = e.target.files[0].name;
                $(this).next().html(fileName);
            });

            let FileCounter = 0;
            $("#btn_add_files").click(function() {
                let tbodyElement = $("#files_tbody")
                let newTr = `
            <tr>
                <td><input type="text" name="file_name[]" class="form-control" placeholder="Nama file"
                    required>
                </td>
                <td>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="input_file" name="files[]"
                                required>
                            <label class="custom-file-label" for="input_file">Pilih file</label>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <span class="btn btn-sm btn-danger btn-delete-files"><i class="fa fa-trash"></i></span>
                </td>
            </tr>
            `;

                tbodyElement.append(newTr)

                FileCounter++;
            })

            $(document).on("click", ".btn-delete-files", function() {
                Swal.fire({
                    title: "Yakin Hapus Baris?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(this).parent().parent().remove()
                    }
                })
            })
        })
    </script>
@endpush
