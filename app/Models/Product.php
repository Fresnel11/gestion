<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'quantite_en_stock',
        'categorie_id',
        'supplier_id'
    ];


    /**
     * Un produit appartient à une catégorie.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Un produit peut avoir plusieurs transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Un produit peut avoir plusieurs fournisseurs.
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('prix_achat');
    }

    /**
     * Un produit peut être présent dans plusieurs commandes.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantite', 'prix_unitaire');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
