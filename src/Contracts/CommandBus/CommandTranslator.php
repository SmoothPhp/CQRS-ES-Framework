<?php
namespace SmoothPhp\Contracts\CommandBus;

use SmoothPhp\CommandBus\Exception\HandlerNotFound;

/**
 * Interface CommandTranslator
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
interface CommandTranslator
{
    /**
     * @param mixed $command
     * @return string
     * @throws HandlerNotFound
     */
    public function toCommandHandler($command);
}