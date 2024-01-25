<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind('constants', function(){
        return require config_path('Constants.php');
      });
  }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
