<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return ["nisn", "nama", "jk", "kelas"];
    }

    public function array(): array
    {
        return [
            ["0012345678", "Ahmad Fulan", "L", "X AKL"],
            ["0087654321", "Siti Aminah", "P", "XI TJKT A"],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold header di baris 1
            1 => ["font" => ["bold" => true]],
        ];
    }
}
