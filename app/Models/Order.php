<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['client_id', 'date_commande', 'total', 'statut'];

     /**
     * Une commande appartient à un client.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Une commande peut contenir plusieurs produits.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantite', 'prix_unitaire');
    }

    /**
     * Une commande peut avoir une facture.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
