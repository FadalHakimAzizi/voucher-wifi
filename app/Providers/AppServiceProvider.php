<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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

        Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp '.number_format($expression, 2, ',', '.'); ?>";
        });
        // Format bytes to human readable
        Blade::directive('formatBytes', function ($bytes) {
            return "<?php 
                if(!empty($bytes)) {
                    if($bytes >= 1073741824) {
                        echo number_format($bytes/1073741824, 2) . ' GB';
                    } elseif($bytes >= 1048576) {
                        echo number_format($bytes/1048576, 2) . ' MB';
                    } elseif($bytes >= 1024) {
                        echo number_format($bytes/1024, 2) . ' KB';
                    } else {
                        echo $bytes . ' bytes';
                    }
                } else {
                    echo '-';
                }
            ?>";
        });

        // Format currency
        Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });
    }
}
