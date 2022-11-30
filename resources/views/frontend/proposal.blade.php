@extends('layouts.master-frontend')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
    <link rel="stylesheet" href="{{ asset('oneUI/css/sweetalert2.min.css') }}">
@endpush

@push('styles')
    <style>
        .nav-item .nav-link p:hover {
            height: auto !important;
        }

        .overlay {
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            position: fixed;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 99998;
        }

        .lds-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
            z-index: 9999999;
            position: fixed;
            top: 50%;
            left: 50%;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #fff;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #fff transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .card-proposal {
            transition: .2s all ease-in-out;
        }

        .card-proposal td p {
            font-size: 15px
        }


        .list-menu {
            list-style-type: none;
        }

        .list-menu li {
            display: flex;
            justify-content: space-between;
            text-align: center;
            border-bottom: 1px solid #c9ced1;
            margin-bottom: 1.3rem
        }

        .course{
            border-top: 7px solid #002e5c;
            transition: 1.5s all ease-in-out;
        }

        .coe{
            border-top: 7px solid #900;
        }

        #content_page{
            transition: 1.5s all ease-in-out;
            background-color: #faf4f4;
        }

        .list-menu li h2 {
            font-size: 17px;
            font-weight: 600;
        }

        #table-proposal_filter input {
            width: 11rem
        }

        .pdfobject-container {
            height: 30rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }

        .nav-group.nav-group-outline {
            background-color:
            #ececec;
            border: 0px solid #b5b5c3;
        }
        .btn.btn-color-gray-400 {
            color: #900;
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
    <div id="download" class="content-menu container">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    'Beranda' => route('home.index'),
                    'Pendaftaran' => '',
                ];
            @endphp
            @include('layouts.parts.frontend.breadcrub', ['datas' => $breadcrumbs])
            <div class="card mb-4 p-3 border-card coe" id="judul_pendaftaran">
                <p class="text-center font-weight-bold judul" style="font-size:30px;margin-bottom:20px;margin-top:10px;">
                    Pendaftaran
                </p>
            </div>
            <div class="nav-group shadow nav-group-outline d-flex justify-content-center mx-auto" style="width: 50%;margin-bottom: 30px" data-kt-buttons="true" data-kt-initialized="1">
                @if (auth()->user()->user_type != 4 || auth()->guard('mahasiswa_umm')->check())
                    <button class="btn btn-color-gray-400 btn-active mx-2 active-tab" value="1" id="m-button">Kelas CoE </button>

                @endif
                    <button class="btn btn-color-gray-400 btn-active mx-2 @if (auth()->user()->user_type == 4 )active-tab @endif" id="f-button">Short Course</button>
            </div>
            <hr>
            <div class="row animate__animated " id="kelas_coe" @if (auth()->user()->user_type == 4 ) style="display: none" @endif>
                <div class="card-proposal col-12 mb-5" style="transition: .2s ease-in-out">
                    <div class="card card-custom shadow p-2 table-responsive">
                        <table class="table table-striped no-gutters w-100" id="table-proposal">
                            <tbody class="w-100">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="section" class="col-md-6 card-result-proposal animate__animated animate__fadeInUp mb-5"
                    style="display: none">
                    <div class="card card-custom shadow ">
                        <div class="card-body">
                            <h1 id="proposal-name" class="h4 font-weight-bold text-body mb-3">
                            </h1>
                            <ul class="list-menu">
                                <li>
                                    <h2 class="text-muted"><i class="fas fa-university mr-2"></i>Prodi</h2>
                                    <p id="proposal-prodi" class="text-muted mb-0">Informatika</p>
                                </li>
                                <li style="display: block" class="dosen">
                                    <h2 class="text-muted text-left"><i
                                            class="far fa-calendar-alt text-muted mr-2"></i>Dosen</h2>
                                </li>
                                <li style="display: block" class="dosen-praktisi">
                                    <h2 class="text-muted text-left"><i
                                            class="far fa-calendar-alt text-muted mr-2"></i>Dosen
                                        Praktisi</h2>
                                    <p class="text-muted mb-0 text-justify">
                                    </p>
                                </li>
                                <li>
                                    <h2 class="text-muted"><i class="fas fa-laptop-house text-muted mr-2"></i>Proposal
                                    </h2>
                                    <button class="btn btn-primary btn-sm mb-3 show-proposal" data-url=""
                                        id="proposal-proposal">Lihat</button>
                                </li>
                                <li class="display-rps">
                                    <h2 class="text-muted"><i class="fas fa-laptop-house text-muted mr-2"></i>RPS</h2>
                                    <button class="btn btn-primary btn-sm mb-3 show-rps" data-url=""
                                        id="proposal-rps">Lihat</button>
                                </li>
                                <li class="d-block text-left" class="dudi">
                                    <h2 class="text-muted"><i class="fas fa-industry text-muted mr-2"></i>Mitra DUDI
                                    </h2>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Bidang</th>
                                                    <th scope="col">Website</th>
                                                </tr>
                                            </thead>
                                            <tbody class="result-dudi">
                                            </tbody>
                                        </table>
                                    </div>


                                </li>
                                <li class="gambar-penunjang">

                                </li>
                            </ul>
                            <div class="daftar-kelas">
                                <button class="btn btn-primary btn-block font-weight-bold btn-daftar-proposal"
                                    data-id="">Register here</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="short_course" class="animate__animated fadeInRight" @if (auth()->user()->user_type != 4 || auth()->guard('mahasiswa_umm')->check()) style="display: none" @endif>
                <div class="card-course col-12 mb-5" style="transition: .2s ease-in-out">
                    <div class="card card-custom shadow p-2 table-responsive">
                        <table class="table table-striped no-gutters w-100" id="table-course">
                            <tbody class="w-100">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="section" class="col-md-6 card-result-course animate__animated animate__fadeInRight mb-5"
                    style="display: none">
                    <div class="card card-custom shadow ">
                        <div class="card-body">
                            <h1 id="course-name" class="h4 font-weight-bold text-body mb-3">
                            </h1>
                            <ul class="list-menu">
                                <li>
                                    <h2 class="text-muted"><i class="fas fa-university mr-2"></i>Prodi</h2>
                                    <p id="course-prodi" class="text-muted mb-0">Informatika</p>
                                </li>
                                <li style="display: block" class="dosen">
                                    <h2 class="text-muted text-left"><i
                                            class="far fa-calendar-alt text-muted mr-2"></i>Dosen</h2>
                                </li>
                                <li style="display: block" class="dosen-dudi-course">
                                    <h2 class="text-muted text-left"><i
                                            class="far fa-calendar-alt text-muted mr-2"></i>Dosen
                                        Praktisi</h2>
                                    <p class="text-muted mb-0 text-justify">
                                    </p>
                                </li>
                                <li>
                                    <h2 class="text-muted"><i class="fas fa-laptop-house text-muted mr-2"></i>Proposal
                                    </h2>
                                    <button class="btn btn-primary btn-sm mb-3 show-proposal" data-url=""
                                        id="proposal-proposal">Lihat</button>
                                </li>
                                <li class="display-rps">
                                    <h2 class="text-muted"><i class="fas fa-laptop-house text-muted mr-2"></i>RPS</h2>
                                    <button class="btn btn-primary btn-sm mb-3 show-rps" data-url=""
                                        id="proposal-rps">Lihat</button>
                                </li>
                                <li class="d-block text-left" class="dudi">
                                    <h2 class="text-muted"><i class="fas fa-industry text-muted mr-2"></i>Mitra DUDI
                                    </h2>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Bidang</th>
                                                    <th scope="col">Website</th>
                                                </tr>
                                            </thead>
                                            <tbody class="result-dudi">
                                            </tbody>
                                        </table>
                                    </div>


                                </li>
                                <li class="gambar-penunjang">

                                </li>
                            </ul>
                            <div class="daftar-kelas">
                                <button class="btn btn-primary btn-block font-weight-bold btn-daftar-course"
                                    data-id="">Register here</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="modal-pdf" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered h-100 modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-pdf-body">
                        <div id="pdf-preview"></div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@include('layouts.data_tables.data_tables')
@include('layouts.parts.loader')


@push('scripts')
    <script>

        $( "#m-button" ).click(function() {
            $("#m-button").addClass("active-tab");
            $('#judul_pendaftaran').removeClass('course');
            $('#judul_pendaftaran').addClass('coe');
            $("#f-button").removeClass("active-tab");
            $('#kelas_coe').css('display','flex');
            $('#short_course').css('display','none');
            $('#content_page').css('background-color','#faf4f4')
            // $("#gender").val("1");
        });
        $( "#f-button" ).click(function() {
            $("#f-button").addClass("active-tab");
            $("#m-button").removeClass("active-tab");
            $('#judul_pendaftaran').removeClass('coe');
            $('#judul_pendaftaran').addClass('course');
            $('#kelas_coe').css('display','none');
            $('#short_course').css('display','flex');
            $('#content_page').css('background-color','rgb(246, 250, 255)')
            // $("#gender").val("0");
        });

        $(document).ready(function() {
            let prodiTable = $('#table-proposal').DataTable({
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

            $('#table-course').DataTable({
                processing: true,
                serverSide: true,
                ajax:" {{ route('home.getCourse') }}",
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


        })
    </script>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
        integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
    <script>
        var widthWindow = $(window).width();

        if (widthWindow <= 767) {
            var cek = false;
            $(document).on('click', '.select-list', function(e) {
                e.preventDefault();
                let data = $(this).data('name');

                $(`.card-${data}`).addClass('col-md-6');
                $(`.card-result-${data}`).css('display', 'block');
                var tinggi = $('.content-menu').height();
                var dataScroll = $(this).attr('data-scroll');

                var elementTujuan = $(dataScroll);

                if (!cek) {
                    $('html, body').animate({
                        scrollTop: elementTujuan.offset().top - 1000
                    }, 1000, 'easeInOutExpo')
                }

                if (cek) {
                    $('html, body').animate({
                        scrollTop: elementTujuan.offset().top - 100
                    }, 1000, 'easeInOutExpo')
                }
                cek = true;

            })
        }

        if (widthWindow >= 767) {
            var cek = false;
            $(document).on('click', '.select-list', function(e) {
                e.preventDefault();
                let data = $(this).data('name');
                $(`.card-${data}`).addClass('col-md-6');
                $(`.card-result-${data}`).css('display', 'block');
                var tinggi = $('.content-menu').height();
                var dataScroll = $(this).attr('data-scroll');
                var elementTujuan = $(dataScroll);

                if (!cek) {
                    $('html, body').animate({
                        scrollTop: elementTujuan.offset().top - 1700
                    }, 1000, 'easeInOutExpo')
                }

                if (cek) {
                    $('html, body').animate({
                        scrollTop: elementTujuan.offset().top - 100
                    }, 1000, 'easeInOutExpo')
                }

                cek = true;
            })

        }





        $(document).on('click', '#list-proposal', function(e) {
            let url = $(this).attr('href');
            $('.dosen p').remove();
            $('.dosen-praktisi p').remove();
            $('.result-dudi tr').remove();
            $('.gambar-penunjang div').remove();
            fetch(url)
                .then(resp => resp.json())
                .then(data => {
                    let rs = data.data


                    $('#proposal-name').html(rs.name);
                    $('#proposal-prodi').html(rs.program_studi.nama_depart);
                    $('.show-rps').attr('data-url', rs.rps);
                    $('.show-proposal').attr('data-url', rs.proposal);
                    $('.btn-daftar-proposal').attr('data-id', rs.id);
                    if(rs.rps == null){
                        $('.display-rps').css('display','none')
                    }else{
                        $('.display-rps').css('display','flex')
                    }


                    if (rs.hasBeenRegistered == null) {
                        $('.btn-daftar-proposal').html('Register Here');
                        $(".btn-daftar-proposal").prop('disabled', false);
                        $(".btn-daftar-proposal").addClass('btn-primary');
                        $(".btn-daftar-proposal").removeClass('btn-secondary');
                    } else {
                        $('.btn-daftar-proposal').html('Anda Sudah Terdaftar');
                        $(".btn-daftar-proposal").prop('disabled', true);
                        $(".btn-daftar-proposal").removeClass('btn-primary');
                        $(".btn-daftar-proposal").addClass('btn-secondary');
                    }


                    $('.gambar-penunjang').append(`
                    <div class="image">
                        <img src="${rs.gambar_penunjang}" class="w-100 h-100" alt="" srcset="">
                    </div>`)

                    rs.dosen.map((result) => {
                        $('.dosen').append(
                            `<p class='text-muted text-left mb-0 text-justif'>- ${result.namaDosen}</p>`
                        );
                    })

                    rs.dosenPraktisi.map((result) => {
                        $('.dosen-praktisi').append(
                            `<p class='text-muted text-left mb-0 text-justif'>- ${result.name}</p>`);
                    })

                    rs.dudi.map(result => {
                        $('.result-dudi').append(`
                             <tr>
                                <td>${result.name}</td>
                                <td>${result.field}</td>
                                <td>
                                    <a href="//${result.website}">${result.website}</a>
                                </td>
                            </tr>
                        `)
                    })
                })
                .catch(err => alert(err))

        })



        $(document).on('click', '#list-course', function(e) {
            let url = $(this).attr('href');
            e.preventDefault()
            fetch(url)
                .then(resp => resp.json())
                .then(data => {
                    let rs = data.data
                    console.log(rs);
                    $('#course-name').html(rs.course.name);
                    $('#course-prodi').html(rs.course.program_studi.nama_depart);
                    // $('.show-rps').attr('data-url', rs.rps);
                    // $('.show-proposal').attr('data-url', rs.proposal);
                    $('.btn-daftar-course').attr('data-id', rs.course.id);
                    if(rs.rps == null){
                        $('.display-rps').css('display','none')
                    }else{
                        $('.display-rps').css('display','flex')
                    }


                    if (rs.hasBeenRegistered == null) {
                        $('.btn-daftar-proposal').html('Register Here');
                        $(".btn-daftar-proposal").prop('disabled', false);
                        $(".btn-daftar-proposal").addClass('btn-primary');
                        $(".btn-daftar-proposal").removeClass('btn-secondary');
                    } else {
                        $('.btn-daftar-proposal').html('Anda Sudah Terdaftar');
                        $(".btn-daftar-proposal").prop('disabled', true);
                        $(".btn-daftar-proposal").removeClass('btn-primary');
                        $(".btn-daftar-proposal").addClass('btn-secondary');
                    }

                    if(rs.gambar_penunjang != null){
                        $('.gambar-penunjang').append(`
                        <div class="image">
                            <img src="${rs.gambar_penunjang}" class="w-100 h-100" alt="" srcset="">
                        </div>`)
                    }
                })
                .catch(err => alert(err))

        })


        $(document).on('click', '.show-rps', function(e) {
            let targetFile = $(this).attr("data-url");
            PDFObject.embed(targetFile, "#pdf-preview");
            $("#modal-pdf").modal("show");
            $('.modal-title').html('RPS');
        })

        $(document).on('click', '.show-proposal', function() {
            let targetFile = $(this).attr("data-url");
            PDFObject.embed(targetFile, "#pdf-preview");
            $("#modal-pdf").modal("show");
            $('.modal-title').html('Proposal');
        })

        $(document).on('click', '.btn-daftar-proposal', function() {
            Swal.fire({
                icon: 'question',
                title: 'Yakin daftar proposal?',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: `Batal.`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let url = "{{ route('mahasiswa.proposal.register') }}";
                    let id = $(this).attr('data-id')
                    loader.show();
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                id
                            })
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.code == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Anda Berhasil Mendaftar',
                                }).then(rs => {
                                    location.reload();
                                })
                            } else if (result.code == 400) {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.message,
                                }).then(rs => {
                                    var url = "{{ route('mahasiswa.biodata.index') }}"
                                    window.location.href = url;
                                })
                            } else if (result.code == 401) {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.message,
                                }).then(rs => {
                                    var url = "{{ route('home.kelas') }}"
                                    window.location.href = url;
                                })
                            } else {
                                throw result.message
                            }
                        }).catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: err,
                            })
                        }).finally(() => loader.hide())
                }
            })
        })

        $(document).on('click', '.btn-daftar-course', function() {
            Swal.fire({
                icon: 'question',
                title: 'Yakin daftar proposal?',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: `Batal.`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let url = "{{ route('mahasiswa.course.register') }}";
                    let id = $(this).attr('data-id');
                    loader.show();
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                id
                            })
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.code == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Anda Berhasil Mendaftar',
                                }).then(rs => {
                                    location.reload();
                                })
                            } else if (result.code == 400) {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.message,
                                }).then(rs => {
                                    var url = "{{ route('mahasiswa.biodata.index') }}"
                                    window.location.href = url;
                                })
                            } else if (result.code == 401) {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.message,
                                }).then(rs => {
                                    var url = "{{ route('home.kelas') }}"
                                    window.location.href = url;
                                })
                            } else {
                                throw result.message
                            }
                        }).catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: err,
                            })
                        }).finally(() => loader.hide())
                }
            })
        })


    </script>
@endpush
