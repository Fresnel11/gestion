<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    // Méthode pour l'enregistrement
    public function register(Request $request)
    {
        // Débogage pour vérifier les données reçues
        logger()->info('Données reçues :', $request->all());

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
        ]);

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user,
        ], 200);
    }


    public function sendTestEmail()
    {
        Mail::raw('Ceci est un test de l\'envoi d\'un e-mail avec Mailtrap.', function ($message) {
            $message->to('destinataire@example.com')  // L'adresse du destinataire de test
                ->subject('Test Email Laravel');
        });

        return 'E-mail de test envoyé avec succès!';
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
