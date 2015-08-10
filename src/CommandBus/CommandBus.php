<?php
namespace SmoothPhp\CommandBus;

/**
 * Interface CommandBus
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
interface CommandBus
{
    /**
     * @param Command $command
     * @return void
     */
    public function execute(Command $command);
}