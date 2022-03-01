<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::create([
            'name' => 'PPH',
            'rate' => 5
        ]);

        Tax::create([
            'name' => 'Pajak Toko',
            'rate' => 10
        ]);
    }
}
