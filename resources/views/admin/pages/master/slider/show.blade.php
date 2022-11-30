@extends('layouts.master')

@section('page_title', 'Slider')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Slider', route('admin.master.slider.index')]];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Attribute Slider
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Judul</th>
                            <td>{{ $data['slider']->title }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>
                                @php
                                    echo $data['slider']->description;
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>Foto Slider</th>
                            <td>
                                <a href="{{ asset($data['slider']->image_path) }}" data-lightbox="image-1"
                                    data-title="{{ $data['slider']->title }}">
                                    <img src="{{ $data['slider']->thumbnail('image_path') }}"
                                        alt="{{ $data['slider']->title }}" data-toggle="tooltip" data-placement="bottom"
                                        title="Klik Untuk Lihat Gambar Ukuran Penuh">
                                </a>
                            </td>
                        </tr>
                        @if (count($data['slider']->button) != 0)
                            <tr>
                                <th>Tombol Tambahan</th>
                                <td>
                                    @foreach ($data['slider']->button as $button)
                                        <a href="{{ $button['url'] }}" class="btn btn-primary"
                                            target="_blank">{{ $button['text'] }}</a>
                                    @endforeach
                                </td>
                        @endif
                        @include('layouts.general_informations.userResponsibleStampInTable',['data'=>$data['slider']])
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
                    @if ($data['slider']->trashed())
                        @can('restore Master_Slider')
                            <x-forms.form-delete action="{{ route('admin.master.slider.restore') }}"
                                class="_form_with_confirm" data-title="Yakin Mengembalikan Slider?">
                                <input type="hidden" name="id" value="{{ $data['slider']->id }}">
                                <button type="submit" class="btn btn-app btn-primary"><i class="fas fa-trash-restore"></i>
                                    Restore</button>
                            </x-forms.form-delete>
                        @endcan
                    @else
                        @can('update Master_Slider')
                            <a href="{{ route('admin.master.slider.edit', ['id' => $data['slider']->id]) }}"
                                class="btn btn-app btn-success mr-2"><i class="fas fa-pen"></i> Edit</a>
                        @endcan
                        @can('delete Master_Slider')
                            <x-forms.form-delete action="{{ route('admin.master.slider.delete') }}"
                                class="_form_with_confirm" data-title="Yakin Hapus Slider?">
                                <input type="hidden" name="id" value="{{ $data['slider']->id }}">
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

@include('layouts.images_viewer.lightbox')
