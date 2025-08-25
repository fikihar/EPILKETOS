<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pilketos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Digital -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <style>
    body {
        background: url('<?php echo base_url(); ?>asset/img/background.webp') no-repeat center center/cover;
        font-family: 'Poppins', sans-serif;
        color: #fff;
        text-align: center;
        position: relative;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .hero {
        padding: 100px 20px 50px;
    }

    .hero h1 {
        font-weight: 800;
        font-size: 4.5rem;
        margin-bottom: 20px;
    }

    .hero h2 {
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .countdown {
        font-family: 'Orbitron', sans-serif;
        font-size: 3rem;
        color: #ffcc00;
        background: #000;
        display: inline-block;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 0 25px rgba(255, 204, 0, 0.9);
        letter-spacing: 4px;
    }

    .btn-primary {
        font-size: 2rem;
        padding: 15px 30px;
        border-radius: 40px;
    }

    .section-title {
        font-size: 3rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 50px;
    }

    .card {
        border: none;
        border-radius: 25px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s;
        background: #fff;
        color: #333;
        padding: 30px;
    }

    .card:hover {
        transform: translateY(-10px);
    }

    .card img {
        max-height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        margin: 20px auto;
    }

    .card h4 {
        font-size: 2rem;
        font-weight: 700;
    }

    .card p,
    .card li {
        font-size: 1.6rem;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero h2 {
            font-size: 1.2rem;
        }

        .countdown {
            font-size: 2rem;
            padding: 12px 20px;
        }

        .section-title {
            font-size: 2rem;
        }

        .card h4 {
            font-size: 1.6rem;
        }
    }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <div class="hero">
        <h1>SELAMAT DATANG DI E-PILKETOS</h1>
        <h2>SMK Walisongo Pecangaan - Pemilihan Ketua OSIS Online</h2>
        <br>
        <div class="countdown" id="countdown">00h 00j 00m 00d</div>
        <br>
        <!-- Tombol untuk memunculkan modal -->
        <a href="<?php echo site_url('user/formlogin'); ?>" class="btn btn-primary btn-lg">
            Ayo Vote
        </a>

    </div>

    <div class="container py-5">
        <h2 class="section-title">DAFTAR KANDIDAT & VISI MISI</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <img src="<?php echo base_url(); ?>asset/img/12.jpg" alt="Kandidat 1">
                    <h4>Kandidat 1</h4>
                    <p><strong>Visi:</strong> Menjadikan OSIS lebih aktif, kreatif, dan inovatif.</p>
                    <p><strong>Misi:</strong></p>
                    <ul class="text-start">
                        <li>Meningkatkan kegiatan ekstrakurikuler</li>
                        <li>Mewujudkan lingkungan sekolah yang nyaman</li>
                        <li>Mengoptimalkan potensi siswa</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <img src="<?php echo base_url(); ?>asset/img/1231.jpg" alt="Kandidat 2">
                    <h4>Kandidat 2</h4>
                    <p><strong>Visi:</strong> OSIS sebagai wadah pengembangan karakter siswa.</p>
                    <p><strong>Misi:</strong></p>
                    <ul class="text-start">
                        <li>Memberikan ruang kreativitas siswa</li>
                        <li>Mendorong prestasi akademik dan non-akademik</li>
                        <li>Mempererat solidaritas antar siswa</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <img src="<?php echo base_url(); ?>asset/img/alfin.jpg" alt="Kandidat 3">
                    <h4>Kandidat 3</h4>
                    <p><strong>Visi:</strong> Mewujudkan sekolah unggul dan berdaya saing.</p>
                    <p><strong>Misi:</strong></p>
                    <ul class="text-start">
                        <li>Mendorong siswa aktif dalam organisasi</li>
                        <li>Meningkatkan program sosial dan peduli lingkungan</li>
                        <li>Mewujudkan kegiatan yang bermanfaat bagi masyarakat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Hitung Mundur -->
    <script>
    const targetDate = new Date("2025-09-01T00:00:00").getTime();
    const countdownEl = document.getElementById("countdown");

    setInterval(function() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownEl.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
    }, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery versi lama agar plugin responsive-tables jalan -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>

    <!-- Responsive Tables -->
    <script src="<?php echo base_url(); ?>asset/vendor/responsive-tables/responsive-tables.js"></script>

</body>


</html>
