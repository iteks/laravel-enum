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
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<string|null>
     */
    public static function descriptions(string $enum, ?string $keyBy = null): array
    {
        return self::mapCasesTo($enum, fn ($case) => self::description($case), $keyBy);
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
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<int|string|null>
     */
    public static function ids(string $enum, ?string $keyBy = null): array
    {
        return self::mapCasesTo($enum, fn ($case) => self::id($case), $keyBy);
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
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<string|null>
     */
    public static function labels(string $enum, ?string $keyBy = null): array
    {
        return self::mapCasesTo($enum, fn ($case) => self::label($case), $keyBy);
    }

    /**
     * Retrieve the metadata attribute or specific metadata values by key(s).
     *
     * @param  mixed  $case  The enum case instance.
     * @param  string|array|null  $key  Optional key or array of keys to retrieve specific metadata values.
     * @return mixed
     */
    public static function metadata(mixed $case, string|array|null $key = null): mixed
    {
        $metadata = self::tryAttributeClass(Metadata::class, $case)?->metadata;

        // Handle JSON string metadata
        if (is_string($metadata) && str_starts_with(trim($metadata), '{')) {
            $decoded = json_decode($metadata, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $metadata = $decoded;
            }
        }

        if ($key === null || ! is_array($metadata)) {
            return $metadata;
        }

        if (is_array($key)) {
            return array_intersect_key($metadata, array_flip($key));
        }

        return $metadata[$key] ?? null;
    }

    /**
     * Retrieve the metadata attribute for all cases, optionally filtered by metadata key(s).
     *
     * @param  string  $enum  The enum class instance.
     * @param  string|array|null  $key  Optional key or array of keys to retrieve specific metadata values.
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<string|int, mixed>
     */
    public static function metadatum(string $enum, string|array|null $key = null, ?string $keyBy = null): array
    {
        return self::mapCasesTo($enum, fn ($case) => self::metadata($case, $key), $keyBy);
    }

    /**
     * Try to get an attribute class instance.
     *
     * @param  string  $attribute  The attribute class.
     * @param  mixed  $case  The case instance.
     * @return mixed
     */
    public static function tryAttributeClass(string $attribute, mixed $case): mixed
    {
        $ref = new ReflectionClassConstant($case::class, $case->name);
        $classAttributes = $ref->getAttributes($attribute);

        if (count($classAttributes) === 0) {
            return null;
        }

        return $classAttributes[0]->newInstance();
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
     * Map enum cases to a given callback, optionally keyed by 'name' or 'value'.
     *
     * @template T
     *
     * @param  mixed  $enum  The enum instance.
     * @param  callable(mixed): T  $callback
     * @param  'name'|'value'|null  $keyBy
     * @return array<string|int, T>
     */
    protected static function mapCasesTo(mixed $enum, callable $callback, ?string $keyBy = null): array
    {
        $cases = $enum::cases();

        if ($keyBy === null) {
            return array_map(
                fn ($case) => $callback($case),
                $cases
            );
        }

        $keys = match ($keyBy) {
            'value' => array_column($cases, 'value'),
            default => array_column($cases, 'name'),
        };

        return array_map(
            fn ($case) => $callback($case),
            array_combine($keys, $cases)
        );
    }
}
