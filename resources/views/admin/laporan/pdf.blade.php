<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Pilketos</title>
    <style>
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .stats-box {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .stats-box td {
            padding: 15px 10px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: top;
            width: 33.33%;
            background: #f9f9f9;
        }

        .stats-box h3 {
            margin: 0 0 5px 0;
            font-size: 24px;
            color: #000;
        }

        .stats-box p {
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        .table-result {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table-result th,
        .table-result td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        .table-result th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .progress-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 5px;
            height: 15px;
        }

        .progress-bar {
            height: 100%;
            background-color: #4CAF50;
        }
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
                <h2 style="margin: 0; font-size: 20px; text-transform: uppercase;">LAPORAN PELAKSANAAN PEMUNGUTAN SUARA</h2>
                <h2 style="margin: 3px 0; font-size: 20px; text-transform: uppercase;">PEMILIHAN KETUA OSIS & WAKIL KETUA OSIS</h2>
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

    <p style="text-align: justify; margin-bottom: 20px;">
        Dengan hormat, bersama surat ini kami selaku Panitia Pemilihan Ketua OSIS {{ $sekolah->nm_sekolah ?? "SMKS Walisongo Pecangaan" }} menyampaikan laporan hasil rekapitulasi akhir pemungutan suara Pemilihan Ketua dan Wakil Ketua OSIS yang telah dilaksanakan dengan rincian sebagai berikut:
    </p>

    <table class="stats-box">
        <tr>
            <td>
                <h3>{{ number_format($total_dpt, 0, ",", ".") }}</h3>
                <p>TOTAL DAFTAR PEMILIH TETAP (DPT)</p>
            </td>
            <td>
                <h3>{{ number_format($suara_masuk, 0, ",", ".") }}</h3>
                <p>TOTAL SUARA MASUK ({{ $total_dpt > 0 ? round(($suara_masuk/$total_dpt)*100, 1) : 0 }}%)</p>
            </td>
            <td>
                <h3>{{ number_format($golput, 0, ",", ".") }}</h3>
                <p>BELUM MEMILIH ({{ $total_dpt > 0 ? round(($golput/$total_dpt)*100, 1) : 0 }}%)</p>
            </td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-bottom: 10px; margin-top: 30px;">RINCIAN PEROLEHAN SUARA KANDIDAT PASLON</h3>

    <table class="table-result">
        <thead>
            <tr>
                <th width="10%" class="text-center">No Urut</th>
                <th width="45%">Nama Pasangan Calon</th>
                <th width="20%" class="text-center">Perolehan Suara</th>
                <th width="25%" class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kandidat as $k)
            @php
            $persentase = $suara_masuk > 0 ? round(($k->pilihans_count / $suara_masuk) * 100, 2) : 0;
            @endphp
            <tr>
                <td class="text-center"><b>{{ $k->no }}</b></td>
                <td>{{ $k->nama }}</td>
                <td class="text-center"><b>{{ number_format($k->pilihans_count, 0, ",", ".") }}</b> Suara</td>
                <td class="text-center">
                    <div style="font-weight: bold; margin-bottom: 3px;">{{ $persentase }}%</div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: {{ $persentase }}%;"></div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align: justify; margin-top: 20px;">
        Demikian laporan hasil pemungutan suara ini kami susun dan sampaikan dengan sebenar-benarnya agar dapat dipergunakan sebagaimana mestinya. Atas perhatian dan dukungan Bapak/Ibu, kami ucapkan terima kasih.
    </p>

    <table width="100%" style="margin-top: 40px; text-align: center; border: none;">
        <tr>
            <td width="50%" style="vertical-align: top;">
                <br>
                Mengetahui,<br>
                Kepala Sekolah
            </td>
            <td width="50%" style="vertical-align: top;">
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
            <td width="50%" style="vertical-align: bottom;">
                <b><u>{{ $sekolah->kpl_sekolah ?? "........................................" }}</u></b><br>
                NIP. {{ $sekolah->nip ?? "-" }}
            </td>
            <td width="50%" style="vertical-align: bottom;">
                <b><u>{{ $sekolah->ketua_panitia ?? "........................................" }}</u></b><br>
                NIP. {{ $sekolah->nip_panitia ?? "-" }}
            </td>
        </tr>
    </table>

</body>

</html>

