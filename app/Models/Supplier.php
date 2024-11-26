<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['nom', 'adresse', 'email', 'telephone'];

    /**
     * Un fournisseur peut fournir plusieurs produits.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Un fournisseur peut être associé à plusieurs transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
