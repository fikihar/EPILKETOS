@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Identitas Sekolah
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Data Sekolah</h3>
            </div>
            <div class="card-body">
                @if(session("success"))
                    <div class="alert alert-important alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <i class="ti ti-check icon alert-icon"></i>
                            </div>
                            <div>{{ session("success") }}</div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <i class="ti ti-alert-circle icon alert-icon"></i>
                            </div>
                            <div>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                <form action="{{ route("admin.identitas.update") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">NPSN</label>
                        <input type="text" class="form-control" name="npsn" value="{{ $identitas->npsn ?? "" }}" placeholder="Contoh: 20338635">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nama Sekolah</label>
                            <input type="text" class="form-control" name="nm_sekolah" value="{{ $identitas->nm_sekolah ?? "" }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Logo Sekolah (Opsional)</label>
                            @if(isset($identitas) && $identitas->logo)
                                <div class="mb-2">
                                    <img src="{{ $identitas->logo_url }}" alt="Logo" height="80" class="border rounded p-1">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            <small class="form-hint">Maksimal 2 MB (JPG/PNG). Logo ini akan muncul pada Kop Surat Laporan PDF.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Kepala Sekolah</label>
                            <input type="text" class="form-control" name="kpl_sekolah" value="{{ $identitas->kpl_sekolah ?? "" }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP Kepala Sekolah</label>
                            <input type="text" class="form-control" name="nip" value="{{ $identitas->nip ?? "" }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nama Ketua Panitia</label>
                            <input type="text" class="form-control" name="ketua_panitia" value="{{ $identitas->ketua_panitia ?? "" }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP / ID Ketua Panitia</label>
                            <input type="text" class="form-control" name="nip_panitia" value="{{ $identitas->nip_panitia ?? "" }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-primary">Target Waktu Pencoblosan (Hitung Mundur)</label>
                            <input type="datetime-local" class="form-control" name="waktu_pelaksanaan" value="{{ $identitas->waktu_pelaksanaan ? date("Y-m-d\TH:i", strtotime($identitas->waktu_pelaksanaan)) : "" }}">
                            <small class="text-muted">Tentukan tanggal dan jam kapan waktu pemilihan dimulai. Akan muncul di layar utama siswa.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jalan</label>
                        <input type="text" class="form-control" name="jln" value="{{ $identitas->jln ?? "" }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Desa</label>
                            <input type="text" class="form-control" name="desa" value="{{ $identitas->desa ?? "" }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" name="kec" value="{{ $identitas->kec ?? "" }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" name="kab" value="{{ $identitas->kab ?? "" }}">
                        </div>
                    </div>

                    <div class="form-footer text-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




