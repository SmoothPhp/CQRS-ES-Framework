<?php
namespace SmoothPhp\CommandBus\Exception;

/**
 * Class InvalidMiddlewareException
 * @package SmoothPhp\CommandBus\Exception
 * @author Simon Bennett <simon@bennett.im>
 */
final class InvalidMiddlewareException extends \InvalidArgumentException
{
    /**
     * @param $invalidMiddleware
     * @return static
     */
    public static function forMiddleware($invalidMiddleware)
    {
        $name = is_object($invalidMiddleware) ? get_class($invalidMiddleware) : gettype($invalidMiddleware);
        $message = sprintf(
            'Cannot add "%s" to Middleware chain as it does not implement the CommandBusMiddleware interface.',
            $name
        );

        return new static($message);
    }
}
