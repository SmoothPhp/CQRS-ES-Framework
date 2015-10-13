<?php
namespace SmoothPhp\Contracts\EventDispatcher;

/**
 * Class EventDispatcher
 * @package SmoothPhp\Contracts\EventDispatcher
 * @author Simon Bennett <simon@smoothphp.com>
 */
interface EventDispatcher
{
    /**
     * @param string $eventName
     * @param array $arguments
     * @return void
     */
    public function dispatch($eventName, array $arguments);

    /**
     * @param string   $eventName
     * @param callable $callable
     * @return void
     */
    public function addListener($eventName, callable $callable);

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function addSubscriber(Subscriber $subscriber);
}