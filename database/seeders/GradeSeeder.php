<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\GradeParent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class11 = GradeParent::create(['name' => 'Class 11']);
        $class12 = GradeParent::create(['name' => 'Class 12']);

        $streams = [
            ['name' => 'Science'],
            ['name' => 'Commerce'],
            ['name' => 'Arts'],
        ];

        foreach ($streams as $stream) {
            $class11->grades()->create($stream);
            $class12->grades()->create($stream);
        }

        $grades = [
            'Pre-Nursery',
            'Nursery',
            'LKG',
            'UKG',
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4',
            'Class 5',
            'Class 6',
            'Class 7',
            'Class 8',
            'Class 9',
            'Class 10',
        ];

        foreach ($grades as $grade) {
            Grade::create(['name' => $grade]);
        }
    }
}
