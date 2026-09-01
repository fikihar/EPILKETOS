@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Dashboard Statistik
        </h2>
    </div>
</div>

<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Total Pemilih (DPT)</div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2">{{ $totalSiswa }}</div>
                    <div class="me-auto">
                        <span class="text-primary d-inline-flex align-items-center lh-1">
                            Siswa
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Kandidat Paslon</div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2">{{ $totalKandidat }}</div>
                    <div class="me-auto">
                        <span class="text-info d-inline-flex align-items-center lh-1">
                            Calon
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-success">Suara Masuk</div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2 text-success">{{ $sudahVote }}</div>
                    <div class="me-auto">
                        <span class="text-success d-inline-flex align-items-center lh-1">
                            <i class="ti ti-check"></i> Sudah Voting
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm mt-3">
                    <div class="progress-bar bg-success" style="width: {{ $totalSiswa > 0 ? ($sudahVote/$totalSiswa)*100 : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-danger">Belum Vote</div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2 text-danger">{{ $belumVote }}</div>
                    <div class="me-auto">
                        <span class="text-danger d-inline-flex align-items-center lh-1">
                            <i class="ti ti-x"></i> Menunggu
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm mt-3">
                    <div class="progress-bar bg-danger" style="width: {{ $totalSiswa > 0 ? ($belumVote/$totalSiswa)*100 : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
