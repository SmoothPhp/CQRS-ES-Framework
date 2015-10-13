<?php
namespace SmoothPhp\Contracts\EventBus;

use SmoothPhp\Contracts\Domain\DomainEventStream;

/**
 * Interface EventBus
 * @package SmoothPhp\Contracts\EventBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface EventBus
{
    /**
     * @param $eventListener
     * @return mixed
     */
    public function subscribe(EventListener $eventListener);

    /**
     * @param DomainEventStream $domainEventStream
     * @return void
     */
    public function publish(DomainEventStream $domainEventStream);
}