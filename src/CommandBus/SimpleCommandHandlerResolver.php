<?php namespace SmoothPhp\CommandBus;

use SmoothPhp\Contracts\CommandBus\CommandHandlerResolver;

/**
 * Class SimpleCommandHandlerResolver
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@pixelatedcrow.com>
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