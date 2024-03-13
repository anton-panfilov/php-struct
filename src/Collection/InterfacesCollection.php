<?php

namespace LeapTheory\Structure\Collection;

class InterfacesCollection extends AbstractCollection
{
    protected function validate($offset, $value): bool
    {
        return is_string($value) && interface_exists($value);
    }
}