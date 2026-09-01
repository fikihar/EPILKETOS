<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IdentitasSekolah;
use Illuminate\Support\Facades\Storage;

class IdentitasSekolahController extends Controller
{
    public function index()
    {
        $identitas = IdentitasSekolah::first();
        return view("admin.identitas", compact("identitas"));
    }

    public function update(Request $request)
    {
        $request->validate([
            "nm_sekolah"  => "required|string|max:100",
            "logo"        => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "kpl_sekolah" => "nullable|string|max:100",
            "npsn"        => "nullable|string|max:15",
            "jln"         => "nullable|string|max:64",
            "desa"        => "nullable|string|max:32",
            "kec"         => "nullable|string|max:32",
            "kab"         => "nullable|string|max:32",
            "nip"         => "nullable|string|max:20",
            "ketua_panitia" => "nullable|string|max:100",
            "nip_panitia" => "nullable|string|max:30",
            "waktu_pelaksanaan" => "nullable|date",
        ], [
            "logo.max"   => "Ukuran logo terlalu besar! Maks 2 MB.",
            "logo.image" => "File logo harus berupa gambar.",
            "logo.mimes" => "Format logo harus JPG atau PNG.",
        ]);

        $identitas = IdentitasSekolah::first();

        // Buat array data HANYA dari field teks ??? jangan gunakan $request->all() atau except()
        // karena Laravel akan memasukkan UploadedFile object ke dalam array tsb
        $data = [
            "nm_sekolah"  => $request->nm_sekolah,
            "kpl_sekolah" => $request->kpl_sekolah,
            "jln"         => $request->jln,
            "desa"        => $request->desa,
            "kec"         => $request->kec,
            "kab"         => $request->kab,
            "nip"         => $request->nip,
            "ketua_panitia" => $request->ketua_panitia,
            "nip_panitia" => $request->nip_panitia,
            "waktu_pelaksanaan" => $request->waktu_pelaksanaan,
        ];

        \Illuminate\Support\Facades\Log::info('Logo Upload Debug', [
            'hasFile' => $request->hasFile('logo'),
            'allFiles' => array_keys($request->allFiles()),
        ]);

        // Proses upload logo jika ada file baru yang dikirim
        if ($request->hasFile("logo")) {
            $file = $request->file("logo");

            \Illuminate\Support\Facades\Log::info('Logo File Info', [
                'original_name' => $file->getClientOriginalName(),
                'size'          => $file->getSize(),
                'is_valid'      => $file->isValid(),
                'error_code'    => $file->getError(),
            ]);

            // Hapus logo lama dari storage jika ada
            if ($identitas && $identitas->logo) {
                \Illuminate\Support\Facades\Storage::disk("public")->delete("logo/" . $identitas->logo);
            }

            // Simpan file ke storage/app/public/logo/
            $filename = "logo_" . time() . "." . $file->getClientOriginalExtension();
            $file->storeAs("logo", $filename, "public");

            \Illuminate\Support\Facades\Log::info('Logo Saved', ['filename' => $filename]);

            // Masukkan NAMA FILE saja (bukan path temp!) ke dalam array data
            $data["logo"] = $filename;
        }

        if ($identitas) {
            $identitas->update($data);
        } else {
            // Jika record identitas belum ada sama sekali, buat baru
            $data["npsn"] = $request->npsn ?? "00000000";
            IdentitasSekolah::create($data);
        }

        return redirect()->route("admin.identitas.index")
            ->with("success", "Identitas sekolah & logo berhasil diperbarui!");
    }
}


