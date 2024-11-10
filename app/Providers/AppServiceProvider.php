<?php

namespace App\Providers;

use App\Models\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Model::preventLazyLoading(! app()->isProduction());
        Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
            $class = get_class($model);
            info("Attempted to lazy load [{$relation}] on model [{$class}].");
        });

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
