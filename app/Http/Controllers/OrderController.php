<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Order;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Controlador para la gestión de pedidos
class OrderController extends Controller
{
    // Método para mostrar el formulario de creación de un nuevo pedido
    public function create()
    {
        $productTypes = ProductType::orderBy('name')->get();

        return view('orders.create', compact('productTypes'));
    }

    // Método para guardar un nuevo pedido en la base de datos
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'exists:product_types,name'],
            'company_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'buyer' => ['required', 'string', 'max:255'],
            'entry_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date', 'after_or_equal:entry_date'],
            'identity_cedula' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:Pendiente,Revisado,Pagado'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
        ]);

        $data['user_id'] = Auth::id();

        // Subir archivo si se proporciona
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('orders', 'public');
            $data['file_path'] = $path;
        }

        $order = Order::create($data);

        // Registrar en bitácora
        Bitacora::log("Pedido #{$order->id} creado (tipo: {$order->type}, qty: {$order->quantity})");

        return redirect()->route('orders.index')
            ->with('status', 'Pedido registrado correctamente.');
    }

    // Método para mostrar la lista de pedidos (con filtros)
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filtrar pedidos según el rol del usuario
        $query = $user->role === 'admin'
            ? Order::query()
            : Order::where('user_id', $user->id);

        // Aplicar filtros si se proporcionan
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }

        $orders = $query->latest()->get();

        $productTypes = ProductType::orderBy('name')->pluck('name');

        return view('orders.index', compact('orders', 'productTypes'));
    }

    // Método para mostrar el formulario de edición de un pedido (solo admin)
    public function edit(Order $order)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $productTypes = ProductType::orderBy('name')->get();

        return view('orders.edit', compact('order', 'productTypes'));
    }

    // Método para actualizar un pedido (solo admin)
    public function update(Request $request, Order $order)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'type' => ['required', 'string', 'exists:product_types,name'],
            'company_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'buyer' => ['required', 'string', 'max:255'],
            'entry_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date', 'after_or_equal:entry_date'],
            'identity_cedula' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:Pendiente,Revisado,Pagado'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
        ]);

        // Manejar archivo nuevo si se sube
        if ($request->hasFile('file')) {
            // Eliminar archivo anterior si existe
            if ($order->file_path && Storage::disk('public')->exists($order->file_path)) {
                Storage::disk('public')->delete($order->file_path);
            }
            $path = $request->file('file')->store('orders', 'public');
            $data['file_path'] = $path;
        }

        $order->update($data);

        // Registrar en bitácora
        Bitacora::log("Pedido #{$order->id} actualizado: estado {$order->status}");

        return back()->with('status', 'Estado del pedido actualizado.');
    }

    // Método para actualizar solo el estatus de un pedido (desde la lista)
    public function updateStatus(Request $request, Order $order)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'string', 'in:Pendiente,Revisado,Pagado'],
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Registrar en bitácora
        Bitacora::log("Pedido #{$order->id} estatus cambiado: {$oldStatus} → {$order->status}");

        return back()->with('status', 'Estado del pedido actualizado correctamente.');
    }
}
