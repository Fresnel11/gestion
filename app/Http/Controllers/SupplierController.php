<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Afficher tous les fournisseurs
    public function index()
    {
        $suppliers = Supplier::with('products')->get(); 
        return response()->json($suppliers);
    }

    // Afficher un fournisseur par ID
    public function show($id)
    {
        $supplier = Supplier::with('products')->find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Fournisseur non trouvé'], 404);
        }
        return response()->json($supplier);
    }

    // Créer un fournisseur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'email' => 'nullable|email|string',
            'telephone' => 'nullable|string|max:15',
        ]);

        $supplier = Supplier::create($validated);
        return response()->json(['message' => 'Fournisseur créé', 'supplier' => $supplier], 201);
    }


     // Mettre à jour un fournisseur
     public function update(Request $request, $id)
     {
         $supplier = Supplier::find($id);
         if (!$supplier) {
             return response()->json(['message' => 'Fournisseur non trouvé'], 404);
         }
 
         $validated = $request->validate([
             'nom' => 'required|string|max:255',
             'adresse' => 'nullable|string',
             'email' => 'nullable|email|string',
             'telephone' => 'nullable|string|max:15',
         ]);
 
         $supplier->update($validated);
         return response()->json(['message' => 'Fournisseur mis à jour', 'supplier' => $supplier]);
     }

     // Supprimer un fournisseur
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Fournisseur non trouvé'], 404);
        }

        $supplier->delete();
        return response()->json(['message' => 'Fournisseur supprimé']);
    }

}
