<?php
namespace SmoothPhp\Contracts\EventSourcing;

use SmoothPhp\Contracts\Domain\DomainEventStream;

/**
 * Interface AggregateRoot
 * @package SmoothPhp\Contracts\EventSourcing
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
interface AggregateRoot
{
    /**
     * @return string
     */
    public function getAggregateRootId();

    /**
     * @return DomainEventStream
     */
    public function getUncommittedEvents();

    /**
     * @param Event $event
     */
    public function apply(Event $event);
}