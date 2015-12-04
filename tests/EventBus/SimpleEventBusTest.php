<?php
namespace SmoothPhp\Tests\EventBus;

use SmoothPhp\Contracts\Domain\DomainMessage;
use SmoothPhp\Contracts\EventBus\EventListener;
use SmoothPhp\Domain\DateTime;
use SmoothPhp\Domain\DomainEventStream;
use SmoothPhp\Domain\Metadata;
use SmoothPhp\EventBus\SimpleEventBus;

/**
 * Class SimpleEventBusTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class SimpleEventBusTest extends \PHPUnit_Framework_TestCase
{
    public function test_subscribing_to_event_bus()
    {
        $eventBus = new SimpleEventBus();

        $listener = new EventBusListener();
        $eventBus->subscribe($listener);


        $this->assertEquals(0,$listener->runCount);
        $eventBus->publish(new DomainEventStream([new \SmoothPhp\Domain\DomainMessage('',0,new Metadata(),null,new DateTime())]));
        $this->assertEquals(1,$listener->runCount);
    }

    /**
     * Should not throw exception!
     */
    public function test_queue_automatically_initialised()
    {
        $bus = new SimpleEventBus();

        $stream = new DomainEventStream([]);
        $bus->publish($stream);
    }
}

class EventBusListener implements EventListener
{
    public $runCount = 0;

    /**
     * @param DomainMessage $domainMessage
     * @return void
     */
    public function handle(DomainMessage $domainMessage)
    {
        $this->runCount++;
    }
}