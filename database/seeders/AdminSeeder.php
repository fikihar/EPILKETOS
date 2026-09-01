<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminSeeder extends Seeder {
    public function run(): void {
        // Password akan di-hash otomatis oleh setter di Model
        Admin::create(['username' => 'admin', 'password' => 'admin']);
    }
}
