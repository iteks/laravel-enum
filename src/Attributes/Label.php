<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides a display label for enum cases.
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Label
{
    /**
     * @param  string  $label
     */
    public function __construct(
        public string $label,
    ) {
    }
}
