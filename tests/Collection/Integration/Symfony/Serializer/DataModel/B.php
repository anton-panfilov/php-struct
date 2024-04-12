<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;

class B extends Obj
{
    public function render(): string
    {
        return "Hello, I am B";
    }
}
