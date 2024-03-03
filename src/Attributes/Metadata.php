<?php

namespace Iteks\Attributes;

use Attribute;

#[Attribute]
class Metadata
{
    public function __construct(
        public array|string $metadata,
    ) {
    }
}
