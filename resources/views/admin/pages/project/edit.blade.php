@extends('layouts.admin')

@section('title', 'Edit Project')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css') }}" />
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

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Project/</span> Edit</h4>
        <div class="card mb-4">
            {{-- <h5 class="card-header">Multi Column with Form Separator</h5> --}}
            <form class="card-body" action="{{ route('project.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                <h5 class="card-header" style="padding: 1.5rem 0">Data Project</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Project</label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="pdam" {{ $project->jenis == 'pdam' ? 'selected' : '' }}>PDAM</option>
                            <option value="pamsimas" {{ $project->jenis == 'pamsimas' ? 'selected' : '' }}>PAMSIMAS</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Project</label>
                        <input type="text" class="form-control" value="{{ $project->nama }}" name="nama" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pengawas</label>
                        <select name="pengawas_id" class="form-control" required>
                            @foreach ($pengawass as $pengawas)
                                <option value="{{ $pengawas->id }}"
                                    {{ $project->pengawas_id == $pengawas->id ? 'selected' : '' }}>{{ $pengawas->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="t_awal" value="{{ $project->t_awal }}" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal akhir</label>
                        <input type="date" class="form-control" name="t_akhir" value="{{ $project->t_akhir }}"
                            required />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" cols="30" rows="5" class="form-control" required>{{ $project->deskripsi }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tender</label>
                        <input type="text" class="form-control" value="{{ $project->tender }}" name="tender"
                            required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Anggaran</label>
                        <input type="number" class="form-control" value="{{ $project->anggaran }}" name="anggaran"
                            required />
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
                                    <option value="{{ $kecamatan->id }}"
                                        {{ $project->kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                        {{ $kecamatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Kelurahan/Desa</label>
                            <input type="text" class="form-control" value="{{ $project->kelurahan }}" name="kelurahan"
                                required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" value="{{ $project->latitude }}"
                                name="latitude" required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" value="{{ $project->longitude }}"
                                name="longitude" required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Status</label> <br>
                            <div class="form-check form-check-inline form-check-warning">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio1"
                                    value="0" {{ $project->status == 0 ? 'checked' : '' }} />
                                <label class="form-check-label" for="inlineRadio1">Sedang berjalan</label>
                            </div>
                            <div class="form-check form-check-inline form-check-success">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio2"
                                    value="1" {{ $project->status == 1 ? 'checked' : '' }} />
                                <label class="form-check-label" for="inlineRadio2">Selesai</label>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="card-header" style="padding: 1.5rem 0">Sumber Air</h5>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Maps</label>
                        <div style="min-height: 500px;" id="mapContainer2"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Detail Lokasi</label>
                        <div class="col-md-12">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude2" placeholder="Latitude"
                                name="sumber_lat" required value="{{ $project->sumber_lat }}" />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude2" placeholder="Longitude"
                                name="sumber_long" required value="{{ $project->sumber_long }}" />
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <a href="{{ route('project.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('backend/vendor/libs/select2/select2.js') }}"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script type="text/javascript">
        //   For Maps
        var mapCenter = [{{ $project->latitude }}, {{ $project->longitude }}];
        var mapCenter2 = [{{ $project->sumber_lat }}, {{ $project->sumber_long }}];
        var map = L.map('mapContainer').setView(mapCenter, 15);
        var map2 = L.map('mapContainer2').setView(mapCenter2, 15);
        //   Street Maps
        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map2);
        //   Hybrid Maps for Detail
        //   L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        //     maxZoom: 20
        //     , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        //   }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);

        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Your location : " + marker.getLatLng().toString())
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

        // Bagian Sumber
        var marker2 = L.marker(mapCenter2).addTo(map2);

        function updateMarker2(lat, lng) {
            marker2
                .setLatLng([lat, lng])
                .bindPopup("Your location : " + marker2.getLatLng().toString())
                .openPopup();
            return false;
        };
        map2.on('click', function(e) {
            let latitude2 = e.latlng.lat.toString().substring(0, 15);
            let longitude2 = e.latlng.lng.toString().substring(0, 15);
            $('#latitude2').val(latitude2);
            $('#longitude2').val(longitude2);
            updateMarker2(latitude2, longitude2);
        });
        var updateMarkerByInputs2 = function() {
            return updateMarker2($('#latitude2').val(), $('#longitude2').val());
        }
        $('#latitude2').on('input', updateMarkerByInputs2);
        $('#longitude2').on('input', updateMarkerByInputs2);
    </script>
@endpush
