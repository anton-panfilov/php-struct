<?php

include "../vendor/autoload.php";

use AP\Structure\Singleton\Singleton;

class Example
{
    use Singleton;

    protected function __construct(
        public readonly string $message = "hello world"
    )
    {
    }
}

echo Example::getInstance()->message;