  <!-- Add New Credit Card Modal -->
  <div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
          <div class="modal-content p-3 p-md-5">
              <div class="modal-body">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="text-center mb-4">
                      <h3>Tambah Laporan</h3>
                      <p>Silahkan menambahkan laporan baru</p>
                  </div>
                  <form class="row g-3" action="{{ route('laporan.store', $project->id) }}" method="POST"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="col-6">
                          <label class="form-label w-100">Foto</label>
                          <input name="foto" class="form-control" type="file" placeholder="Masukkan Foto Laporan"
                              required />
                      </div>
                      <div class="col-6">
                          <label class="form-label w-100">Tanggal</label>
                          <input name="tanggal" class="form-control" type="date"
                              placeholder="Masukkan Tanggal Laporan" required />
                      </div>
                      <div class="col-12">
                          <label class="form-label w-100">Catatan</label>
                          <input name="catatan" class="form-control" type="text" placeholder="Masukkan Catatan"
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

  @foreach ($laporans as $laporan)
      @isset($laporan->id)
          <div class="modal fade" id="edit-{{ $laporan->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content p-3 p-md-5">
                      <div class="modal-body">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          <div class="text-center mb-4">
                              <h3>Edit Laporan</h3>
                              <p>Silahkan mengedit laporan yang diinginkan</p>
                          </div>
                          <form class="row g-3" action="{{ route('laporan.update', [$project->id, $laporan->id]) }}"
                              method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="col-6">
                                  <label class="form-label w-100">Foto</label>
                                  <input name="foto" class="form-control" type="file"
                                      placeholder="Masukkan Foto Laporan" />
                              </div>
                              <div class="col-6">
                                  <label class="form-label w-100">Tanggal</label>
                                  <input name="tanggal" class="form-control" type="date" value="{{ $laporan->tanggal }}"
                                      required />
                              </div>
                              <div class="col-12">
                                  <label class="form-label w-100">Catatan</label>
                                  <input name="catatan" class="form-control" type="text" value="{{ $laporan->catatan }}"
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
          <div class="modal fade" id="hapus-{{ $laporan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus Laporan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                          </button>
                      </div>
                      <form action="{{ route('laporan.destroy', [$project->id, $laporan->id]) }}" method="post">
                          @method('DELETE')
                          @csrf
                          <input type="hidden" name="id" id="id" value="{{ $laporan->id }}">
                          <div class="modal-body">
                              Anda yakin ingin menghapus Laporan ini ?
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
