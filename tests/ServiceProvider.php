<?php

use Iteks\Support\Enums\BackedEnumShape;
use Iteks\Support\EnumServiceProvider;
use Iteks\Support\Facades\Enum;
use Iteks\Support\Services\BackedEnumService;
use Iteks\Support\Services\EnumService;
use Iteks\Support\Services\HasAttributesService;

describe('Service Provider', function () {
    it('registers the enum service on the container', function () {
        $app = app();

        (new EnumServiceProvider($app))->register();

        expect($app->get(Enum::class))->toBeInstanceOf(Enum::class);
    });

    it('registers the enum service on the container as singleton', function () {
        $app = app();

        (new EnumServiceProvider($app))->register();

        $enum = $app->get(Enum::class);

        expect($enum)->toBeInstanceOf(Enum::class);
    });

    it('boots str macros on the container', function () {
        $app = app();

        (new EnumServiceProvider($app))->register();

        Enum::setFacadeApplication($app);

        $array = Enum::asSelectArray(BackedEnumShape::class);

        expect($array)->toBeArray();
    });

    it('provides', function () {
        $app = app();

        $provides = (new EnumServiceProvider($app))->provides();

        expect($provides)->toBe([
            'enum',
            EnumService::class,
            BackedEnumService::class,
            HasAttributesService::class,
        ]);
    });
})->group('service-provider');
