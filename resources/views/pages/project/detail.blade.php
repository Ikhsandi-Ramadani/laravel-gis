@extends('layouts.opd')

@section('title', 'Tambah Kegiatan')

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
    <span class="text-muted fw-light">Kegiatan / </span> Detail
  </h4>

  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 col-12 mb-md-0 mb-4">
          <div class="card">
            <h5 class="card-header">Kegiatan</h5>
            <div class="card-body">
              <p>Detail Kegiatan</p>
              <table class="table">
                <tbody>
                  <tr>
                    <td>No. Kegiatan</td>
                    <td>{{ $kegiatan->no_keg }}</td>
                  </tr>
                  <tr>
                    <td>Nama Kegiatan</td>
                    <td>{{ $kegiatan->nama_keg }}</td>
                  </tr>
                  <tr>
                    <td>OPD Pelaksana</td>
                    <td>{{ $kegiatan->opd->nama }}</td>
                  </tr>
                  <tr>
                    <td>Tanggal Kegiatan</td>
                    <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_keg)->isoFormat('dddd, D MMMM Y') }}
                    </td>
                  </tr>
                  <tr>
                    <td>Desa</td>
                    <td>{{ $kegiatan->desa->nama }}</td>
                  </tr>
                  <tr>
                    <td>kelurahan</td>
                    <td>{{ $kegiatan->kelurahan->nama }}</td>
                  </tr>
                  <tr>
                    <td>kecamatan</td>
                    <td>{{ $kegiatan->kecamatan->nama }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-body" style="margin-top: -20px">
              <p>Lokasi Kegiatan</p>
              <table class="table">
                <tbody>
                  <tr>
                    <td>Nama Tempat</td>
                    <td>{{ $kegiatan->maps->nama }}</td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td>{{ $kegiatan->maps->alamat }}</td>
                  </tr>
                  <tr>
                    <td>Deskripsi</td>
                    <td>{{ $kegiatan->maps->deskripsi }}</td>
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
      <a href="{{ route('kegiatan.index') }}" class="btn btn-primary">Kembali</a>
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
  var mapCenter = [{{ $kegiatan->maps->latitude }}, {{ $kegiatan->maps->longitude }}];
  var map = L.map('mapContainer').setView(mapCenter, 15);
  //   Street Maps
  L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20
    , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  }).addTo(map);
  //   Hybrid Maps for Detail
  //   L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
  //     maxZoom: 20
  //     , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  //   }).addTo(map);

  L.marker([{{ $kegiatan->maps->latitude }}, {{ $kegiatan->maps->longitude }}]).addTo(map)
  axios.get('{{ route("api.places.index") }}')
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

