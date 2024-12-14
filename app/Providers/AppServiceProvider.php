<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('active', function ($route) {
            return "<?php echo request()->is($route) ? 'active' : null; ?>";
        });
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
