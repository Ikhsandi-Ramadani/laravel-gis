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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="leaflet-map" id="map"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <div class="text-center fw-bold pt-3 pt-md-0">
                        <h2>Data Project</h2>
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
                                </tr>
                            @endforeach
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
            $('#table-project').DataTable({
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
        var data{{ $kecamatan->id }} = L.layerGroup();

        var map = L.map('map', {
            center: [-4.027078357839807, 120.17884135764147],
            zoom: 11,
            layers: [peta2, data{{ $kecamatan->id }}, project]
        });


        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4,
        };

        var overlayer = {
            "{{ $kecamatan->nama }}": data{{ $kecamatan->id }},
            "Project": project,
        };

        L.control.layers(baseMaps, overlayer).addTo(map);

        var kecamatan = L.geoJSON(<?= $kecamatan->geojson ?>, {
            style: {
                color: 'white',
                fillColor: '{{ $kecamatan->warna }}',
                fillOpacity: 0.5,
            },
        }).addTo(data{{ $kecamatan->id }});

        map.fitBounds(kecamatan.getBounds());

        @foreach ($projects as $project)

            var informasi =
                '<table class="table table-bordered fs-6"><tbody><tr><td>Nama Project</td><td>: {{ $project->nama }}</td></tr><tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} - {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}</td></tr><tr><td>Status</td><td>: @if ($project->status == 1)<span class="badge bg-label-success">Selesai</span>@else<span class="badge bg-label-warning">Sedang Berjalan</span>@endif</td></tr><tr><td colspan="2" class="text-center"><a href="{{ route('detail', $project->id) }}" class="btn btn-sm btn-light">Detail</a></td></tr></tbody></table>';

            L.marker([{{ $project->latitude }}, {{ $project->longitude }}], )
                .addTo(project)
                .bindPopup(informasi);
        @endforeach
    </script>
@endpush
