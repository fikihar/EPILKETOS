<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pilihan;
use App\Models\Siswa;
use App\Models\IdentitasSekolah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $kandidat = Pilihan::withCount("pilihans")->orderBy("no", "ASC")->get();
        $total_dpt = Siswa::count();
        
        // Total suara adalah jumlah siswa yang status pilih()->exists()
        // Atau bisa dijumlahkan dari total suara kandidat
        $suara_masuk = $kandidat->sum("pilihans_count");
        $golput = $total_dpt - $suara_masuk;

        return view("admin.laporan.index", compact("kandidat", "total_dpt", "suara_masuk", "golput"));
    }

    public function exportPdf()
    {
        $kandidat = Pilihan::withCount("pilihans")->orderBy("no", "ASC")->get();
        $total_dpt = Siswa::count();
        $suara_masuk = $kandidat->sum("pilihans_count");
        $golput = $total_dpt - $suara_masuk;
        $sekolah = IdentitasSekolah::first();

        $pdf = Pdf::loadView("admin.laporan.pdf", compact("kandidat", "total_dpt", "suara_masuk", "golput", "sekolah"));
        $pdf->setPaper("a4", "portrait");
        return $pdf->download("Laporan_Hasil_Pilketos.pdf");
    }

    public function exportGolputPdf()
    {
        $siswa_golput = Siswa::with("kelas")
            ->where(function($q) {
                $q->where("hadir", "Tidak Hadir")
                  ->orWhere("hadir", "")
                  ->orWhereNull("hadir");
            })
            ->orderBy("kd_kelas", "ASC")
            ->orderBy("nm_siswa", "ASC")
            ->get();
            
        $sekolah = IdentitasSekolah::first();

        $pdf = Pdf::loadView("admin.laporan.pdf_golput", compact("siswa_golput", "sekolah"));
        $pdf->setPaper("a4", "portrait");
        return $pdf->download("Daftar_Siswa_Belum_Memilih.pdf");
    }
}


