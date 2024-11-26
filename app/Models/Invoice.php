<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = ['order_id', 'montant_total', 'date_facture'];

    /**
     * Une facture appartient à une commande.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
