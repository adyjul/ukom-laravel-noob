@extends('layouts.master-frontend')

@push('styles')
@endpush

@section('content')
    <div id="download" class="content-menu">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    'Beranda' => route('home.index'),
                    'Download' => '',
                ];
            @endphp
            @include('layouts.parts.frontend.breadcrub',['datas'=>$breadcrumbs])
            <div class="card card-custom p-3 border-card">
                <p class="text-center font-weight-bold judul" style="font-size:30px;margin-bottom:20px;margin-top:10px;">
                    Download
                </p>
                <hr>
                <table class="table table-striped w-100" id="table-download">
                    <thead>
                        <tr>
                          <th class="text-center">File</th>
                          <th class="text-center">Download</th>
                        </tr>
                      </thead>
                    <tbody class="w-100">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@include('layouts.data_tables.data_tables')

@push('scripts')
    <script>
        $('#table-download').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url()->full() !!}',
            columns: [{
                data: 'name',
                name: 'name',
                orderable: false,
                sortable: false,
            }, ],
            drawCallback: function() {
                $(this.api().table().header()).hide();
            },
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, 'All']
            ]
        });

    </script>
@endpush
