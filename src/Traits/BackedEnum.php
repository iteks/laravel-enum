<?php

namespace Iteks\Traits;

use Illuminate\Support\Str;

trait BackedEnum
{
    use ExtendsBackedEnum;

    /**
     * Get a backed enum class as an array to populate a select element.
     * The array will consist of a `text` key column containing values of the case name in display format,
     * and a `value` keys column containing values using the original simpler values.
     *
     * @return array<array>
     */
    public static function asSelectArray(): array
    {
        $enumClass = static::class;

        return array_map(function ($case): array {
            return [
                'text' => self::label($case->name) ?? self::toLabel($case->value),
                'value' => self::id($case->name) ?? $case->value,
            ];
        }, $enumClass::cases());
    }

    /**
     * Maps a scalar to an enum instance.
     *
     * @param  string  $name  The case name.
     * @return mixed
     */
    public static function fromName(string $name): mixed
    {
        return self::__fromName($name);
    }

    /**
     * Retrieve the case name for the given simpler value.
     *
     * @param  int|string  $value  The simpler value.
     * @return string|null The case name.
     */
    public static function name(int|string $value): ?string
    {
        $enum = self::tryFrom($value);

        return $enum ? $enum->name : null;
    }

    /**
     * Retrieve an array containing all of the case names.
     *
     * @return array<string> An array of case names.
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Create a label from the case name.
     *
     * @param  int|string  $value  The simpler value.
     * @param  bool  $isConst  Case format is a traditional "CONSTANT_CASE" string.
     * @return string The created label.
     */
    public static function toLabel(int|string $value, bool $isConst = false): string
    {
        $enum = self::tryFrom($value);

        $name = $enum ? $enum->name : '';
        $name = $isConst ? Str::splitConstantCase($name) : Str::splitEnumCase($name);

        return $name ? Str::title($name) : '';
    }

    /**
     * Create and compile an array of labels from the case names.
     *
     * @param  bool  $isConst  Case format is a traditional "CONSTANT_CASE" string.
     * @return array<string> The created labels.
     */
    public static function toLabels(bool $isConst = false): array
    {
        return array_map(function ($name) use ($isConst): string {
            return Str::title($isConst ? Str::splitConstantCase($name) : Str::splitEnumCase($name));
        }, array_column(self::cases(), 'name'));
    }

    /**
     * Maps a scalar to an enum instance or null.
     *
     * @param  string  $name  The case name.
     * @return mixed
     */
    public static function tryFromName(string $name): mixed
    {
        return self::__tryFromName($name);
    }

    /**
     * Retrieve the simpler value for the given case name.
     *
     * @param  string  $name  The case name.
     * @return int|string|null The simpler value.
     */
    public static function value(string $name): int|string|null
    {
        $enumClass = static::class;

        foreach ($enumClass::cases() as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }

        return null;
    }

    /**
     * Retrieve an array containing all of the simpler values.
     *
     * @return array<int|string> An array of simpler values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
