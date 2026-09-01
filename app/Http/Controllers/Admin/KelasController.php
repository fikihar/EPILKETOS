<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        // Ambil semua kelas beserta jumlah siswa di dalamnya
        $kelas = Kelas::withCount("siswas")->orderBy("nm_kelas", "ASC")->get();
        return view("admin.kelas.index", compact("kelas"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nm_kelas" => "required|string|max:50|unique:tb_kelas,nm_kelas"
        ], [
            "nm_kelas.unique" => "Nama kelas sudah ada."
        ]);

        Kelas::create(["nm_kelas" => $request->nm_kelas]);

        return redirect()->route("admin.kelas.index")->with("success", "Kelas berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            "nm_kelas" => "required|string|max:50|unique:tb_kelas,nm_kelas," . $kelas->kd_kelas . ",kd_kelas"
        ]);

        $kelas->update(["nm_kelas" => $request->nm_kelas]);

        return redirect()->route("admin.kelas.index")->with("success", "Kelas berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // Cek jika ada siswa di kelas ini (opsional untuk proteksi)
        if($kelas->siswas()->count() > 0) {
            return redirect()->route("admin.kelas.index")->with("error", "Gagal! Kelas ini masih memiliki data siswa.");
        }

        $kelas->delete();

        return redirect()->route("admin.kelas.index")->with("success", "Kelas berhasil dihapus.");
    }
}
