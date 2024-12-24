<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cour;
use App\Models\Domaine;
use App\Models\Prof;
use Illuminate\Support\Str;

class CourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupère tous les domaines et professeurs existants
        $domaines = Domaine::all();
        $profs = Prof::all();

        // Création de 20 cours fictifs
        for ($i = 1; $i <= 20; $i++) {
            $cour = Cour::create([
                'name' => 'Cours ' . $i,
                'slug' => Str::slug('Cours ' . $i),
                'domaine_id' => $domaines->random()->id,
            ]);

            // Attache entre 1 et 3 professeurs aléatoires à chaque cours
            $cour->profs()->attach(
                $profs->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
