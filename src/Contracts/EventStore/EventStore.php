<?php
namespace SmoothPhp\Contracts\EventStore;

use SmoothPhp\Contracts\Domain\DomainEventStream;

/**
 * Interface EventStore
 * @package SmoothPhp\EventStore
 * @author Simon Bennett <simon@bennett.im>
 */
interface EventStore
{
    /**
     * @param string $id
     * @return DomainEventStream
     * @throws EventStreamNotFound
     */
    public function load($id);

    /**
     * @param mixed                      $id
     * @param DomainEventStream $eventStream
     */
    public function append($id, DomainEventStream $eventStream);

    /**
     * @param string[] $eventTypes
     * @return int
     */
    public function getEventCountByTypes($eventTypes);

    /**
     * @param string[] $eventTypes
     * @param int $skip
     * @param int $take
     * @return DomainEventStream
     */
    public function getEventsByType($eventTypes, $skip, $take);
}
