<?php
namespace SmoothPhp\Contracts\CommandBus;

/**
 * Interface Command
 * @package SmoothPhp\Contracts\CommandBus
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
interface Command
{
    /**
     * @return string
     */
    public function __toString();
}