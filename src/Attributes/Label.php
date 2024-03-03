<?php

namespace Iteks\Attributes;

use Attribute;

#[Attribute]
class Label
{
    public function __construct(
        public string $label,
    ) {
    }
}
