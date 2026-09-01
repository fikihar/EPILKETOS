@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Manajemen Kandidat Paslon
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-tambah">
            <i class="ti ti-plus me-2"></i> Tambah Kandidat
        </a>
    </div>
</div>

@if(session("success"))
    <div class="alert alert-important alert-success alert-dismissible mb-3" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-check icon alert-icon"></i></div>
            <div>{{ session("success") }}</div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

@if(session("error"))
    <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
            <div>{!! session("error") !!}</div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
            <div>{{ $errors->first() }}</div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

<div class="row row-cards">
    @forelse($kandidat as $k)
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <!-- Foto Kandidat -->
            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url('{{ $k->photo_url }}'); height: 350px; background-position: top center; background-size: cover;"></div>
            
            <div class="card-body text-center">
                <span class="badge bg-primary text-white mb-2 fs-3 px-3 py-2">Paslon No. {{ $k->no }}</span>
                <h3 class="card-title mb-1 mt-2">{{ $k->nama }}</h3>
                
                
                <div class="mt-3">
                    <span class="badge bg-green-lt p-2 px-3 fs-4">
                        <i class="ti ti-check me-1"></i> {{ $k->pilihans_count }} Suara Masuk
                    </span>
                </div>
            </div>
            <div class="d-flex">
                <a href="#" class="card-btn" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $k->nisn }}">
                    <i class="ti ti-edit me-2 text-info"></i> Edit
                </a>
                <a href="#" class="card-btn" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $k->nisn }}">
                    <i class="ti ti-trash me-2 text-danger"></i> Hapus
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal modal-blur fade" id="modal-edit-{{ $k->nisn }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kandidat No. {{ $k->no }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route("admin.kandidat.update", $k->nisn) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <span class="avatar avatar-xl mb-3 rounded" style="background-image: url('{{ $k->photo_url }}')"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label required">Nomor Urut</label>
                                <input type="number" class="form-control" name="no" value="{{ $k->no }}" required>
                            </div>
                        </div>
                        @php
                            $pecahNama = explode(" & ", $k->nama);
                            $namaKetua = trim($pecahNama[0] ?? $k->nama);
                            $namaWakil = trim($pecahNama[1] ?? "");
                        @endphp
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Calon Ketua</label>
                                <input type="text" class="form-control" name="nama_ketua" value="{{ $namaKetua }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Calon Wakil</label>
                                <input type="text" class="form-control" name="nama_wakil" value="{{ $namaWakil }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" class="form-control" name="photo" accept="image/*">
                            <small class="form-hint">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG (Max 2MB).</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-primary ms-auto">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal modal-blur fade" id="modal-delete-{{ $k->nisn }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <i class="ti ti-alert-triangle text-danger mb-2" style="font-size: 3rem;"></i>
                    <h3>Anda yakin?</h3>
                    <div class="text-secondary">Apakah Anda benar-benar ingin menghapus Kandidat <b>{{ $k->nama }}</b>? Tindakan ini tidak dapat dibatalkan.</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Batal</a></div>
                            <div class="col">
                                <form action="{{ route("admin.kandidat.destroy", $k->nisn) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger w-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card p-5 text-center">
            <h2 class="text-muted">Belum Ada Kandidat</h2>
            <p class="text-secondary">Silakan klik tombol "Tambah Kandidat" untuk mendaftarkan paslon.</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Modal Tambah Kandidat -->
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kandidat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("admin.kandidat.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Nomor Urut</label>
                            <input type="number" class="form-control" name="no" placeholder="Misal: 1" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nama Calon Ketua</label>
                            <input type="text" class="form-control" name="nama_ketua" placeholder="Ketik Nama Ketua..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nama Calon Wakil</label>
                            <input type="text" class="form-control" name="nama_wakil" placeholder="Ketik Nama Wakil..." required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Foto (Opsional)</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                        <small class="form-hint">Gunakan foto portrait (berdiri/vertikal) agar proporsional. Format: JPG, PNG (Max 2MB).</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <i class="ti ti-plus me-2"></i> Simpan Kandidat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


