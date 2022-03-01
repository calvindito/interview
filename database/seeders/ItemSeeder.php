<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemTax;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'name' => 'Baju Batik'
        ]);

        ItemTax::create([
            'item_id' => 1,
            'tax_id'  => 1
        ]);

        ItemTax::create([
            'item_id' => 1,
            'tax_id'  => 2
        ]);
    }
}
