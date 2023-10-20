<?php

namespace Database\Seeders;

use App\Models\Markup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarkupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            [
                'service' => 'hotel',
                'markup' => 10,
            ],

            [
                'service' => 'flight',
                'markup' => 10,
            ],

            [
                'service' => 'transfer',
                'markup' => 10,
            ],

            [
                'service' => 'activity',
                'markup' => 10,
            ],

            [
                'service' => 'umrah',
                'markup' => 10,
            ],

            [
                'service' => 'ziyarat',
                'markup' => 10,
            ],

            [
                'service' => 'visa',
                'markup' => 10,
            ],
        ];

        foreach ($entries as $entry) {
            Markup::create($entry);
        }
    }
}
