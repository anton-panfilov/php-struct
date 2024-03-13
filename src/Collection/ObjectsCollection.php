<?php

namespace LeapTheory\Structure\Collection;

class ObjectsCollection extends AbstractCollection
{
    public function __construct(
        private readonly string  $class,
        array|AbstractCollection $data = []
    )
    {
        parent::__construct($data);
    }

    protected function validate($offset, $value): bool
    {
        return $value instanceof $this->class;
    }
}