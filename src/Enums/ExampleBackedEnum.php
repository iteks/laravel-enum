<?php

namespace Iteks\Support\Enums;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum ExampleBackedEnum: int
{
    use BackedEnum;
    use HasAttributes;

    #[Description('Active status indicating the resource is currently in use')]
    #[Id(101)]
    #[Label('Active')]
    #[Metadata(['status_type' => 'positive', 'display_color' => 'green'])]
    case CurrentlyActive = 1;

    #[Description('Pending status indicating the resource is awaiting processing or approval')]
    #[Id(102)]
    #[Label('Pending')]
    #[Metadata('{"status_type": "neutral", "display_color": "yellow"}')]
    case PendingReview = 2;

    #[Description('Temporarily suspended status indicating the resource is on hold')]
    #[Id(103)]
    #[Label('Suspended (!)')]
    #[Metadata([])]
    case TemporarilySuspended = 3;
}
