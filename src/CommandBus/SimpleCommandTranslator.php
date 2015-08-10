<?php
namespace SmoothPhp\CommandBus;

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
        return get_class($command) . 'Handler';
    }
}