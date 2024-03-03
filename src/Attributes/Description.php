<?php

namespace Iteks\Attributes;

use Attribute;

#[Attribute]
class Description
{
    public function __construct(
        public string $description,
    ) {
    }
}
