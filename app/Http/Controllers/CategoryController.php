<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $validated = $request->validate([
            'nom' => 'required|string|max:255',  
            'description' => 'nullable|string',  
        ]);

        $category = Category::create($validated);

        return response()->json(['message' => 'Catégorie créée', 'category' => $category], 200);
    }



    // Modifier une catégorie
    public function update(Request $request, $id)
    {
        $category = Category::find($id);  
        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated); 

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

