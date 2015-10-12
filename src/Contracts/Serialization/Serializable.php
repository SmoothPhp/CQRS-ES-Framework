<?php
namespace SmoothPhp\Contracts\Serialization;

/**
 * Interface Serializable
 * @package SmoothPhp\Contracts\Serialization
 * @author Simon Bennett <simon@bennett.im>
 */
interface Serializable
{
    /**
     * @return array
     */
    public function serialize();

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data);
}