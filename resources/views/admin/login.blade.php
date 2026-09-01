<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Login Admin | E-Pilketos</title>
    <!-- Tabler Core & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.36.0/tabler-icons.min.css" rel="stylesheet"/>
    
    <!-- FIX UI/UX: Google Fonts untuk kesan premium dan konsisten -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        /* FIX UI/UX: Mengganti font sistem dengan Inter */
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #f8fafc; /* Warna background lebih lembut (Slate 50) */
            color: #334155;
        }

        /* Tipografi Heading dengan Plus Jakarta Sans */
        h1, h2, h3, .h2 {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        /* FIX UI/UX: SaaS Card Style - Bayangan luas dan lembut */
        .saas-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 10px rgba(0,0,0,0.01);
            border-radius: 20px !important;
            padding: 10px;
        }

        /* Input Styles Premium */
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            margin-bottom: 8px;
        }

        /* FIX UI/UX: Modern Button Style */
        .btn-admin {
            background-color: #0f172a;
            border: none;
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-admin:hover:not(:disabled) {
            background-color: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(15, 23, 42, 0.15);
            color: white;
        }

        .btn-admin:disabled {
            background-color: #94a3b8;
            cursor: not-allowed;
            opacity: 0.9;
        }

        /* FIX UI/UX: Tombol toggle password (aksesibilitas) */
        .btn-toggle-pass {
            background: transparent;
            border: none;
            padding: 0 16px;
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #64748b;
            transition: color 0.2s ease;
            border-radius: 0 10px 10px 0;
        }

        .btn-toggle-pass:hover {
            color: #0f172a;
        }

        .btn-toggle-pass:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: -2px;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="#" class="navbar-brand navbar-brand-autodark">
                    <!-- FIX UI/UX: Alt text logo -->
                    <img src="{{ asset('img/epilketos-logo.webp') }}" height="56" alt="Logo Administrator E-Pilketos" class="rounded-3 shadow-sm">
                </a>
            </div>
            
            <!-- Menggunakan class .saas-card -->
            <div class="card card-md border-0 saas-card">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h2 text-center fw-bold mb-4">Panel Admin</h2>
                    
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert" style="border-radius: 10px; background-color: #fef2f2; border-color: #fecaca; color: #991b1b;">
                            <div class="d-flex align-items-center">
                                <div><i class="ti ti-alert-circle icon alert-icon me-2"></i></div>
                                <div style="font-size: 14px; font-weight: 500;">{{ $errors->first() }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- FIX UI/UX: Tambah id="loginForm" untuk JS intercept -->
                    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off" id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <!-- FIX UI/UX: Aksesibilitas label (for="usernameInput") -->
                            <label for="usernameInput" class="form-label">Username</label>
                            <input type="text" id="usernameInput" name="username" class="form-control" placeholder="Masukkan username admin" autocomplete="off" required value="{{ old('username') }}" autofocus>
                        </div>
                        <div class="mb-4">
                            <!-- FIX UI/UX: Aksesibilitas label (for="passwordInput") -->
                            <label for="passwordInput" class="form-label">Password</label>
                            <div class="input-group input-group-flat" style="border-radius: 10px; overflow: hidden; border: 1px solid #cbd5e1; background: #fff;">
                                <input type="password" id="passwordInput" name="password" class="form-control border-0" placeholder="Masukkan password admin" autocomplete="off" required style="box-shadow: none;">
                                <span class="input-group-text border-0 p-0 bg-transparent">
                                    <!-- FIX UI/UX: Menggunakan <button> bukan <a> untuk toggle -->
                                    <button type="button" class="btn-toggle-pass" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password">
                                        <i class="ti ti-eye fs-3" id="eyeIcon"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-footer mt-5">
                            <!-- FIX UI/UX: Tombol loading state & bahasa lokal -->
                            <button type="submit" id="submitBtn" class="btn-admin w-100">
                                <span id="btnText">Masuk ke Panel</span>
                                <i class="ti ti-login ms-1" id="btnIcon"></i>
                                <!-- Spinner disembunyikan default -->
                                <div id="btnSpinner" class="spinner-border spinner-border-sm" role="status" style="display: none;"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center text-slate-400 mt-4" style="font-size: 13px; font-weight: 500;">
                &copy; {{ date("Y") }} Hak Cipta E-Pilketos
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script>
        // Fitur Toggle Password dengan Accessibility
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("passwordInput");
            const eyeIcon = document.getElementById("eyeIcon");
            const isHidden = passwordInput.type === "password";
            
            passwordInput.type = isHidden ? "text" : "password";
            
            if (isHidden) {
                eyeIcon.classList.remove("ti-eye");
                eyeIcon.classList.add("ti-eye-off");
                this.setAttribute("aria-label", "Sembunyikan password");
                this.setAttribute("title", "Sembunyikan password");
            } else {
                eyeIcon.classList.remove("ti-eye-off");
                eyeIcon.classList.add("ti-eye");
                this.setAttribute("aria-label", "Tampilkan password");
                this.setAttribute("title", "Tampilkan password");
            }
        });

        // FIX UI/UX: Loading State saat disubmit (cegah klik berkali-kali)
        document.getElementById("loginForm").addEventListener("submit", function() {
            const btn = document.getElementById("submitBtn");
            const btnText = document.getElementById("btnText");
            const btnIcon = document.getElementById("btnIcon");
            const btnSpinner = document.getElementById("btnSpinner");
            
            // Ubah tombol jadi status loading
            btn.disabled = true;
            btnText.innerText = "Memverifikasi...";
            if(btnIcon) btnIcon.style.display = "none";
            btnSpinner.style.display = "inline-block";
        });
    </script>
</body>
</html>

