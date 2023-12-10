@extends('layouts.admin')

@section('title', 'Tambah Kecamatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kecamatan/</span> Tambah</h4>
        <div class="card mb-4">
            {{-- <h5 class="card-header">Multi Column with Form Separator</h5> --}}
            <form class="card-body" action="{{ route('kecamatan.store') }}" method="POST">
                @csrf
                <h5 class="card-header" style="padding: 1.5rem 0">Data Kecamatan</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Kecamatan</label>
                        <input type="text" class="form-control" placeholder="Nama Kecamatan" name="nama" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Warna</label>
                        <input type="text" class="form-control" placeholder="Warna" name="warna" required />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Geojson</label>
                        <textarea name="geojson" cols="30" rows="5" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script type="text/javascript">
        //   For Maps
        var mapCenter = ['-3.9941999757946536', '120.18023305568417'];
        var map = L.map('mapContainer').setView(mapCenter, 15);
        //   Street Maps
        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        //   Hybrid Maps for Detail
        // L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        //     maxZoom: 20,
        //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        // }).addTo(map);

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
