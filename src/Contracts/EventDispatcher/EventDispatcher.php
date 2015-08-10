<?php
namespace SmoothPhp\Contracts\EventDispatcher;

use Closure;

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
     * @param string $eventName
     * @param Closure $closure
     * @return void
     */
    public function addListener($eventName, Closure $closure);
}