
<?php
require "c:/laragon/www/Epilketos/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inputPath = "C:/Users/FIKIH/Downloads/1. DATA SISWA X TP. 2026-2027.xlsx";
$outputPath = "C:/Users/FIKIH/Downloads/DPT_SIAP_UPLOAD.xlsx";

$spreadsheet = IOFactory::load($inputPath);
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

$newSpreadsheet = new Spreadsheet();
$newSheet = $newSpreadsheet->getActiveSheet();

// Set Headers for the new format
$newSheet->setCellValue("A1", "nisn");
$newSheet->setCellValue("B1", "nama");
$newSheet->setCellValue("C1", "kelas");
$newSheet->setCellValue("D1", "jk");

$rowIndex = 2;
foreach ($rows as $index => $row) {
    if ($index == 0) continue; // skip header

    $nipd = trim($row[1]);
    $nama = trim($row[3]);
    $rombel = trim($row[4]);

    if (empty($nipd) || empty($nama)) continue;

    $newSheet->setCellValue("A" . $rowIndex, $nipd);
    $newSheet->setCellValue("B" . $rowIndex, $nama);
    $newSheet->setCellValue("C" . $rowIndex, $rombel);
    $newSheet->setCellValue("D" . $rowIndex, "L");
    $rowIndex++;
}

$writer = new Xlsx($newSpreadsheet);
$writer->save($outputPath);
echo "File DPT_SIAP_UPLOAD.xlsx berhasil dibuat!";

