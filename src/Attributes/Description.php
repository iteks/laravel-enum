<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides descriptive text for enum classes and cases.
 *
 * This attribute can be used on both class and case level, and supports multiple instances
 * to provide different types of descriptions (e.g., short/long form, different languages).
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
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
