
$admin = Auth::guard("admin")->attempt(["username" => "admin", "password" => "admin"]);
echo "Login Admin (admin/admin): " . ($admin ? "BERHASIL" : "GAGAL") . "\n";

