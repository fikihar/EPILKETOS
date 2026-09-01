<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\IdentitasSekolah;
class IdentitasSekolahSeeder extends Seeder {
    public function run(): void {
        IdentitasSekolah::create([
            'npsn' => '20338635',
            'nm_sekolah' => 'SMKS WALISONGO PECANGAAN',
            'jln' => 'Jl. Kauman No.1',
            'desa' => 'Pecangaan Kulon',
            'kec' => 'Pecangaan',
            'kab' => 'Jepara',
            'kpl_sekolah' => 'Irbab Aulia Amri, S.Pd, M.Pd',
            'nip' => ''
        ]);
    }
}
