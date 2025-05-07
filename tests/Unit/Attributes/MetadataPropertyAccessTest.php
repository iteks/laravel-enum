<?php

namespace Tests\Unit\Attributes;

use Iteks\Support\Enums\BackedEnumShape;

describe('Metadata Property Access', function () {
    it('can access metadata as properties', function () {
        expect(BackedEnumShape::RoundCircle->meta()->color)->toBe('red')
            ->and(BackedEnumShape::RoundCircle->meta()->sides)->toBe(0)
            ->and(BackedEnumShape::RoundCircle->meta()->type)->toBe('curved')
            ->and(BackedEnumShape::BoxSquare->meta()->color)->toBe('blue')
            ->and(BackedEnumShape::BoxSquare->meta()->sides)->toBe(4)
            ->and(BackedEnumShape::BoxSquare->meta()->regular)->toBeTrue();
    });

    it('can access JSON string metadata as properties', function () {
        expect(BackedEnumShape::BoxSquare->meta()->color)->toBe('blue')
            ->and(BackedEnumShape::BoxSquare->meta()->sides)->toBe(4)
            ->and(BackedEnumShape::BoxSquare->meta()->type)->toBe('polygon')
            ->and(BackedEnumShape::BoxSquare->meta()->regular)->toBeTrue()
            ->and(BackedEnumShape::PointedStar->meta()->color)->toBe('yellow')
            ->and(BackedEnumShape::PointedStar->meta()->points)->toBe(5)
            ->and(BackedEnumShape::PointedStar->meta()->symmetrical)->toBeTrue();
    });

    it('accessing non-existent metadata property returns null', function () {
        expect(BackedEnumShape::RoundCircle->meta()->nonexistent)->toBeNull()
            ->and(BackedEnumShape::BoxSquare->meta()->nonexistent)->toBeNull()
            ->and(BackedEnumShape::PointedStar->meta()->sides)->toBeNull()
            ->and(BackedEnumShape::RightTriangle->meta()->regular)->toBeNull();
    });
});
