<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Afficher tous les clients
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    // Afficher un client spécifique
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Client non trouvé'], 404);
        }
        return response()->json($customer);
    }

       // Créer un client
    public function store(Request $request)
    {
           $validated = $request->validate([
               'nom' => 'required|string|max:255',
               'email' => 'required|email|unique:customers,email',
               'adresse' => 'nullable|string',
               'telephone' => 'nullable|string|max:15',
           ]);
   
           $customer = Customer::create($validated);
           return response()->json(['message' => 'Client créé', 'customer' => $customer], 200);
    }

      // Mettre à jour un client
      public function update(Request $request, $id)
      {
          $customer = Customer::find($id);
          if (!$customer) {
              return response()->json(['message' => 'Client non trouvé'], 404);
          }
  
          $validated = $request->validate([
              'nom' => 'sometimes|string|max:255',
              'email' => 'sometimes|email|unique:customers,email,' . $id,
              'adresse' => 'nullable|string',
              'telephone' => 'nullable|string|max:15',
          ]);
  
          $customer->update($validated);
          return response()->json(['message' => 'Client mis à jour', 'customer' => $customer], 200);
      }

      // Supprimer un client
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Client non trouvé'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Client supprimé'], 200);
    }
}
