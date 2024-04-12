<?php

namespace AP\Structure\Collection\Integration\Symfony\Serializer;

use AP\Structure\Collection\ClassesCollection;

interface ObjectsCollectionClassesMapping
{
    public static function serializerClassesMapper(): ClassesCollection;
}