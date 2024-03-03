<?php

use Iteks\Support\Enums\ExampleEnum;
use Iteks\Support\Facades\Enum;

describe('Attributes', function () {
    it('retrieves correct description for enum cases', function () {
        $description = Enum::description(ExampleEnum::FirstExample);

        expect($description)->toBe('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    });

    it('retrieves all descriptions', function () {
        $descriptions = Enum::descriptions(ExampleEnum::class);

        expect($descriptions)->toHaveCount(3)
            ->and($descriptions[0])->toBe('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->and($descriptions[1])->toBe('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
            ->and($descriptions[2])->toBe('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
    });
})->group('attributes');
