<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Afficher toutes les catégories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }



    // Afficher une catégorie par son ID
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        return response()->json($category);
    }



    // Créer une nouvelle catégorie
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        // Vérifier si une catégorie avec le même nom existe déjà
        $existingCategory = Category::where('nom', $validated['nom'])->first();
    
        if ($existingCategory) {
            // Si une catégorie avec ce nom existe, retourner une erreur
            return response()->json(['message' => 'Une catégorie avec ce nom existe déjà.'], 400);
        }
    
        // Créer la nouvelle catégorie si le nom est unique
        $category = Category::create($validated);
    
        // Retourner une réponse JSON avec la catégorie créée
        return response()->json(['message' => 'Catégorie créée', 'category' => $category], 200);
    }
    



    // Modifier une catégorie
    public function update(Request $request, $id)
    {
        // Cherche la catégorie par ID
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
    
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        // Met à jour la catégorie
        $category->update($validated);
    
        // Retourne la réponse JSON
        return response()->json(['message' => 'Catégorie mise à jour', 'category' => $category]);
    }
    




    // Supprimer une catégorie
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée']);
    }
}
