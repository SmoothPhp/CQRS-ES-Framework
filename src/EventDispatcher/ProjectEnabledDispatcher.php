<?php
namespace SmoothPhp\EventDispatcher;

use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class ProjectEnabledDispatcher
 * @package SmoothPhp\EventDispatcher
 * @author Simon Bennett <simon@bennett.im>
 */
final class ProjectEnabledDispatcher implements EventDispatcher
{
    /**
     * @var array
     */
    private $listeners = [];

    /**
     * @var bool
     */
    private $runProjectionsOnly;

    /**
     * ProjectEnabledDispatcher constructor.
     * @param bool $runProjectionsOnly
     */
    public function __construct($runProjectionsOnly = false)
    {
        $this->runProjectionsOnly = $runProjectionsOnly;
    }

    /**
     * @param string $eventName
     * @param array $arguments
     * @return void
     */
    public function dispatch($eventName, array $arguments)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }
        foreach ($this->listeners[$eventName] as $listener) {
            if ($this->runProjectionsOnly && (is_array($listener) && !$listener[0] instanceof Projection)) {
                continue;
            }
            call_user_func_array($listener, $arguments);
        }
    }

    /**
     * @param string $eventName
     * @param callable $callable
     * @return void
     */
    public function addListener($eventName, callable $callable)
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = array();
        }
        $this->listeners[$eventName][] = $callable;
    }


    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function addSubscriber(Subscriber $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $event => $methods) {
            foreach ($methods as $method) {
                $this->addListener(str_replace('\\', '.', $event), [$subscriber, $method]);
            }
        }
    }
}