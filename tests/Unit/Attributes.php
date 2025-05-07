<?php

use Iteks\Support\Enums\BackedEnumShape;
use Iteks\Support\Facades\Enum;

describe('Attributes', function () {
    it('retrieves correct description for enum cases', function () {
        $description = Enum::description(BackedEnumShape::RoundCircle);

        expect($description)->toBe('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center');
    });

    it('retrieves all descriptions', function () {
        $descriptions = Enum::descriptions(BackedEnumShape::class);

        expect($descriptions)->toHaveCount(5)
            ->and($descriptions)->toContain('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center')
            ->and($descriptions)->toContain('A square is a regular quadrilateral, all sides have equal length and all angles are 90 degrees')
            ->and($descriptions)->toContain('A triangle is a polygon with three edges and three vertices')
            ->and($descriptions)->toContain('A star is a self-intersecting, equilateral polygon')
            ->and($descriptions)->toContain('A rectangle is a quadrilateral with four right angles');
    });
})->group('attributes');
