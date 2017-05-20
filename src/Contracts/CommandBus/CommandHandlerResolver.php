<?php namespace SmoothPhp\Contracts\CommandBus;

/**
 * Interface Container
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
interface CommandHandlerResolver
{
    /**
     * @param string $className     The command handler
     * @return mixed                The command handler
     */
    public function make($className);
}