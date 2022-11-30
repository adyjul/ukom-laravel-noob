@section('content')


    <div class="block block-rounded block-mode-hidden shadow"  style="border-left: 6px solid #30c78d">
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
                        <td>{{ $data['course']->student_achievement }}
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi Course</th>
                        <td>{{ $data['course']->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>Anggaran yang disetujui</th>
                        <td>Rp. {{ number_format($data['course']->cost, 0, '', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="js-wizard-simple block  shadow border-10px">
                <!-- Step Tabs -->
                <ul class="nav nav-tabs nav-tabs-block nav-justified {{ $status }}" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step1" data-toggle="tab">Data Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step2" data-toggle="tab">Data Dosen Perguruan
                            Tinggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step4" data-toggle="tab">Data Dosen Praktisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  h-100 d-flex justify-content-center align-items-center"
                            href="#wizard-simple-step3" data-toggle="tab">Data DUDI</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;" id="block_content">
                    <!-- Step 1 -->
                    @include('prodi.pages.course.layout_menu.data_course')
                    <!-- END Step 1 -->

                    <!-- Step 2 -->
                    <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                        <div class="form-group">
                            <div class="ml-auto card-tools mb-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#modal-data-prodi"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-vcenter" id="table-dosen"
                                    style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Dosen Prodi</th>
                                            {{-- <th style="width: 40%;">NIDN</th>
                                            <th class="text-center" style="width: 20%;">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Step 2 -->


                    <!-- Step 3 -->
                    @include('prodi.pages.course.layout_menu.data_praktisi')
                    <!-- END Step 3 -->


                    {{-- Step 4 --}}
                    @include('prodi.pages.course.layout_menu.data_dudi')

                    {{-- end Step 4 --}}



                </div>
            </div>
        </div>
    </div>

@endsection


@push('modals')
    <div class="modal fade" id="modal-data-prodi" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Tambah Data Dosen</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('prodi.course.ajax.store.dosen') }}" method="post" id="form_dosen">
                        <div class="block-content font-size-sm">
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="prodi_lecture_name">Dosen Prodi <span
                                        class="text-danger">*</span></label>
                                <select class="dosen_prodi w-100" id="prodi_lecture_name" name="prodi_lecture_name">
                                </select>
                            </div>
                            <div class="form-gorup mb-3">
                                <label class="w-100" for="prodi_lecture_name">NIDN<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="nidn_dosen" disabled class="form-control">
                            </div>
                            {{-- <div class="form-gorup mb-3">
                                <label for="prodi_instructure_name">Instruktur dari Prodi <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="prodi_instructure_name" name="prodi_instructure_name"
                                    class="form-control" value="{{ old('prodi_instructure_name') }}">
                            </div> --}}
                            <div class="">
                                <button class="btn btn-primary mr-auto mb-3" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush


@include('layouts.select2.bootstrap4')
@include('layouts.data_tables.basic_data_tables')

@push('scripts')
    <script>
        $(document).on(
            'submit',
            "._form_with_confirm",
            function(event) {
                event.preventDefault()
                Swal.fire({
                    title: $(this).data("title"),
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        loader.show()

                        fetch($(this).attr('action'), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                body: new FormData(this)
                            })
                            .then(resp => resp.json())
                            .then(data => {
                                if (data.code != 200) {
                                    throw data.message;
                                }
                                Toast.success(data.message);
                                $($(this).data("table")).DataTable().ajax.reload()
                            })
                            .catch(err => Toast.error(err))
                            .finally(() => loader.hide())
                    }
                })
            })
    </script>
@endpush


@push('scripts')
    <script>
        function select(id, url,input) {
            $(`#${id}`).select2({
                minimumInputLength: input,
                theme: 'bootstrap4',
                ajax: {
                    url,
                    dataType: 'json',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: function(term) {
                        return (JSON.stringify({
                            searchString: term.term
                        }))
                    },
                    processResults: function(data, page) {
                        return {
                            results: data.data
                        }
                    }
                }
            })
        }
    </script>
@endpush

@push('scripts')
    <script>

        $('#table-dosen').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('prodi.course.ajax.datatable.dosen', ['course_id' => $data['course']->id]) }}",
            columns: [
                {
                    data: 'name',
                },
                // {
                //     data: 'nidn',
                //     name: 'nidn',
                //     className: "text-center",
                // },
                // {
                //     data: 'action',
                //     className: "text-center",
                //     orderable: false,
                //     sortable: false,
                // }
            ]
        });

        $('#nidn_dosen').val(" ")
        var nidn = '';

        select('prodi_lecture_name', '{{ route('prodi.proposal.ajax.select2.dosen.prodi') }}',1);

        $(document).on('change', '#prodi_lecture_name', function() {
            var value = $(this).val()
            nidn = value;
            $('#nidn_dosen').val(value)
        }).trigger("change");

        $(document).on('submit', '#form_dosen', function(e) {
            e.preventDefault();
            var url = $(this).attr('action')
            var id = "{{ $data['course']->id }}";
            $('#table-dosen').DataTable().ajax.reload();
            loader.show();
            postDataWithJsonStringify(url,{
                id,nidn
            })
            .then((success) =>{
                swal.fire({
                    'icon' : 'success',
                    'title' : success.message
                }).then(()=>{
                    $('#table-dosen').DataTable().ajax.reload();
                })
            })
            .catch((err)=>{
                swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => {
                loader.hide();
                $('.modal').modal('hide');
                $('#prodi_lecture_name').val("").trigger('change');
            })
        })

    </script>
@endpush





