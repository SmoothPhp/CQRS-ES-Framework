<?php
namespace SmoothPhp\Contracts\Serialization;

/**
 * Interface ObjectSelfSerializer
 * @package SmoothPhp\Contracts\Serialization
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
interface Serializer
{
    /**
     * @param $object
     * @return array
     */
    public function serialize($object);

    /**
     * @param array $serializedObject
     * @return mixed
     *
     */
    public function deserialize(array $serializedObject);
}