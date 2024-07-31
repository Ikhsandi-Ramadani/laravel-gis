@extends('layouts.web')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        .leaflet-map {
            height: 700px;
        }

        .table-wrapper {
            max-height: 700px;
            overflow: auto;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="leaflet-map" id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-100">
                <div class="table-wrapper">
                    <table class="table table-bordered" id="table-project">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Jumlah Project</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
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



        @foreach ($kecamatans as $data)
            var data{{ $data->id }} = L.layerGroup();
        @endforeach
        var project = L.layerGroup();



        var map = L.map('map', {
            center: [-4.027078357839807, 120.17884135764147],
            zoom: 10,
            layers: [peta1,
                @foreach ($kecamatans as $data)
                    data{{ $data->id }},
                @endforeach
                project
            ]
        });


        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4,
        };

        var overlayer = {
            @foreach ($kecamatans as $data)
                "{{ $data->nama }}": data{{ $data->id }},
            @endforeach
            "Project": project,
        };

        L.control.layers(baseMaps, overlayer).addTo(map);

        @foreach ($kecamatans as $data)
            L.geoJSON(<?= $data->geojson ?>, {
                style: {
                    color: 'white',
                    fillColor: '{{ $data->warna }}',
                    fillOpacity: 1.0,
                },
            }).addTo(data{{ $data->id }});
        @endforeach

        @foreach ($projects as $project)
            @if ($project->jenis == 'pdam')
                var icon = L.icon({
                    iconUrl: '{{ asset('pdam.png') }}',
                    iconSize: [40, 40],
                });
            @else
                var icon = L.icon({
                    iconUrl: '{{ asset('pamsimas.png') }}',
                    iconSize: [40, 40],
                });
            @endif


            var informasi =
                '<table class="table table-bordered fs-6"><tbody><tr><td>Nama Project</td><td>: {{ $project->nama }}</td></tr><tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} - {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}</td></tr><tr><td>Status</td><td>: @if ($project->status == 1)<span class="badge bg-label-success">Selesai</span>@else<span class="badge bg-label-warning">Sedang Berjalan</span>@endif</td></tr><tr><td colspan="2" class="text-center"><a href="{{ route('detail', $project->id) }}" class="btn btn-sm btn-light">Detail</a></td></tr></tbody></table>';

            L.marker([{{ $project->latitude }}, {{ $project->longitude }}], {
                    icon: icon
                })
                .addTo(project)
                .bindPopup(informasi);
        @endforeach
    </script>
@endpush
