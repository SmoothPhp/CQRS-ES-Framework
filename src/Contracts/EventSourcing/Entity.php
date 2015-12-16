<?php namespace SmoothPhp\Contracts\EventSourcing;

use SmoothPhp\EventSourcing\Exception;

/**
 * Abstract class Entity
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
interface Entity
{
    /**
     * @param Event $event
     * @throws Exception\AggregateRootAlreadyRegistered
     */
    public function handleRecursively(Event $event);

    /**
     * @param AggregateRoot $aggregateRoot
     * @throws Exception\AggregateRootAlreadyRegistered
     */
    public function registerAggregateRoot(AggregateRoot $aggregateRoot);

    /**
     * @return string
     */
    public function getEntityId();
}