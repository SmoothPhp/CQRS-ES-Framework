<?php
namespace SmoothPhp\Contracts\CommandBus;

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
     */
    public function toCommandHandler($command);
}