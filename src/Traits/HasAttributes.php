<?php

namespace Iteks\Traits;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Support\Services\MetadataAccessor;
use ReflectionClassConstant;

trait HasAttributes
{
    use ExtendsBackedEnum;

    /**
     * Retrieve all of the attributes for all cases.
     *
     * @param  string|null  $name  The case name.
     * @param  array|null  $filter  Filter attributes array.
     * @return array<array>
     */
    public static function attributes(?string $name = null, ?array $filter = null): array
    {
        $attributes = [];
        foreach (static::cases() as $case) {
            if ($name && $case->name !== $name) {
                continue;
            }
            $attributes[$case->name] = self::getAttributes($case, $filter);
        }

        if ($name && count($attributes) === 1) {
            return $attributes[$name];
        }

        return $attributes;
    }

    /**
     * Retrieve the description attribute.
     *
     * @param  string  $name  The case name.
     * @return string|null
     */
    public static function description(string $name): ?string
    {
        return self::mapAttributeClass(Description::class, self::mapFromCase($name))?->description;
    }

    /**
     * Retrieve the description attribute for all cases.
     *
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<int|string, string|null>
     */
    public static function descriptions(?string $keyBy = null): array
    {
        return self::mapCasesTo(fn ($name) => self::description($name), $keyBy);
    }

    /**
     * Retrieve the id attribute.
     *
     * @param  string  $name  The case name.
     * @return int|string|null
     */
    public static function id(string $name): int|string|null
    {
        $enum = self::mapFromCase($name);

        return self::mapAttributeClass(Id::class, $enum)?->id;
    }

    /**
     * Retrieve the id attribute for all cases.
     *
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<int|string, int|string|null>
     */
    public static function ids(?string $keyBy = null): array
    {
        return self::mapCasesTo(fn ($name) => self::id($name), $keyBy);
    }

    /**
     * Retrieve the label attribute.
     *
     * @param  string  $name  The case name.
     * @return string|null
     */
    public static function label(string $name): ?string
    {
        $enum = self::mapFromCase($name);

        return self::mapAttributeClass(Label::class, $enum)?->label;
    }

    /**
     * Retrieve the label attribute for all cases.
     *
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<int|string, string|null>
     */
    public static function labels(?string $keyBy = null): array
    {
        return self::mapCasesTo(fn ($name) => self::label($name), $keyBy);
    }

    /**
     * Retrieve the metadata attribute or specific metadata values by key(s).
     *
     * @param  string  $name  The case name.
     * @param  string|array|null  $key  Optional key or array of keys to retrieve specific metadata values.
     * @return mixed
     */
    public static function metadata(string $name, string|array|null $key = null): mixed
    {
        $metadata = self::mapAttributeClass(Metadata::class, self::mapFromCase($name))?->metadata;

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
     * @param  string|array|null  $key  Optional key or array of keys to retrieve specific metadata values.
     * @param  'name'|'value'|null  $keyBy  Whether to key the result by case name or case value. Defaults to zero-indexed array.
     * @return array<string|int, mixed>
     */
    public static function metadatum(string|array|null $key = null, ?string $keyBy = null): array
    {
        return self::mapCasesTo(fn ($name) => self::metadata($name, $key), $keyBy);
    }

    /**
     * Get a metadata accessor for property-like access to metadata values.
     *
     * @return MetadataAccessor
     */
    public function meta(): MetadataAccessor
    {
        return new MetadataAccessor($this);
    }

    /**
     * Retrieve all of the attributes.
     *
     * @param  self  $enum  The enum instance.
     * @param  array|null  $filter  Filter by attributes array.
     * @return array
     */
    protected static function getAttributes(self $enum, ?array $filter = null): array
    {
        return $filter ? array_filter([
            'simpleValue' => $enum->value,
            'description' => self::description($enum->name),
            'id' => self::id($enum->name),
            'label' => self::label($enum->name),
            'metadata' => self::metadata($enum->name),
        ], function ($key) use ($filter) {
            return in_array($key, $filter);
        }, ARRAY_FILTER_USE_KEY) : [
            'simpleValue' => $enum->value,
            'description' => self::description($enum->name),
            'id' => self::id($enum->name),
            'label' => self::label($enum->name),
            'metadata' => self::metadata($enum->name),
        ];
    }

    /**
     * Maps an attribute class to an enum instance.
     *
     * @param  string  $attribute  The attribute class.
     * @param  self  $enum  The enum instance.
     * @return mixed
     */
    protected static function mapAttributeClass(string $attribute, self $enum): mixed
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes($attribute);

        if (count($classAttributes) === 0) {
            return null;
        }

        return $classAttributes[0]->newInstance();
    }

    /**
     * Maps a scalar to an enum instance.
     *
     * @param  string  $name  The case name.
     * @return mixed
     */
    protected static function mapFromCase(string $name): mixed
    {
        return self::__tryFromName($name);
    }

    /**
     * Map enum cases to a given callback, optionally keyed by 'name' or 'value'.
     *
     * @template T
     *
     * @param  callable(string): T  $callback  A function that receives the enum case name as string.
     * @param  'name'|'value'|null  $keyBy
     * @return array<string|int, T>
     */
    protected static function mapCasesTo(callable $callback, ?string $keyBy = null): array
    {
        $cases = static::cases(); // use static for late binding

        if ($keyBy === null) {
            return array_map(
                fn ($case) => $callback($case->name),
                $cases
            );
        }

        $keys = match ($keyBy) {
            'value' => array_column($cases, 'value'),
            default => array_column($cases, 'name'),
        };

        return array_map(
            fn ($case) => $callback($case->name),
            array_combine($keys, $cases)
        );
    }
}
