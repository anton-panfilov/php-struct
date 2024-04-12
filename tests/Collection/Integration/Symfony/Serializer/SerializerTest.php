<?php declare(strict_types=1);

namespace AP\Structure\Tests\Collection\Integration\Symfony\Serializer;

use AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel\A;
use AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel\B;
use AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel\C;
use AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel\ObjCollection;
use AP\Structure\Tests\Collection\Integration\Symfony\Serializer\DataModel\SerializerObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class SerializerTest extends TestCase
{
    public function testSimple(): void
    {
        $format = JsonEncoder::FORMAT;

        $collection = new ObjCollection([
            new A("hello"),
            new B(),
            new C(),
            new A("bye"),
        ]);

        $dump = SerializerObject::getInstance()->normalize(
            data: $collection,
            format: $format
        );

        $this->assertEquals("a", $dump[0]['type']);
        $this->assertEquals("b", $dump[1]['type']);
        $this->assertEquals(C::class, $dump[2]['type']);
        $this->assertEquals("a", $dump[3]['type']);

        $collection2 = SerializerObject::getInstance()->denormalize(
            data: $dump,
            type: $collection::class,
            format: $format
        );

        $this->assertEquals($collection, $collection2);
    }
}
