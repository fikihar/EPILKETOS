@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Manajemen Kelas
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                <i class="ti ti-plus me-2"></i> Tambah Kelas
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            
            @if(session("success"))
                <div class="alert alert-important alert-success alert-dismissible m-3" role="alert">
                    <div class="d-flex">
                        <div><i class="ti ti-check icon alert-icon"></i></div>
                        <div>{{ session("success") }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if(session("error"))
                <div class="alert alert-important alert-danger alert-dismissible m-3" role="alert">
                    <div class="d-flex">
                        <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
                        <div>{{ session("error") }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-important alert-danger alert-dismissible m-3" role="alert">
                    <div class="d-flex">
                        <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
                        <div>{{ $errors->first() }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-vcenter table-mobile-md card-table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jumlah Siswa / DPT</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $k)
                        <tr>
                            <td class="text-secondary">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $k->nm_kelas }}</td>
                            <td class="text-secondary">
                                <span class="badge bg-blue-lt">{{ $k->siswas_count }} Siswa</span>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $k->kd_kelas }}">
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $k->kd_kelas }}">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal modal-blur fade" id="modal-edit-{{ $k->kd_kelas }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Kelas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route("admin.kelas.update", $k->kd_kelas) }}" method="POST">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label required">Nama Kelas</label>
                                                <input type="text" class="form-control" name="nm_kelas" value="{{ $k->nm_kelas }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                                            <button type="submit" class="btn btn-primary ms-auto">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal modal-blur fade" id="modal-delete-{{ $k->kd_kelas }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-status bg-danger"></div>
                                    <div class="modal-body text-center py-4">
                                        <i class="ti ti-alert-triangle text-danger mb-2" style="font-size: 3rem;"></i>
                                        <h3>Anda yakin?</h3>
                                        <div class="text-secondary">Apakah Anda benar-benar ingin menghapus kelas <b>{{ $k->nm_kelas }}</b>? Tindakan ini tidak dapat dibatalkan.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Batal</a></div>
                                                <div class="col">
                                                    <form action="{{ route("admin.kelas.destroy", $k->kd_kelas) }}" method="POST">
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
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data kelas yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("admin.kelas.store") }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nama Kelas</label>
                        <input type="text" class="form-control" name="nm_kelas" placeholder="Contoh: X AKL 1" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <i class="ti ti-plus me-2"></i> Tambah Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
