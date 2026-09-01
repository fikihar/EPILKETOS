@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Manajemen Data Siswa (DPT)
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <!-- Tombol Hapus Semua -->
            <a href="#" class="btn btn-danger d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-hapus-semua">
                <i class="ti ti-trash me-2"></i> Kosongkan Data
            </a>
            <!-- Tombol Import Excel -->
            <a href="#" class="btn btn-success d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-import">
                <i class="ti ti-file-spreadsheet me-2"></i> Import Excel
            </a>
            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                <i class="ti ti-plus me-2"></i> Tambah Siswa
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            
            <div class="card-header">
                <form action="{{ route("admin.siswa.index") }}" method="GET" class="d-flex w-100 flex-column flex-md-row gap-2">
                    <div class="input-icon flex-grow-1">
                        <span class="input-icon-addon"><i class="ti ti-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama / NISN..." value="{{ request("search") }}">
                    </div>
                    <div class="flex-shrink-0" style="width: 200px;">
                        <select name="filter_kelas" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->kd_kelas }}" {{ request("filter_kelas") == $k->kd_kelas ? "selected" : "" }}>{{ $k->nm_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    @if(request("search") || request("filter_kelas"))
                        <a href="{{ route("admin.siswa.index") }}" class="btn btn-link">Reset</a>
                    @endif
                </form>
            </div>

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
                        <div>{!! session("error") !!}</div>
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
                            <th>NISN / Username</th>
                            <th>Nama Siswa</th>
                            <th>L/P</th>
                            <th>Kelas</th>
                            <th>Status Vote</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                        <tr>
                            <td class="text-secondary fw-bold">{{ $s->username }}</td>
                            <td class="fw-bold">{{ $s->nm_siswa }}</td>
                            <td class="text-secondary">{{ $s->jk }}</td>
                            <td class="text-secondary">
                                <span class="badge bg-blue-lt">{{ $s->kelas->nm_kelas ?? "Tidak Ada" }}</span>
                            </td>
                            <td>
                                @if($s->sudahVote())
                                    <span class="badge bg-success text-white"><i class="ti ti-check me-1"></i> Sudah</span>
                                @else
                                    <span class="badge bg-danger text-white"><i class="ti ti-x me-1"></i> Belum</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $s->username }}">Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $s->username }}">Hapus</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal modal-blur fade" id="modal-edit-{{ $s->username }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route("admin.siswa.update", $s->username) }}" method="POST">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label required">NISN / Username</label>
                                                <input type="text" class="form-control" name="username" value="{{ $s->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Nama Siswa</label>
                                                <input type="text" class="form-control" name="nm_siswa" value="{{ $s->nm_siswa }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required">Jenis Kelamin</label>
                                                    <select class="form-select" name="jk" required>
                                                        <option value="L" {{ $s->jk == "L" ? "selected" : "" }}>Laki-laki (L)</option>
                                                        <option value="P" {{ $s->jk == "P" ? "selected" : "" }}>Perempuan (P)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required">Kelas</label>
                                                    <select class="form-select" name="kd_kelas" required>
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach($kelas as $k)
                                                            <option value="{{ $k->kd_kelas }}" {{ $s->kd_kelas == $k->kd_kelas ? "selected" : "" }}>
                                                                {{ $k->nm_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru (Opsional)</label>
                                                <input type="text" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin merubah password">
                                                <small class="form-hint text-danger">Isi hanya jika ingin me-reset password siswa ini.</small>
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
                        <div class="modal modal-blur fade" id="modal-delete-{{ $s->username }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-status bg-danger"></div>
                                    <div class="modal-body text-center py-4">
                                        <i class="ti ti-alert-triangle text-danger mb-2" style="font-size: 3rem;"></i>
                                        <h3>Anda yakin?</h3>
                                        <div class="text-secondary">Apakah Anda benar-benar ingin menghapus data <b>{{ $s->nm_siswa }}</b>? Tindakan ini tidak dapat dibatalkan.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Batal</a></div>
                                                <div class="col">
                                                    <form action="{{ route("admin.siswa.destroy", $s->username) }}" method="POST">
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
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data siswa yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $siswa->links("pagination::bootstrap-5") }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("admin.siswa.store") }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">NISN / Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Contoh: 0012345678" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nama Siswa</label>
                        <input type="text" class="form-control" name="nm_siswa" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Jenis Kelamin</label>
                            <select class="form-select" name="jk" required>
                                <option value="L">Laki-laki (L)</option>
                                <option value="P">Perempuan (P)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Kelas</label>
                            <select class="form-select" name="kd_kelas" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->kd_kelas }}">{{ $k->nm_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Khusus (Opsional)</label>
                        <input type="text" class="form-control" name="password" placeholder="Kosongkan agar password default = NISN">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <i class="ti ti-plus me-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Siswa (Excel/CSV)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("admin.siswa.import") }}" method="POST" enctype="multipart/form-data" onsubmit="document.getElementById('btn-import').innerHTML = '<span class=\'spinner-border spinner-border-sm me-2\' role=\'status\'></span> Sedang Memproses...'; document.getElementById('btn-import').classList.add('disabled');">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Pilih File (Excel / CSV)</label>
                        <input type="file" class="form-control" name="file_excel" accept=".xlsx,.xls,.csv" required>
                        <div class="form-hint mt-2">
                            Pastikan format kolom sesuai dengan template.
                            <a href="{{ route("admin.siswa.template") }}" class="text-primary fw-bold" target="_blank">
                                <i class="ti ti-download"></i> Download Template CSV
                            </a>
                        </div>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-title">Catatan Penting:</h4>
                        <div class="text-secondary">
                            <ul class="mb-0 mt-2">
                                <li>Pastikan nama kelas di file <b>sama persis</b> dengan Data Kelas yang ada di sistem (contoh: "X AKL 1").</li>
                                <li>Password siswa yang diimport akan secara otomatis disamakan dengan <b>NISN</b>-nya.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" id="btn-import" class="btn btn-success ms-auto">
                        <i class="ti ti-upload me-2"></i> Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Hapus Semua -->
<div class="modal modal-blur fade" id="modal-hapus-semua" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-alert-triangle text-danger mb-2" style="font-size: 3rem;"></i>
                <h3>Kosongkan Seluruh Data?</h3>
                <div class="text-secondary">Apakah Anda benar-benar yakin ingin menghapus <b>SEMUA</b> data Siswa/DPT? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Batal</a></div>
                        <div class="col">
                            <form action="{{ route("admin.siswa.deleteAll") }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Ya, Hapus Semua</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





