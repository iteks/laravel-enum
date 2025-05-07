<?php

namespace Iteks\Support\Enums;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

#[Description('A collection of geometric shapes, used for demonstrating enum attributes')]
#[Metadata(['version' => '1.0', 'category' => 'geometry'])]
enum BackedEnumShape: string
{
    use BackedEnum;
    use HasAttributes;

    #[Description('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center')]
    #[Id(1)]
    #[Label('Round Circle')]
    #[Metadata(['color' => 'red', 'sides' => 0, 'type' => 'curved'])]
    case RoundCircle = 'circle';

    #[Description('A square is a regular quadrilateral, all sides have equal length and all angles are 90 degrees')]
    #[Id(2)]
    #[Label('Perfect Square')]
    #[Metadata('{"color": "blue", "sides": 4, "type": "polygon", "regular": true}')]
    case BoxSquare = 'square';

    #[Description('A triangle is a polygon with three edges and three vertices')]
    #[Id(3)]
    #[Label('Right-Triangle')]
    #[Metadata(['color' => 'green', 'sides' => 3, 'type' => 'polygon'])]
    case RightTriangle = 'triangle';

    #[Description('A star is a self-intersecting, equilateral polygon')]
    #[Id(4)]
    #[Label('5 Point Star')]
    #[Metadata('{"color": "yellow", "points": 5, "type": "star", "symmetrical": true}')]
    case PointedStar = 'star';

    #[Description('A rectangle is a quadrilateral with four right angles')]
    #[Id(5)]
    #[Label('Poly-Rectangle')]
    #[Metadata(['color' => 'purple', 'sides' => 4, 'type' => 'polygon', 'regular' => false])]
    case PolygonRectangle = 'rectangle';
}
