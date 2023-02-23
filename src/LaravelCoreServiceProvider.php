<?php

namespace Rekamy\LaravelCore;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class LaravelCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerHigherOrderContainer();
        $this->registerMacro();
        $this->bootstrapLoggingContext();
        $this->preventLazyLoading();
    }

    private function bootstrapLoggingContext()
    {
        Log::withContext([
            'server' => request()->server('HOSTNAME'),
            'env' => config('app.env'),
            'debug' => config('app.debug'),
            'url' => request()->url(),
            'method' => request()->method(),
            'payload' => request()->all(),
        ]);
    }

    private function preventLazyLoading()
    {
        if (!app()->runningInConsole() || app()->isLocal()) {
            Model::preventLazyLoading();
        } else if (!app()->isProduction()) {
            Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
                $class = get_class($model);

                logger()->error("Attempted to lazy load [{$relation}] on model [{$class}].");
            });
        }
    }

    private function registerMacro()
    {
        Blueprint::macro('auditable', function () {
            $this->datetime('created_at')->nullable();
            $this->datetime('updated_at')->nullable();
            $this->datetime('deleted_at')->nullable();
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();
        });

        Blueprint::macro('is', function ($key, $prefix = 'is_') {
            return $this->boolean($prefix . $key);
        });
    }

    private function registerHigherOrderContainer()
    {
        $this->app->bind(
            \Illuminate\Pagination\LengthAwarePaginator::class,
            \App\Contracts\Overrides\LengthAwarePaginator::class
        );

        $this->app->bind(
            \Prettus\Repository\Criteria\RequestCriteria::class,
            \App\Contracts\Overrides\RequestCriteria::class
        );
    }
}
