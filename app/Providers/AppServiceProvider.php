<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191);

        Relation::morphMap([
            'alert' => 'App\Alert',
            'institution_report' => 'App\InstitutionReport',
            'freeform_report' => 'App\FreeFormReport',
            'external_report' => 'App\ExternalReport',
        ]);
    }
}
