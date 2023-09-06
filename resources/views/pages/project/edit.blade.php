@extends('layouts.opd')

@section('title','Edit Kegiatan')

@push('style')
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css') }}" />
{{-- <link rel="stylesheet" href="{{ asset('backend/vendor/libs/flatpickr/flatpickr.css') }}" /> --}}
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/leaflet/leaflet.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css" />

@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @if ($message = Session::get('success'))
  <div class="alert alert-success">
    <p>{{ $message }}</p>
  </div>
  @endif

  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kegiatan/</span> Edit</h4>
  <div class="card mb-4">
    {{-- <h5 class="card-header">Multi Column with Form Separator</h5> --}}
    <form class="card-body" action="{{ route('kegiatan.update',$kegiatan->id) }}" method="POST">
      @csrf
      @method("PUT")
      <h5 class="card-header" style="padding: 1.5rem 0">Data Kegiatan</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">No. Kegiatan</label>
          <input type="text" class="form-control" value="{{ $kegiatan->no_keg }}" name="no_keg" required />
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Kegiatan</label>
          <input type="text" class="form-control" value="{{ $kegiatan->nama_keg }}" name="nama_keg" required />
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <input type="text" class="form-control tanggal" id="tanggal" name="tanggal_keg" value="{{ $kegiatan->tanggal_keg }}" required />
        </div>
      </div>
      <hr class="my-4 mx-n4" />
      <h5 class="card-header" style="padding: 1.5rem 0">Lokasi Kegiatan</h5>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Kecamatan</label>
          <select class="select2 form-select" data-allow-clear="true" name="kecamatan_id">
            @foreach ($kecamatan as $camat)
            <option value="{{ $camat->id }}" {{ $camat->id == $kegiatan->camat_id ? 'selected' : '' }}>{{ $camat->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Kelurahan</label>
          <select class="select2 form-select" data-allow-clear="true" name="kelurahan_id">
            @foreach ($kelurahan as $lurah)
            <option value="{{ $lurah->id }}" {{ $lurah->id == $kegiatan->kelurahan_id ? 'selected' : '' }}>{{ $lurah->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Desa</label>
          <select class="select2 form-select" data-allow-clear="true" name="desa_id">
            @foreach ($desa as $d)
            <option value="{{ $d->id }}" {{ $d->id == $kegiatan->desa_id ? 'selected' : '' }}>{{ $d->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-8">
          <label class="form-label">Maps</label>
          <div style="min-height: 500px;" id="mapContainer"></div>
        </div>
        <div class="col-md-4">
          <label class="form-label">Detail Maps</label>
          <div class="col-md-12">
            <label class="form-label">Nama lokasi</label>
            <input type="text" class="form-control" value="{{ $kegiatan->maps->nama }}" name="nama_lok" required />
          </div>
          <div class="col-md-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat_lok" id="" cols="30" rows="4" class="form-control" required>{{ $kegiatan->maps->alamat }}</textarea>
          </div>
          <div class="col-md-12">
            <label class="form-label">Deskripsi Lokasi</label>
            <textarea name="deskripsi_lok" id="" cols="30" rows="4" class="form-control" required>{{ $kegiatan->maps->deskripsi }}</textarea>
          </div>
          <div class="col-md-12">
            <label class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" value="{{ $kegiatan->maps->latitude }}" name="latitude" readonly required />
          </div>
          <div class="col-md-12">
            <label class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" value="{{ $kegiatan->maps->longitude }}" name="longitude" readonly required />
          </div>
        </div>
      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-label-secondary">Cancel</a>
      </div>
    </form>
  </div>

</div>
@endsection

@push('script')
<!-- Vendors JS -->
<script src="{{ asset('backend/vendor/libs/moment/moment.js') }}"></script>
{{-- <script src="{{ asset('backend/vendor/libs/flatpickr/flatpickr.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script src="{{ asset('backend/vendor/libs/select2/select2.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('backend/js/form-layouts.js') }}"></script>
<script src="{{ asset('backend/vendor/libs/leaflet/leaflet.js') }}"></script>

<script type="text/javascript">
  $("#tanggal").flatpickr();
  // Untuk Validasi Data
  var bsValidationForms = document.querySelectorAll(".needs-validation");

  Array.prototype.slice.call(bsValidationForms).forEach(function(form) {
    form.addEventListener(
      "submit"
      , function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      }
      , false
    );
  });
  // End Validasi Data

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
</script>
@endpush
