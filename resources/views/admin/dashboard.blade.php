@extends("admin.layouts.app")

@section("content")
<div class="row mb-3 align-items-center">
    <div class="col">
        <h2 class="page-title">
            Live Count & Dashboard
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none d-flex align-items-center gap-3">
        <label class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox" id="autoRefreshToggle">
            <span class="form-check-label">Auto-Refresh (15s)</span>
        </label>
        
        <form action="{{ route("admin.dashboard.reset") }}" method="POST" id="formReset">
            @csrf
            <button type="button" class="btn btn-danger" onclick="confirmReset()">
                <i class="ti ti-trash me-2"></i> Reset Suara
            </button>
        </form>
    </div>
</div>

@if(session("success"))
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-check icon alert-icon"></i></div>
            <div>{{ session("success") }}</div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

<div class="row row-deck row-cards mb-4">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Total Pemilih (DPT)</div>
                </div>
                <div class="h1 mb-3">{{ number_format($total_dpt, 0, ",", ".") }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-success">Suara Masuk</div>
                </div>
                <div class="h1 mb-3 text-success">{{ number_format($suara_masuk, 0, ",", ".") }}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: {{ $total_dpt > 0 ? ($suara_masuk/$total_dpt)*100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-danger">Belum Memilih (Golput)</div>
                </div>
                <div class="h1 mb-3 text-danger">{{ number_format($golput, 0, ",", ".") }}</div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: {{ $total_dpt > 0 ? ($golput/$total_dpt)*100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Perolehan Suara Paslon</h3>
    </div>
    <div class="card-body">
        @forelse($kandidat as $k)
            @php 
                $persentase = $suara_masuk > 0 ? round(($k->pilihans_count / $suara_masuk) * 100, 2) : 0;
            @endphp
            <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <span class="avatar avatar-md" style="background-image: url('{{ $k->photo_url }}')"></span>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center mb-1">
                        <div class="font-weight-medium">Paslon {{ sprintf("%02d", $k->no) }} - {{ $k->nama }}</div>
                        <div class="ms-auto font-weight-bold h3 mb-0">{{ number_format($k->pilihans_count, 0, ",", ".") }} Suara</div>
                    </div>
                    <div class="progress progress-lg">
                        <div class="progress-bar bg-primary" style="width: {{ $persentase }}%"></div>
                    </div>
                    <div class="text-secondary mt-1 text-end">{{ $persentase }}%</div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">Belum ada kandidat.</div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fitur Reset
    function confirmReset() {
        Swal.fire({
            title: "Kosongkan Kotak Suara?",
            html: "Ini akan mereset <b>semua perolehan suara menjadi 0</b> dan mengembalikan status kehadiran seluruh siswa menjadi <b>Tidak Hadir</b>.<br><br>Gunakan ini HANYA saat uji coba selesai dan Anda siap memulai pemilihan asli!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus Semua Suara!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("formReset").submit();
            }
        });
    }

    // Fitur Auto Refresh Live Count
    const toggle = document.getElementById("autoRefreshToggle");
    const REFRESH_INTERVAL = 15000; // 15 detik
    let refreshTimer;

    // Cek state dari localStorage
    if (localStorage.getItem("autoRefreshDashboard") === "true") {
        toggle.checked = true;
        startAutoRefresh();
    }

    toggle.addEventListener("change", function() {
        if (this.checked) {
            localStorage.setItem("autoRefreshDashboard", "true");
            startAutoRefresh();
        } else {
            localStorage.setItem("autoRefreshDashboard", "false");
            clearTimeout(refreshTimer);
        }
    });

    function startAutoRefresh() {
        refreshTimer = setTimeout(() => {
            window.location.reload();
        }, REFRESH_INTERVAL);
    }
</script>
@endsection
