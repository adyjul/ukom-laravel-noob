@extends('layouts.master')

@section('page_title', 'Detail Dudi')

@section('breadcrumb')
    @php
    $breadcrumbs = [['Dudi', route('prodi.dudi.index')], ['Detail', route('prodi.dudi.show', ['id' => $data['obj']->id])]];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Attribute Dudi
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $data['obj']->name }}</td>
                        </tr>
                        <tr>
                            <th>Field</th>
                            <td>{{ $data['obj']->field }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $data['obj']->address }}</td>
                        </tr>
                        <tr>
                            <th>Direktur</th>
                            <td>{{ $data['obj']->director_name }}</td>
                        </tr>
                        <tr>
                            <th>CP</th>
                            <td>{{ $data['obj']->cp_name }}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td><a class="badge badge-success" target="_blank" href="//{{ $data['obj']->website }}">{{ $data['obj']->website }}</a></td>
                        </tr>
                        @if ($data['obj']->mou != null)
                            <tr>
                                <th>MOU</th>
                                <td>
                                    <a href="{{ asset($data['obj']->mou) }}"
                                        class="btn btn-primary btn-rounded btn-preview_pdf">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
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
                <div class="card-body d-flex justify-content-center">
                    @if ($data['obj']->trashed())
                        @can('restore Prodi_Menu_Dudi')
                            <x-forms.form-delete action="{{ route('prodi.dudi.restore') }}" class="_form_with_confirm"
                                data-title="Yakin Mengembalikan Dudi?">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <button type="submit" class="btn btn-app btn-primary"><i class="fas fa-trash-restore"></i>
                                    Restore</button>
                            </x-forms.form-delete>
                        @endcan
                    @else
                        @can('update Prodi_Menu_Dudi')
                            <a href="{{ route('prodi.dudi.edit', ['id' => $data['obj']->id]) }}"
                                class="btn btn-app btn-success mr-2"><i class="fas fa-pen"></i> Edit</a>
                        @endcan
                        @can('delete Prodi_Menu_Dudi')
                            <x-forms.form-delete action="{{ route('prodi.dudi.delete') }}" class="_form_with_confirm"
                                data-title="Yakin Hapus Dudi?">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <button class="btn btn-app btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                    Delete</button>
                            </x-forms.form-delete>
                        @endcan
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
