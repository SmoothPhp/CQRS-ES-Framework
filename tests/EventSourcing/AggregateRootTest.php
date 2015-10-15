<?php
namespace SmoothPhp\Test\AggregateRoot;

use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Domain\DateTime;
use SmoothPhp\Domain\DomainEventStream;
use SmoothPhp\Domain\DomainMessage;
use SmoothPhp\Domain\Metadata;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class AggregateRootTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class AggregateRootTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function apply_event()
    {
        $aggregate = new Aggregate();

        $aggregate->bar();

        $this->assertCount(1, $aggregate->getUncommittedEvents());

        $this->assertTrue($aggregate->run);
    }

    /**
     * @test
     */
    public function from_event_stream()
    {
        $events = new DomainEventStream([new DomainMessage('1', 0, new Metadata(), new Bar(), DateTime::now())]);

        $aggregate = new Aggregate();

        $aggregate->initializeState($events);

        $this->assertCount(0, $aggregate->getUncommittedEvents());

        $this->assertTrue($aggregate->run);
    }

    /**
     * @test
     */
    public function event_does_not_apply()
    {
        $aggregate = new Aggregate();
        $aggregate->foo();

        $this->assertCount(1, $aggregate->getUncommittedEvents());
    }
}

class Aggregate extends AggregateRoot
{
    public $run = false;

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return '1';
    }

    public function bar()
    {
        $this->apply(new Bar());
    }

    public function foo()
    {
        $this->apply(new Foo());
    }

    public function applyBar()
    {
        $this->run = true;
    }
}

class Bar implements Event
{
}

class Foo implements Event
{
}