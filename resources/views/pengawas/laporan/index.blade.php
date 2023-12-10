@extends('layouts.pengawas')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between">
            <h4 class="fw-bold py-3 mb-4">Project {{ $project->nama }}</h4>
            <a href="#" class="btn btn-primary py-3 mb-4">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <div class="card">
                            <h5 class="card-header">Detail Project</h5>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nama Project</td>
                                            <td>{{ $project->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tender</td>
                                            <td>{{ $project->tender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Anggaran</td>
                                            <td>Rp. {{ number_format($project->anggaran, '0', '', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Project</td>
                                            <td> {{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} -
                                                {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}</td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kelurahan/Desa</td>
                                            <td>{{ $project->kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <td>kecamatan</td>
                                            <td>{{ $project->kecamatan->nama }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <h5 class="card-header">Maps</h5>
                            <div class="card-body" style="min-height: 500px" id="map">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    {{-- Error --}}
                    @if ($errors->any())
                        <ul class="mt-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {{-- End Error --}}
                    <div class="card-header flex-column flex-md-row">
                        <div class="text-end pt-3 pt-md-0">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah">
                                <span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">Tambah
                                        Laporan</span></span>
                            </button>
                        </div>
                    </div>
                    <div class="card-datatable text-nowrap">
                        <table class="table table-bordered" id="table-laporan">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Foto</th>
                                    <th>Catatan</th>
                                    <th>Tangal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($laporan->foto)
                                                <img src="{{ asset('storage/foto/' . $laporan->foto) }}"
                                                    style="height: 50px;width:100px;">
                                            @else
                                                <span>Belum ada gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $laporan->catatan }}</td>
                                        <td> {{ \Carbon\Carbon::parse($laporan->tanggal)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                                data-bs-target="#edit-{{ $laporan->id }}"><span><i
                                                        class="bx bx-edit me-sm-2"></i>
                                                    <span class="d-none d-sm-inline-block">Edit</span></span> </button>
                                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                                data-bs-target="#hapus-{{ $laporan->id }}"><span><i
                                                        class="bx bx-trash me-sm-2"></i> <span
                                                        class="d-none d-sm-inline-block">Delete</span></span> </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pengawas.laporan.modal')
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table-laporan').DataTable({
                // Scroll options
                scrollY: '300px',
                scrollX: true,
            });
        });

        var peta1 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaWtoc2FuZGlyYW1hZGFuaSIsImEiOiJjbG03bHk5OHAwMXM0M2Nvc240M2g1bG0wIn0.e-7lftp8mBogPgouQbxCKQ', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11'
            });

        var peta2 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaWtoc2FuZGlyYW1hZGFuaSIsImEiOiJjbG03bHk5OHAwMXM0M2Nvc240M2g1bG0wIn0.e-7lftp8mBogPgouQbxCKQ', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/satellite-v9'
            });


        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var peta4 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaWtoc2FuZGlyYW1hZGFuaSIsImEiOiJjbG03bHk5OHAwMXM0M2Nvc240M2g1bG0wIn0.e-7lftp8mBogPgouQbxCKQ', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/dark-v10'
            });

        var map = L.map('map', {
            center: [{{ $project->latitude }}, {{ $project->longitude }}],
            zoom: 14,
            layers: [peta1],
        });

        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4,
        };

        L.control.layers(baseMaps).addTo(map);

        //mengambil titik koordinat
        var curLocation = [{{ $project->latitude }}, {{ $project->longitude }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation);
        map.addLayer(marker);

        //ambil koordinat saat marker di drag n drop
        // marker.on('dragend', function(event) {
        //     var position = marker.getLatLng();
        //     marker.setLatLng(position, {
        //         draggable: 'true',
        //     }).bindPopup(position).update();
        //     //console.log(position.lat + "," + position.lng);
        //     $("#posisi").val(position.lat + "," + position.lng).keyup();
        // });

        //ambil koordinat saatmap diklik
        // var posisi = document.querySelector("[name=posisi]");
        // map.on("click", function(event) {
        //     var lat = event.latlng.lat;
        //     var lng = event.latlng.lng;
        //     if (!marker) {
        //         marker = L.marker(event.latlng).addTo(map);
        //     } else {
        //         marker.setLatLng(event.latlng);
        //     }
        //     posisi.value = lat + "," + lng;
        // });
    </script>
@endpush
