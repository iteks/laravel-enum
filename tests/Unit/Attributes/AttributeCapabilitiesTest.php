<?php

namespace Tests\Unit\Attributes;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Support\Enums\BackedEnumShape;
use ReflectionClass;

describe('Attribute Capabilities', function () {
    it('supports class-level and multiple descriptions', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);
        $attributes = $reflector->getAttributes(Description::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->description)->toBe('A collection of geometric shapes, used for demonstrating enum attributes');
    });

    it('supports case-level and multiple descriptions', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);
        $constant = $reflector->getReflectionConstant('RoundCircle');
        $attributes = $constant->getAttributes(Description::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->description)->toBe('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center');
    });

    it('supports only case-level id', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);

        // Class should not have Id attribute.
        expect($reflector->getAttributes(Id::class))->toHaveCount(0);

        // Case should have Id attribute.
        $constant = $reflector->getReflectionConstant('RoundCircle');
        $attributes = $constant->getAttributes(Id::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->id)->toBe(1);
    });

    it('supports only case-level label', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);

        // Class should not have Label attribute.
        expect($reflector->getAttributes(Label::class))->toHaveCount(0);

        // Case should have Label attribute.
        $constant = $reflector->getReflectionConstant('RoundCircle');
        $attributes = $constant->getAttributes(Label::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->label)->toBe('Round Circle');
    });

    it('supports class-level and multiple metadata', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);
        $attributes = $reflector->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['version' => '1.0', 'category' => 'geometry']);
    });

    it('supports case-level and multiple metadata', function () {
        $reflector = new ReflectionClass(BackedEnumShape::class);
        $constant = $reflector->getReflectionConstant('BoxSquare');
        $attributes = $constant->getAttributes(Metadata::class);

        $expectedMetadata = json_decode('{"color": "blue", "sides": 4, "type": "polygon", "regular": true}', true);
        $actualMetadata = json_decode($attributes[0]->newInstance()->metadata, true);

        expect($attributes)->toHaveCount(1)
            ->and($actualMetadata)->toBe($expectedMetadata);
    });
});
