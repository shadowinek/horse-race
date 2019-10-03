<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	//
    }

    public function boot() {
	    Blade::directive('horse_time_format', function($expression) {
		    return "<?php echo date('i:s', {$expression}/100) . '.' . {$expression}%100; ?>";
	    });
    }
}
