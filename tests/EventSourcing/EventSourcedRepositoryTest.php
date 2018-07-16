<?php
namespace SmoothPhp\Test\AggregateRoot;

use PHPUnit\Framework\TestCase;
use SmoothPhp\Contracts\Domain\DomainEventStream;
use SmoothPhp\Contracts\EventBus\EventBus;
use SmoothPhp\Contracts\EventBus\EventListener;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\EventStore\DomainEventStreamInterface;
use SmoothPhp\Contracts\EventStore\EventStore;
use SmoothPhp\Domain\DateTime;
use SmoothPhp\Domain\DomainMessage;
use SmoothPhp\Domain\Metadata;
use SmoothPhp\EventSourcing\AggregateRoot;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class EventSourcedRepositoryTest
 * @package SmoothPhp\Test\AggregateRoot
 * @author Simon Bennett <simon@bennett.im>
 */
final class EventSourcedRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_loading_aggergate()
    {
        $mockStore = new MockStore();
        $eventBus = new MockEventBus();
        $repo = new Repo($mockStore, $eventBus);

        $aggregate = $repo->load('1');

        $this->assertInstanceOf(MockAggregate::class, $aggregate);
        $this->assertEquals(1, $mockStore->loadRunCount);
    }

    /**
     * @test
     */
    public function test_saving_aggregate()
    {
        $mockStore = new MockStore();
        $eventBus = new MockEventBus();
        $repo = new Repo($mockStore, $eventBus);

        $aggregate = new MockAggregate();
        $aggregate->apply(new MockEvent());//Lazy way to apply an event

        $repo->save($aggregate);

        $this->assertEquals(1, $mockStore->appendRunCount);
        $this->assertEquals(1, $eventBus->runCount);

        $this->assertCount(1,$eventBus->domainEventStream);

    }
}

class Repo extends EventSourcedRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'foo';
    }

    protected function getAggregateType()
    {
        return MockAggregate::class;
    }
}

class MockEvent implements Event
{
}

class MockAggregate extends AggregateRoot
{


    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return '1';
    }
}

class MockStore implements EventStore
{
    public $loadRunCount = 0;

    public $appendRunCount = 0;

    /**
     * @param string $id
     * @return DomainEventStream
     */
    public function load($id) : DomainEventStream
    {
        $this->loadRunCount++;

        return new \SmoothPhp\Domain\DomainEventStream([
                                                           new DomainMessage('1',
                                                                             0,
                                                                             new Metadata(),
                                                                             new Bar(),
                                                                             DateTime::now())
                                                       ]);
    }

    public function append($id, DomainEventStream $eventStream,bool $ignorePlayhead = false) : void
    {
        $this->appendRunCount++;

        return;
    }

    /**
     * @param string[] $eventTypes
     * @return int
     */
    public function getEventCountByTypes($eventTypes) : int
    {
    }

    /**
     * @param string[] $eventTypes
     * @param int $skip
     * @param int $take
     * @return \Generator
     */
    public function getEventsByType($eventTypes, $skip, $take) : \Generator
    {
    }

    /**
     * @param string $streamId
     */
    public function deleteStream(string $streamId) : void
    {
        throw new \Exception('Not implemented [deleteStream] method');
    }

}

class MockEventBus implements EventBus
{
    public $runCount = 0;

    /**
     * @var DomainEventStream
     */
    public $domainEventStream;

    /**
     * @param $eventListener
     * @return mixed
     */
    public function subscribe(EventListener $eventListener)
    {
        throw new \Exception('Not implemented [subscribe] method');
    }

    /**
     * @param DomainEventStream $domainEventStream
     * @return void
     */
    public function publish(DomainEventStream $domainEventStream)
    {
        $this->runCount++;

        $this->domainEventStream = $domainEventStream;
    }
}
