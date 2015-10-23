<?php
namespace SmoothPhp\CommandBus;

use SmoothPhp\CommandBus\Exception\HandlerNotFound;
use SmoothPhp\Contracts\CommandBus\CommandTranslator;

/**
 * Class SimpleCommandTranslator
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class SimpleCommandTranslator implements CommandTranslator
{
    /**
     * @param $command
     * @return string
     */
    public function toCommandHandler($command)
    {
        $handler = get_class($command) . 'Handler';

        if (!class_exists($handler)) {
            throw new HandlerNotFound($command);
        }

        return $handler;
    }
}