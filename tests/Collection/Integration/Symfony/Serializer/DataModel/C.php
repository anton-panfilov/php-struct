<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;

class C extends Obj
{
    public function render(): string
    {
        return "no mapping C";
    }
}
