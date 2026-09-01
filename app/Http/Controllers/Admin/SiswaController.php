<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with("kelas")->orderBy("kd_kelas", "ASC")->orderBy("nm_siswa", "ASC");
        
        if($request->has("search") && $request->search != ""){
            $query->where(function($q) use ($request) {
                $q->where("nm_siswa", "LIKE", "%".$request->search."%")
                  ->orWhere("username", "LIKE", "%".$request->search."%");
            });
        }

        if($request->has("filter_kelas") && $request->filter_kelas != ""){
            $query->where("kd_kelas", $request->filter_kelas);
        }

        $siswa = $query->paginate(50)->appends($request->all());
        
        $kelas = Kelas::orderBy("nm_kelas", "ASC")->get();

        return view("admin.siswa.index", compact("siswa", "kelas"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "username" => "required|string|max:50|unique:tb_siswa,username",
            "nm_siswa" => "required|string|max:100",
            "jk"       => "required|in:L,P",
            "kd_kelas" => "required|exists:tb_kelas,kd_kelas"
        ], [
            "username.unique" => "NISN/Username sudah terdaftar!"
        ]);

        // Secara default password adalah NISN/Username-nya sendiri jika tidak diisi
        $password = $request->password ? $request->password : $request->username;

        Siswa::create([
            "username" => $request->username,
            "nm_siswa" => $request->nm_siswa,
            "jk"       => $request->jk,
            "kd_kelas" => $request->kd_kelas,
            "password" => $password, 
            "hadir" => "Tidak Hadir" // Default belum hadir
        ]);

        return redirect()->route("admin.siswa.index")->with("success", "Siswa berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            "username" => "required|string|max:50|unique:tb_siswa,username," . $siswa->username . ",username",
            "nm_siswa" => "required|string|max:100",
            "jk"       => "required|in:L,P",
            "kd_kelas" => "required|exists:tb_kelas,kd_kelas"
        ]);

        $data = [
            "username" => $request->username,
            "nm_siswa" => $request->nm_siswa,
            "jk"       => $request->jk,
            "kd_kelas" => $request->kd_kelas,
        ];

        // Jika password diisi, maka update password
        if($request->filled("password")){
            $data["password"] = $request->password;
        }

        $siswa->update($data);

        return redirect()->route("admin.siswa.index")->with("success", "Data siswa berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        
        // Cek apakah siswa ini sudah melakukan voting
        if($siswa->sudahVote()){
            return redirect()->route("admin.siswa.index")->with("error", "Gagal! Siswa ini sudah memberikan suaranya.");
        }

        $siswa->delete();

        return redirect()->route("admin.siswa.index")->with("success", "Data siswa berhasil dihapus.");
    }


    public function import(Request $request)
    {
        $request->validate([
            "file_excel" => "required|mimes:xlsx,xls,csv"
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SiswaImport, $request->file("file_excel"));
            return redirect()->route("admin.siswa.index")->with("success", "Data siswa berhasil diimport!");
        } catch (\Exception $e) {
            return redirect()->route("admin.siswa.index")->with("error", "Gagal mengimport data! Pastikan format sesuai template. Error: " . $e->getMessage());
        }
    }

            public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaTemplateExport, "template_import_siswa.xlsx");
    }

    public function deleteAll()
    {
        try {
            // Hapus semua data siswa (abaikan sementara FK checks jika ada yg sudah vote)
            \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=0;");
            \App\Models\Siswa::truncate();
            \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=1;");
            
            return redirect()->route("admin.siswa.index")->with("success", "Seluruh data siswa (DPT) berhasil dikosongkan!");
        } catch (\Exception $e) {
            return redirect()->route("admin.siswa.index")->with("error", "Gagal mengosongkan data. Error: " . $e->getMessage());
        }
    }
}





