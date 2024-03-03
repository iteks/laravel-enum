<?php

namespace Iteks\Support\Services;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use ReflectionClassConstant;

class HasAttributesService
{
    /**
     * Retrieve all of the attributes for all cases.
     *
     * @param  mixed  $enumOrCase  The enum class or the case name.
     * @param  array|null  $filter  Filter attributes array.
     * @return array<array>
     */
    public static function attributes(mixed $enumOrCase, ?array $filter = null): array
    {
        if (is_object($enumOrCase)) {
            return self::getAttributes($enumOrCase, $filter);
        }

        $attributes = [];
        foreach ($enumOrCase::cases() as $case) {
            $attributes[$case->name] = self::getAttributes($case, $filter);
        }

        return $attributes;
    }

    /**
     * Retrieve the description attribute.
     *
     * @param  mixed  $case  The enum case instance.
     * @return string|null
     */
    public static function description(mixed $case): ?string
    {
        return self::tryAttributeClass(Description::class, $case)?->description;
    }

    /**
     * Retrieve the description attribute for all cases.
     *
     * @param  string  $enum  The enum class instance.
     * @return array<string|null>
     */
    public static function descriptions(string $enum): array
    {
        return array_map(function ($case): ?string {
            return self::description($case);
        }, $enum::cases());
    }

    /**
     * Retrieve the id attribute.
     *
     * @param  mixed  $case  The enum case instance.
     * @return int|string|null
     */
    public static function id(mixed $case): int|string|null
    {
        return self::tryAttributeClass(Id::class, $case)?->id;
    }

    /**
     * Retrieve the id attribute for all cases.
     *
     * @param  string  $enum  The enum class instance.
     * @return array<int|string|null>
     */
    public static function ids(string $enum): array
    {
        return array_map(function ($case): int|string|null {
            return self::id($case);
        }, $enum::cases());
    }

    /**
     * Retrieve the label attribute.
     *
     * @param  mixed  $case  The enum case instance.
     * @return string|null
     */
    public static function label(mixed $case): ?string
    {
        return self::tryAttributeClass(Label::class, $case)?->label;
    }

    /**
     * Retrieve the label attribute for all cases.
     *
     * @param  string  $enum  The enum class instance.
     * @return array<string|null>
     */
    public static function labels(string $enum): array
    {
        return array_map(function ($case): ?string {
            return self::label($case);
        }, $enum::cases());
    }

    /**
     * Retrieve the metadata attribute.
     *
     * @param  mixed  $case  The enum case instance.
     * @return array|string|null
     */
    public static function metadata(mixed $case): array|string|null
    {
        return self::tryAttributeClass(Metadata::class, $case)?->metadata;
    }

    /**
     * Retrieve the metadata attribute for all cases.
     *
     * @param  string  $enum  The enum class instance.
     * @return array<array|string|null>
     */
    public static function metadatum(string $enum): array
    {
        return array_map(function ($case): array|string|null {
            return self::metadata($case);
        }, $enum::cases());
    }

    /**
     * Retrieve all of the attributes for the given enum class. Optionally, filter the attributes.
     *
     * @param  mixed  $enum  The enum instance.
     * @param  array|null  $filter  Filter attributes array.
     * @return array
     */
    protected static function getAttributes(mixed $enum, ?array $filter = null): array
    {
        return $filter ? array_filter([
            'simpleValue' => $enum->value,
            'description' => self::description($enum),
            'id' => self::id($enum),
            'label' => self::label($enum),
            'metadata' => self::metadata($enum),
        ], function ($key) use ($filter) {
            return in_array($key, $filter);
        }, ARRAY_FILTER_USE_KEY) : [
            'simpleValue' => $enum->value,
            'description' => self::description($enum),
            'id' => self::id($enum),
            'label' => self::label($enum),
            'metadata' => self::metadata($enum),
        ];
    }

    /**
     * Maps an attribute class to an enum instance.
     *
     * @param  string  $attribute  The attribute class.
     * @param  mixed  $case  The enum case instance.
     * @return mixed
     */
    protected static function tryAttributeClass(string $attribute, mixed $case): mixed
    {
        $ref = new ReflectionClassConstant($case::class, $case->name);
        $classAttributes = $ref->getAttributes($attribute);

        if (count($classAttributes) === 0) {
            return null;
        }

        return $classAttributes[0]->newInstance();
    }
}
