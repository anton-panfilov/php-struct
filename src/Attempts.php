<?php declare(strict_types=1);

namespace AP\Structure;

class Attempts
{
    protected array $ids = [];

    public function add(int $id): void
    {
        $this->ids[$id] = true;
    }

    public function was(int $id): bool
    {
        return isset($this->ids[$id]);
    }
}
