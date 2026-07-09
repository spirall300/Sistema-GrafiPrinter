<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    $monthParam = request('month');
    $calendarDate = now();

    if ($monthParam) {
        try {
            $calendarDate = Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
        } catch (\Exception $e) {
            $calendarDate = now();
        }
    }

    // Si es admin o encargado, mostrar todos los pedidos; si no, solo los suyos
    $ordersQuery = in_array($user->role, ['admin', 'encargado']) ? Order::query() : Order::where('user_id', $user->id);
    $upcomingDeliveriesQuery = in_array($user->role, ['admin', 'encargado']) ? Order::query() : Order::where('user_id', $user->id);

    $orders = $ordersQuery
        ->whereMonth('delivery_date', $calendarDate->month)
        ->whereYear('delivery_date', $calendarDate->year)
        ->orderBy('delivery_date')
        ->take(8)
        ->get();
    $upcomingDeliveries = $upcomingDeliveriesQuery
        ->whereMonth('delivery_date', $calendarDate->month)
        ->whereYear('delivery_date', $calendarDate->year)
        ->orderBy('delivery_date')
        ->select(['id', 'type', 'company_name', 'status', 'delivery_date'])
        ->get();

    // Pedidos próximos a entregar (próximos 3 días)
    $soonDeliveries = $upcomingDeliveriesQuery
        ->whereDate('delivery_date', '>=', now()->toDateString())
        ->whereDate('delivery_date', '<=', now()->addDays(3)->toDateString())
        ->where('status', '!=', 'Pagado')
        ->orderBy('delivery_date')
        ->select(['id', 'type', 'company_name', 'status', 'delivery_date'])
        ->get();

    return view('dashboard', compact('orders', 'upcomingDeliveries', 'calendarDate', 'soonDeliveries'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // AJAX: Marcar soonDeliveriesDismissed en la sesión
    Route::post('/dashboard/soon-deliveries-dismiss', function () {
        session(['soonDeliveriesDismissed' => true]);
        return response()->json(['ok' => true]);
    });

    // Pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Tipos de producto
    Route::get('/product-types', [App\Http\Controllers\ProductTypeController::class, 'index'])->name('product-types.index');
    Route::get('/product-types/{productType}/edit', [App\Http\Controllers\ProductTypeController::class, 'edit'])->name('product-types.edit');
    Route::post('/product-types', [App\Http\Controllers\ProductTypeController::class, 'store'])->name('product-types.store');
    Route::patch('/product-types/{productType}', [App\Http\Controllers\ProductTypeController::class, 'update'])->name('product-types.update');
    Route::delete('/product-types/{productType}', [App\Http\Controllers\ProductTypeController::class, 'destroy'])->name('product-types.destroy');

    // Inventario
    Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventoryItem}/edit', [App\Http\Controllers\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::patch('/inventory/{inventoryItem}', [App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventoryItem}', [App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Bitácoras
    Route::get('/bitacoras', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacoras.index');

    // Administración de usuarios
    Route::get('/admin/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
