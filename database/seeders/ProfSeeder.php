<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prof;
use Illuminate\Support\Str;

class ProfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création de 10 professeurs fictifs
        for ($i = 1; $i <= 10; $i++) {
            Prof::create([
                'name' => 'Professeur ' . $i,
                'slug' => Str::slug('Professeur ' . $i),
            ]);
        }
    }
}
