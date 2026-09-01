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
            $filename = time() . "_" . Str::slug($request->nama_ketua . "-" . $request->nama_wakil) . ".webp";
            
            // Native Auto-Compress to WebP via GD
            $this->compressAndSaveImage($file, "foto-calon", $filename);
            
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
            $filename = time() . "_" . Str::slug($request->nama_ketua . "-" . $request->nama_wakil) . ".webp";
            
            // Native Auto-Compress to WebP via GD
            $this->compressAndSaveImage($file, "foto-calon", $filename);
            
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

    /**
     * Helper compress image native GD (Tanpa library berat)
     */
    private function compressAndSaveImage($file, $destinationFolder, $filename)
    {
        $maxWidth = 600; // Ukuran proporsional HP
        
        $source = $file->getPathname();
        $info = getimagesize($source);
        $mime = $info["mime"];
        
        if ($mime == "image/jpeg") $image = imagecreatefromjpeg($source);
        elseif ($mime == "image/png") $image = imagecreatefrompng($source);
        elseif ($mime == "image/gif") $image = imagecreatefromgif($source);
        elseif ($mime == "image/webp") $image = imagecreatefromwebp($source);
        else return false;

        $width = $info[0];
        $height = $info[1];
        
        // Resize jika lebih besar dari maxWidth
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Jaga transparansi untuk PNG/WebP
        if ($mime == "image/png" || $mime == "image/webp") {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        $fullPath = storage_path("app/public/" . $destinationFolder);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        // Convert paksa menjadi format WebP kualitas 80% (Sangat Kecil & Tajam)
        imagewebp($newImage, $fullPath . "/" . $filename, 80);
        
        imagedestroy($image);
        imagedestroy($newImage);
        
        return true;
    }
}

