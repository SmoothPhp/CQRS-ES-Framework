<?php
namespace SmoothPhp\Test\Serialization;

use PHPUnit\Framework\TestCase;
use SmoothPhp\Serialization\ObjectSelfSerializer;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class ObjectSelfSerializerTest
 * @package SmoothPhp\Test\Serialization
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ObjectSelfSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_only_serialize_serializable_objects()
    {

        $this->expectException('\SmoothPhp\Serialization\Exception\SerializationException');
        $serializer = new ObjectSelfSerializer;
        $nonSerializableObject = new \stdClass;

        $serializer->serialize($nonSerializableObject);
    }

    /**
     * @test
     */
    public function it_should_not_attempt_to_deserialize_non_serializable_data()
    {
        $this->expectException('\SmoothPhp\Serialization\Exception\SerializationException');

        $serializer = new ObjectSelfSerializer;
        $data = ['class' => 'stdClass', 'payload' => ['foo' => 'bar']];

        $serializer->deserialize($data);
    }

    /**
     * @test
     */
    public function it_should_serialize_serializable_objects()
    {
        $serializer = new ObjectSelfSerializer;
        $object     = new SerializableObject('foo');

        $this->assertEquals([
            'class' => SerializableObject::class,
            'payload' => ['foo' => 'foo']
        ], $serializer->serialize($object));
    }

    /**
     * @test
     */
    public function it_should_deserialize_arrays_into_the_correct_object()
    {
        $serializer = new ObjectSelfSerializer;
        $data       = ['class' => SerializableObject::class, 'payload' => ['foo' => 'foo']];

        $object     = $serializer->deserialize($data);
        $this->assertInstanceOf(SerializableObject::class, $object);
        $this->assertEquals('foo', $object->getFoo());
    }
}

final class SerializableObject implements Serializable
{
    private $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    public function serialize()
    {
        return ['foo' => $this->foo];
    }

    public static function deserialize(array $data)
    {
        return new self($data['foo']);
    }

    public function getFoo()
    {
        return $this->foo;
    }
}