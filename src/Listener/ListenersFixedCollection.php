<?php

namespace AP\Structure\Listener;

use AP\Structure\Collection\AbstractCollection;
use AP\Structure\Collection\InterfacesCollection;

class ListenersFixedCollection extends AbstractCollection
{
    private array $index = [];

    public function __construct(
        private readonly InterfacesCollection $interfaces,
        array|AbstractCollection              $data = []
    )
    {
        foreach ($this->interfaces as $interface) {
            $this->index[$interface] = [];
        }
        parent::__construct($data);
    }

    protected function validate($offset, $value): bool
    {
        if (is_object($value)) {
            foreach ($this->interfaces as $interface) {
                if ($value instanceof $interface) {
                    return true;
                }
            }
        }
        return false;
    }

    public function offsetSet($offset, $value): void
    {
        parent::offsetSet($offset, $value);
        $offset = $offset ?? array_key_last($this->elements);
        foreach ($this->interfaces as $interface) {
            if ($value instanceof $interface) {
                $this->index[$interface][$offset] = $value;
            }
        }
    }

    public function offsetUnset($offset): void
    {
        parent::offsetUnset($offset);
        foreach ($this->interfaces as $interface) {
            unset($this->index[$interface][$offset]);
        }
    }

    public function getByInterface(string $interface): array
    {
        return $this->index[$interface] ?? [];
    }

    public function getAllByInterfaces(): array
    {
        return $this->index;
    }
}