<?php

namespace AP\Structure\Collection\Integration\Symfony\Serializer;

use AP\Structure\Collection\ObjectsCollection;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ObjectsCollectionNormalizer implements
    DenormalizerAwareInterface,
    DenormalizerInterface,
    NormalizerAwareInterface,
    NormalizerInterface
{
    private const EL_CLASS = 'type';
    private const EL_DATA  = 'data';

    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_a($type, ObjectsCollection::class, true);
    }

    public function supportsNormalization(mixed $data, ?string $format = null)
    {
        return
            is_a($data, ObjectsCollection::class, true)
            && is_a($data, ObjectsCollectionMultiClasses::class, true);
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        $collection = new $type();
        if (!($collection instanceof ObjectsCollection)) {
            throw new RuntimeException('post condition: type is no collection');
        }
        if (is_array($data) || $data instanceof \ArrayAccess) {
            $cl = $collection->class;

            $mapping = $collection instanceof ObjectsCollectionClassesMapping ?
                $collection::serializerClassesMapper()->all() :
                null;

            foreach ($data as $k => $v) {
                if ($collection instanceof ObjectsCollectionMultiClasses) {
                    if (!isset($v[self::EL_DATA], $v[self::EL_DATA])) {
                        throw new RuntimeException(
                            "required elements: " . self::EL_CLASS . ", " . self::EL_DATA . " no found"
                        );
                    }
                    $dt = $v[self::EL_DATA];
                    $cl = $v[self::EL_CLASS];

                    if (is_array($mapping) && isset($mapping[$cl])) {
                        $cl = $mapping[$cl];
                    }

                    if (!class_exists($cl)) {
                        throw new RuntimeException(
                            "invalid type: " . $cl
                        );
                    }
                } else {
                    $dt = $v;
                }
                $collection[$k] = $this->denormalizer->denormalize(
                    $dt,
                    $cl,
                    $format,
                    $context
                );
            }
        }
        return $collection;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = [])
    {
        if (!($object instanceof ObjectsCollection)) {
            throw new RuntimeException('post condition: object is no collection');
        }

        $mapping = $object instanceof ObjectsCollectionClassesMapping ?
            $object::serializerClassesMapper()->all() :
            null;

        $mapping_by_classes = [];
        if (is_array($mapping)) {
            foreach ($mapping as $name => $class) {
                $mapping_by_classes[$class] = $name;
            }
        }

        $result = [];
        foreach ($object as $k => $v) {
            $class      = get_class($v);
            $result[$k] = [
                self::EL_CLASS => $mapping_by_classes[$class] ?? $class,
                self::EL_DATA  => $this->normalizer->normalize(
                    $v,
                    $format,
                    $context
                )
            ];
        }
        return $result;
    }
}