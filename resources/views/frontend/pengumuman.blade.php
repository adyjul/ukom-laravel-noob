@extends('layouts.master-frontend')


@section('content')
<!-- <div class="pengumuman">
    <h3 class="judul-pengumuman">Pengumuman</h3>
    <div class="container">
        <hr>
        <div class="tabel">
            <div class="boxes shadow-lg">
                <table class="table table-striped w-100" id="table-announcement">
                    <tbody class="w-100">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->

<div class="content-menu pengumuman">
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
                Pengumuman
            </p>
            <hr>
            <div class="content-pengumuman">
                <table class="table table-striped w-100" id="table-announcement">
                    <tbody class="w-100">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold ml-4" id="staticgiBackdropLabel"></h4>
                <button type="button" class="close mr-4" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="deskripsi-pengumuman mx-4 "></div>
            </div>
            <div class="modal-footer mx-auto">
                <button type="button" class="btn button-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.data_tables.data_tables')

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table-announcement').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url()->full() !!}',
            columns: [{
                data: 'title',
                name: 'title',
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

        $(document).on("click", '.btn-detail_announcement', function() {
            const id = $(this).data('id')
            let url = "{{ route('home.pengumuman.detail', ['id' => '__id']) }}"
            url = url.replace('__id', id)
            fetch(url)
                .then(resp => resp.json())
                .then(data => {
                    if (data.code != 200) {
                        throw data.message
                    }
                    $('.modal .modal-title').text(data.data.title)
                    $('.modal .deskripsi-pengumuman').html(data.data.body)
                })
                .catch(err => alert(err))
        })
    })
</script>
@endpush
