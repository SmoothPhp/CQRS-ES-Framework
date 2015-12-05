<?php
namespace SmoothPhp\EventBus;

use SmoothPhp\Contracts\Domain\DomainEventStream;
use SmoothPhp\Contracts\Domain\DomainMessage;
use SmoothPhp\Contracts\EventBus\EventBus;
use SmoothPhp\Contracts\EventBus\EventListener;

/**
 * Class SimpleEventBus
 * @package SmoothPhp\EventBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class SimpleEventBus implements EventBus
{
    /**
     * @var EventListener[]
     */
    private $eventListeners = [];

    /**
     * @var DomainMessage[]
     */
    private $queue = [];

    /**
     * @param $eventListener
     * @return mixed
     */
    public function subscribe(EventListener $eventListener)
    {
        $this->eventListeners[] = $eventListener;
    }

    /**
     * @param DomainEventStream $domainEventStream
     * @return void
     */
    public function publish(DomainEventStream $domainEventStream)
    {
        foreach ($domainEventStream as $domainMessage) {
            $this->queue[] = $domainMessage;
        }

        while ($domainMessage = array_shift($this->queue)) {
            foreach ($this->eventListeners as $eventListener) {
                $eventListener->handle($domainMessage);
            }
        }
    }
}