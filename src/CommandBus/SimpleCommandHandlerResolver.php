<?php namespace SmoothPhp\CommandBus;

use SmoothPhp\Contracts\CommandBus\CommandHandlerResolver;

/**
 * Class SimpleCommandHandlerResolver
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class SimpleCommandHandlerResolver implements CommandHandlerResolver
{
    /**
     * {@inheritdoc}
     */
    public function make($className)
    {
        return new $className;
    }
}