<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Terima Kasih | E-Pilketos</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>
        * { box-sizing: border-box; }
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
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 0;
            padding: 20px;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(-45deg, rgba(6,78,59,0.88), rgba(5,150,105,0.85), rgba(11,25,44,0.90), rgba(6,78,59,0.88));
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            z-index: -1;
        }

        @keyframes gradientMove {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-radius: 28px;
            width: 100%;
            max-width: 460px;
            padding: 50px 35px;
            text-align: center;
            animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.7); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* Animated Checkmark */
        .checkmark-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.2);
            border: 3px solid rgba(16, 185, 129, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70%  { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .checkmark-icon {
            color: #10b981;
            animation: drawCheck 0.6s ease 0.3s both;
        }

        @keyframes drawCheck {
            from { opacity: 0; transform: scale(0) rotate(-30deg); }
            to   { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        h1.title {
            font-size: 2rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .nama-siswa {
            font-size: 1.2rem;
            font-weight: 600;
            color: #6ee7b7;
            margin-bottom: 20px;
        }

        p.subtitle {
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .countdown-bar-wrap {
            background: rgba(255,255,255,0.1);
            border-radius: 50px;
            height: 6px;
            width: 100%;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .countdown-bar {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #6ee7b7);
            border-radius: 50px;
            width: 100%;
            animation: shrink 5s linear forwards;
        }

        @keyframes shrink {
            from { width: 100%; }
            to   { width: 0%; }
        }

        .countdown-text {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            margin-bottom: 25px;
        }

        .btn-back-now {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            backdrop-filter: blur(5px);
        }

        .btn-back-now:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateY(-2px);
        }

        /* Floating particles */
        .particle {
            position: fixed;
            border-radius: 50%;
            opacity: 0;
            animation: float-up 4s ease-in infinite;
            pointer-events: none;
        }

        @keyframes float-up {
            0%   { opacity: 0; transform: translateY(0) scale(0); }
            10%  { opacity: 0.7; }
            90%  { opacity: 0.2; }
            100% { opacity: 0; transform: translateY(-100vh) scale(1.5); }
        }
    </style>
</head>
<body>

    <!-- Floating Particles Confetti -->
    <div class="particle" style="width:12px; height:12px; background:#10b981; left:10%; top:90%; animation-delay:0s; animation-duration:5s;"></div>
    <div class="particle" style="width:8px;  height:8px;  background:#6ee7b7; left:25%; top:90%; animation-delay:0.8s; animation-duration:4.5s;"></div>
    <div class="particle" style="width:15px; height:15px; background:#fbbf24; left:40%; top:90%; animation-delay:1.5s; animation-duration:6s;"></div>
    <div class="particle" style="width:10px; height:10px; background:#60a5fa; left:55%; top:90%; animation-delay:0.3s; animation-duration:4s;"></div>
    <div class="particle" style="width:8px;  height:8px;  background:#10b981; left:70%; top:90%; animation-delay:1.2s; animation-duration:5.5s;"></div>
    <div class="particle" style="width:12px; height:12px; background:#a78bfa; left:85%; top:90%; animation-delay:0.5s; animation-duration:4.8s;"></div>
    <div class="particle" style="width:6px;  height:6px;  background:#fbbf24; left:90%; top:90%; animation-delay:2s; animation-duration:5s;"></div>
    <div class="particle" style="width:10px; height:10px; background:#6ee7b7; left:5%;  top:90%; animation-delay:1.8s; animation-duration:4.2s;"></div>

    <div class="glass-box">
        <!-- Animated Checkmark -->
        <div class="checkmark-circle">
            <svg class="checkmark-icon" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>

        <h1 class="title">Suara Diterima!</h1>
        <div class="nama-siswa">{{ $nm_siswa }}</div>

        <p class="subtitle">
            Hak pilih Anda telah berhasil direkam ke dalam kotak suara digital dengan aman dan rahasia. Terima kasih telah berpartisipasi aktif dalam pemilihan Ketua OSIS!
        </p>

        <div class="countdown-bar-wrap">
            <div class="countdown-bar" id="barProgress"></div>
        </div>
        <p class="countdown-text" id="countdownText">Mengalihkan ke halaman utama dalam <span id="secLeft">5</span> detik...</p>

        <a href="/" class="btn-back-now" onclick="clearAndGoHome()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6-6"/></svg>
            Kembali Sekarang
        </a>
    </div>

    <script>
        var sec = 5;
        var timer = setInterval(function() {
            sec--;
            document.getElementById("secLeft").textContent = sec;
            if (sec <= 0) {
                clearInterval(timer);
                window.location.href = "/";
            }
        }, 1000);

        function clearAndGoHome() {
            clearInterval(timer);
        }
    </script>
</body>
</html>
