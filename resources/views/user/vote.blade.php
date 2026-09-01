<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Bilik Suara | E-Pilketos</title>
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet" />
    {{-- FIX #1: Tambahkan Google Fonts agar konsisten dengan halaman login --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
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
            flex-direction: column;
            position: relative;
            z-index: 0;
        }

        /* FIX #1: Typography heading konsisten */
        h1,
        h2,
        h3,
        h4,
        .font-heading {
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

        /* FIX #9 & #13: Hormati preferensi reduced-motion pengguna */
        @media (prefers-reduced-motion: reduce) {
            body::before {
                animation: none;
                background-position: 0% 50%;
            }

            .glass-card,
            .btn-coblos,
            .btn-coblos:hover {
                transition: none !important;
                transform: none !important;
            }
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass-nav {
            background: rgba(25, 30, 45, 0.3) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* FIX #10: Turunkan transparansi card agar glassmorphism lebih premium */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            border-radius: 24px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        /* FIX #6: Seluruh card terasa interaktif saat di-hover */
        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px 0 rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .kandidat-img {
            height: 320px;
            width: 100%;
            object-fit: contain;
            background-color: transparent;
            padding: 15px;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.3));
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
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            backdrop-filter: blur(4px);
        }

        .btn-coblos {
            background: linear-gradient(135deg, #10b981, #059669);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            color: white;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            letter-spacing: 0.5px;
            border-radius: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-coblos:hover:not(:disabled) {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
            color: white;
        }

        /* FIX #7: State disabled saat dialog konfirmasi aktif */
        .btn-coblos:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .student-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        .avatar-circle {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Tombol Batal & Keluar Premium */
        .btn-logout {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 500;
            padding: 0 20px;
            min-height: 44px;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.85);
            /* Red 500 */
            border-color: rgba(239, 68, 68, 1);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        /* FIX #11 & #12: Separator dan hierarki nama ketua-wakil */
        .paslon-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px auto;
            width: 80%;
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .paslon-divider::before,
        .paslon-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.25);
        }

        @media (max-width: 575.98px) {
            .kandidat-img {
                height: 260px !important;
            }

            .btn-coblos {
                padding: 14px;
                font-size: 15px;
            }

            .student-info {
                flex-direction: column;
                text-align: center;
            }

            .avatar-circle {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="navbar navbar-expand-md glass-nav d-print-none sticky-top">
        <div class="container-xl">
            <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3 mb-0">
                <img src="{{ asset('img/epilketos-logo.jpg') }}" height="36" alt="Logo E-Pilketos" class="me-2 rounded shadow-sm">
                <span class="text-white fw-bold">E-Pilketos</span>
            </h1>
            <div class="navbar-nav flex-row order-md-last ms-auto">
                <form action="{{ route('logout') }}" method="POST" id="formLogout">
                    @csrf
                    <!-- FIX UI/UX: Tombol logout premium + konfirmasi -->
                    <button type="button" class="btn-logout" onclick="konfirmasiLogout()" aria-label="Batal dan Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                            <path d="M9 12h12l-3 -3"></path>
                            <path d="M18 15l3 -3"></path>
                        </svg>
                        Batal &amp; Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-xl pt-4 pb-5 flex-grow-1">

        <!-- Informasi Pemilih -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="student-info shadow-lg">
                    {{-- FIX #2: Tambahkan aria-label pada avatar agar screen reader paham --}}
                    <div class="avatar-circle" aria-label="Inisial nama: {{ $siswa->nm_siswa }}" role="img">
                        {{ strtoupper(substr($siswa->nm_siswa, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="mb-0 fs-3 fw-bold text-white">{{ $siswa->nm_siswa }}</h3>
                        <div class="text-white opacity-75 mt-1" style="font-size: 14px;">NISN: {{ $siswa->username }} &bull; Kelas: {{ $siswa->kelas->nm_kelas ?? "-" }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <h2 class="display-6 fw-bold text-white" style="text-shadow: 0 4px 15px rgba(0,0,0,0.6);">Surat Suara Digital</h2>
            <p class="lead text-white opacity-75" style="font-size: 16px; line-height: 1.6;">Gunakan hak pilih Anda dengan bijak. Pilihan hanya dapat dilakukan 1 kali.</p>
        </div>

        <!-- Daftar Kandidat -->
        <div class="row row-cards justify-content-center">
            @forelse($kandidat as $k)
            <div class="col-11 col-sm-6 col-md-5 col-lg-4 mb-4">
                <div class="card glass-card h-100 border-0">
                    <div class="position-relative">
                        <div class="number-badge">Paslon {{ sprintf("%02d", $k->no) }}</div>
                        {{-- FIX #4: Alt text lebih deskriptif | FIX #8: Fallback jika gambar gagal muat --}}
                        <img
                            src="{{ $k->photo_url }}"
                            class="card-img-top kandidat-img"
                            alt="Foto Paslon {{ sprintf('%02d', $k->no) }}: {{ $k->nama }}"
                            onerror="this.onerror=null; this.src='{{ asset('img/epilketos-logo.jpg') }}';">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                        @php
                        $pecahNama = explode(" & ", $k->nama);
                        $ketua = trim($pecahNama[0] ?? $k->nama);
                        $wakil = trim($pecahNama[1] ?? "");
                        @endphp
                        {{-- FIX #12: Hierarki visual nama ketua lebih besar dari wakil --}}
                        <h3 class="card-title mb-0 fw-bold text-white px-2" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); letter-spacing: -0.5px; line-height: 1.2;">{{ $ketua }}</h3>
                        @if($wakil)
                        {{-- FIX #11: Separator teks lebih elegan daripada garis --}}
                        <div class="paslon-divider">bersama</div>
                        <div class="text-white fw-medium" style="font-size: clamp(0.9rem, 2vw, 1.1rem); opacity: 0.85;">{{ $wakil }}</div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 px-4">
                        {{-- FIX #3: Tambahkan aria-label deskriptif pada tombol coblos --}}
                        {{-- FIX #7: Semua tombol bisa dinonaktifkan via JS saat dialog aktif --}}
                        <button
                            onclick="konfirmasiCoblos('{{ $k->nisn }}', '{{ addslashes($k->nama) }}', '{{ $k->photo_url }}', '{{ sprintf("%02d", $k->no) }}')"
                            class="btn btn-coblos w-100 py-3"
                            aria-label="Coblos Paslon {{ sprintf('%02d', $k->no) }}: {{ $k->nama }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M9 12l2 2l4 -4"></path>
                            </svg>
                            COBLOS PASLON {{ sprintf("%02d", $k->no) }}
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-white opacity-75">Belum ada data paslon.</div>
            @endforelse
        </div>
    </div>

    <!-- Form Tersembunyi untuk Submit Voting (logika tidak diubah) -->
    <form id="formVote" action="{{ route('vote.submit') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="nisn_paslon" id="nisn_paslon">
    </form>

    <footer class="mt-auto py-3 text-center text-white-50" style="background: rgba(0,0,0,0.2); backdrop-filter: blur(10px);">
        <div class="container-xl">
            <small>&copy; {{ date("Y") }} E-Pilketos {{ $sekolah->nm_sekolah ?? "" }}</small>
        </div>
    </footer>

    <!-- SweetAlert2 (sudah benar di bawah body) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Konfirmasi SweetAlert (logika tidak diubah) -->
    <script>
        function konfirmasiCoblos(id_paslon, nama_paslon, foto_url, no_urut) {
            // FIX #7: Nonaktifkan semua tombol coblos saat dialog konfirmasi aktif
            const semuaTombol = document.querySelectorAll('.btn-coblos');
            semuaTombol.forEach(btn => btn.disabled = true);

            Swal.fire({
                title: "Konfirmasi Pilihan",
                html: "Anda akan memberikan suara untuk:<br><br><b>PASLON " + no_urut + "</b><br><h3 class='text-primary mt-2'>" + nama_paslon + "</h3><br><span class='text-muted small'>Pilihan tidak dapat diubah setelah dikonfirmasi!</span>",
                imageUrl: foto_url,
                imageWidth: 200,
                imageAlt: "Foto Paslon " + no_urut,
                background: "#1e293b",
                color: "#fff",
                showCancelButton: true,
                confirmButtonColor: "#10b981",
                cancelButtonColor: "#ef4444",
                confirmButtonText: "Ya, Saya Yakin!",
                cancelButtonText: "Batal",
                reverseButtons: true,
                customClass: {
                    image: "rounded shadow-sm"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Memproses Suara...",
                        text: "Mohon tunggu sebentar",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: "#1e293b",
                        color: "#fff",
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById("nisn_paslon").value = id_paslon;
                    document.getElementById("formVote").submit();
                } else {
                    // FIX #7: Aktifkan kembali semua tombol jika user membatalkan
                    semuaTombol.forEach(btn => btn.disabled = false);
                }
            });
        }

        // FUNGSI BARU: Konfirmasi sebelum logout
        function konfirmasiLogout() {
            Swal.fire({
                title: "Yakin ingin keluar?",
                text: "Anda belum menggunakan hak suara Anda di bilik ini.",
                icon: "warning",
                iconColor: "#ef4444",
                background: "#1e293b",
                color: "#fff",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#334155",
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Keluar...",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: "#1e293b",
                        color: "#fff",
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById("formLogout").submit();
                }
            });
        }
    </script>
</body>

</html>
