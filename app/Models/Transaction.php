<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = ['type', 'quantite', 'date', 'product_id', 'supplier_id'];

    /**
     * Une transaction appartient à un produit.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Une transaction peut être liée à un fournisseur.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
