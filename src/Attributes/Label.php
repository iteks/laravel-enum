<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides a display label for enum cases.
 *
 * @deprecated 1.1.0 Using this attribute on classes is deprecated and will be removed in v2.0.0.
 *             It should only be used on enum cases.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
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
