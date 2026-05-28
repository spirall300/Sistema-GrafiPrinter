<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con pedidos (orders) por nombre de tipo
    public function orders()
    {
        return $this->hasMany(Order::class, 'type', 'name');
    }
}
