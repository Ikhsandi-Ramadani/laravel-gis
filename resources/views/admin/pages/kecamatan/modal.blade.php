  <!-- Add New Credit Card Modal -->
  <div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
          <div class="modal-content p-3 p-md-5">
              <div class="modal-body">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="text-center mb-4">
                      <h3>Tambah Kecamatan</h3>
                      <p>Silahkan menambahkan kecamatan baru</p>
                  </div>
                  <form class="row g-3" action="{{ route('kecamatan.store') }}" method="POST">
                      @csrf
                      <div class="col-12">
                          <label class="form-label w-100">Nama Kecamatan</label>
                          <input name="nama" class="form-control" type="text"
                              placeholder="Masukkan Nama Kecamatan" required />
                      </div>
                      <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Simpan</button>
                          <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal"
                              aria-label="Close">
                              Cancel
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <!--/ Add New Credit Card Modal -->

  @foreach ($kecamatans as $kecamatan)
      @isset($kecamatan->id)
          <div class="modal fade" id="edit-{{ $kecamatan->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content p-3 p-md-5">
                      <div class="modal-body">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          <div class="text-center mb-4">
                              <h3>Edit Kecamatan</h3>
                              <p>Silahkan mengedit kecamatan yang diinginkan</p>
                          </div>
                          <form class="row g-3" action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="col-12">
                                  <label class="form-label w-100">Nama Kecamatan</label>
                                  <input name="nama" class="form-control" type="text" value="{{ $kecamatan->nama }}"
                                      required />
                              </div>
                              <div class="col-12 text-center">
                                  <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Simpan</button>
                                  <button type="reset" class="btn btn-label-secondary btn-reset mt-3"
                                      data-bs-dismiss="modal" aria-label="Close">
                                      Cancel
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Modal Delete -->
          <div class="modal fade" id="hapus-{{ $kecamatan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus Kecamatan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                          </button>
                      </div>
                      <form action="{{ route('kecamatan.destroy', $kecamatan->id) }}" method="post">
                          @method('DELETE')
                          @csrf
                          <input type="hidden" name="id" id="id" value="{{ $kecamatan->id }}">
                          <div class="modal-body">
                              Anda yakin ingin menghapus Kecamatan <b>{{ $kecamatan->nama }}</b> ini ?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  <i class="bx bx-x d-block d-sm-none"></i>
                                  <span class="d-none d-sm-block">Tutup</span>
                              </button>
                              <button type="submit" class="btn btn-outline-danger ml-1" id="btn-save">
                                  <i class="bx bx-check d-block d-sm-none"></i>
                                  <span class="d-none d-sm-block">Yakin</span>
                              </button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      @endisset
  @endforeach
