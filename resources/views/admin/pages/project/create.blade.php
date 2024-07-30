@extends('layouts.admin')

@section('title', 'Tambah Project')

@push('style')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
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

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Project/</span> Tambah</h4>
        <div class="card mb-4">
            {{-- <h5 class="card-header">Multi Column with Form Separator</h5> --}}
            <form class="card-body" action="{{ route('project.store') }}" method="POST">
                @csrf
                <h5 class="card-header" style="padding: 1.5rem 0">Data Project</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Project</label>
                        <input type="text" class="form-control" placeholder="Nama Project" name="nama" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pengawas</label>
                        <select name="pengawas_id" class="form-control" required>
                            @foreach ($pengawass as $pengawas)
                                <option value="{{ $pengawas->id }}">{{ $pengawas->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="t_awal" placeholder="DD-MM-YYYY" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal akhir</label>
                        <input type="date" class="form-control" name="t_akhir" placeholder="DD-MM-YYYY" required />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" cols="30" rows="5" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tender</label>
                        <input type="text" class="form-control" placeholder="Nama Tender" name="tender" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Anggaran</label>
                        <input type="number" class="form-control" placeholder="Anggaran" name="anggaran" required />
                    </div>
                </div>

                <hr class="my-4 mx-n4" />

                <h5 class="card-header" style="padding: 1.5rem 0">Lokasi Project</h5>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Maps</label>
                        <div style="min-height: 500px;" id="mapContainer"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Detail Lokasi</label>
                        <div class="col-md-12">
                            <label class="form-label">Kecamatan</label>
                            <select name="kecamatan_id" class="form-control" required>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Kelurahan/Desa</label>
                            <input type="text" class="form-control" placeholder="Kelurahan" name="kelurahan" required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" placeholder="Latitude" name="latitude"
                             required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" placeholder="Longitude"
                                name="longitude" required />
                        </div>
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
