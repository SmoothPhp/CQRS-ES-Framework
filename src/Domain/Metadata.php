<?php
namespace SmoothPhp\Domain;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class Metadata
 * @package SmoothPhp\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
final class Metadata implements Serializable
{
    /** @var array */
    private $meta;

    /**
     * Metadata constructor.
     * @param array $meta
     */
    public function __construct(array $meta = [])
    {
        $this->meta = $meta;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return $this->meta;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data);
    }
}