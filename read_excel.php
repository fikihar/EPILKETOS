
<?php
require "c:/laragon/www/Epilketos/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = "C:/Users/FIKIH/Downloads/1. DATA SISWA X TP. 2026-2027.xlsx";
if (!file_exists($filePath)) {
    echo "File not found!";
    exit;
}

$spreadsheet = IOFactory::load($filePath);
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

echo "HEADERS:\n";
print_r(array_slice($rows, 0, 5));

