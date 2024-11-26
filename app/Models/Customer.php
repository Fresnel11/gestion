<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['nom', 'email', 'adresse', 'telephone'];

     /**
     * Un client peut avoir plusieurs transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Un client peut passer plusieurs commandes.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
