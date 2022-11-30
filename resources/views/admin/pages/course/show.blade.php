@extends('layouts.master')

@section('page_title', 'Detail Proposal - ' . $data['course']->name)

@section('breadcrumb')
    @php
    $breadcrumbs = [['Proposal', route('admin.proposal.index')], 'Detail'];
    @endphp
    @include('layouts.parts.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@push('styles')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('oneUI') }}/js/plugins/datatables/dataTables.bootstrap4.css">
@endpush

@push('styles')
    <style>
        .bg-body-white {
            background-color: white;
            border-radius: 10px;
        }

        .border-10px {
            border-radius: 10px;
        }

        .select2-container {
            width: 100% !important;
        }

        .table td,
        .table th {
            border-bottom: 1px solid #e1e6e9;
        }

    </style>
@endpush


@php
$status;
$class;
$color;

if ($data['course']->validation_status == 1) {
    $status = 'pending';
    $class = 'bg-primary';
    $color = 'primary';
} elseif ($data['course']->validation_status == 2) {
    $status = 'ditolak';
    $class = 'bg-danger';
    $color = 'danger';
} elseif ($data['course']->validation_status == 3) {
    $status = 'direvisi';
    $class = 'bg-warning';
    $color = 'warning';
} else {
    $status = 'diterima';
    $class = 'bg-success';
    $color = 'success';
}
@endphp


@section('content')

    <div class="block block-rounded block-mode-hidden cl-{{ $color }}  shadow"  style="border-left: 6px solid">
        <div class="block-header">
            <h3 class="block-title">Detail Course</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                    <i class="si si-pin"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-down"></i></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                    <i class="si si-close"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width: 20%;">Proposal</th>
                        <td>
                            <a class="btn_history_proposal btn-preview_pdf"
                                href="{{ asset($data['course']->proposal) }}" >Lihat File</a>
                            <i class="far fa-eye">
                        </td>
                    </tr>
                    <tr>
                        <th>Capaian Mahasiswa</th>
                        <td>
                            @php
                               echo $data['course']->student_achievement
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi Course</th>
                        <td>{{ $data['course']->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>Biaya Pendaftaran</th>
                        <td>Rp. {{ number_format($data['course']->cost, 0, '', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if ($data['course']->activity_date != null)
        <div class="block block-rounded block-mode-hidden cl-{{ $color }}  shadow"  style="border-left: 6px solid">
            <div class="block-header">
                <h3 class="block-title">Data Course</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                        <i class="si si-pin"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-down"></i></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                        <i class="si si-close"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">Kuota</th>
                            <td>{{ $data['course']->quota }}</td>
                        </tr>
                        <tr>
                            <th>Jam Pelajaran</th>
                            <td>{{ $data['course']->lesson_hours }}</td>
                        </tr>
                        <tr>
                            <th>Capaian Pembelajaran</th>
                            <td>
                                @php
                                    echo $data['course']->learning_achievement
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pendaftaran Peserta</th>
                            <td>{{ $data['course']->registration_date['registration_start']  }} sampai {{ $data['course']->registration_date['registration_end']  }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaksanaan Peserta</th>
                            <td>{{ $data['course']->activity_date['activity_start']  }} sampai {{ $data['course']->activity_date['activity_end']  }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="js-wizard-simple block shadow border-10px">
                <!-- Step Tabs -->
                <ul class="nav nav-tabs nav-tabs-block {{ $status }} nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step1" data-toggle="tab">Data Dosen Perguruan
                            Tinggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step2" data-toggle="tab">Data Dosen Praktisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step3" data-toggle="tab">Data DUDI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step4" data-toggle="tab">Validasi/Kategori</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;">

                    <!-- Step 2 -->
                    @include('admin.pages.course.layout_menu.data_dosen')
                    <!-- END Step 2 -->

                    <!-- Step 3 -->
                    @include('admin.pages.course.layout_menu.data_praktisi')
                    <!-- END Step 3 -->

                    {{-- Step 4 --}}
                    @include('admin.pages.course.layout_menu.data_dudi')

                    {{-- START Step 5 --}}

                    <div class="tab-pane" id="wizard-simple-step4" role="tabpanel">
                        <form action="{{ route('admin.course.update.status') }}" id="form_submit_validation">
                            <input type="hidden" name="id" value="{{ $data['course']->id }}">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="validation_status">Status <span
                                        class="text-danger">*</span></label>
                                <select class="status w-100" id="validation_status" name="validation_status" required>
                                    @foreach ($data['validation_status'] as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ $data['course']->validation_status == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-gorup mb-3" id="form_category">
                                <label class="w-100" for="category_course">Kategori Course <span
                                        class="text-danger">*</span></label>
                                <select class="status w-100" id="category_course" name="category_course" required>
                                    @foreach ($data['category_course'] as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ $data['course']->category_course == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="form_alasan" style="display: none">
                                <label for="alasan">Alasan</label>
                                <textarea class="form-control" id="validation_message" name="validation_message" rows="3"
                                    maxlength="2000">{{ $data['course']->validation_message }}</textarea>
                            </div>


                            <button type="submit" class="btn btn-primary my-2">Simpan</button>
                        </form>
                    </div>
                    {{-- END Step 5 --}}
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

@include('layouts.data_tables.basic_data_tables')
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('oneUI/js/config.js') }}"></script>
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

@push('scripts')

<script>
    function selectShort(id) {
        $(`#${id}`).select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Item'
        })
    }

    $('#validation_status').on('change', function() {
        if (["2", "3"].includes($(this).val())) {
            $('#form_alasan').css('display', 'block');
            $('.form_anggaran').css('display', 'none');
            $('#form_category').css('display', 'none');
        } else {
            $('#form_alasan').css('display', 'none');
            $('.form_anggaran').css('display', 'block');
            $('#form_category').css('display', 'block');
        }
    }).trigger('change')

    selectShort('category_course');
    selectShort('validation_status');


    $(document).on('submit','#form_submit_validation',function(e){
        e.preventDefault();
        var form1 = $(this)[0];
        let formData = new FormData(form1);
        loader.show();
        postDataWithPromise($(this).attr('action'),formData)
            .then(resolve => {
                swal.fire({
                    'icon' : 'success',
                    'title' : resolve.message
                }).then(() => location.reload())
            })
            .catch(err =>{
                swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => loader.hide());
    })

    $('#table-dosen').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('admin.course.ajax.datatable.dosen', ['course_id' => $data['course']->id]) }}",
            columns: [
                {
                    data: 'dosen.nama_dan_gelar',
                    name: 'dosen.nama_dan_gelar',
                },
                {
                    data: 'nidn',
                    name: 'nidn',
                    className: "text-center",
                },

            ]
        });

        $('#table-dosen-praktisi').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('admin.course.ajax.datatable.dosen.dudi', ['course_id' => $data['course']['id']]) }}",
            columns: [{
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'position',
                    name: 'position',
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'email',
                    name: 'email',
                },
            ]
        });


        $('#table-dudi').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('admin.course.ajax.datatable.dudi', ['course_id' => $data['course']['id']]) }}",
            columns: [{
                    data: 'dudi.name',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.field',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.address',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.director_name',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.cp_name',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.mou',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'dudi.website',
                },
            ]
        });

</script>


@endpush



