@extends('layouts.admin')

@section('title', 'Data Project')

@push('style')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Project</span></h4>

        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="text-end pt-3 pt-md-0">
                    <a class="btn btn-primary" href="{{ route('project.create') }}"><span><i class="bx bx-plus me-sm-2"></i>
                            <span class="d-none d-sm-inline-block">Tambah
                                Data</span></span>
                    </a>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="table table-bordered" id="table-project">
                    <thead>
                        <tr>
                            <th>Nama Projek</th>
                            <th>Pengawas</th>
                            <th>Anggaran</th>
                            <th>Tender</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->nama }}</td>
                                <td>{{ $project->pengawas->name }}</td>
                                <td>Rp. {{ number_format($project->anggaran, '0', '', '.') }}</td>
                                <td>{{ $project->tender }}</td>
                                <td>{{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} -
                                    {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}</td>
                                <td>
                                    @if ($project->status == 1)
                                        <span class="badge bg-label-success">Selesai</span>
                                    @else
                                        <span class="badge bg-label-warning">Sedang Berjalan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('project.show', $project->id) }}"
                                        class="btn btn-warning btn-sm"><span><i class="fa-solid fa-eye fa-lg"></i></span>
                                    </a>
                                    <a href="{{ route('project.edit', $project->id) }}"
                                        class="btn btn-primary btn-sm"><span><i class="fa-solid fa-pen-to-square fa-lg"></i>
                                        </span>
                                    </a>
                                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalDelete{{ $project->id }}"><span><i
                                                class="fa-solid fa-trash fa-lg"></i> </span>
                                    </button>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="modalDelete{{ $project->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Project</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <form action="{{ route('project.destroy', $project->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="id" id="id"
                                                value="{{ $project->id }}">
                                            <div class="modal-body text-wrap">
                                                Anda yakin ingin menghapus Project <b>{{ $project->nama }} </b>ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Tutup</span>
                                                </button>
                                                <button type="submit" class="btn btn-outline-danger ml-1" id="btn-save">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Yakin</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-project').DataTable({
                // Scroll options
                scrollY: '300px',
                scrollX: true,
            });
        });
    </script>
@endpush
