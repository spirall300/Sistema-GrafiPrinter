<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Bitacora extends Model
{
    // Esto permite que Laravel escriba en estos campos
    protected $fillable = ['user_id', 'accion', 'ip_address', 'user_agent'];

    /**
     * Relación con el usuario que realizó la acción.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Registra una acción en la bitácora.
     */
    public static function log(string $accion, ?int $userId = null): void
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return;
        }

        self::create([
            'user_id' => $userId,
            'accion' => $accion,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->user?->role) {
            'admin' => 'Administrador',
            'encargado' => 'Encargado',
            default => 'Usuario',
        };
    }

    public function getDeviceLabelAttribute(): string
    {
        $agent = strtolower((string) $this->user_agent);

        if (preg_match('/mobile|android|iphone|ipad|ipod|blackberry|opera mini|windows phone/i', $agent)) {
            return 'Móvil';
        }

        return 'Escritorio';
    }
}
