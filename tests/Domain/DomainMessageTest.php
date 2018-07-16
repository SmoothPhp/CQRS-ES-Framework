<?php
namespace SmoothPhp\Test\Domain;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Domain\DateTime;
use SmoothPhp\Domain\DomainMessage;
use SmoothPhp\Domain\Metadata;

/**
 * Class DomainMessageTest
 * @package SmoothPhp\Test\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
final class DomainMessageTest extends TestCase
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
        $this->assertTrue(Carbon::instance($domainMessage->getRecordedOn())->diffInSeconds() <= 1);

        $this->assertEquals('SmoothPhp.Test.Domain.TestEvent', $domainMessage->getType());
    }

    public function test_carbon_test_date_does_not_affect()
    {
        $metaData = new Metadata();
        $payload = new TestEvent();
        $date = Carbon::create(2017, 1, 1);
        Carbon::setTestNow($date);
        $domainMessage = DomainMessage::recordNow('1', 0, $metaData, $payload);

        $formatted = $domainMessage->getRecordedOn()->format('d/m/Y');
        $this->assertNotSame($date->format('d/m/Y'), $formatted);
    }
}

class TestEvent implements Event
{

}