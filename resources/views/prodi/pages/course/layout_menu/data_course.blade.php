<div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">

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
        <label for="">Capaian Mahasiswa<span class="text-danger mt-4">*</span></label>
        <div class="input-group mb-3">
            <textarea class="form-control" id="student_achievement" name="student_achievement"  rows="5">{{ $data['course']->student_achievement }}</textarea>
        </div>
        <label for="">Capaian Pembelajaran<span class="text-danger mt-4">*</span></label>
        <div class="input-group mb-3">
            <textarea class="form-control" id="learning_achievement" name="learning_achievement"  rows="5">{{ $data['course']->learning_achievement }}</textarea>
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

        <label for="">Biaya Pendaftaran <span class="text-danger input_required">*</span></label>
        <div class="input-group mb-3">
            <input type="numeric" class="form-control currency" id="cost" name="cost" required value="{{ $data['course']->cost }}">
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

@include('layouts.datepicker.bootstrap_datepicker')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush


@push('scripts')
    <script>

    $(".input-daterange").datepicker({
        // autoclose: true,
        todayHighlight: true,
    });


    $(document).on('click', '.btn-preview_pdf', function() {
        event.preventDefault()
        console.log('hai')
        let targetFile = $(this).attr("href")
        PDFObject.embed(targetFile, "#preview_pdf_div");
        $("#modal_preview_pdf").modal("show")
    })

    $('#learning_achievement').summernote({
        placeholder: 'Capaian Pembelajaran',
        tabsize: 2,
        height: 300,
    });

    $('#student_achievement').summernote({
        placeholder: 'Capaian Pembelajaran',
        height: 300,
    });


    $('#form_course_validation').submit(function() {
        event.preventDefault();
        var form1 = $(this)[0];
        let formData = new FormData(form1);
        loader.show();
        postDataWithPromise(form1.action,formData)
            .then((result)=>{
                Swal.fire({
                    icon: 'success',
                    title: result.message,
                }).then(() =>{
                    window.location.reload()
                })
            })
            .catch(err => {
                Swal.fire({
                    'icon' : 'error',
                    'title' : err
                })
            })
            .finally(() => loader.hide())

    });

    </script>
@endpush
