<?php

include "../../vendor/autoload.php";

use AP\Structure\Singleton\Singleton;

class SingletonExample2
{
    use Singleton;

    protected ?int $randID = null;

    public function getID()
    {
        if (is_null($this->randID)) {
            $this->randID = rand(PHP_INT_MIN, PHP_INT_MAX);
        }
        return $this->randID;
    }
}

$example1 = SingletonExample2::getInstance();
$example2 = SingletonExample2::getInstance();

if ($example1->getID() == $example2->getID()) {
    echo "Same ids: " . $example1->getID();
}