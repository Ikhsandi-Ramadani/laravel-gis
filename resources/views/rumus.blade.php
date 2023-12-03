@extends('layouts.web')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        .leaflet-map {
            height: 700px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <div class="leaflet-map" id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hitung Euclidean Distance</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('hitung') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                placeholder="Latitude">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Longitude">
                        </div>
                        <button type="submit" class="btn btn-primary">Hitung</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($hasil == true)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="text-center fw-bold pt-3 pt-md-0">
                            <h2>Hasil</h2>
                        </div>
                    </div>
                    <div class="card-datatable text-nowrap">
                        <table class="table table-bordered" id="table-project">
                            <thead>
                                <tr>
                                    <th>Nama Projek</th>
                                    <th>Jarak (Km)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distances as $id => $value)
                                    @php
                                        $project = App\Models\Projects::findorfail($id);
                                    @endphp
                                    <tr>
                                        <td>{{ $project->nama }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script type="text/javascript">
        //   For Maps
        @if ($hasil == true)
            var mapCenter = [{{ $latitude }}, {{ $longitude }}];
        @else 
            var mapCenter = ['-3.9941999757946536', '120.18023305568417'];
        @endif
        var map = L.map('map').setView(mapCenter, 15);
        //   Street Maps
        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);

        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Your location :" + marker.getLatLng().toString())
                .openPopup();
            return false;
        };
        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude);
        });
        var updateMarkerByInputs = function() {
            return updateMarker($('#latitude').val(), $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);
    </script>
@endpush
