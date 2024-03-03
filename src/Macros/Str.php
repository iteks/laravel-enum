<?php

namespace Iteks\Support\Macros;

class Str
{
    /**
     * Splits a "CONSTANT_CASE" string into words separated by whitespace.
     *
     * @param  string  $value
     * @return string
     */
    public static function splitConstantCase(string $value): string
    {
        return implode(' ', explode('_', $value));
    }

    /**
     * Splits a "EnumCase" string into words separated by whitespace.
     *
     * @param  string  $value
     * @return string
     */
    public static function splitEnumCase(string $value): string
    {
        return preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', $value) ?? '';
    }
}
