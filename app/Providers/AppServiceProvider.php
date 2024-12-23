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

        config(['app.locale' => env('LOCALE', 'id')]);
        Carbon::setLocale(env('LOCALE', 'id'));
        date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Jakarta'));

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
