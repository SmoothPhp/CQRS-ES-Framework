<?php namespace SmoothPhp\Contracts\CommandBus;

/**
 * Interface Container
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
interface CommandHandlerResolver
{
    /**
     * @param string $handlerId     The command handler ID
     * @return mixed                The command handler
     */
    public function make($handlerId);
}