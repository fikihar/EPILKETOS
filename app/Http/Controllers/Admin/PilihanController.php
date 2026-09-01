<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pilihan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PilihanController extends Controller
{
    public function index()
    {
        // Ambil data paslon urut berdasarkan nomor urut
        $kandidat = Pilihan::withCount("pilihans")->orderBy("no", "ASC")->get();
        return view("admin.kandidat.index", compact("kandidat"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "no"    => "required|integer|unique:tb_pilihan,no",
            "nama_ketua" => "required|string|max:30",
            "nama_wakil" => "required|string|max:30",
            "photo" => "nullable|image|mimes:jpeg,png,jpg|max:10240"
        ], [
            "nisn.unique" => "NISN/ID Paslon ini sudah digunakan.",
            "no.unique"   => "Nomor urut ini sudah terpakai oleh kandidat lain.",
            "photo.max"   => "Ukuran foto terlalu besar! Maksimal ukuran file adalah 10 MB.",
            "photo.image" => "File yang diunggah harus berupa gambar/foto.",
            "photo.mimes" => "Format foto harus JPG, JPEG, atau PNG."
        ]);

        $data = [
            "nisn" => "PASLON-" . time(), // Generate ID otomatis untuk menggantikan NISN
            "no"   => $request->no,
            "nama" => trim($request->nama_ketua) . " & " . trim($request->nama_wakil),
        ];

        if ($request->hasFile("photo")) {
            $file = $request->file("photo");
            $filename = time() . "_" . Str::slug($request->nama_ketua . "-" . $request->nama_wakil) . "." . $file->getClientOriginalExtension();
            // Simpan ke storage/app/public/foto-calon
            $file->storeAs("foto-calon", $filename, "public");
            $data["photo"] = $filename;
        }

        Pilihan::create($data);

        return redirect()->route("admin.kandidat.index")->with("success", "Kandidat Paslon berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $kandidat = Pilihan::findOrFail($id);

        $request->validate([
            "no"    => "required|integer|unique:tb_pilihan,no," . $kandidat->nisn . ",nisn",
            "nama_ketua" => "required|string|max:30",
            "nama_wakil" => "required|string|max:30",
            "photo" => "nullable|image|mimes:jpeg,png,jpg|max:10240"
        ], [
            "nisn.unique" => "NISN/ID Paslon ini sudah digunakan.",
            "no.unique"   => "Nomor urut ini sudah terpakai oleh kandidat lain.",
            "photo.max"   => "Ukuran foto terlalu besar! Maksimal ukuran file adalah 10 MB.",
            "photo.image" => "File yang diunggah harus berupa gambar/foto.",
            "photo.mimes" => "Format foto harus JPG, JPEG, atau PNG."
        ]);

        $data = [
            "nisn" => "PASLON-" . time(), // Generate ID otomatis untuk menggantikan NISN
            "no"   => $request->no,
            "nama" => trim($request->nama_ketua) . " & " . trim($request->nama_wakil),
        ];

        if ($request->hasFile("photo")) {
            // Hapus foto lama jika ada
            if ($kandidat->photo && Storage::disk("public")->exists("foto-calon/" . $kandidat->photo)) {
                Storage::disk("public")->delete("foto-calon/" . $kandidat->photo);
            }

            $file = $request->file("photo");
            $filename = time() . "_" . Str::slug($request->nama_ketua . "-" . $request->nama_wakil) . "." . $file->getClientOriginalExtension();
            $file->storeAs("foto-calon", $filename, "public");
            $data["photo"] = $filename;
        }

        $kandidat->update($data);

        return redirect()->route("admin.kandidat.index")->with("success", "Data Kandidat berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $kandidat = Pilihan::findOrFail($id);
        
        // Proteksi: jangan hapus jika kandidat sudah memiliki suara
        if ($kandidat->totalSuara() > 0) {
            return redirect()->route("admin.kandidat.index")->with("error", "Gagal! Kandidat ini sudah menerima suara dari pemilih.");
        }

        // Hapus foto fisik dari storage
        if ($kandidat->photo && Storage::disk("public")->exists("foto-calon/" . $kandidat->photo)) {
            Storage::disk("public")->delete("foto-calon/" . $kandidat->photo);
        }

        $kandidat->delete();

        return redirect()->route("admin.kandidat.index")->with("success", "Data Kandidat berhasil dihapus.");
    }
}



