<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides descriptive text for enum classes and cases.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT)]
class Description
{
    /**
     * @param  string  $description
     */
    public function __construct(
        public string $description,
    ) {
    }
}
