@extends('layouts.pengawas')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Project</h4>

        <div class="row">
            @forelse ($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->nama }}</h5>
                            <table>
                                <tr>
                                    <td>Tender </td>
                                    <td>: {{ $project->tender }}</td>
                                </tr>
                                <tr>
                                    <td>Anggaran</td>
                                    <td>: Rp. {{ number_format($project->anggaran, '0', '', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>: {{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} -
                                        {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}</td>
                                </tr>
                            </table>
                            <a href="javascript:void(0)" class="btn btn-primary mt-4">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <h1>Belum ada Project</h1>
            @endforelse
        </div>
    </div>
@endsection
