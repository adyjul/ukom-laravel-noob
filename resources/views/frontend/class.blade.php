@extends('layouts.master-frontend')

@push('styles')
    <link rel="stylesheet" href="style.css">
    <style>
        .top-card{
            height: 10px;
        }
        .table td, .table th{
            border-top: none;
        }

        .bg-icon{
            font-size: 15rem;
            position: absolute;
            z-index: 0;
            opacity: 0.2;
            bottom: -2rem;
            right: -2rem;
        }

        .nav-group.nav-group-outline {
            width: 20rem !important;
            background-color:
            #ececec;
            border: 0px solid #b5b5c3;
        }
        .btn.btn-color-gray-400 {
            color: #900;
        }

        .hide-element{
            display: none !important;
        }
        .active-tab {
            background-color: #3a3a64;
            color: #fff !important;
            box-shadow: 0.3rem 0.3rem 0.6rem #c8d0e7, -0.2rem -0.2rem 0.5rem #fff;
        }
        .nav-group {
            padding: 0.55rem;
            border-radius: 0.95rem;
        }

        .btn {
        border-radius: 14px;
        }

    </style>
@endpush

@section('content')
    <div id="alur" class="content-menu">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    'Beranda' => route('home.index'),
                    'My Class' => '',
                ];
            @endphp
            @include('layouts.parts.frontend.breadcrub',['datas'=>$breadcrumbs])
            <div class="card card-custom p-3 border-card mb-5">
                <div class="nav-group shadow nav-group-outline d-flex justify-content-center mx-auto" style="margin-bottom: 30px" data-kt-buttons="true" data-kt-initialized="1">
                    @if (auth()->user()->user_type != 4 || auth()->guard('mahasiswa_umm')->check())
                    <button class="btn btn-color-gray-400 btn-active mx-2 active-tab" value="1" id="m-button">Kelas CoE </button>
                @endif
                <button class="btn btn-color-gray-400 btn-active mx-2 @if (auth()->user()->user_type == 4 )active-tab @endif" id="f-button">Short Course</button>
                </div>
                <hr>
                @php
                    $status = [0 => 'warning',1 =>'danger',2 => 'success'];
                    $icon = [ 0 => 'fa fa-history',1=>'fas fa-times-circle',2=>'fas fa-check-circle'];
                @endphp



                @if (count($data['coe']) > 0)
                    <div id="coe" class="row d-flex justify-content-center" @if (auth()->user()->user_type == 4 ) style="display: none" @endif>
                        @foreach ($data['coe'] as $d)
                            @if($d->proposal != null)
                            <div class="col-md-6">
                                <div class="card card-custom shadow" style="overflow: hidden">
                                    <div class="top-card bg-{{ $status[$d['validation_status']] }}"></div>
                                    <div class="card-body">
                                        <div class="judul-card" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            {{-- <p class="text-muted font-weight-bold mb-0">Nama Kelas : </p> --}}
                                            <h4 class="font-weight-bold text-center">{{ $d['proposal']['name'] }}</h4>
                                        </div>
                                        <hr>
                                        <table class="table" class="collapse" id="collapseExample">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        Prodi
                                                    </th>
                                                    <td class="text-muted">
                                                        {{ $d['proposal']['program_studi_name'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Tanggal Mendaftar
                                                    </th>
                                                    <td class="text-muted">
                                                        {{
                                                            $d->getFormattedDateColumnAttribute('created_at')
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <td>
                                                        <p class="mb-0 mt-0 badge badge-{{ $status[$d['validation_status']] }}">{{ $d['validation_status_text'] }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <i class=" {{  $icon[$d['validation_status']] }} bg-icon text-{{$status[$d['validation_status']]}}  "></i>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div id="coe" @if (auth()->user()->user_type == 4 ) style="display: none" @endif>
                        <p style="display: flex;justify-content: center;font-weight: bold;">Anda belum mendaftar</p>
                    </div>
                @endif
                @if (count($data['course']) > 0)
                    <div id="course" class="row d-flex justify-content-center hide-element"  @if (auth()->user()->user_type != 4 || auth()->guard('mahasiswa_umm')->check()) style="display: none" @endif>
                        @foreach ($data['course'] as $d)
                            <div class="col-md-6">
                                <div class="card card-custom shadow" style="overflow: hidden">
                                    <div class="top-card bg-{{ $status[$d['validation_status']] }}"></div>
                                    <div class="card-body">
                                        <div class="judul-card" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            {{-- <p class="text-muted font-weight-bold mb-0">Nama Kelas : </p> --}}
                                            <h4 class="font-weight-bold text-center">{{ $d['course']['name'] }}</h4>
                                        </div>
                                        <hr>
                                        <table class="table" class="collapse" id="collapseExample">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        Prodi
                                                    </th>
                                                    <td class="text-muted">
                                                        {{ $d['course']['program_studi_name'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Tanggal Mendaftar
                                                    </th>
                                                    <td class="text-muted">
                                                        {{
                                                            $d->getFormattedDateColumnAttribute('created_at')
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <td>
                                                        <p class="mb-0 mt-0 badge badge-{{ $status[$d['validation_status']] }}">{{ $d['validation_status_text'] }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <i class=" {{  $icon[$d['validation_status']] }} bg-icon text-{{$status[$d['validation_status']]}}  "></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div id="course" class="row d-flex justify-content-center  @if (auth()->user()->user_type != 4 || auth()->guard('mahasiswa_umm')->check()) hide-element @endif">
                        <p style="display: flex;justify-content: center;font-weight: bold;">Anda belum mendaftar</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
         $( "#m-button" ).click(function() {
            $("#m-button").addClass("active-tab");
            $("#f-button").removeClass("active-tab");
            $('#coe').removeClass('hide-element');
            $('#course').addClass('hide-element');

        });
        $( "#f-button" ).click(function() {
            $("#f-button").addClass("active-tab");
            $("#m-button").removeClass("active-tab");
            $('#coe').addClass('hide-element');
            $('#course').removeClass('hide-element');

        });

    </script>
@endpush
