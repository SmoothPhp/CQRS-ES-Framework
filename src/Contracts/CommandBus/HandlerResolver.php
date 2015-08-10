<?php
namespace SmoothPhp\Contracts\CommandBus;

/**
 * Interface Container
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
interface HandlerResolver
{
    /**
     * @param string $handlerClassName handler class to be built
     * @return mixed instance of the handler class
     */
    public function make($handlerClassName);
}