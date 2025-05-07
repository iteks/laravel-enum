<?php

namespace Iteks\Attributes;

use Attribute;

/**
 * Provides an identifier for enum cases.
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Id
{
    /**
     * @param  int|string  $id
     */
    public function __construct(
        public int|string $id,
    ) {}
}
