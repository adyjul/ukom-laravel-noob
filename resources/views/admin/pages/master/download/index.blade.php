@extends('layouts.master')

@section('page_title', 'Download')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Master', ['Download', route('admin.master.download.index')]];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title">List Download</h3>
                    <div class="ml-auto card-tools">
                        @can('create master_download')
                            <a class="btn btn-primary" href="{{ route('admin.master.download.createGet') }}"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                        @endcan
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="main-table">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    @include('layouts.data_tables.th_status',["model" => $data['model']])
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.data_tables.basic_data_tables')

@push('scripts')
    <script>
        $(function() {
            let table = $('#main-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url()->full() !!}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        sortable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center",
                        orderable: false,
                        sortable: false,
                    }
                ]
            });

            $("#th_status").change(function() {
                let url = "";
                url =
                    "{{ route(
                        request()->route()->getName(),
                        ['status' => '__status'],
                    ) }}"
                table.ajax.url(url.replace('__status', $(this).val())).load();
            })
        });
    </script>
@endpush
