<?php
namespace SmoothPhp\Test\Domain;

use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Domain\DateTime;
use SmoothPhp\Domain\DomainMessage;
use SmoothPhp\Domain\Metadata;

/**
 * Class DomainMessageTest
 * @package SmoothPhp\Test\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
final class DomainMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_default_domain_message()
    {
        $metaData = new Metadata();
        $payload = new TestEvent();
        $recodedAt = DateTime::now();


        $domainMessage = new DomainMessage('1', 0, $metaData, $payload, $recodedAt);

        $this->assertEquals('1', $domainMessage->getId());
        $this->assertEquals(0, $domainMessage->getPlayHead());
        $this->assertSame($metaData, $domainMessage->getMetadata());
        $this->assertSame($payload, $domainMessage->getPayload());
        $this->assertSame($recodedAt, $domainMessage->getRecordedOn());

        $this->assertEquals('SmoothPhp.Test.Domain.TestEvent', $domainMessage->getType());


    }

    public function test_default_domain_message_static()
    {
        $metaData = new Metadata();
        $payload = new TestEvent();


        $domainMessage = DomainMessage::recordNow('1', 0, $metaData, $payload);

        $this->assertEquals('1', $domainMessage->getId());
        $this->assertEquals(0, $domainMessage->getPlayHead());
        $this->assertSame($metaData, $domainMessage->getMetadata());
        $this->assertSame($payload, $domainMessage->getPayload());
        $this->assertTrue($domainMessage->getRecordedOn()->diffInSeconds() <= 1);

        $this->assertEquals('SmoothPhp.Test.Domain.TestEvent', $domainMessage->getType());
    }
}

class TestEvent implements Event
{

}