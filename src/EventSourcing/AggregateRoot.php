<?php
namespace SmoothPhp\EventSourcing;

use SmoothPhp\Contracts\EventSourcing\AggregateRoot as AggregateRootInterface;
use SmoothPhp\Contracts\EventSourcing\Entity;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Domain\DomainEventStream;
use SmoothPhp\Domain\DomainMessage;
use SmoothPhp\Domain\Metadata;

/**
 * Class AggregateRoot
 * @author Simon Bennett <simon@smoothphp.im>
 */
abstract class AggregateRoot implements AggregateRootInterface
{
    /**
     * @var []
     */
    private $uncommittedEvents = [];

    private $playHead = -1;

    /** @var Entity[] */
    private $children = [];

    /**
     * @param Event $event
     */
    public function apply(Event $event)
    {
        $this->handleRecursively($event);

        $this->playHead++;
        $this->uncommittedEvents[] = DomainMessage::recordNow(
            $this->getAggregateRootId(),
            $this->playHead,
            new Metadata(array()),
            $event
        );
    }


    /**
     * Handles event if capable.
     *
     * @param $event
     */
    protected function handle(Event $event)
    {
        $method = $this->getApplyMethod($event);
        if (!method_exists($this, $method)) {
            return;
        }
        $this->$method($event);
    }

    protected function handleRecursively(Event $event)
    {
        $this->handle($event);

        foreach ($this->children as $child) {
            $child->registerAggregateRoot($this);
            $child->handleRecursively($event);
        }
    }

    /**
     * @param Event $event
     * @return string
     */
    private function getApplyMethod(Event $event)
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts);
    }

    /**
     * @return DomainEventStream
     */
    public function getUncommittedEvents()
    {
        $stream = new DomainEventStream($this->uncommittedEvents);

        $this->uncommittedEvents = [];

        return $stream;
    }

    /**
     * @param DomainEventStream $stream
     */
    public function initializeState(DomainEventStream $stream)
    {
        foreach ($stream as $message) {
            $this->playHead++;
            $this->handle($message->getPayload());
        }
    }

    /**
     * @param Entity $entity
     */
    public function addChildEntity(Entity $entity)
    {
        $this->children[] = $entity;
    }
}