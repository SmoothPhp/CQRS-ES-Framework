<?php
namespace SmoothPhp\CommandBus;

use SmoothPhp\CommandBus\Exception\InvalidMiddlewareException;
use SmoothPhp\Contracts\CommandBus\Command;
use SmoothPhp\Contracts\CommandBus\CommandBusMiddleware;

/**
 * Class CommandBus
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
final class CommandBus implements \SmoothPhp\Contracts\CommandBus\CommandBus
{
    /**
     * @var callable
     */
    private $middlewareChain;

    /**
     * CommandBus constructor.
     * @param CommandBusMiddleware[] $middleware
     */
    public function __construct(array $middleware)
    {
        $this->middlewareChain = $this->generateMiddlewareCallChain($middleware);
    }

    /**
     * @param Command $command
     */
    public function execute(Command $command)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($command);
    }

    /**
     * @param $middleware
     * @return \Closure
     */
    private function generateMiddlewareCallChain($middlewareList)
    {
        $lastCallable = function () {
            // the final callable does not run
        };

        while ($middleware = array_pop($middlewareList)) {
            if (!$middleware instanceof CommandBusMiddleware) {
                throw InvalidMiddlewareException::forMiddleware($middleware);
            }
            $lastCallable = function ($command) use ($middleware, $lastCallable) {
                return $middleware->execute($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
