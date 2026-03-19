<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $logs = Bitacora::with('user')->latest()->paginate(20);

        return view('bitacoras.index', compact('logs'));
    }
}
