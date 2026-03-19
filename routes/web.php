<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $orders = Order::where('user_id', Auth::id())
        ->orderBy('delivery_date')
        ->take(5)
        ->get();

    $upcomingDeliveries = Order::where('user_id', Auth::id())
        ->whereDate('delivery_date', '>=', now()->toDateString())
        ->orderBy('delivery_date')
        ->take(5)
        ->get();

    return view('dashboard', compact('orders', 'upcomingDeliveries'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    Route::get('/product-types', [App\Http\Controllers\ProductTypeController::class, 'index'])->name('product-types.index');
    Route::get('/product-types/{productType}/edit', [App\Http\Controllers\ProductTypeController::class, 'edit'])->name('product-types.edit');
    Route::post('/product-types', [App\Http\Controllers\ProductTypeController::class, 'store'])->name('product-types.store');
    Route::patch('/product-types/{productType}', [App\Http\Controllers\ProductTypeController::class, 'update'])->name('product-types.update');
    Route::delete('/product-types/{productType}', [App\Http\Controllers\ProductTypeController::class, 'destroy'])->name('product-types.destroy');

    Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventoryItem}/edit', [App\Http\Controllers\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::patch('/inventory/{inventoryItem}', [App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventoryItem}', [App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/bitacoras', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacoras.index');

    Route::get('/admin/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
