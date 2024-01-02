@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Dashboard</h4>
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $pengawas }}</h4>
                        </div>
                        <p class="mb-1">Jumlah Pengawas</p>
                        {{-- <p class="mb-0">
                            <span class="fw-medium me-1">+18.2%</span>
                            <small class="text-muted">than last week</small>
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-building"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $kecamatan }}</h4>
                        </div>
                        <p class="mb-1">Jumlah Kecamatan</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i
                                        class="bx bx-git-repo-forked"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $berjalan }}</h4>
                        </div>
                        <p class="mb-1">Proyek Berjalan</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $selesai }}</h4>
                        </div>
                        <p class="mb-1">Proyek Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
