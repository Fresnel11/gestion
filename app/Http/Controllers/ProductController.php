<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Afficher tous les produits
    public function index()
    {
        $products = Product::with('category')->get(); 
        return response()->json($products);
    }

    // Afficher un produit par ID
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        return response()->json($product);
    }

    // Créer un produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'quantite_en_stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id', // Clé étrangère optionnelle
        ]);

        $product = Product::create($validated);
        return response()->json(['message' => 'Produit créé', 'product' => $product], 201);
    }

    // Mettre à jour un produit
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'quantite_en_stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id', // Clé étrangère optionnelle
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Produit mis à jour', 'product' => $product]);
    }

    // Supprimer un produit
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produit supprimé']);
    }
}