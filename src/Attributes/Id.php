<?php

namespace Iteks\Attributes;

use Attribute;

#[Attribute]
class Id
{
    public function __construct(
        public int|string $id,
    ) {
    }
}
