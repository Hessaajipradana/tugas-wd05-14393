<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
        // Set default string length untuk MySQL compatibility
        Schema::defaultStringLength(191);
        
        // ✅ SET TIMEZONE INDONESIA - Simple & Correct
        date_default_timezone_set('Asia/Jakarta');
        
        // Share common data to all views
        View::composer('*', function ($view) {
            $view->with([
                'appName' => config('app.name', 'Poliklinikikuk'),
                'appVersion' => '1.0.0',
                'currentTimezone' => 'Asia/Jakarta',
            ]);
        });
        
        // Carbon locale to Indonesian
        Carbon::setLocale('id');
        
        // Custom blade directives for role checking
        \Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
        
        \Blade::if('dokter', function () {
            return auth()->check() && auth()->user()->isDokter();
        });
        
        \Blade::if('pasien', function () {
            return auth()->check() && auth()->user()->isPasien();
        });
        
        // Helper untuk format currency
        \Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });
        
        // ✅ Helper untuk format tanggal Indonesia dengan timezone
        \Blade::directive('dateID', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y'); ?>";
        });
        
        // ✅ Helper untuk format datetime Indonesia dengan timezone
        \Blade::directive('datetimeID', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y H:i'); ?>";
        });

        // ✅ Helper untuk timestamp debug
        \Blade::directive('timestampDebug', function ($expression) {
            return "<?php 
                echo '<small class=\"text-muted\">[Debug: ' . 
                \Carbon\Carbon::parse($expression ?: now())->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s T') . 
                ']</small>';
            ?>";
        });

        // ✅ Helper untuk waktu Jakarta sekarang
        \Blade::directive('nowJakarta', function ($format = 'Y-m-d H:i:s') {
            return "<?php echo \Carbon\Carbon::now('Asia/Jakarta')->format($format ?: 'Y-m-d H:i:s'); ?>";
        });
    }
}