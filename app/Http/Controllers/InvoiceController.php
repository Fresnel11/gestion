<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Afficher toutes les factures
    public function index()
    {
        $invoices = Invoice::with('order')->get();
        return response()->json($invoices);
    }

    // Afficher une facture spécifique
    public function show($id)
    {
        $invoice = Invoice::with('order')->find($id);
        if (!$invoice) {
            return response()->json(['message' => 'Facture non trouvée'], 404);
        }
        return response()->json($invoice);
    }

    // Créer une facture
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'montant_total' => 'required|numeric|min:0',
            'date_facture' => 'required|date',
        ]);

        $invoice = Invoice::create($validated);
        return response()->json(['message' => 'Facture créée', 'invoice' => $invoice], 201);
    }

     // Mettre à jour une facture
     public function update(Request $request, $id)
     {
         $invoice = Invoice::find($id);
         if (!$invoice) {
             return response()->json(['message' => 'Facture non trouvée'], 404);
         }
 
         $validated = $request->validate([
             'order_id' => 'sometimes|exists:orders,id',
             'montant_total' => 'sometimes|numeric|min:0',
             'date_facture' => 'sometimes|date',
         ]);
 
         $invoice->update($validated);
         return response()->json(['message' => 'Facture mise à jour', 'invoice' => $invoice]);
     }

       // Supprimer une facture
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => 'Facture non trouvée'], 404);
        }

        $invoice->delete();
        return response()->json(['message' => 'Facture supprimée']);
    }
}
