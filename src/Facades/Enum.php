<?php

namespace Iteks\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The `Enum` facade accessor for the `BackedEnumService` and `HasAttributesService` classes.
 *
 * @method static array asSelectArray(string $enum) Get a backed enum class as an array to populate a select element.
 * @method static string toLabel(mixed $case, bool $isConst = false) Create a label from the case name.
 * @method static array toLabels(string $enum, bool $isConst = false) Create and compile an array of labels from the case names.
 * @method static array attributes(mixed $enumOrCase, ?array $filter = null) Retrieve all of the attributes for all cases.
 * @method static string|null description(mixed $case) Retrieve the description attribute.
 * @method static array descriptions(string $enum, ?string $keyBy = null) Retrieve the description attribute for all cases.
 * @method static int|string|null id(mixed $case) Retrieve the id attribute.
 * @method static array ids(string $enum, ?string $keyBy = null) Retrieve the id attribute for all cases.
 * @method static string|null label(mixed $case) Retrieve the label attribute.
 * @method static array labels(string $enum, ?string $keyBy = null) Retrieve the label attribute for all cases.
 * @method static mixed metadata(mixed $case, string|array|null $key = null) Retrieve the metadata attribute or specific metadata values by key(s).
 * @method static array metadatum(string $enum, string|array|null $key = null, ?string $keyBy = null) Retrieve the metadata attribute for all cases, optionally filtered by metadata key(s).
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
