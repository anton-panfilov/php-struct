<?php

include "../../vendor/autoload.php";

use AP\Structure\Singleton\Singleton;

class SingletonExample1
{
    use Singleton;

    protected function __construct(
        public readonly string $message = "hello world",
        public readonly string $version = "1.0.0",
    )
    {
    }
}

echo SingletonExample1::getInstance()->message;
echo "\n";
echo SingletonExample1::getInstance()->version;