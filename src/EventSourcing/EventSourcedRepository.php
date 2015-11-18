<?php
namespace SmoothPhp\EventSourcing;

use SmoothPhp\Contracts\EventBus\EventBus;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot as AggregateRootInterface;
use SmoothPhp\Contracts\EventStore\EventStore;

/**
 * Class EventSourcedRepository
 * @package SmoothPhp\EventSourcing
 * @author Simon Bennett <simon@bennett.im>
 */
abstract class EventSourcedRepository
{
    /** @var EventStore */
    private $eventStore;

    /** @var EventBus */
    private $eventBus;


    /**
     * EventSourcedRepository constructor.
     * @param EventStore $eventStore
     * @param EventBus $eventBus
     */
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        $this->eventStore = $eventStore;
        $this->eventBus = $eventBus;
    }


    /**
     * @return string
     */
    abstract protected function getPrefix();

    /**
     * @return string
     */
    abstract protected function getAggregateType();

    /**
     * @param string $id
     * @return AggregateRootInterface
     */
    public function load($id)
    {
        $domainEvents = $this->eventStore->load($this->getPrefix() . $id);
        $aggregateClassName = $this->getAggregateType();

        $aggregate = new $aggregateClassName();
        $aggregate->initializeState($domainEvents);

        return $aggregate;
    }

    /**
     * @param AggregateRootInterface $aggregate
     * @return void
     */
    public function save(AggregateRootInterface $aggregate)
    {
        $events = $aggregate->getUncommittedEvents();

        $this->eventStore->append($aggregate->getAggregateRootId(), $events);

        $this->eventBus->publish($events);
    }

}