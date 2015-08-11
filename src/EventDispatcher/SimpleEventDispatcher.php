<?php
namespace SmoothPhp\EventDispatcher;

use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class SimpleEventDispatcher
 * @author Simon Bennett <simon@smoothphp.com>
 */
final class SimpleEventDispatcher implements EventDispatcher
{
    /**
     * @var array
     */
    private $listeners = [];

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
            call_user_func_array($listener, $arguments);
        }
    }

    /**
     * @param string   $eventName
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
}