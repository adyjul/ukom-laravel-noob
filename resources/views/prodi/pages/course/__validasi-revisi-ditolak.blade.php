@section('content')
    @if (in_array($data['course']->validation_status, [2,3]))
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="block block-rounded">
                <div class="block-header alert alert-{{ $data['course']->validation_status == 2 ? 'danger' : 'warning' }}">
                    <h3 class="block-title alert-heading">Pesan</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                            <i class="si si-pin"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <p class="mt-0">{{ $data['course']->validation_message }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="container-fludi">
            <div class="card" style="border:none">
                <div class="card-top {{ $class }}"></div>
                <div class="card-body">
                    <form action="{{ route('prodi.course.ajax.store.courseValidation') }}" id="form_course_validation" method="post"
                        enctype="multipart/form-data" id="form_proposal">

                        <div class="">
                            <input type="hidden" id="proposal" name="id" value="{{ $data['course']->id }}">
                            <label for="">Nama Short Course<span class="text-danger ">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="{{ $data['course']->name }}">
                            </div>
                            <label for="">Deskripsi Short Course<span class="text-danger ">*</span></label>
                            <div class="input-group mb-3">
                                <textarea id="description" name="description" class="form-control" required>{{ $data['course']->description }}</textarea>
                            </div>
                            <label for="">Capaian Mahasiswa<span class="text-danger ">*</span></label>
                            <div class="input-group mb-3">
                                <textarea class="form-control" id="student_achievement" name="student_achievement"  rows="5">{{ $data['course']->student_achievement }}</textarea>
                            </div>
                            @if ($data['course']->proposal == null)
                            <label for="">Proposal <span class="text-danger input_required">*</span></label>
                            <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="proposal" required>
                                        <label class="custom-file-label" for="customFile">Pilih Proposal</label>
                                    </div>
                                </div>
                            @endif

                            @if ($data['course']->proposal != null)
                            <label for="">Proposal <span class="text-danger input_required">*</span></label>
                            <div class="input-group mb-3">
                                <div class="mb-3" id="proposal_preview" style="display: flex;">
                                    <button class="btn btn-primary btn-preview_pdf mr-2" href={{ asset($data['course']->proposal) }}><i class="fas fa-eye"></i>  Lihat</button>
                                    <button type="button" class="btn btn-warning" id="btn_ubah_proposal"><i class="fas fa-money-check-edit"></i>  Upload Ulang</button>
                                </div>


                                <div id="upload_ulang_proposal" style="display: none">
                                    <button class="btn btn-danger mr-2" id="btn_batal_ubah_proposal"><i class="fas fa-money-check-edit"></i>Batal</button>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="proposal" value="{{ $data['course']->proposal }}">
                                        @php
                                            $proposalName = explode('-',$data['course']->proposal);
                                        @endphp
                                        <label class="custom-file-label" for="customFile">{{ end($proposalName) }} </label>
                                    </div>
                                </div>

                            </div>
                            @endif

                            <label for="">Anggaran <span class="text-danger input_required">*</span></label>
                            <div class="input-group mb-3">
                                <input type="numeric" class="form-control" id="cost" name="cost" required value="{{ $data['course']->cost }}">
                            </div>
                            <small style="font-size: 15px">Aturan:
                                <ul>
                                    <li>Ukuran maksimal <strong>2MB</strong></li>
                                    <li>File <strong>Proposal</strong> harus berupa pdf</li>
                                </ul>
                            </small>
                            @if ($data['course']->validation_status != 2)
                                <div class="btn_proposal">
                                    <button href="" class="btn btn-primary mr-auto mb-3" type="submit">Simpan</a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection




@push('scripts')
<script>
    $(document).on('submit','#form_course_validation',function(e){
            e.preventDefault();
            var form1 = $(this)[0];
            let formData = new FormData(form1);
            loader.show();
            postDataWithPromise(form1.action,formData)
                .then((result)=>{
                    Swal.fire({
                        icon: 'success',
                        title: result.message,
                    }).then(() =>{
                        location.reload();
                    })
                })
                .catch(err => {
                    Swal.fire({
                        'icon' : 'error',
                        'title' : err
                    })
                })
                .finally(() => loader.hide())
    })

    $(document).on('click','#btn_ubah_proposal',function(e){
        e.preventDefault();
        $('#proposal_preview').addClass('d-none-important');
        $('#upload_ulang_proposal').css('display','flex')
    })

    $(document).on('click','#btn_batal_ubah_proposal',function(e){
        e.preventDefault();
        $('#proposal_preview').removeClass('d-none-important');
        $('#upload_ulang_proposal').css('display','none')
    })
    </script>
@endpush
