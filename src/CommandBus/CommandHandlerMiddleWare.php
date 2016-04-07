<?php
namespace SmoothPhp\CommandBus;

use SmoothPhp\Contracts\CommandBus\Command;
use SmoothPhp\Contracts\CommandBus\CommandBusMiddleware;
use SmoothPhp\Contracts\CommandBus\CommandHandlerResolver;
use SmoothPhp\Contracts\CommandBus\CommandTranslator;

/**
 * Class PlainCommandBus
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class CommandHandlerMiddleWare implements CommandBusMiddleware
{
    /** @var CommandTranslator */
    private $commandTranslator;

    /** @var CommandHandlerResolver */
    private $handlerResolver;

    /**
     * @param CommandTranslator $commandTranslator
     * @param CommandHandlerResolver $handlerResolver
     */
    public function __construct(CommandTranslator $commandTranslator, CommandHandlerResolver $handlerResolver)
    {
        $this->commandTranslator = $commandTranslator;
        $this->handlerResolver = $handlerResolver;
    }

    /**
     * @param Command $command
     * @param callable $next
     * @return mixed|void
     */
    public function execute(Command $command, callable $next)
    {
        $handler = $this->commandTranslator->toCommandHandler($command);

        return $this->handlerResolver->make($handler)->handle($command);
    }
}