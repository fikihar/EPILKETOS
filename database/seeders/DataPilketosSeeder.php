<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\DataPilketos;
use Carbon\Carbon;
class DataPilketosSeeder extends Seeder {
    public function run(): void {
        DataPilketos::create([
            'tapel' => '2026/2027',
            'tgl' => Carbon::now()->addDays(7)->toDateString() // 1 minggu dari sekarang
        ]);
    }
}
