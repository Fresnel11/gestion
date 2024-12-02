<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
     // Afficher tous les stocks
     public function index()
     {
         $stocks = Stock::with('product.category')->get();
         return response()->json($stocks);
     }

      // Afficher un stock spécifique
    public function show($id)
    {
        $stock = Stock::with('product')->find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock non trouvé'], 404);
        }
        return response()->json($stock);
    }

     // Créer un stock
     public function store(Request $request)
     {
         $validated = $request->validate([
             'product_id' => 'required|exists:products,id',
             'quantite' => 'required|integer|min:0',
         ]);
 
         $stock = Stock::create($validated);
         return response()->json(['message' => 'Stock créé', 'stock' => $stock], 201);
     }

     // Mettre à jour un stock
    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock non trouvé'], 404);
        }

        $validated = $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'quantite' => 'sometimes|integer|min:0',
        ]);

        $stock->update($validated);
        return response()->json(['message' => 'Stock mis à jour', 'stock' => $stock]);
    }

    // Supprimer un stock
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock non trouvé'], 404);
        }

        $stock->delete();
        return response()->json(['message' => 'Stock supprimé']);
    }
}
