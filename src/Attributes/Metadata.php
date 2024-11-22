<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides additional metadata for enum classes and cases.
 * The metadata can be provided as either an array or a JSON string.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT)]
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
