<?php

namespace Iteks\Support\Services;

use Illuminate\Support\Str;

class BackedEnumService
{
    /**
     * Get a backed enum class as an array to populate a select element.
     * The array will consist of a `text` key column containing values of the case name in display format,
     * and a `value` keys column containing values using the original simpler values.
     *
     * @param  string  $enum  The enum class.
     * @return array<array>
     */
    public static function asSelectArray(string $enum): array
    {
        return array_map(function ($case): array {
            return [
                'text' => self::toLabel($case),
                'value' => $case->value,
            ];
        }, $enum::cases());
    }

    /**
     * Create a label from the case name.
     *
     * @param  mixed  $case  The case instance.
     * @param  bool  $isConst  Case format is a traditional "CONSTANT_CASE" string.
     * @return string The created label.
     */
    public static function toLabel(mixed $case, bool $isConst = false): string
    {
        $name = $case ? $case->name : '';
        $name = $isConst ? Str::splitConstantCase($name) : Str::splitEnumCase($name);

        return $name ? Str::title($name) : '';
    }

    /**
     * Create and compile an array of labels from the case names.
     *
     * @param  string  $enum  The enum class.
     * @param  bool  $isConst  Case format is a traditional "CONSTANT_CASE" string.
     * @return array<string> The created labels.
     */
    public static function toLabels(string $enum, bool $isConst = false): array
    {
        return array_map(function ($name) use ($isConst): string {
            return Str::title($isConst ? Str::splitConstantCase($name) : Str::splitEnumCase($name));
        }, array_column($enum::cases(), 'name'));
    }
}
