<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $kelasMap = [];
        $semuaKelas = Kelas::all();
        foreach($semuaKelas as $k) {
            $kelasMap[strtolower(trim($k->nm_kelas))] = $k->kd_kelas;
        }

        $nisnTerdaftar = Siswa::pluck("username")->toArray();
        $nisnDiExcel = [];
        $errors = [];

        // FASE 1: VALIDASI KETAT SEMUA BARIS (Cari Error)
        foreach ($rows as $index => $row) 
        {
            $baris = $index + 2; // +2 karena baris 1 adalah header

            // Lewati baris kosong
            if (empty($row["nisn"])) continue;

            $nisn = trim($row["nisn"]);
            $namaKelas = isset($row["kelas"]) ? strtolower(trim($row["kelas"])) : "";

            // 1. Cek Kelas Typo / Tidak Ditemukan
            if (!isset($kelasMap[$namaKelas])) {
                $errors[] = "<b>Baris {$baris}</b>: Kelas \"{$row["kelas"]}\" tidak ditemukan di sistem.";
            }

            // 2. Cek NISN sudah ada di Database
            if (in_array($nisn, $nisnTerdaftar)) {
                $errors[] = "<b>Baris {$baris}</b>: NISN \"{$nisn}\" sudah terdaftar di database.";
            }

            // 3. Cek NISN ganda di dalam file Excel itu sendiri
            if (in_array($nisn, $nisnDiExcel)) {
                $errors[] = "<b>Baris {$baris}</b>: Terdapat duplikasi NISN \"{$nisn}\" di dalam file Excel.";
            }
            $nisnDiExcel[] = $nisn;
        }

        // JIKA ADA ERROR, HENTIKAN IMPORT DAN LEMPAR PESAN ERROR
        if (count($errors) > 0) {
            throw new \Exception(implode("<br>", $errors));
        }

        // FASE 2: JIKA 100% AMAN, MASUKKAN SEMUA KE DATABASE
        foreach ($rows as $row) 
        {
            if (empty($row["nisn"])) continue;

            $namaKelas = strtolower(trim($row["kelas"]));

            Siswa::create([
                "username" => trim($row["nisn"]),
                "nm_siswa" => trim($row["nama"]),
                "jk"       => isset($row["jk"]) ? strtoupper(trim($row["jk"])) : "L",
                "kd_kelas" => $kelasMap[$namaKelas],
                "password" => trim($row["nisn"]), 
                "hadir" => "Tidak Hadir"
            ]);
        }
    }
}

