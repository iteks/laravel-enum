<?php

use Iteks\Support\Enums\BackedEnumShape;
use Iteks\Support\Facades\Enum;

describe('Methods', function () {
    it('transforms enum to select array', function () {
        $selectArray = Enum::asSelectArray(BackedEnumShape::class);
        expect($selectArray)->toBeArray()
            ->each->toHaveKeys(['text', 'value']);
    });
})->group('methods');
