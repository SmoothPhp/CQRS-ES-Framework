<?php
namespace SmoothPhp\Domain;

use ArrayIterator;
use SmoothPhp\Contracts\Domain\DomainEventStream as DomainEventStreamInterface;

/**
 * Class DomainEventStream
 * @package SmoothPhp\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
final class DomainEventStream implements DomainEventStreamInterface
{
    /**
     * @var array
     */
    private $events;

    /**
     * @param \SmoothPhp\Contracts\Domain\DomainMessage[] $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}