@extends('layouts.master')

@section('page_title', 'Detail Download')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Download', route('admin.master.download.index')], 'Detail'];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Attribute Download
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $data['obj']->name }}</td>
                        </tr>
                        <tr>
                            <th>File</th>
                            <td>
                                <a href="{{ asset($data['obj']->path) }}" download><i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                        @include('layouts.general_informations.userResponsibleStampInTable',['data'=>$data['obj']])
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
                        @can('restore Master_Download')
                            <x-forms.form-delete action="{{ route('admin.master.download.restore') }}"
                                class="_form_with_confirm" data-title="Yakin Mengembalikan Download?">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <button type="submit" class="btn btn-app btn-primary"><i class="fas fa-trash-restore"></i>
                                    Restore</button>
                            </x-forms.form-delete>
                        @endcan
                    @else
                        @can('update Master_Download')
                            <a href="{{ route('admin.master.download.edit', ['id' => $data['obj']->id]) }}"
                                class="btn btn-app btn-success mr-2"><i class="fas fa-pen"></i> Edit</a>
                        @endcan
                        @can('delete Master_Download')
                            <x-forms.form-delete action="{{ route('admin.master.download.delete') }}"
                                class="_form_with_confirm" data-title="Yakin Hapus Download?">
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

@push('scripts')
@endpush
