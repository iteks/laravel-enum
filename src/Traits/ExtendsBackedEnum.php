<?php

namespace Iteks\Traits;

use ValueError;

trait ExtendsBackedEnum
{
    /**
     * Maps a scalar to an enum instance.
     *
     * @param  string  $name  The case name.
     * @return mixed
     */
    private static function __fromName(string $name): mixed
    {
        $enum = static::__tryFromName($name);

        if ($enum === null) {
            throw new ValueError($name . ' is not a valid backing value for enum ' . static::class);
        }

        return $enum;
    }

    /**
     * Maps a scalar to an enum instance or null.
     *
     * @param  string  $name  The case name.
     * @return mixed
     */
    private static function __tryFromName(string $name): mixed
    {
        $enum = array_filter(static::cases(), function ($case) use ($name) {
            return $case->name === $name;
        });

        // Unwrap the enum object.
        $enum = array_shift($enum);

        return $enum ? $enum : null;
    }
}
