<?php
namespace SmoothPhp\Serialization;

use SmoothPhp\Contracts\Serialization\Serializer;
use SmoothPhp\Contracts\Serialization\Serializable;
use SmoothPhp\Serialization\Exception\SerializationException;

/**
 * Class ObjectSelfSerializer
 * @package SmoothPhp\Serialization
 * @author Simon Bennett <simon@bennett.im>
 */
final class ObjectSelfSerializer implements Serializer
{
    /**
     * {@inheritDoc}
     */
    public function serialize($object)
    {
        if (! $object instanceof Serializable) {
            throw new SerializationException(sprintf(
                                                 'Object \'%s\' does not implement Serializable',
                                                 get_class($object)
                                             ));
        }
        return array(
            'class'   => get_class($object),
            'payload' => $object->serialize()
        );
    }
    /**
     * {@inheritDoc}
     */
    public function deserialize(array $serializedObject)
    {
        if (! in_array(Serializable::class, class_implements($serializedObject['class']))) {
            throw new SerializationException(
                sprintf(
                    'Class \'%s\' does not implement Serializable',
                    $serializedObject['class']
                )
            );
        }
        return $serializedObject['class']::deserialize($serializedObject['payload']);
    }
}