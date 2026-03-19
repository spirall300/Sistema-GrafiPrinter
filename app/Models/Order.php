<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo que representa un pedido en el sistema
class Order extends Model
{
    use HasFactory;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'type',
        'company_name',
        'quantity',
        'buyer',
        'entry_date',
        'delivery_date',
        'identity_cedula',
        'status',
        'file_path',
    ];

    // Definir el tipo de datos de ciertos atributos
    protected $casts = [
        'entry_date' => 'date',
        'delivery_date' => 'date',
    ];
}
