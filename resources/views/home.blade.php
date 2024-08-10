@extends('layouts.web')

@push('style')
    <!-- Menyertakan stylesheet untuk Leaflet -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        /* Mengatur tinggi peta */
        .leaflet-map {
            height: 700px;
        }

        /* Mengatur tinggi dan overflow dari wrapper tabel */
        .table-wrapper {
            max-height: 700px;
            overflow: auto;
            display: inline-block;
        }

        /* Styling untuk label kecamatan */
        .kecamatan-label {
            text-align: center;
            white-space: nowrap; /* Mencegah teks terputus */
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card h-100">
                <div class="card-body">
                    <!-- Tempatkan peta Leaflet di dalam div ini -->
                    <div class="leaflet-map" id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-100">
                <div class="table-wrapper">
                    <!-- Tabel untuk menampilkan data kecamatan dan jumlah proyek -->
                    <table class="table table-bordered" id="table-project">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Jumlah Project</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iterasi data kecamatan untuk menampilkan nama kecamatan, jumlah proyek, dan aksi -->
                            @foreach ($kecamatans as $kecamatan)
                                <tr>
                                    <td>{{ $kecamatan->nama }}</td>
                                    <td>{{ $kecamatan->projects_count }}</td>
                                    <td>
                                        <a href="{{ route('kecamatan', $kecamatan->id) }}" class="btn btn-warning">
                                            Detail
                                        </a>
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
    <!-- Menyertakan script untuk Leaflet -->
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script>
        // Token Mapbox (Ganti dengan token valid jika diperlukan)
        var accessToken = 'pk.eyJ1IjoiaWtoc2FuZGlyYW1hZGFuaSIsImEiOiJjbG03bHk5OHAwMXM0M2Nvc240M2g1bG0wIn0.e-7lftp8mBogPgouQbxCKQ';

        // Mendefinisikan layer peta dari Mapbox dan OpenStreetMap
        var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11'
        });

        var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/satellite-v9'
        });

        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/dark-v10'
        });

        // Membuat layer untuk setiap kecamatan
        @foreach ($kecamatans as $data)
            var data{{ $data->id }} = L.layerGroup();
        @endforeach

        var project = L.layerGroup(); // Membuat layer untuk proyek

        // Menginisialisasi peta dengan lokasi dan zoom level tertentu
        var map = L.map('map', {
            center: [-4.027078357839807, 120.17884135764147], // Lokasi awal peta
            zoom: 10, // Zoom level awal
            layers: [peta1, 
                @foreach ($kecamatans as $data)
                    data{{ $data->id }},
                @endforeach
                project
            ]
        });

        // Menyiapkan data proyek per kecamatan
        @php
        $projectGaris = App\Models\Projects::all();
        $projectGarisPerKecamatan = []; // Array untuk menyimpan koordinat proyek per kecamatan
        foreach ($projectGaris as $project) {
            $projectGarisPerKecamatan[$project->kecamatan_id][] = [
                'lat' => $project->latitude,
                'lng' => $project->longitude
            ];
        }
        @endphp

        // Menggambar garis putus-putus untuk setiap kecamatan berdasarkan koordinat proyek
        @foreach($projectGarisPerKecamatan as $kecamatanId => $coordinates)
            var projectCoordinates{{ $kecamatanId }} = [
                @foreach($coordinates as $coordinate)
                    [{{ $coordinate['lat'] }}, {{ $coordinate['lng'] }}],
                @endforeach
            ];

            var polyline{{ $kecamatanId }} = L.polyline(projectCoordinates{{ $kecamatanId }}, {
                color: 'red',           // Warna garis
                weight: 3,              // Ketebalan garis
                dashArray: '5, 10'      // Pola garis putus-putus
            }).addTo(map);

            // Menyesuaikan tampilan peta agar sesuai dengan bounds dari garis yang digambar
            map.fitBounds(polyline{{ $kecamatanId }}.getBounds());
        @endforeach

        // Menambahkan kontrol layer untuk memilih peta dasar dan overlay
        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4
        };

        var overlayer = {
            @foreach ($kecamatans as $data)
                "{{ $data->nama }}": data{{ $data->id }},
            @endforeach
            "Project": project
        };

        L.control.layers(baseMaps, overlayer).addTo(map);

        // Menambahkan geoJSON untuk setiap kecamatan
        @foreach ($kecamatans as $data)
            var layer{{ $data->id }} = L.geoJSON(<?= $data->geojson ?>, {
                style: {
                    color: 'white',
                    fillColor: '{{ $data->warna }}', // Warna isian untuk kecamatan
                    fillOpacity: 0.1, // Transparansi isian
                },
            }).addTo(data{{ $data->id }});

            // Menambahkan label untuk nama kecamatan
            var center = layer{{ $data->id }}.getBounds().getCenter();
            L.marker(center, {
                icon: L.divIcon({
                    className: 'kecamatan-label',
                    html: '<div style="background-color: ; padding: 2px; border-radius: 5px; font-size: 20px; font-weight: bold;">{{ $data->nama }}</div>'
                })
            }).addTo(map);
        @endforeach

        // Menambahkan marker untuk setiap proyek berdasarkan jenis dan statusnya
        @foreach ($projects as $project)
            var iconUrl;

            // Menentukan ikon berdasarkan jenis dan status proyek
            @if ($project->jenis == 'pdam')
                iconUrl = '{{ $project->status === 0 ? asset('pdam_selesai.png') : asset('pdam_start.png') }}';
            @else
                iconUrl = '{{ $project->status === 0 ? asset('pamsimas_start.png') : asset('pamsimas-selesai.png') }}';
            @endif

            // Menambahkan marker dengan ikon yang sesuai dan popup yang berisi informasi proyek
            L.marker([{{ $project->latitude }}, {{ $project->longitude }}], {
                icon: L.icon({
                    iconUrl: iconUrl, // Menentukan URL ikon
                    iconSize: [40, 40] // Ukuran ikon
                })
            }).addTo(project)
            .bindPopup(
                '<b>{{ $project->nama }}</b><br>' +
                'Kecamatan: {{ $project->kecamatan->nama }}<br>' +
                'Status: {{ $project->status == 0 ? 'Dalam Proses' : 'Selesai' }}'
            );
        @endforeach
    </script>
@endpush