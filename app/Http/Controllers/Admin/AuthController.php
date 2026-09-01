<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("admin.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "username" => ["required", "string"],
            "password" => ["required", "string"],
        ]);

        if (Auth::guard("admin")->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended("admin/dashboard");
        }

        return back()->withErrors([
            "username" => "Username atau password salah.",
        ])->onlyInput("username");
    }

    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("admin/login");
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "password" => "required|min:4|confirmed"
        ]);

        $admin = Auth::guard("admin")->user();
        $admin->password = $request->password; // Model Admin sudah otomatis melakukan Hash::make via setPasswordAttribute
        $admin->save();

        return back()->with("success", "Password Admin berhasil diperbarui!");
    }
}



