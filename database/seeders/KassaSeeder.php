<?php

namespace Database\Seeders;

use App\Models\Kassa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KassaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kassa::create([
            'name'=>'Cash kassa',
            'balance'=>0,
            'is_cash'=>1,
            'is_click'=>0,
        ]);
        Kassa::create([
            'name'=>'Card kassa',
            'balance'=>0,
            'is_cash'=>0,
            'is_click'=>0,
        ]);
        Kassa::create([
            'name'=>'Click kassa',
            'balance'=>0,
            'is_cash'=>0,
            'is_click'=>1,
        ]);
    }
}
