@extends('layouts.admin')

@section('title', 'Detail Project')

@push('style')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/leaflet/leaflet.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Project / </span> Detail
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <div class="card">
                            <h5 class="card-header">Project</h5>
                            <div class="card-body">
                                <p>Detail Project</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nama Project</td>
                                            <td>{{ $project->nama_keg }}</td>
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
                                            <td>Tanggal</td>
                                            <td>{{ \Carbon\Carbon::parse($project->t_awal)->isoFormat('D') }} -
                                                {{ \Carbon\Carbon::parse($project->t_akhir)->isoFormat('D MMMM Y') }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body" style="margin-top: -20px">
                                <p>Lokasi Project</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>kecamatan</td>
                                            <td>{{ $project->kecamatan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>kelurahan</td>
                                            <td>{{ $project->kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Desa</td>
                                            <td>{{ $project->desa }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <h5 class="card-header">Maps</h5>
                            <div class="card-body" style="min-height: 500px" id="mapContainer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-4">
                <a href="{{ route('project.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('backend/vendor/libs/select2/select2.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/form-layouts.js') }}"></script>
    <script src="{{ asset('backend/vendor/libs/leaflet/leaflet.js') }}"></script>

    <script type="text/javascript">
        //   For Maps
        var mapCenter = [{{ $project->latitude }}, {{ $project->longitude }}];
        var map = L.map('mapContainer').setView(mapCenter, 15);
        //   Street Maps
        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        //   Hybrid Maps for Detail
        //   L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        //     maxZoom: 20
        //     , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        //   }).addTo(map);

        L.marker([{{ $project->latitude }}, {{ $project->longitude }}]).addTo(map)
        axios.get('{{ route('project.index') }}')
            .then(function(response) {
                //console.log(response.data);
                L.geoJSON(response.data, {
                        pointToLayer: function(geoJsonPoint, latlng) {
                            return L.marker(latlng);
                        }
                    })
                    .bindPopup(function(layer) {
                        //return layer.feature.properties.map_popup_content;
                        return ('<div class="my-2"><strong>Place Name</strong> :<br>' + layer.feature.properties
                            .place_name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + layer
                            .feature.properties.description +
                            '</div><div class="my-2"><strong>Address</strong>:<br>' + layer.feature.properties
                            .address + '</div>');
                    }).addTo(map);
                console.log(response.data);
            })
            .catch(function(error) {
                console.log(error);
            });
    </script>
@endpush
