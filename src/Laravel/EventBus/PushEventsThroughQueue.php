<?php
namespace SmoothPhp\Laravel\EventBus;

use Illuminate\Contracts\Queue\Queue;
use SmoothPhp\Contracts\Domain\DomainMessage;
use SmoothPhp\Contracts\EventBus\EventListener;
use SmoothPhp\Contracts\Serialization\Serializer;

/**
 * Class PushEventsThroughQueue
 * @package SmoothPhp\Laravel\EventBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class PushEventsThroughQueue implements EventListener
{
    /** @var Queue */
    private $queue;

    /** @var Serializer */
    private $serializer;

    /**
     * PushEventsThroughQueue constructor.
     * @param Queue $queue
     * @param Serializer $serializer
     */
    public function __construct(Queue $queue, Serializer $serializer)
    {
        $this->queue = $queue;
        $this->serializer = $serializer;
    }

    /**
     * @param DomainMessage $domainMessage
     * @return void
     */
    public function handle(DomainMessage $domainMessage)
    {
        $this->queue->push(QueueToEventDispatcher::class,
                           [
                               'uuid'        => (string)$domainMessage->getId(),
                               'playhead'    => $domainMessage->getPlayHead(),
                               'metadata'    => json_encode($this->serializer->serialize($domainMessage->getMetadata())),
                               'payload'     => json_encode($this->serializer->serialize($domainMessage->getPayload())),
                               'recorded_on' => (string)$domainMessage->getRecordedOn(),
                               'type'        => $domainMessage->getType(),
                           ]);
    }
}