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
     *
     * @return DomainEventStreamInterface
     */
    public function load($id);

    /**
     * @param mixed                      $id
     * @param DomainEventStream $eventStream
     */
    public function append($id, DomainEventStream $eventStream);
}
