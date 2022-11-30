@extends('layouts.master')

@section('page_title', 'Detail Pengumuman')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Pengumuman', route('admin.master.announcement.index')], 'Detail'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Attribute Pengumuman
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Judul</th>
                            <td>{{ $data['obj']->title }}</td>
                        </tr>
                        <tr>
                            <th>Isi Pengumuman</th>
                            <td>
                                @php
                                    echo $data['obj']->body;
                                @endphp
                            </td>
                        </tr>
                        @include(
                            'layouts.general_informations.userResponsibleStampInTable',
                            ['data' => $data['obj']]
                        )
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    File Tambahan
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($data['obj']->attachments as $attachment)
                            <li>
                                <a href="{{ asset($attachment->path) }}" target="_blank" download=""><i
                                        class="fa fa-download"></i>
                                    {{ $attachment->name }}.{{ pathinfo($attachment->path)['extension'] }}</a>
                            </li>
                        @endforeach
                    </ul>
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
                        @can('restore Master_Pengumuman')
                            <x-forms.form-delete action="{{ route('admin.master.announcement.restore') }}"
                                class="_form_with_confirm" data-title="Yakin Mengembalikan Pengumuman?">
                                <input type="hidden" name="id" value="{{ $data['obj']->id }}">
                                <button type="submit" class="btn btn-app btn-primary"><i class="fas fa-trash-restore"></i>
                                    Restore</button>
                            </x-forms.form-delete>
                        @endcan
                    @else
                        @can('update master_announcement')
                            <a href="{{ route('admin.master.announcement.edit', ['id' => $data['obj']->id]) }}"
                                class="btn btn-app btn-success mr-2"><i class="fas fa-pen"></i> Edit</a>
                        @endcan
                        @can('delete master_announcement')
                            <x-forms.form-delete action="{{ route('admin.master.announcement.delete') }}"
                                class="_form_with_confirm" data-title="Yakin Hapus Pengumuman?">
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
