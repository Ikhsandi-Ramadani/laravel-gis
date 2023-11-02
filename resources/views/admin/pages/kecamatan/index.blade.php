@extends('layouts.admin')

@section('title', 'Kecamatan')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <h4 class="fw-bold py-3 mb-4">Kecamatan</h4>

        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="text-end pt-3 pt-md-0">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah">
                        <span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">Tambah
                                Kecamatan</span></span>
                    </button>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="table table-bordered" id="table-kecamatan">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kecamatans as $kecamatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kecamatan->nama }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#edit-{{ $kecamatan->id }}"><span><i class="bx bx-edit me-sm-2"></i>
                                            <span class="d-none d-sm-inline-block">Edit</span></span> </button>
                                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#hapus-{{ $kecamatan->id }}"><span><i
                                                class="bx bx-trash me-sm-2"></i> <span
                                                class="d-none d-sm-inline-block">Delete</span></span> </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Modal --}}
                @include('pages.kecamatan.modal')
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-kecamatan').DataTable({
                // Scroll options
                scrollY: '300px',
                scrollX: true,
            });
        });
    </script>
@endpush
