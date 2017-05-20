<?php
namespace SmoothPhp\Contracts\CommandBus;

/**
 * Class CommandBusMiddleware
 * @package SmoothPhp\Contracts\CommandBus
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
interface CommandBusMiddleware
{
    /**
     * @param $command
     * @param callable $next
     * @return mixed
     */
    public function execute(Command $command, callable $next);
}
