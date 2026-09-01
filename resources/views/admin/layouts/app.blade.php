<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>E-Pilketos Admin | {{ $sekolah->nm_sekolah ?? "Panel" }}</title>
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <style>
      @import url("https://rsms.me/inter/inter.css");
      :root {
      	--tblr-font-sans-serif: "Inter Var", -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
</head>
<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark mt-3">
                    <a href="{{ route("admin.dashboard") }}" style="text-decoration: none; font-weight: bold; letter-spacing: 1px;">
                        <i class="ti ti-box-margin text-primary"></i> E-PILKETOS
                    </a>
                </h1>
                
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item {{ request()->routeIs("admin.dashboard") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.dashboard") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs("admin.identitas.*") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.identitas.index") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-building-arch"></i>
                                </span>
                                <span class="nav-link-title">Identitas Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs("admin.kelas.*") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.kelas.index") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-chalkboard"></i>
                                </span>
                                <span class="nav-link-title">Data Kelas</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs("admin.siswa.*") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.siswa.index") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="nav-link-title">Data Siswa / DPT</span>
                            </a>
                        </li>
                    <li class="nav-item {{ request()->routeIs("admin.kandidat.*") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.kandidat.index") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-user-star"></i>
                                </span>
                                <span class="nav-link-title">Kandidat Paslon</span>
                            </a>
                        </li>
                    <li class="nav-item {{ request()->routeIs("admin.laporan.*") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route("admin.laporan.index") }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-report-analytics"></i>
                                </span>
                                <span class="nav-link-title">Laporan Hasil</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Navbar Header -->
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-last ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm bg-primary text-white">AD</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Administrator</div>
                                <div class="mt-1 small text-secondary">Super Admin</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalPassword">
                                <i class="ti ti-key me-2"></i> Ganti Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route("admin.logout") }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    @yield("content")
                </div>
            </div>
            
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2026 E-Pilketos SMKS Walisongo. All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>

    <!-- Modal Ganti Password -->
    <div class="modal modal-blur fade" id="modalPassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route("admin.password.update") }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-title">Ganti Password Admin</div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" required minlength="4">
                        </div>
                        <div>
                            <label class="form-label">Ulangi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required minlength="4">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>






