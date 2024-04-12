<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;

class A extends Obj
{
    public function __construct(
        public readonly string $message
    )
    {
    }

    public function render(): string
    {
        return "A say: " . $this->message;
    }
}
