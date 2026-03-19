<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controlador para la gestión de tipos de producto
class ProductTypeController extends Controller
{
    // Método para mostrar la lista de tipos de producto (solo admin)
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $types = ProductType::orderBy('name')->get();

        return view('product-types.index', compact('types'));
    }

    // Método para crear un nuevo tipo de producto (solo admin)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:product_types,name'],
        ]);

        $type = ProductType::create(['name' => $request->name]);

        // Registrar en bitácora
        Bitacora::log("Tipo de producto creado: {$type->name}");

        return redirect()->route('product-types.index')->with('success', 'Tipo de producto agregado correctamente.');
    }

    // Método para mostrar el formulario de edición de un tipo de producto (solo admin)
    public function edit(ProductType $productType)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        return view('product-types.edit', compact('productType'));
    }

    // Método para actualizar un tipo de producto (solo admin)
    public function update(Request $request, ProductType $productType)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:product_types,name,{$productType->id}"],
        ]);

        $productType->update(['name' => $request->name]);

        // Registrar en bitácora
        Bitacora::log("Tipo de producto actualizado: {$productType->name}");

        return redirect()->route('product-types.index')->with('success', 'Tipo de producto actualizado correctamente.');
    }

    // Método para eliminar un tipo de producto (solo admin)
    public function destroy(ProductType $productType)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $productType->delete();

        // Registrar en bitácora
        Bitacora::log("Tipo de producto eliminado: {$productType->name}");

        return redirect()->route('product-types.index')->with('success', 'Tipo de producto eliminado.');
    }
}
