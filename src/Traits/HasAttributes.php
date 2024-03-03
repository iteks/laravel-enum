<?php

namespace Iteks\Traits;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
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
     * @return array<int, string|null>
     */
    public static function descriptions(): array
    {
        return array_map(function ($case): ?string {
            return self::description($case->name);
        }, static::cases());
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
     * @return array<int, int|string|null>
     */
    public static function ids(): array
    {
        return array_map(function ($case): int|string|null {
            return self::id($case->name);
        }, static::cases());
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
     * @return array<int, string|null>
     */
    public static function labels(): array
    {
        return array_map(function ($case): ?string {
            return self::label($case->name);
        }, static::cases());
    }

    /**
     * Retrieve the metadata attribute.
     *
     * @param  string  $name  The case name.
     * @return array|string|null
     */
    public static function metadata(string $name): array|string|null
    {
        return self::mapAttributeClass(Metadata::class, self::mapFromCase($name))?->metadata;
    }

    /**
     * Retrieve the metadata attribute for all cases.
     *
     * @return array<int, array|string|null>
     */
    public static function metadatum(): array
    {
        return array_map(function ($case): array|string|null {
            return self::metadata($case->name);
        }, static::cases());
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
}
