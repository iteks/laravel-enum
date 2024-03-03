<?php

namespace Iteks\Support;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
// use Iteks\Support\Facades\Enum;
use Iteks\Support\Macros\Str as StrMacro;
use Iteks\Support\Services\BackedEnumService;
use Iteks\Support\Services\EnumService;
use Iteks\Support\Services\HasAttributesService;

class EnumServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('enum', function () {
            return new EnumService(new BackedEnumService(), new HasAttributesService());
        });

        // $this->app->alias('enum', EnumService::class);
        // $this->app->alias('enum', Enum::class);
    }

    public function boot(): void
    {
        Str::macro('splitConstantCase', function ($value) {
            return StrMacro::splitConstantCase($value);
        });

        Str::macro('splitEnumCase', function ($value) {
            return StrMacro::splitEnumCase($value);
        });
    }

    public function provides(): array
    {
        return [
            'enum',
            EnumService::class,
            BackedEnumService::class,
            HasAttributesService::class,
        ];
    }
}
