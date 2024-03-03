<?php

use Iteks\Support\Enums\ExampleEnum;
use Iteks\Support\Facades\Enum;

describe('Methods', function () {
    it('transforms enum to select array', function () {
        $selectArray = Enum::asSelectArray(ExampleEnum::class);
        expect($selectArray)->toBeArray()
            ->each->toHaveKeys(['text', 'value']);
    });
})->group('methods');
