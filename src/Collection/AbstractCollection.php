<?php

namespace LeapTheory\Structure\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class AbstractCollection implements IteratorAggregate, Countable, ArrayAccess
{
    protected array $elements = [];

    abstract protected function validate($offset, $value): bool;

    public function __construct(
        array|AbstractCollection $data = []
    )
    {
        foreach ($data as $k => $v){
            $this[$k] = $v;
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function all(): array
    {
        return $this->elements;
    }

    public function offsetSet($offset, $value): void
    {
        if (!$this->validate($offset, $value)) {
            throw new InvalidArgumentException("Illegal value");
        }

        if (is_null($offset)) {
            $this->elements[] = $value;
        } else {
            $this->elements[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->elements[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->elements[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->elements[$offset] ?? null;
    }
}