
<?php
require "c:/laragon/www/Epilketos/vendor/autoload.php";
$app = require_once "c:/laragon/www/Epilketos/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$filePath = "C:/Users/FIKIH/Downloads/1. DATA SISWA X TP. 2026-2027.xlsx";
if (!file_exists($filePath)) {
    echo "File not found!";
    exit;
}

echo "Loading Excel...\n";
$spreadsheet = IOFactory::load($filePath);
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

// Get all existing classes mapping
$kelasMap = [];
$semuaKelas = Kelas::all();
foreach($semuaKelas as $k) {
    $kelasMap[strtolower(trim($k->nm_kelas))] = $k->kd_kelas;
}

echo "Memulai Import...\n";
$inserted = 0;
$skipped = 0;

DB::beginTransaction();
try {
    foreach ($rows as $index => $row) {
        if ($index == 0) continue; // skip header

        $nipd = trim($row[1]);
        $nama = trim($row[3]);
        $rombel = trim($row[4]);

        if (empty($nipd) || empty($nama)) {
            continue;
        }

        $rombelLower = strtolower($rombel);

        // Cari atau buat kelas baru
        if (!isset($kelasMap[$rombelLower])) {
            $newKd = Kelas::max("kd_kelas") + 1;
            $newKelas = Kelas::create([
                "kd_kelas" => (string)$newKd,
                "nm_kelas" => $rombel
            ]);
            $kelasMap[$rombelLower] = $newKelas->kd_kelas;
            echo "Membuat Kelas Baru: $rombel\n";
        }

        $kd_kelas = $kelasMap[$rombelLower];

        // Update or Create Siswa
        $siswa = Siswa::updateOrCreate(
            ["username" => $nipd],
            [
                "nm_siswa" => $nama,
                "kd_kelas" => $kd_kelas,
                "jk" => "L", // default
                "password" => Hash::make($nipd), // Sesuai aturan: password default = NISN
                "hadir" => "Tidak Hadir"
            ]
        );
        $inserted++;
    }
    DB::commit();
    echo "Berhasil import/update $inserted data siswa DPT!\n";
} catch (\Exception $e) {
    DB::rollback();
    echo "Gagal: " . $e->getMessage() . "\n";
}


