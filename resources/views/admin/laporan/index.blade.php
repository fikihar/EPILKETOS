@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Rekapitulasi Hasil Pilketos
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="{{ route("admin.laporan.pdf_golput") }}" class="btn btn-warning d-none d-sm-inline-block me-2" target="_blank">
            <i class="ti ti-users me-1"></i> Cetak Daftar Golput
        </a>
        <a href="{{ route("admin.laporan.pdf") }}" class="btn btn-danger d-none d-sm-inline-block" target="_blank">
            <i class="ti ti-file-type-pdf me-1"></i> Export Laporan Akhir
        </a>
    </div>
</div>

<div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar"><i class="ti ti-users"></i></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Total DPT</div>
                        <div class="text-secondary">{{ number_format($total_dpt, 0, ",", ".") }} Siswa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-success text-white avatar"><i class="ti ti-check"></i></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Suara Masuk</div>
                        <div class="text-secondary">
                            {{ number_format($suara_masuk, 0, ",", ".") }} Siswa 
                            ({{ $total_dpt > 0 ? round(($suara_masuk/$total_dpt)*100, 1) : 0 }}%)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-danger text-white avatar"><i class="ti ti-x"></i></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Belum Memilih / Golput</div>
                        <div class="text-secondary">
                            {{ number_format($golput, 0, ",", ".") }} Siswa
                            ({{ $total_dpt > 0 ? round(($golput/$total_dpt)*100, 1) : 0 }}%)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Perolehan Suara Kandidat</h3>
    </div>
    <div class="card-body">
        @forelse($kandidat as $k)
            @php 
                $persentase = $suara_masuk > 0 ? round(($k->pilihans_count / $suara_masuk) * 100, 2) : 0;
            @endphp
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <span class="avatar avatar-md" style="background-image: url('{{ $k->photo_url }}')"></span>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center mb-1">
                        <div class="font-weight-medium">Paslon No. {{ $k->no }} - {{ $k->nama }}</div>
                        <div class="ms-auto font-weight-bold text-primary">{{ number_format($k->pilihans_count, 0, ",", ".") }} Suara</div>
                    </div>
                    <div class="progress progress-lg">
                        <div class="progress-bar bg-primary" style="width: {{ $persentase }}%" role="progressbar" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $persentase }}% Complete"></div>
                    </div>
                    <div class="text-secondary mt-1 text-end">{{ $persentase }}% dari total suara masuk</div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-3">Belum ada kandidat terdaftar.</div>
        @endforelse
    </div>
</div>
@endsection


