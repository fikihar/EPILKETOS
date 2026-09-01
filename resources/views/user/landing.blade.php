<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>E-Pilketos | {{ $sekolah->nm_sekolah ?? "SMK" }}</title>
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Animated Mesh Gradient Background */
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
            background-color: #0b192c;
            background-image: url("{{ asset('img/bg-hero.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 0;
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* Animated Overlay yang menyatu dengan Foto Background */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(-45deg, rgba(11,25,44,0.85), rgba(26,54,93,0.85), rgba(43,108,176,0.85), rgba(44,122,123,0.85));
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            z-index: -1;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism Styles */
        .glass-nav {
            background: rgba(25, 30, 45, 0.3) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            border-radius: 24px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        @media (hover: hover) {
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
        }

        .countdown-box { 
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 16px; 
            padding: 15px 10px; 
            min-width: 80px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .countdown-value { font-size: 32px; font-weight: 800; line-height: 1; text-shadow: 0 2px 10px rgba(255,255,255,0.3); }
        .countdown-label { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; opacity: 0.8; font-weight: 500; }
        
        .kandidat-img { 
            height: 320px; 
            width: 100%;
            object-fit: contain; 
            background-color: transparent; 
            padding: 15px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
        }

        .number-badge { 
            position: absolute; 
            top: 16px; 
            left: 16px; 
            background: linear-gradient(135deg, #FF0054, #ff5e62); 
            color: white; 
            padding: 8px 20px; 
            border-radius: 30px; 
            display: inline-block; 
            font-size: 13px; 
            letter-spacing: 1.5px;
            font-weight: 900; 
            box-shadow: 0 6px 20px rgba(255, 0, 84, 0.4); 
            z-index: 10; 
            border: 1.5px solid rgba(255,255,255,0.4);
            text-transform: uppercase;
            backdrop-filter: blur(4px);
        }

        .hero-title {
            font-weight: 900;
            letter-spacing: -1px;
            color: #ffffff;
            text-shadow: 0 5px 25px rgba(0,0,0,0.7);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: bold;
            transition: all 0.3s;
            min-height: 44px; /* Touch target accessibility */
            display: inline-flex;
            align-items: center;
        }
        @media (hover: hover) {
            .btn-glass:hover {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.4);
                color: white;
            }
        }
        
        .btn-primary-glow {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            color: white;
            font-weight: bold;
            transition: all 0.3s;
            min-height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        @media (hover: hover) {
            .btn-primary-glow:hover {
                box-shadow: 0 6px 25px rgba(59, 130, 246, 0.6);
                transform: translateY(-2px);
                color: white;
            }
        }

        .footer-text {
            font-size: 1.25rem;
        }

        /* STICKY CTA MOBILE */
        .sticky-cta-mobile {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            padding: 12px 16px calc(12px + env(safe-area-inset-bottom));
            background: rgba(11, 25, 44, 0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: none;
        }

        /* MOBILE RESPONSIVE < 576px */
        @media (max-width: 575.98px) {
            body {
                background-attachment: scroll;
            }
            body::before {
                background: rgba(11, 25, 44, 0.9);
                animation: none;
            }
            
            .hero-title { 
                font-size: 28px; 
                line-height: 1.15;
            }
            .hero-subtitle {
                font-size: 14px;
                margin-bottom: 2rem !important;
            }
            
            #countdown {
                gap: 6px !important;
            }
            .countdown-box { 
                min-width: 0; 
                flex: 1;
                padding: 10px 5px; 
            }
            .countdown-value { font-size: 22px; }
            .countdown-label { font-size: 9px; }
            
            .glass-card {
                border-radius: 18px;
            }
            
            .kandidat-img { height: 230px; }
            
            .badge { white-space: normal; text-align: center; font-size: 14px !important; padding: 10px !important; }
            
            .navbar-brand span { font-size: 1rem; }
            
            .btn-glass { padding-left: 15px !important; padding-right: 15px !important; font-size: 13px !important; }
            
            .footer-text {
                font-size: 11px;
            }
            footer {
                padding-top: 1rem !important;
                padding-bottom: calc(1rem + 80px) !important;
            }

            .main-cta-desktop {
                display: none !important;
            }
            .sticky-cta-mobile {
                display: block;
            }
        }
        
        /* Max width for mobile CTA button */
        .btn-mobile-cta {
            width: 100%;
            max-width: 380px;
            font-size: 15px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <!-- Navbar Glass -->
    <header class="navbar navbar-expand-md glass-nav d-print-none sticky-top">
        <div class="container-xl">
            <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
                <img src="{{ asset('img/epilketos-logo.jpg') }}" height="36" alt="E-Pilketos Logo" class="me-2 rounded shadow-sm" style="object-fit: cover;">
                <span class="text-white fw-bold tracking-wide">E-Pilketos</span>
            </h1>
            <div class="navbar-nav flex-row order-md-last ms-auto">
                <div class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-glass rounded-pill px-4 btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path><path d="M20 12h-13l3 -3m0 6l-3 -3"></path></svg>
                        Login Pemilih
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero / Countdown -->
    <div class="container text-center pt-4 pb-3 mt-3 mt-md-4">
        <h2 class="hero-title mb-2 mb-md-3" style="font-size: clamp(24px, 5vw, 42px);">Pemilihan Ketua & Wakil Ketua OSIS</h2>
        <p class="hero-subtitle mb-4 text-white opacity-75">{{ $sekolah->nm_sekolah ?? "SMKS Walisongo Pecangaan" }}</p>
        
        <div class="d-flex justify-content-center gap-3 mb-2 px-2" id="countdown">
            <div class="countdown-box">
                <div class="countdown-value" id="days">00</div>
                <div class="countdown-label">Hari</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="hours">00</div>
                <div class="countdown-label">Jam</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="minutes">00</div>
                <div class="countdown-label">Menit</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="seconds">00</div>
                <div class="countdown-label">Detik</div>
            </div>
        </div>
        <div id="countdown-expired" class="mt-3 d-none">
            <!-- Disisipkan via JS -->
        </div>
    </div>

    <!-- Kandidat Section -->
    <div class="flex-grow-1 pb-4 pb-md-5">
        <div class="container-xl mt-3 mt-md-4 px-3">
            <div class="text-center mb-4 mb-md-5">
                <h3 class="text-white fw-bold" style="letter-spacing: 1px; text-transform: uppercase; font-size: 14px; text-shadow: 0 4px 10px rgba(0,0,0,0.6); opacity: 0.9;">Kandidat Paslon Masa Bakti Mendatang</h3>
            </div>
            
            <div class="row row-cards justify-content-center g-3 g-md-4">
                @forelse($kandidat as $k)
                    <div class="col-11 col-sm-6 col-md-4">
                        <div class="card glass-card h-100 border-0">
                            <div class="position-relative">
                                <div class="number-badge">Paslon {{ sprintf("%02d", $k->no) }}</div>
                                <img src="{{ $k->photo_url }}" class="card-img-top kandidat-img" alt="Foto {{ $k->nama }}" style="cursor: pointer;" onclick="previewFoto('{{ $k->photo_url }}', '{{ addslashes($k->nama) }}')">
                            </div>
                            <div class="card-body text-center d-flex flex-column justify-content-center py-3 py-md-4">
                                @php
                                    $pecahNama = explode(" & ", $k->nama);
                                    $ketua = trim($pecahNama[0] ?? $k->nama);
                                    $wakil = trim($pecahNama[1] ?? "");
                                @endphp
                                
                                <div class="mb-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1.5px; color: rgba(255,255,255,0.5);">Calon Ketua</div>
                                <h3 class="card-title mb-0 fs-3 fs-md-2 fw-bold text-white px-2" style="letter-spacing: -0.5px; line-height: 1.2;">{{ $ketua }}</h3>
                                
                                @if($wakil)
                                    <div class="mx-auto my-3" style="width: 40px; height: 2px; background: rgba(255,255,255,0.2); border-radius: 2px;"></div>
                                    
                                    <div class="mb-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1.5px; color: rgba(255,255,255,0.5);">Calon Wakil</div>
                                    <div class="text-white fw-medium fs-4 fs-md-3">{{ $wakil }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-white-50 py-5 glass-card">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ghost mb-3" width="64" height="64" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 11a7 7 0 0 1 14 0v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-7"></path><path d="M10 10l.01 0"></path><path d="M14 10l.01 0"></path><path d="M10 14a3.5 3.5 0 0 0 4 0"></path></svg>
                        <p class="mb-0 fs-3">Belum ada kandidat paslon terdaftar.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5 mb-3 main-cta-desktop">
                <a href="{{ route('login') }}" class="btn btn-primary-glow btn-lg rounded-pill px-5 py-3 btn-login d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 10v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10.5 7.5l1 1l2 -2" /><rect x="4" y="10" width="16" height="12" rx="2" /><line x1="9" y1="15" x2="15" y2="15" /></svg>
                    <span class="fs-4 fs-md-3">Mulai Mencoblos Sekarang</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M13 18l6 -6"></path><path d="M13 6l6 6"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Sticky CTA Mobile -->
    <div class="sticky-cta-mobile text-center">
        <a href="{{ route('login') }}" class="btn btn-primary-glow rounded-pill btn-mobile-cta btn-login d-flex justify-content-center align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 10v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10.5 7.5l1 1l2 -2" /><rect x="4" y="10" width="16" height="12" rx="2" /><line x1="9" y1="15" x2="15" y2="15" /></svg>
            <span>Mulai Mencoblos Sekarang</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M13 18l6 -6"></path><path d="M13 6l6 6"></path></svg>
        </a>
    </div>

    <!-- Footer Glass -->
    <footer class="mt-auto py-3 py-md-4 text-center text-white-50" style="background: rgba(0,0,0,0.2); backdrop-filter: blur(10px);">
        <div class="container-xl">
            <div class="footer-text">
                Hak Cipta &copy; {{ date('Y') }} E-Pilketos {{ $sekolah->nm_sekolah ?? "SMK" }}
            </div>
        </div>
    </footer>

    <!-- Script Waktu & Alert -->
    <script>
        var startTime = new Date("{{ $target_waktu }}").getTime();
        var endTime = new Date("{{ $target_selesai }}").getTime();
        var statusZona = 0; 

        function updateState() {
            var now = new Date().getTime();
            var containerCountdown = document.getElementById("countdown");
            var containerExpired = document.getElementById("countdown-expired");

            if (now > endTime) {
                statusZona = 3;
                containerCountdown.classList.add("d-none");
                containerExpired.innerHTML = '<span class="badge bg-danger px-3 px-md-4 py-2 py-md-3 rounded-pill shadow-lg border border-danger text-wrap"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"></path><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path><path d="M8 11v-4a4 4 0 1 1 8 0v4"></path></svg>Waktu Pencoblosan Telah Berakhir</span>';
                containerExpired.classList.remove("d-none");
                return false;
            } else if (now >= startTime && now <= endTime) {
                statusZona = 2;
                containerCountdown.classList.add("d-none");
                containerExpired.innerHTML = '<span class="badge bg-success px-3 px-md-4 py-2 py-md-3 rounded-pill shadow-lg border border-success text-wrap"><span class="spinner-grow spinner-grow-sm me-2" role="status" aria-hidden="true"></span>Masa Pencoblosan Sedang Berlangsung!</span>';
                containerExpired.classList.remove("d-none");
                return false;
            } else {
                statusZona = 1;
                var distance = startTime - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerHTML = days < 10 ? "0" + days : days;
                document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
                document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
                document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;
                return true; 
            }
        }

        var keepRunning = updateState();
        if (keepRunning) {
            var x = setInterval(function() {
                if (!updateState()) {
                    clearInterval(x);
                }
            }, 1000);
        }

        document.querySelectorAll(".btn-login").forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                if (statusZona === 1) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "info",
                        title: "Belum Dimulai",
                        text: "Sabar ya! Waktu pemilihan belum dimulai. Silakan tunggu sampai hitungan mundur selesai.",
                        confirmButtonColor: "#3b82f6",
                        background: "#1e293b",
                        color: "#fff"
                    });
                } else if (statusZona === 3) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Pencoblosan Berakhir",
                        text: "Mohon maaf, batas waktu pemilihan telah berakhir. Anda tidak dapat melakukan pencoblosan lagi.",
                        confirmButtonColor: "#ef4444",
                        background: "#1e293b",
                        color: "#fff"
                    });
                }
            });
        });
    
        function previewFoto(url, nama) {
            Swal.fire({
                title: nama,
                imageUrl: url,
                imageAlt: "Foto " + nama,
                background: "#1e293b",
                color: "#fff",
                confirmButtonColor: "#3b82f6",
                confirmButtonText: "Tutup Preview",
                customClass: {
                    image: "rounded"
                }
            });
        }
    </script>
</body>
</html>

