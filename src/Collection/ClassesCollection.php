<?php

namespace LeapTheory\Structure\Collection;

class ClassesCollection extends AbstractCollection
{
    protected function validate($offset, $value): bool
    {
        return is_string($value) && class_exists($value);
    }
}