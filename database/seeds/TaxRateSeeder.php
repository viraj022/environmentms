<?php

use App\TaxRate;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                "name" => "vat",
                "rate" => 0,
            ],
            [
                "name" => "nbt",
                "rate" => 0,
            ]
        ];
        foreach ($items as $item) {
            TaxRate::create($item);
        }
        print("Tax rates seeded successfully." . PHP_EOL);
    }
}
