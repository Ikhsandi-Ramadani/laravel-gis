  <!-- Add New Credit Card Modal -->
  <div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
          <div class="modal-content p-3 p-md-5">
              <div class="modal-body">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="text-center mb-4">
                      <h3>Tambah Pengawas</h3>
                      <p>Silahkan menambahkan pengawas baru</p>
                  </div>
                  <form class="row g-3" action="{{ route('pengawas.store') }}" method="POST">
                      @csrf
                      <div class="col-6">
                          <label class="form-label w-100">Nama Pengawas</label>
                          <input name="nama" class="form-control" type="text" placeholder="Masukkan Nama Pengawas"
                              required />
                      </div>
                      <div class="col-6 col-md-6">
                          <label class="form-label">No. Telpon</label>
                          <input type="text" name="telp" class="form-control" placeholder="Masukkan No.Telp"
                              required />
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

  @foreach ($pengawass as $pengawas)
      @isset($pengawas->id)
          <div class="modal fade" id="edit-{{ $pengawas->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content p-3 p-md-5">
                      <div class="modal-body">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          <div class="text-center mb-4">
                              <h3>Edit Pengawas</h3>
                              <p>Silahkan mengedit pengawas yang diinginkan</p>
                          </div>
                          <form class="row g-3" action="{{ route('pengawas.update', $pengawas->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="col-6">
                                  <label class="form-label w-100">Nama Pengawas</label>
                                  <input name="nama" class="form-control" type="text" value="{{ $pengawas->nama }}"
                                      required />
                              </div>
                              <div class="col-6 col-md-6">
                                  <label class="form-label">No. Telpon</label>
                                  <input type="text" name="telp" class="form-control" value="{{ $pengawas->telp }}"
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
          <div class="modal fade" id="hapus-{{ $pengawas->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus Pengawas</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                          </button>
                      </div>
                      <form action="{{ route('pengawas.destroy', $pengawas->id) }}" method="post">
                          @method('DELETE')
                          @csrf
                          <input type="hidden" name="id" id="id" value="{{ $pengawas->id }}">
                          <div class="modal-body">
                              Anda yakin ingin menghapus Pengawas <b>{{ $pengawas->nama }}</b> ini ?
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
