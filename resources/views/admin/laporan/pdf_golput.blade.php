<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa Belum Memilih</title>
    <style>
        body { font-family: "Helvetica", "Arial", sans-serif; font-size: 14px; color: #333; }
        .kop-surat { width: 100%; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; text-align: center; }
        .kop-surat table { width: 100%; }
        .kop-surat td { vertical-align: middle; }
        .logo { width: 80px; height: auto; }
        .text-kop h2, .text-kop h3, .text-kop p { margin: 0; }
        .text-kop h2 { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .text-kop h3 { font-size: 16px; font-weight: bold; margin-top: 5px; }
        .text-kop p { font-size: 12px; margin-top: 5px; }
        .table-data { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table-data th, .table-data td { border: 1px solid #333; padding: 8px; text-align: left; }
        .table-data th { background-color: #f0f0f0; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <table width="100%" style="border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td width="15%" style="text-align: center; vertical-align: middle;">
                <!-- Logo Sekolah di Kiri -->
                @if(isset($sekolah) && $sekolah->logo && file_exists($sekolah->logo_path))
                <img src="{{ $sekolah->logo_path }}" style="height: 85px; width: auto;" alt="Logo Sekolah">
                @endif
            </td>
            <td width="70%" style="text-align: center; vertical-align: middle;">
                <h2 style="margin: 0; font-size: 20px; text-transform: uppercase; font-weight: bold;">LAPORAN PELAKSANAAN PEMUNGUTAN SUARA</h2>
                <h2 style="margin: 3px 0; font-size: 20px; text-transform: uppercase; font-weight: bold;">PEMILIHAN KETUA OSIS & WAKIL KETUA OSIS</h2>
                <p style="margin: 0; font-size: 16px;"><b>{{ $sekolah->nm_sekolah ?? "SMKS Walisongo Pecangaan" }}</b></p>
                <p style="margin: 3px 0 0 0; font-size: 12px; color: #333;">{{ $sekolah->jln ?? "" }} {{ $sekolah->desa ?? "" }} {{ $sekolah->kec ?? "" }} {{ $sekolah->kab ?? "" }}</p>
            </td>
            <td width="15%" style="text-align: center; vertical-align: middle;">
                <!-- Logo OSIS di Kanan -->
                @if(file_exists(public_path("img/logo-osis.webp")))
                <img src="{{ public_path("img/logo-osis.webp") }}" style="height: 85px; width: auto;" alt="Logo OSIS">
                @endif
            </td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-bottom: 20px;">DAFTAR SISWA BELUM MEMILIH (GOLPUT)</h3>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NISN</th>
                <th width="45%">Nama Siswa</th>
                <th width="15%">L/P</th>
                <th width="15%">Kelas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa_golput as $index => $s)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $s->username }}</td>
                    <td>{{ $s->nm_siswa }}</td>
                    <td class="text-center">{{ $s->jk }}</td>
                    <td class="text-center">{{ $s->kelas->nm_kelas ?? "-" }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Semua siswa telah menggunakan hak pilihnya.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table width="100%" style="margin-top: 40px; border: none;">
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center; vertical-align: top;">
                {{ $sekolah->kab ?? "Jepara" }}, {{ date("d F Y") }}<br>
                <br>
                Ketua Panitia Pemilihan
            </td>
        </tr>
        <tr>
            <td height="80"></td>
            <td height="80"></td>
        </tr>
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center; vertical-align: bottom;">
                <b><u>{{ $sekolah->ketua_panitia ?? "........................................" }}</u></b><br>
                NIP. {{ $sekolah->nip_panitia ?? "-" }}
            </td>
        </tr>
    </table>
</body>
</html>




