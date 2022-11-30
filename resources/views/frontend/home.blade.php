@extends('layouts.master-frontend')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/plugin/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/plugin/imagehover.css') }}">
@endpush

@push('styles')
    <style>
        :root {
            --bgMain: #900;
            --bgSecond: #392775;
        }

        .card-1 {
            border: 4px solid var(--bgSecond);
            /* background-color: aliceblue; */
        }

        .card-2 {
            border: 4px solid var(--bgMain);
            /* background-color: antiquewhite; */
        }

        .card-3 {
            border: 4px solid #459900;
            /* background-color: #f1ffe4; */
        }

        .icon-1 {
            border: 4px solid var(--bgSecond);
            /* background-color: aliceblue; */
            color: var(--bgSecond);
        }

        .icon-2 {
            border: 4px solid var(--bgMain);
            /* background-color: antiquewhite; */
            color: var(--bgMain)
        }

        .icon-3 {
            border: 4px solid #459900;
            /* background-color: #f1ffe4; */
            color: #459900;
        }

    </style>
@endpush

@section('page', 'id=home')

@section('content')
    <div id="home">
        <div id="carousel" class="carousel slide hero-slides" data-ride="carousel">
            <ol class="carousel-indicators" style="bottom: 45px">
                @foreach ($data['slider'] as $slider)
                    <li class="@if ($loop->first) {{ 'active' }} @endif" data-target="#carousel"
                        data-slide-to="{{ $loop->index + 1 }}"></li>
                @endforeach
            </ol>

            <div class="carousel-inner" role="listbox">
                @foreach ($data['slider'] as $slider)
                    <div class="carousel-item @if ($loop->first) {{ 'active' }} @endif"
                        style="background-image: url({{ asset($slider->image_path) }});">
                        <div class="overlay"></div>
                        <div class="container text-content h-100 d-md-block">
                            <div class="row align-items-center h-100">
                                <div class="col-md-6">
                                    <h2 class="animated fadeInUp"> <span style="font-size: 4.5rem">{{ $slider->title }}
                                    </h2>
                                    <p class="animated fadeInRight">{{ $slider->description }}</p>
                                    @foreach ($slider->button as $button)
                                        <a href="{{ $button['url'] }}"
                                            class="animated fadeInUp btn btn-custom">{{ $button['text'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- <div class="container">
        <div class="card card-tgl card-custom shadow">
            <div class="row">
                <div class="card-body content-left">
                    <p class="font-weight-bold text-white judul">Tanggal Pelaksanaan</p>
                    <p class="text-white font-weight-bold tgl">21 Maret - 22 April 2022</p>
                </div>
                <div class="card-body content-right">
                    <p class="font-weight-bold">Center Of Excelent</p>
                    <p class="font-weight-bold caption">Uji Kompetensi Khusus Bagi Mahasiswa</p>
                </div>
            </div>
        </div>
    </div> --}}

    </div>



    {{-- <div id="kerjasama">
    <div class="container">
        <div class="row">
            <div class="col-md-6 content-left">
                <h2 class="font-weight-bold">Kerjasama dan MOU dengan beberapa indusri</h2>
                <p class="text-muted">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum qui veritatis ea nam. Voluptate laborum possimus dolorem aut ut molestias iste soluta, provident illo hic maxime ex labore cumque odio!</p>
                <a class="btn btn-custom" href="">Selengkapnya
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
            <div class="col-md-6 content-right">
                <div class="circle one"></div>
                <div class="circle two"></div>
            <div class="row">
                <div class="col-md-6 my-2">
                    <div class="card card-custom shadow">
                        <div class="card-body">
                            <div class="content-body d-flex">
                                <i class="fab fa-amazon mt-3 mr-3"></i>
                                <p class="font-weight-bold">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="card card-custom shadow">
                        <div class="card-body">
                            <div class="content-body d-flex">
                                <i class="fab fa-amazon mt-3 mr-3"></i>
                                <p class="font-weight-bold">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="card card-custom shadow">
                        <div class="card-body">
                            <div class="content-body d-flex">
                                <i class="fab fa-amazon mt-3 mr-3"></i>
                                <p class="font-weight-bold">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="card card-custom shadow">
                        <div class="card-body">
                            <div class="content-body d-flex">
                                <i class="fab fa-amazon mt-3 mr-3"></i>
                                <p class="font-weight-bold">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}

    <div id="statistika">
        <div class="container text-center">
            <div class="judul-section">
                <h2 class="font-weight-bold mt-1 wow fadeInDown" data-wow-duration=".3" data-wow-delay=".2s">Statistik</h2>
                <hr class="wow fadeInDown" data-wow-duration=".3" data-wow-delay=".6s">
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card card-1 card-custom mb-5 wow fadeInDown" data-wow-duration=".3" data-wow-delay=".2s">
                        <i class="icon icon-1 fas fa-university text-black" style="position: absolute"></i>
                        <div class="card-body">
                            <p class="font-weight-bold mt-3 mb-1" style="color: var(--bgSecond)">Program Studi</p>
                            <h3 class="font-weight-bold" style="color: var(--bgSecond)">62</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-2 card-custom mb-5 bg wow fadeInDown" data-wow-duration=".3" data-wow-delay=".4s">
                        <i class="icon icon-2 fas fa-clipboard" style="position: absolute"></i>
                        <div class="card-body">
                            <p class="font-weight-bold mt-3 mb-1" style="color: var(--bgMain)">Proposal yang Diupload</p>
                            <h3 class="font-weight-bold" style="color: var(--bgMain)">{{ $data['proposal_uploaded'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom card-3 wow fadeInDown" data-wow-duration=".3" data-wow-delay=".6s">
                        <i class="icon icon-3 fas fa-clipboard-check" style="position: absolute"></i>
                        <div class="card-body">
                            <p class="font-weight-bold mt-3 mb-1" style="color: #459900">Proposal yang Diterima</p>
                            <h3 class="font-weight-bold" style="color: #459900">{{$data['proposal_accepted']}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="informasi">
        <div class="container ">
            <div class="judul-section text-center">
                <h2 class="font-weight-bold my-3 wow fadeInDown" data-wow-duration=".3" data-wow-delay=".2s">UMM PASTI</h2>
                <h3 class="mb-4 wow fadeInUp" data-wow-duration=".5" data-wow-delay=".4s">" UMM memberikan kepastian bagi
                    seluruh mahasiswa selama menempuh studi yaitu <span>Pasti Lulus, Pasti Bekerja dan Pasti Mandiri</span>
                    "</h3>
                <hr class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".5s">
            </div>

            <div class="row">
                <div class="col-md-6 content-left wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".2s">
                    <img class="w-100 mb-4  " src="{{ asset('frontend/images/mahasiswa2.jpg') }}" alt="" srcset="">
                </div>
                <div class="col-md-6 content-right wow fadeInRight" data-wow-duration=".3" data-wow-delay=".4s">
                    <div class="section-heading">
                        <h3 class="font-weight-bold" style="font-size: 34px">Center Of Excellence <br> (Sekolah Unggulan)
                            </p>
                    </div>
                    <div class="caption">
                        <p align="justify" class="text-muted">
                            Sekolah Unggulan yang dikembangkan oleh setiap Program Studi diharapkan menjadi
                            keunggulan kompetitif sebagai modal tambahan untuk bertarung pada dunia
                            persaingan global. Prodi yang mempunyai CoE dengan keunggulan spesifik tentu saja
                            menjadi magnet yang akan menarik dengan kekuatan ganda bagi calon mahasiswa baru.
                            Bukan hanya itu, CoE akan menjadi magnet kuat bagi institusi lain, termasuk DUDI,
                            untuk dapat bekerjasama dengan Prodi dalam sistem simbiosis-mutualisme.
                            Kerjasama yang saling menguntungkan: Prodi memberikan ilmu pengetahuan baru bagi
                            para DUDI, DUDI memberikan tambahan skill dan kompetensi bagi mahasiswa, dan
                            mahasiswa memperoleh jaringan untuk dapat bekerja setelah lulus
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="sambutan">
        <div class="container content">
            <p class="font-weight-bold judul-page wow fadeInDown" data-wow-duration=".3" data-wow-delay=".2s">Sambutan</p>
            {{-- <h2 class="font-weight-bold my-3">Sambutan</h2> --}}
            {{-- <h3 class="mb-4">" UMM memberikan kepastian bagi seluruh mahasiswa selama menempuh studi yaitu <span>Pasti Lulus, Pasti Bekerja dan Pasti Mandiri</span> "</h3> --}}
            <div class="card shadow card-custom card-content wow fadeInUp" data-wow-duration=".3" data-wow-delay=".4s"
                style="padding: 20px">
                <div class="row">
                    <div class="col-md-8 content-left">
                        <h4 class="font-weight-bold">SAMBUTAN REKTOR UMM</h4>
                        <hr>

                        <p align="justify" class="text-muted">
                            Untuk menjawab kebutuhan SDM pada era digital maka Univesitas Muhammadiyah
                            Malang sudah mendirikan beberapa sekolah unggulan (Center of Excellence) sejak tahun
                            2018. Sekolah unggulan ini dilaksanakan oleh Program Studi sebagai bagian yang
                            terintegrasi dengan kegiatan akademik. UMM telah mencanangkan bahwa lulusan harus
                            mempunyai kompetensi akademik dan kompetensi kepemimpinan atau leadership.
                            Kompetensi akademik diperoleh mahasiswa selama menempuh pendidikan formal
                            sesuai kurikulum standart yang ada dimasing-masing Program Studi. Sedangkan
                            kompetensi kepemimpinan dapat diperoleh melalui sekolah unggulan atau Center of Excellence

                            <a href="#" class="baca_selengkapnya" style="font-size: 16px">Baca Selengkapnya...</a>
                        </p>
                        <div class="pesan">
                            <p align="justify" class="text-muted">
                                Beberapa sekolah unggulan yang sudah berjalan antara lain: Kelas Profesional Unggas,
                                Sekolah Udang, Sekolah Anggrek, Sekolah Welding Inspector dan lain-lain. Pimpinan
                                Universitas telah menggalakan dan menginstrusikan agar semua Program Studi
                                mendirikan sekolah-sekolah unggulan khusus sesuai dengan kebutuhan dan passion
                                mahasiswa. Diharapkan peserta sekolah unggulan tidak hanya mahasiswa prodi yang
                                bersangkutan, tetapi juga mahasiswa antar prodi antar fakultas dan bahkan mahasiswa
                                antar Universitas se-Indonesia sebagai bagian dari implementasi Merdeka Belajar
                                Kampus Merdeka (MBKM) selain itu Program Sekolah Unggulan UMM diharapkan
                                mengakselerasi Program UMM PASTI yaitu Lulus Tepat Waktu, Bekerja dan Mandiri.
                            </p>
                        </div>

                    </div>
                    <div class="col-md-4 content-right">
                        <div class="img-content text-center">
                            <img src="{{ asset('frontend/images/rektor.jpeg') }}" alt="" class="w-100"
                                srcset="">
                            <p class="font-weight-bold mb-0">Dr. Fauzan, M.Pd</p>
                            <p class="mt-0 text-muted">Rektor UMM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kata">
        <div class="content container">
            <div class="judul-section text-center mt-4">
                <h2 class="font-weight-bold p-0 text-white wow fadeInDown" data-wow-duration=".3" data-wow-delay=".2s">UMM
                    PASTI</h2>
                <h3 class="mb-0 text-white wow fadeInUp" data-wow-duration=".5" data-wow-delay=".4s">" UMM memberikan
                    kepastian bagi seluruh mahasiswa selama menempuh studi yaitu <span>Pasti Lulus, Pasti Bekerja dan Pasti
                        Mandiri</span> "</h3>
                <hr>
            </div>
        </div>
    </div>

    <div id="pengumuman">
        <div class="container">
            <p class="font-weight-bold judul-page wow fadeInUp" data-wow-duration=".3" data-wow-delay=".3s">Galeri</p>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".3">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/gambar_11.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">UMM Internasionalisasi</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">"Mahasiswa UMM berpeluang untuk mendapatkan beasiswa ke luar
                                        negeri melalui program beasiswa erasmus+"</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".5">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/foto2.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">Miniatur Indonesia</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">""Mahasiswa UMM berasal dari berbagai macam pelosok seluruh
                                        Indonesia, bergabung dengan UMM seperti masuk pada miniatur Indonesia""</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".7">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/foto3.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">Learning by Doing</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">"Iklim pembelajaran UMM sangat kondusif sangat cocok bagi calon
                                        mahasiswa mengembangkan minat dan bakat sesuai dengan passionya"</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".9">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/foto4.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">Bersama Membangun Negeri</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">"Iklim Tri dharma pendidikan selalu ditanamkan untuk seluruh
                                        civitas akademika UMM"</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".13">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/foto5.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">Kreativitas Tanpa Batas</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">"Budaya Kreativitas di UMM selalu ditanamkan sejak mahasiswa
                                        pertama kali menginjakan kakinya di UMM"</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="wow fadeInUp" data-wow-duration=".3" data-wow-delay=".15">
                        <figure class="imghvr-fold-down">
                            <img loading="lazy" src="{{ asset('frontend/images/foto6.jpg') }}" alt="example-image">
                            <figcaption>
                                <h3 class="ih-fade-down ih-delay-sm ">Kepedulian pada Sesama</h3>
                                <p class="ih-zoom-in ih-delay-md">
                                    <i style="color: white;">"Seluruh civitas akademika UMM selalu memperhatikan kepada
                                        sesama yang membutuhkan uluran bantuan"</i>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
@endpush


@push('scripts')
    <script>
        $(document).ready(function() {
            new WOW().init();
            $(".pesan").hide();
            $(".baca_selengkapnya").click(function(e) {
                e.preventDefault();
                $(".pesan").slideDown('slow');
                $(this).hide();
            })
        });
    </script>
@endpush
