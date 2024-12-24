<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cours = Cour::with(['domaine', 'profs'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $cours,
            'message' => 'Liste des cours récupérée avec succès.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:cours,slug'],
            'domaine_id' => ['required', 'exists:domaines,id'],
            'profs' => ['required', 'array'],
            'profs.*' => ['exists:profs,id'],
        ]);

        // Créer un nouveau cours
        $cour = Cour::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'domaine_id' => $request->domaine_id,
        ]);

        // Attacher les professeurs au cours
        $cour->profs()->attach($request->profs);

        return response()->json([
            'status' => 'success',
            'data' => $cour->load(['domaine', 'profs']),
            'message' => 'Le cours a été créé avec succès.',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
               $cour=Cour::find($id)  ;   
            if (!$cour) {
                return response()->json([
                    'status' => 'failed',
                    'id' => $id,
                    'message' => 'cours non trouvable.',
                ], 404);
            }
       $cour->load(['domaine', 'profs']);

        return response()->json([
            'status' => 'success',
            'data' => $cour,
            'message' => 'Détails du cours récupérés avec succès.',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cour $cour)
    {
        // Valider les données de la requête
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'unique:cours,slug,' . $cour->id],
            'domaine_id' => ['sometimes', 'required', 'exists:domaines,id'],
            'profs' => ['sometimes', 'required', 'array'],
            'profs.*' => ['exists:profs,id'],
        ]);

        // Mettre à jour les attributs du cours
        if ($request->has('name')) {
            $cour->name = $request->name;
        }

        if ($request->has('slug')) {
            $cour->slug = Str::slug($request->slug);
        }

        if ($request->has('domaine_id')) {
            $cour->domaine_id = $request->domaine_id;
        }

        $cour->save();

        // Synchroniser les professeurs si fournis
        if ($request->has('profs')) {
            $cour->profs()->sync($request->profs);
        }

        return response()->json([
            'status' => 'success',
            'data' => $cour->load(['domaine', 'profs']),
            'message' => 'Le cours a été mis à jour avec succès.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cour $cour)
    {
        // Détacher tous les professeurs associés
        $cour->profs()->detach();

        // Supprimer le cours
        $cour->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Le cours a été supprimé avec succès.',
        ], 200);
    }
}
