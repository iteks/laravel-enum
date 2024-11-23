<?php

use Iteks\Support\Enums\ExampleBackedEnum;
use Iteks\Support\Facades\Enum;

describe('Attributes', function () {
    it('retrieves correct description for enum cases', function () {
        $description = Enum::description(ExampleBackedEnum::CurrentlyActive);

        expect($description)->toBe('Active status indicating the resource is currently in use');
    });

    it('retrieves all descriptions', function () {
        $descriptions = Enum::descriptions(ExampleBackedEnum::class);

        expect($descriptions)->toHaveCount(3)
            ->and($descriptions[0])->toBe('Active status indicating the resource is currently in use')
            ->and($descriptions[1])->toBe('Pending status indicating the resource is awaiting processing or approval')
            ->and($descriptions[2])->toBe('Temporarily suspended status indicating the resource is on hold');
    });
})->group('attributes');
