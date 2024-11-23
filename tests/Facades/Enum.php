<?php

use Iteks\Support\Enums\ExampleBackedEnum;
use Iteks\Support\EnumServiceProvider;
use Iteks\Support\Facades\Enum;

describe('Facade', function () {
    it('resolves facades', function () {
        $app = app();

        (new EnumServiceProvider($app))->register();

        Enum::setFacadeApplication($app);

        $array = Enum::asSelectArray(ExampleBackedEnum::class);

        expect($array)->toBeArray();
    });
})->group('facade');
