<?php

namespace Iteks\Support\Services;

use BadMethodCallException;

/**
 * The `EnumService` class is a facade for the `BackedEnumService` and `HasAttributesService` classes.
 *
 * @method array asSelectArray(string $enum) Get a backed enum class as an array to populate a select element. he array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.
 * @method string toLabel(object $case, bool $isConst = false) Create a label from the case name.
 * @method array toLabels(string $enum, bool $isConst = false) Create and compile an array of labels from the case names.
 * @memberof Iteks\Support\Services\BackedEnumService
 * @method array attributes(object|string $enumOrCase, ?array $filter = null) Retrieve all of the attributes for all cases.
 * @method string|null description(object $case) Retrieve the description attribute.
 * @method array descriptions(string $enum) Retrieve the description attribute for all cases.
 * @method int|string|null id(object $case) Retrieve the id attribute.
 * @method array ids(string $enum) Retrieve the id attribute for all cases.
 * @method string|null label(object $case) Retrieve the label attribute.
 * @method array labels(string $enum) Retrieve the label attribute for all cases.
 * @method array|string|null metadata(object $case) Retrieve the metadata attribute.
 * @method array metadatum(string $enum) Retrieve the metadata attribute for all cases.
 * @memberof Iteks\Support\Services\HasAttributesService
 */
class EnumService
{
    public function __construct(
        public BackedEnumService $backedEnum,
        public HasAttributesService $hasAttributes
    ) {
    }

    public function __call(mixed $method, mixed $parameters): mixed
    {
        // Determine which service should handle the call based on the method.
        if (method_exists($this->backedEnum, $method)) {
            return $this->backedEnum->$method(...$parameters);
        } elseif (method_exists($this->hasAttributes, $method)) {
            return $this->hasAttributes->$method(...$parameters);
        }

        throw new BadMethodCallException('Call to undefined method Iteks\Support\Facades\Enum::' . $method . '()');
    }
}
