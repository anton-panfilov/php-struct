<?php

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;


use AP\Structure\Collection\Integration\Symfony\Serializer\ObjectsCollectionNormalizer;
use AP\Structure\Singleton\Singleton;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerObject extends Serializer
{
    use Singleton;

    private function __construct()
    {
        parent::__construct(
            [new ObjectsCollectionNormalizer(), new ObjectNormalizer],
            [new JsonEncoder]
        );
    }
}
