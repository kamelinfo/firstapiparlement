<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domaine;
use Illuminate\Support\Str;

class DomaineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création de 5 domaines fictifs
        for ($i = 1; $i <= 5; $i++) {
            Domaine::create([
                'name' => 'Domaine ' . $i,
                'slug' => Str::slug('Domaine ' . $i),
            ]);
        }
    }
}
