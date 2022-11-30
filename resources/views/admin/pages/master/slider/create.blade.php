@extends('layouts.master')

@section('page_title', 'Tambah Slider')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Slider', route('admin.master.slider.index')]];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tambah Slider Baru
                </div>
                <form action="{{ route('admin.master.slider.createPost') }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Judul Slider..."
                                value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Deskripsi</label>
                            <textarea name="description" class="form-control" id="summernote">{{ old('description') }}</textarea>
                        </div>
                        <hr>
                        @php
                            $note = ['Ukuran file maksimal 2MB', 'File harus berupa gambar', 'Disarankan menggunakan gambar berdimensi 1x1 (persegi)'];
                        @endphp
                        <x-forms.input-image-with-preview img-preview-id="img_preview" label="Foto Slider"
                            is-required="TRUE" input-name="image" :notes="$note" />
                        <hr>
                        <h3>Tombol tambahan</h3>
                        <span class="btn btn-sm btn-success mb-2" id="btn_add_button"><i class="fa fa-plus"></i> Tambah
                            Tombol</span>
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Teks Tombol</th>
                                        <th>Url Tombol</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="button_tbody">

                                </tbody>
                            </table>
                        </div>
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
        $('#btn_add_button').click(function() {
            let newTr = `
            <tr>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" id="button_text"
                            name="button_text[]" placeholder="Teks Pada Tombol..." value=""
                            required>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" id="button_url"
                            name="button_url[]" placeholder="Url Tombol Saat Diklik..." value=""
                            required>
                    </div>
                </td>
                 <td class="text-center">
                    <span class="btn btn-sm btn-danger btn_delete_button"><i
                            class="fa fa-trash"></i></span>
                </td>
            </tr>
            `;
            $("#button_tbody").append(newTr)
        })

        $(document).on('click', ".btn_delete_button", function() {
            Swal.fire({
                'icon': 'question',
                title: 'Yakin hapus data?',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: `Batal.`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(this).parent().parent().remove()
                }
            })
        })
    </script>
@endpush
