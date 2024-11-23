<?php

use Iteks\Support\Enums\ExampleBackedEnum;
use Iteks\Support\Facades\Enum;

describe('Methods', function () {
    it('transforms enum to select array', function () {
        $selectArray = Enum::asSelectArray(ExampleBackedEnum::class);
        expect($selectArray)->toBeArray()
            ->each->toHaveKeys(['text', 'value']);
    });
})->group('methods');
