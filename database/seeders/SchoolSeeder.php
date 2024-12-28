<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::factory(50)->create()->each(function (School $school) {
            Address::factory()->create([
                'addressable_id' => $school->id,
                'addressable_type' => School::class,
            ]);
        });
    }
}
