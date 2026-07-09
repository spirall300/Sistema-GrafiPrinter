<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Compartir soonDeliveries globalmente en todas las vistas si el usuario está autenticado
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $soonDeliveriesQuery = in_array($user->role, ['admin', 'encargado'])
                    ? \App\Models\Order::query()
                    : \App\Models\Order::where('user_id', $user->id);
                $soonDeliveries = $soonDeliveriesQuery
                    ->whereDate('delivery_date', '>=', now()->toDateString())
                    ->whereDate('delivery_date', '<=', now()->addDays(7)->toDateString())
                    ->where('status', 'Pagado')
                    ->orderBy('delivery_date')
                    ->select(['id', 'type', 'company_name', 'status', 'delivery_date'])
                    ->get();
                $view->with('soonDeliveries', $soonDeliveries);
            }
        });
    }
}
