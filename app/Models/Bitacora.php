<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    // Esto permite que Laravel escriba en estos campos
    protected $fillable = ['user_id', 'accion', 'ip_address', 'user_agent'];
}
