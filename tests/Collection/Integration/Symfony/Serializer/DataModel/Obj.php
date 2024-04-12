<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;

abstract class Obj
{
    abstract public function render(): string;
}
