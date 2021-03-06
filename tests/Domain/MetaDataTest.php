<?php
namespace SmoothPhp\Test\Domain;

use PHPUnit\Framework\TestCase;
use SmoothPhp\Domain\Metadata;

/**
 * Class MetaDataTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class MetaDataTest extends TestCase
{
    /**
     * @test
     */
    public function test_meta_data()
    {
        $metaData = new Metadata(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $metaData->getMeta());

        $this->assertEquals(['foo' => 'bar'], $metaData->serialize());

        $this->assertEquals(Metadata::deserialize(['foo' => 'bar']), $metaData);

    }
}