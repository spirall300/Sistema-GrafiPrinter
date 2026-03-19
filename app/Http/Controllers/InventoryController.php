<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controlador para la gestión del inventario
class InventoryController extends Controller
{
    // Método para mostrar la lista de artículos del inventario (admin y encargado)
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'encargado'])) {
            abort(403, 'Acceso denegado');
        }

        $query = InventoryItem::query();

        // Aplicar filtro por nombre si se proporciona
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $items = $query->orderBy('name')->paginate(20);

        return view('inventory.index', compact('items'));
    }

    // Método para crear un nuevo artículo en el inventario (solo admin)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $item = InventoryItem::create($data);

        // Registrar en bitácora
        Bitacora::log("Inventario: artículo creado ({$item->name})");

        return redirect()->route('inventory.index')->with('success', 'Artículo agregado al inventario.');
    }

    // Método para mostrar el formulario de edición de un artículo (solo admin)
    public function edit(InventoryItem $inventoryItem)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        return view('inventory.edit', ['item' => $inventoryItem]);
    }

    // Método para actualizar un artículo del inventario (solo admin)
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $inventoryItem->update($data);

        // Registrar en bitácora
        Bitacora::log("Inventario: artículo actualizado ({$inventoryItem->name})");

        return redirect()->route('inventory.index')->with('success', 'Artículo actualizado correctamente.');
    }

    // Método para eliminar un artículo del inventario (solo admin)
    public function destroy(InventoryItem $inventoryItem)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $name = $inventoryItem->name;
        $inventoryItem->delete();

        // Registrar en bitácora
        Bitacora::log("Inventario: artículo eliminado ({$name})");

        return redirect()->route('inventory.index')->with('success', 'Artículo eliminado del inventario.');
    }
}
