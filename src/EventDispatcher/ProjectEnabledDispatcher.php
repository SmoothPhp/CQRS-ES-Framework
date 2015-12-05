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
     * @var array
     */
    private $sorted = [];

    /**
     * @param string $eventName
     * @param array $arguments
     * @param bool $runProjectionsOnly
     */
    public function dispatch($eventName, array $arguments, $runProjectionsOnly = false)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }
        foreach ($this->getListenersInOrder($eventName) as $listener) {
            if ($this->listenerCanRun($runProjectionsOnly, $listener)) {
                call_user_func_array($listener, $arguments);
            }
        }
    }

    /**
     * @param string $eventName
     * @param callable $callable
     * @param int $priority
     */
    public function addListener($eventName, callable $callable, $priority = 0)
    {
        $dotEventName = str_replace('\\', '.', $eventName);
        $this->listeners[$dotEventName][$priority][] = $callable;
        unset($this->sorted[$dotEventName]);

    }


    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function addSubscriber(Subscriber $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (is_string($params)) {
                $this->addListener($eventName, array($subscriber, $params));
            } elseif (is_string($params[0])) {
                $this->addListener($eventName, array($subscriber, $params[0]), isset($params[1]) ? $params[1] : 0);
            } else {
                foreach ($params as $listener) {
                    $this->addListener($eventName, array($subscriber, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
                }
            }
        }
    }

    /**
     * @param $runProjectionsOnly
     * @param $listener
     * @return bool
     */
    protected function listenerCanRun($runProjectionsOnly, $listener)
    {
        return !$runProjectionsOnly || (is_array($listener) && $listener[0] instanceof Projection);
    }

    /**
     * @param $eventName
     * @return array
     */
    protected function getListenersInOrder($eventName)
    {
        if (!isset($this->listeners[$eventName])) {
            return [];
        }
        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }

        return $this->sorted[$eventName];
    }

    /**
     * Sorts the internal list of listeners for the given event by priority.
     *
     * @param string $eventName The name of the event.
     */
    private function sortListeners($eventName)
    {
        $this->sorted[$eventName] = array();

        krsort($this->listeners[$eventName]);
        $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
    }
}