<?php

use Iteks\Support\Enums\ExampleEnum;
use Iteks\Support\EnumServiceProvider;
use Iteks\Support\Facades\Enum;

describe('Facade', function () {
    it('resolves facades', function () {
        $app = app();

        (new EnumServiceProvider($app))->register();

        Enum::setFacadeApplication($app);

        $array = Enum::asSelectArray(ExampleEnum::class);

        expect($array)->toBeArray();
    });
})->group('facade');
