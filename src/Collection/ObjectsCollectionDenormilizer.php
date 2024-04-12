<?php

namespace AP\Structure\Collection;

use RuntimeException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @deprecated
 */
class ObjectsCollectionDenormilizer implements DenormalizerAwareInterface, DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_a($type, ObjectsCollection::class, true);
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        $collection = new $type();
        if (!($collection instanceof ObjectsCollection)) {
            throw new RuntimeException('post condition: type is no collection');
        }
        if (is_array($data) || $data instanceof \ArrayAccess) {
            foreach ($data as $k => $v) {
                $collection[$k] = $this->denormalizer->denormalize($v, $collection->class, $format, $context);
            }
        }
        return $collection;
    }
}