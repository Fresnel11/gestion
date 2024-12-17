<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Méthode pour l'enregistrement
    public function register(Request $request)
    {
        // Validation des champs
        $validator = Validator::make($request->all(), [
            // Données utilisateurs
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users', // Vérifie si l'email est déjà utilisé par un utilisateur
            'password' => 'required|string|confirmed|min:8',

            // Données entreprise
            'company_name' => 'required|string', // Valide que le nom d'entreprise est requis
            'company_address' => 'nullable|string',
            'registration_number' => 'required|string', // Valide que le numéro de registre est requis
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Vérifier si l'adresse de l'entreprise existe déjà
        if ($request->company_address) {
            $existingCompanyByAddress = Company::where('address', $request->company_address)->first();

            if ($existingCompanyByAddress) {
                return response()->json([
                    'company_address' => 'Il existe déjà une entreprise à cette adresse.',
                ], 400);
            }
        }

        // Vérifier si le nom de l'entreprise ou le numéro d'enregistrement existent déjà
        $existingCompany = Company::where('name', $request->company_name)
            ->orWhere('registration_number', $request->registration_number)
            ->first();

        if ($existingCompany) {
            $errors = [];

            if ($existingCompany->name === $request->company_name) {
                $errors['company_name'] = 'Une entreprise avec ce nom existe déjà.';
            }

            if ($existingCompany->registration_number === $request->registration_number) {
                $errors['registration_number'] = 'Un numéro d’enregistrement similaire existe déjà.';
            }

            return response()->json($errors, 400);
        }

        // Créer une nouvelle compagnie
        $company = Company::create([
            'name' => $request->company_name,
            'address' => $request->company_address,
            'registration_number' => $request->registration_number,
        ]);

        // Créer un utilisateur associé à la compagnie
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'company_id' => $company->id,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Retourner une réponse en cas de succès
        return response()->json([
            'message' => 'Utilisateur et compagnie créés avec succès',
            'user' => $user,
            'company' => $company,
            'token' => $token,
        ], 200);
    }


    public function checkEmail(Request $request)
    {
        // Valider que l'email est fourni
        $request->validate([
            'email' => 'required|email',
        ]);

        // Vérifier si l'email existe déjà dans la base de données
        $emailExists = User::where('email', $request->email)->exists();

        // Retourner la réponse JSON
        return response()->json([
            'exists' => $emailExists,
        ]);
    }



    // Méthode pour la connexion
    public function login(Request $request)
    {

        // Vérifie le contenu brut de la requête
        if (!$request->has(['login', 'password'])) {
            return response()->json(['message' => 'Les champs login et password sont requis.'], 400);
        }

        // Valider les données
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Chercher l'utilisateur par email ou username
        $user = User::where('email', $credentials['login'])
            ->orWhere('username', $credentials['login'])
            ->first();

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable. Veuillez vérifier votre email ou nom d’utilisateur.'], 404);
        }

        // Vérifier si le mot de passe est correct
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Mot de passe incorrect. Veuillez réessayer.'], 401);
        }

        // Créer un token pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        // Répondre avec un message de succès et le token
        return response()->json([
            'message' => 'Connexion réussie !',
            'token' => $token,
        ]);
    }



    // Méthode pour la déconnexion
    public function logout(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        // Supprimer tous les tokens de l'utilisateur
        $user->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie.'], 200);
    }
}
