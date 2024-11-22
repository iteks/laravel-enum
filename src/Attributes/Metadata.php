<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides additional metadata for enum classes and cases.
 *
 * This attribute can be used on both class and case level, and supports multiple instances
 * to provide different types of metadata (e.g., versioning, categorization, configuration).
 * The metadata can be provided as either an array or a JSON string.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
class Metadata
{
    /**
     * @param  array|string  $metadata
     */
    public function __construct(
        public array|string $metadata,
    ) {
    }
}
