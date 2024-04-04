<?php

namespace AP\Structure\Collection;

use RuntimeException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ObjectsCollectionDenormilizer implements DenormalizerAwareInterface, ContextAwareDenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function setDenormalizer(DenormalizerInterface $denormalizer): void
    {
        if (!method_exists($denormalizer, 'getSupportedTypes')) {
            trigger_deprecation('symfony/serializer', '6.3', 'Not implementing the "DenormalizerInterface::getSupportedTypes()" in "%s" is deprecated.', get_debug_type($denormalizer));
        }

        $this->denormalizer = $denormalizer;
    }

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
        foreach ($data as $k => $v){
            $collection[$k] =  $this->denormalizer->denormalize($v, $collection->class, $format, $context);
        }
        return $collection;
    }
}