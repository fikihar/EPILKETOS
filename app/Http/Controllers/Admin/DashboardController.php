<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pilih;
use App\Models\Pilihan;

class DashboardController extends Controller
{
    public function index()
    {
        $kandidat = Pilihan::withCount("pilihans")->orderBy("no", "ASC")->get();
        $total_dpt = Siswa::count();
        $suara_masuk = $kandidat->sum("pilihans_count");
        $golput = $total_dpt - $suara_masuk;

        return view("admin.dashboard", compact("kandidat", "total_dpt", "suara_masuk", "golput"));
    }

    public function resetVoting()
    {
        try {
            \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=0;");
            \Illuminate\Support\Facades\DB::table("tb_pilih")->truncate();
            \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=1;");
            
            // Set all hadir to empty string first to avoid enum errors, then to Tidak Hadir
            Siswa::query()->update(["hadir" => "Tidak Hadir"]);
            
            return redirect()->route("admin.dashboard")->with("success", "Semua data suara berhasil di-reset ke NOL!");
        } catch (\Exception $e) {
            return redirect()->route("admin.dashboard")->with("error", "Gagal mereset suara: " . $e->getMessage());
        }
    }
}

