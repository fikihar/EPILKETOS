<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pilihan;
use App\Models\IdentitasSekolah;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLanding()
    {
        $sekolah = IdentitasSekolah::first();
        $kandidat = Pilihan::orderBy("no", "ASC")->get();
        
        if ($sekolah && $sekolah->waktu_pelaksanaan) {
            $waktu_mulai = Carbon::parse($sekolah->waktu_pelaksanaan);
            $waktu_selesai = $waktu_mulai->copy()->endOfDay(); // Tutup tepat 23:59:59 hari H
        } else {
            $waktu_mulai = Carbon::tomorrow()->setHour(8);
            $waktu_selesai = $waktu_mulai->copy()->endOfDay();
        }

        $target_waktu = $waktu_mulai->format("M d, Y H:i:s");
        $target_selesai = $waktu_selesai->format("M d, Y H:i:s");

        return view("user.landing", compact("sekolah", "kandidat", "target_waktu", "target_selesai"));
    }

    public function showLoginForm()
    {
        return view("user.login");
    }

    public function login(Request $request)
    {
        $sekolah = IdentitasSekolah::first();
        if ($sekolah && $sekolah->waktu_pelaksanaan) {
            $now = Carbon::now();
            $waktu_mulai = Carbon::parse($sekolah->waktu_pelaksanaan);
            $waktu_selesai = $waktu_mulai->copy()->endOfDay();

            if ($now->lt($waktu_mulai)) {
                return back()->withErrors(["username" => "Pemilihan belum dimulai! Silakan tunggu sampai waktu pencoblosan dibuka."])->onlyInput("username");
            }

            if ($now->gt($waktu_selesai)) {
                return back()->withErrors(["username" => "Masa pencoblosan telah berakhir! Anda sudah tidak bisa login."])->onlyInput("username");
            }
        }

        $credentials = $request->validate([
            "username" => ["required", "string"],
            "password" => ["required", "string"],
        ]);

        if (Auth::guard("siswa")->attempt($credentials)) {
            $siswa = Auth::guard("siswa")->user();
            
            // Cek langsung saat login apakah sudah vote
            if ($siswa->hadir == "Hadir" || $siswa->hadir == "1") {
                Auth::guard("siswa")->logout();
                return back()->withErrors(["username" => "Akses Ditolak! Anda sudah menggunakan hak suara Anda sebelumnya."])->onlyInput("username");
            }

            $request->session()->regenerate();
            return redirect()->intended("vote");
        }

        return back()->withErrors([
            "username" => "NISN atau password salah.",
        ])->onlyInput("username");
    }

    public function logout(Request $request)
    {
        Auth::guard("siswa")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}



