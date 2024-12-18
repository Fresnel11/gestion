<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route pour l'enrégistrement d'un utilisateur
Route::post('/register', [AuthController::class, 'register']);

// Route pour la connexion d'un utilisateur
Route::post('/login', [AuthController::class, 'login']);

// Route pour la déconnexion d'un utilisateur
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// Routes concernant les catégories
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher toutes les catégories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Afficher toutes les catégories par id
    Route::middleware('auth:sanctum')->get('/categories/{id}', [CategoryController::class, 'show']);
    
    // Ajouter une catégorie
    Route::post('/categories', [CategoryController::class, 'store']);
    
    // Mettre à jour une catégorie
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    
    // Supprimer une catégorie
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

// Routes concernant les produits
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher toutes les produits
    Route::get('/products', [ProductController::class, 'index']);

    // Afficher les produits par id
    Route::get('/products{id}', [ProductController::class, 'show']);

    // Ajouter un nouveau produit
    Route::post('products', [ProductController::class, 'store']);

    // Mettre à jour une produit
    Route::put('/products/{id}', [ProductController::class, 'update']);

    // Supprimer un produit
    Route::delete('/products/{id}',  [ProductController::class, 'destroy']);
});

// Routes concernants les fournisseurs
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher touts les fournisseurs
    Route::get('/suppliers', [SupplierController::class, 'index']);

    // Afficher les fournisseurs par id
    Route::get('/suppliers/{id}', [SupplierController::class, 'show']);

    // Ajouter un nouveau fournisseur
    Route::post('/suppliers', [SupplierController::class, 'store']);

    // Mettre à jour un fournisseur
    Route::put('/suppliers/{id}', [SupplierController::class, 'update']);

    // Supprimer un fournisseur
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);

});

// Routes concernant les clients
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher tous les clients
    Route::get('/customers', [CustomerController::class, 'index']);

    // Afficher un client par ID
    Route::get('/customers/{id}', [CustomerController::class, 'show']);

    // Ajouter un nouveau client
    Route::post('/customers', [CustomerController::class, 'store']);

    // Mettre à jour un client
    Route::put('/customers/{id}', [CustomerController::class, 'update']);

    // Supprimer un client
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
});

// Routes concernants les factures
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher toutes les factures
    Route::get('/invoices', [InvoiceController::class, 'index']);

    // Afficher une facture par id
    Route::get('/invoices/{id}', [InvoiceController::class, 'show']);

    // Ajouter une nouvelle facture
    Route::post('/invoices', [InvoiceController::class, 'store']);

    // Mettre à jour une facture
    Route::put('/invoices/{id}', [InvoiceController::class, 'update']);

    // Supprimer une facture
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
});

// Routes concernants les stocks
Route::middleware(['auth:sanctum'])->group(function () {
    // Afficher toutes les factures
    Route::get('/stocks', [StockController::class, 'index']);

    // Afficher une facture par id
    Route::get('/stocks/{id}', [StockController::class, 'show']);

    // Ajouter une nouvelle facture
    Route::post('/stocks', [StockController::class, 'store']);

    // Mettre à jour une facture
    Route::put('/stocks/{id}', [StockController::class, 'update']);

    // Supprimer une facture
    Route::delete('/stocks/{id}', [StockController::class, 'destroy']);
});

