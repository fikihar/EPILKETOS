<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Login Pemilih | E-Pilketos</title>
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    {{-- FIX #4: SweetAlert2 dipindahkan ke bawah body agar tidak memblokir render --}}
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #0b192c;
            background-image: url("{{ asset('img/bg-hero.webp') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 0;
            padding: 20px;
        }

        /* Typography Override */
        h1, h2, h3, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(-45deg, rgba(11, 25, 44, 0.85), rgba(26, 54, 93, 0.85), rgba(43, 108, 176, 0.85), rgba(44, 122, 123, 0.85));
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            z-index: -1;
        }

        /* FIX #6: Hormati preferensi reduced-motion pengguna */
        @media (prefers-reduced-motion: reduce) {
            body::before {
                animation: none;
                background-position: 0% 50%;
            }
            .btn-primary-glow,
            .glass-input,
            .btn-back {
                transition: none !important;
            }
        }

        @keyframes gradientMove {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            border-radius: 24px;
            width: 100%;
            max-width: 420px;
            padding: 40px 30px;
            text-align: center;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 15px;
            backdrop-filter: blur(5px);
            transition: all 0.2s ease;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1) !important;
            outline: none;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .btn-primary-glow {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 12px;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-primary-glow:hover:not(:disabled) {
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            transform: translateY(-2px);
        }

        .btn-primary-glow:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-align: left;
            margin-bottom: 8px;
            display: block;
        }

        .btn-back {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            padding: 10px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-back:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        /* FIX #2: Toggle password sebagai button */
        .toggle-password-btn {
            cursor: pointer;
            padding: 0 16px;
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.2s ease;
        }

        .toggle-password-btn:hover {
            color: white;
        }

        .toggle-password-btn:focus-visible {
            outline: 2px solid rgba(255, 255, 255, 0.5);
            outline-offset: 2px;
            border-radius: 6px;
        }

        /* Divider sebelum tombol kembali */
        .form-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 28px 0 0 0;
        }
    </style>
</head>

<body>
    <div class="glass-login-box">

        {{-- Logo â€” FIX #5: Logo tidak bisa diklik agar tidak keluar halaman login tidak sengaja --}}
        <img src="{{ asset('img/epilketos-logo.jpg') }}" alt="Logo E-Pilketos" class="login-logo">

        <h2 class="h2 mb-2 font-heading text-white">Login Bilik Suara</h2>
        <p class="text-white-50 mb-4" style="font-size: 14px; line-height: 1.6;">Gunakan NIS Anda untuk masuk</p>

        {{-- FIX #3: Kontras warna pesan error diperbaiki --}}
        @if($errors->any())
        <div class="alert" role="alert" style="background: rgba(180, 30, 30, 0.35); border: 1px solid rgba(255, 100, 100, 0.5); color: #ffffff; text-align: left; border-radius: 12px; padding: 12px 14px; margin-bottom: 16px;">
            <div class="d-flex align-items-start gap-2">
                <div style="flex-shrink: 0; margin-top: 1px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                </div>
                <div style="font-size: 14px; font-weight: 500; line-height: 1.5;">{{ $errors->first() }}</div>
            </div>
        </div>
        @endif

        <form action="{{ route('login.submit') }}" method="post" autocomplete="off" id="loginForm">
            @csrf

            {{-- FIX #1: Label dan placeholder diseragamkan menjadi NIS --}}
            <div class="mb-3">
                <label for="usernameInput" class="form-label">NIS</label>
                <input
                    type="text"
                    id="usernameInput"
                    class="form-control glass-input"
                    name="username"
                    placeholder="Masukkan NIS Anda"
                    value="{{ old('username') }}"
                    required
                    autofocus>
            </div>

            <div class="mb-4">
                <label for="passwordInput" class="form-label">Password</label>
                <div class="input-group input-group-flat glass-input p-0" style="background: transparent !important; overflow: hidden; align-items: stretch;">
                    {{-- FIX #2: Placeholder netral, tidak membocorkan info keamanan --}}
                    <input
                        type="password"
                        class="form-control glass-input border-0"
                        id="passwordInput"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                        style="border-radius: 12px 0 0 12px; backdrop-filter: none; background: transparent !important;">

                    <span class="input-group-text glass-input border-0 p-0" style="border-radius: 0 12px 12px 0; backdrop-filter: none; background: transparent !important;">
                        {{-- FIX #2: Ganti <a> menjadi <button type="button"> untuk aksesibilitas keyboard --}}
                        <button
                            type="button"
                            id="togglePassword"
                            class="toggle-password-btn"
                            aria-label="Tampilkan password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="icon" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </button>
                    </span>
                </div>
            </div>

            <div class="form-footer">
                {{-- FIX #5: Ikon diganti menjadi arrow-right yang lebih intuitif untuk aksi "Masuk" --}}
                <button type="submit" id="submitBtn" class="btn btn-primary-glow w-100 d-flex align-items-center justify-content-center">
                    <span id="btnText">Masuk ke Bilik Suara</span>
                    <svg id="btnIcon" xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l14 0"></path>
                        <path d="M13 18l6 -6"></path>
                        <path d="M13 6l6 6"></path>
                    </svg>
                    <div id="btnSpinner" class="spinner-border spinner-border-sm ms-2" role="status" style="display: none;">
                        <span class="visually-hidden">Memproses...</span>
                    </div>
                </button>
            </div>
        </form>

        {{-- FIX #8: Pemisah visual sebelum tombol kembali --}}
        <hr class="form-divider">

        <a href="{{ route('landing') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l14 0"></path>
                <path d="M5 12l6 6"></path>
                <path d="M5 12l6 -6"></path>
            </svg>
            Kembali ke Halaman Utama
        </a>
    </div>

    {{-- FIX #4: SweetAlert2 dipindahkan ke bawah body agar tidak blokir render halaman --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // FIX #2: Toggle password â€” sekarang pakai <button> sehingga bisa dikontrol via keyboard
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordInput = document.getElementById("passwordInput");
            const eyeIcon = document.getElementById("eyeIcon");
            const isHidden = passwordInput.type === "password";

            passwordInput.type = isHidden ? "text" : "password";
            this.setAttribute("aria-label", isHidden ? "Sembunyikan password" : "Tampilkan password");

            eyeIcon.innerHTML = isHidden
                ? '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" />'
                : '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />';
        });

        // Loading State saat form submit
        document.getElementById("loginForm").addEventListener("submit", function () {
            const btn = document.getElementById("submitBtn");
            const btnText = document.getElementById("btnText");
            const btnIcon = document.getElementById("btnIcon");
            const btnSpinner = document.getElementById("btnSpinner");

            btn.disabled = true;
            btnText.innerText = "Memproses...";
            btnIcon.style.display = "none";
            btnSpinner.style.display = "inline-block";
        });
    </script>
</body>

</html>

