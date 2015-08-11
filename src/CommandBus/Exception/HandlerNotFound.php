<?php namespace SmoothPhp\CommandBus\Exception;

use InvalidArgumentException;

/**
 * Class HandlerNotFound
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class HandlerNotFound extends InvalidArgumentException
{
    /**
     * @param mixed $command
     */
    public function __construct($command)
    {
        parent::__construct(sprintf('Handler for command [%s] not found', $command));
    }
}