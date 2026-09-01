<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
class KelasSeeder extends Seeder {
    public function run(): void {
        $kelas = [
            'X DPK', 'XI DPK', 'XII DPK',
            'X AKL', 'XI AKL', 'XII AKL',
            'X TO A', 'XI TO A', 'XII TO A',
            'X TO B', 'XI TO B', 'XII TO B',
            'X TO INDUSTRI', 'XI TO INDUSTRI', 'XII TO INDUSTRI',
            'X TJKT A', 'XI TJKT A', 'XII TJKT A',
            'X TJKT B', 'XI TJKT B', 'XII TJKT B'
        ];
        foreach ($kelas as $k) {
            Kelas::create(['nm_kelas' => $k]);
        }
    }
}
