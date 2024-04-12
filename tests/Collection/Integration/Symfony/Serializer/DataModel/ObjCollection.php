<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel;

use AP\Structure\Collection\AbstractCollection;
use AP\Structure\Collection\ClassesCollection;
use AP\Structure\Collection\Integration\Symfony\Serializer\ObjectsCollectionClassesMapping;
use AP\Structure\Collection\Integration\Symfony\Serializer\ObjectsCollectionMultiClasses;
use AP\Structure\Collection\ObjectsCollection;

class ObjCollection extends ObjectsCollection implements
    ObjectsCollectionMultiClasses,
    ObjectsCollectionClassesMapping
{
    public function __construct(array|AbstractCollection $data = [])
    {
        parent::__construct(Obj::class, $data);
    }

    /**
     * @return Obj[]
     */
    public function all(): array
    {
        return parent::all();
    }

    public static function serializerClassesMapper(): ClassesCollection
    {
        return new ClassesCollection([
            "a" => A::class,
            "b" => B::class,
        ]);
    }
}
