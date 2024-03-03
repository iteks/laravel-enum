<?php

namespace Iteks\Support\Enums;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum ExampleEnum: int
{
    use BackedEnum;
    use HasAttributes;

    #[Description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')]
    #[Id(0)]
    #[Label('First-Example')]
    #[Metadata(['key' => 'value'])]
    case FirstExample = 1;

    #[Description('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')]
    #[Id(1)]
    #[Label('SecondExample (Example)')]
    #[Metadata('{"key": "value"}')]
    case SecondExample = 2;

    #[Description('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.')]
    #[Id(2)]
    #[Label('3rd Eg.')]
    #[Metadata([])]
    case ThirdExample = 3;
}
