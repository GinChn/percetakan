@extends('layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Dashboard</h3>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-success">
                    <h5>Selamat Datang!</h5>
                    <p>{{ auth()->user()->nama }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ $desain_belum }}</h3>
                        <p>Desain Belum Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-excel"></i>
                    </div>
                    <a href="/pekerjaan/belum-ada-desain" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $desain_selesai }}</h3>
                        <p>Desain Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="/pekerjaan/sudah-ada-desain" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ $pekerjaan_dikerjakan }}</h3>
                        <p>Pesanan Dikerjakan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <a href="/pekerjaan/dikerjakan" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $pekerjaan_selesai }}</h3>
                        <p>Pesanan Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <a href="/pekerjaan/selesai" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
