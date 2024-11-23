<?php

namespace Tests\Unit\Attributes;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Support\Enums\ExampleBackedEnum;
use ReflectionClass;

describe('Attribute Capabilities', function () {
    it('supports class-level description', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);
        $attributes = $reflector->getAttributes(Description::class);

        expect($attributes)->toHaveCount(0); // ExampleBackedEnum doesn't have class-level description
    });

    it('supports case-level description', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);
        $constant = $reflector->getReflectionConstant('CurrentlyActive');
        $attributes = $constant->getAttributes(Description::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->description)->toBe('Active status indicating the resource is currently in use');
    });

    it('supports only case-level id', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);

        // Class should not have Id attribute
        expect($reflector->getAttributes(Id::class))->toHaveCount(0);

        // Case should have Id attribute
        $constant = $reflector->getReflectionConstant('CurrentlyActive');
        $attributes = $constant->getAttributes(Id::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->id)->toBe(101);
    });

    it('supports only case-level label', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);

        // Class should not have Label attribute
        expect($reflector->getAttributes(Label::class))->toHaveCount(0);

        // Case should have Label attribute
        $constant = $reflector->getReflectionConstant('CurrentlyActive');
        $attributes = $constant->getAttributes(Label::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->label)->toBe('Active');
    });

    it('supports class-level metadata', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);
        $attributes = $reflector->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(0); // ExampleBackedEnum doesn't have class-level metadata
    });

    it('supports case-level metadata', function () {
        $reflector = new ReflectionClass(ExampleBackedEnum::class);
        $constant = $reflector->getReflectionConstant('CurrentlyActive');
        $attributes = $constant->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['status_type' => 'positive', 'display_color' => 'green']);
    });
});
