@extends('layouts.web')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        .leaflet-map {
            height: 700px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <h5 class="card-header">Maps</h5>
                        <div class="card-body">
                            <div class="leaflet-map" id="map"></div>
                        </div>
                    </div>
                </div>
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
                                        <td>Pengawas</td>
                                        <td>{{ $project->pengawas->name }}</td>
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
                                        <td>Desa</td>
                                        <td>{{ $project->desa }}</td>
                                    </tr>
                                    <tr>
                                        <td>kelurahan</td>
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

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Laporan</h4>
                <div class="card-datatable text-nowrap">
                    <table class="table table-bordered" id="table-laporan">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Foto</th>
                                <th>Catatan</th>
                                <th>Tangal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($project->laporan as $laporan)
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
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-laporan').DataTable({
                // Scroll options
                scrollY: '300px',
                scrollX: true,
            });
        });
    </script>

    <script>
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

        var project = L.layerGroup();

        var map = L.map('map', {
            center: [-4.027078357839807, 120.17884135764147],
            zoom: 11,
            layers: [peta2, project]
        });


        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4,
        };

        var overlayer = {
            "Project": project,
        };

        L.control.layers(baseMaps, overlayer).addTo(map);

        var informasi =
            '{{ $project->nama }}';

        L.marker([{{ $project->latitude }}, {{ $project->longitude }}], )
            .addTo(project)
            .bindPopup(informasi);
    </script>
@endpush
