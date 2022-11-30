@extends('layouts.master-frontend')

@push('styles')
@endpush

@section('content')
    <div id="alur" class="content-menu">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    'Beranda' => route('home.index'),
                    'Download' => '',
                ];
            @endphp
            @include('layouts.parts.frontend.breadcrub',['datas'=>$breadcrumbs])
            <div class="card card-custom p-3 border-card mb-5">
                <p class="text-center font-weight-bold judul" style="font-size:30px;margin-bottom:20px;margin-top:10px;">
                    Alur
                </p>
                <hr>
                <div class="image">
                    <img src="{{ asset('frontend/images/0002.jpg') }}" class="w-100 h-100" alt="" srcset="">
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
