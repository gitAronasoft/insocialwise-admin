<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use App\Helpers\DateHelper;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }
        
        if (env('REPLIT_DEV_DOMAIN')) {
            URL::forceScheme('https');
        }

        Blade::directive('formatDate', function ($expression) {
            return "<?php echo \App\Helpers\DateHelper::format($expression); ?>";
        });

        Blade::directive('formatDateTime', function ($expression) {
            return "<?php echo \App\Helpers\DateHelper::formatDateTime($expression); ?>";
        });

        Blade::directive('formatTime', function ($expression) {
            return "<?php echo \App\Helpers\DateHelper::formatTime($expression); ?>";
        });

        Blade::directive('diffForHumans', function ($expression) {
            return "<?php echo \App\Helpers\DateHelper::diffForHumans($expression); ?>";
        });
    }
}
