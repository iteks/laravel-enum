<?php

namespace Iteks\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array asSelectArray(string $enum) Get a backed enum class as an array to populate a select element.
 * @method static string toLabel(mixed $case, bool $isConst = false) Create a label from the case name.
 * @method static array toLabels(string $enum, bool $isConst = false) Create and compile an array of labels from the case names.
 * @method static array attributes(mixed $enumOrCase, ?array $filter = null) Retrieve all of the attributes for all cases.
 * @method static string|null description(mixed $case) Retrieve the description attribute.
 * @method static array descriptions(string $enum) Retrieve the description attribute for all cases.
 * @method static int|string|null id(mixed $case) Retrieve the id attribute.
 * @method static array ids(string $enum) Retrieve the id attribute for all cases.
 * @method static string|null label(mixed $case) Retrieve the label attribute.
 * @method static array labels(string $enum) Retrieve the label attribute for all cases.
 * @method static array|string|null metadata(mixed $case) Retrieve the metadata attribute.
 * @method static array metadatum(string $enum) Retrieve the metadata attribute for all cases.
 *
 * @see \Iteks\Support\Enum
 */
class Enum extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'enum';
    }
}
