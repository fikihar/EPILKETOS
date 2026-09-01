<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pilihan;
use App\Models\Pilih;
use App\Models\IdentitasSekolah;
use App\Models\Siswa;

class VoteController extends Controller
{
    public function index()
    {
        $siswa = Auth::guard("siswa")->user();

        if ($siswa->hadir == "Hadir") {
            Auth::guard("siswa")->logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect("/")->with("error", "Akses Ditolak! Anda sudah menggunakan hak suara Anda sebelumnya.");
        }

        $sekolah = IdentitasSekolah::first();
        $kandidat = Pilihan::orderBy("no", "ASC")->get();

        return view("user.vote", compact("siswa", "kandidat", "sekolah"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nisn_paslon" => "required|exists:tb_pilihan,nisn"
        ]);

        $siswa = Auth::guard("siswa")->user();

        if ($siswa->hadir == "Hadir") {
            Auth::guard("siswa")->logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect("/")->with("error", "Anda sudah menggunakan hak suara.");
        }

        // Catat Suara
        Pilih::create([
            "nisn"     => $request->nisn_paslon,
            "username" => $siswa->username
        ]);

        // Update status hadir
        Siswa::where("username", $siswa->username)->update(["hadir" => "Hadir"]);

        // Simpan nama ke session SEBELUM session di-reset
        $nm_siswa = $siswa->nm_siswa;

        // Logout: Hanya forget guard saja, JANGAN invalidate session dulu
        Auth::guard("siswa")->logout();

        // Simpan nama ke session (session masih hidup)
        session(["nm_siswa_vote" => $nm_siswa]);

        return redirect()->route("terimakasih");
    }

    public function terimakasih()
    {
        $nm_siswa = session("nm_siswa_vote");

        if (!$nm_siswa) {
            return redirect("/");
        }

        // Hapus dari session setelah diambil
        session()->forget("nm_siswa_vote");

        return view("user.terimakasih", compact("nm_siswa"));
    }
}
