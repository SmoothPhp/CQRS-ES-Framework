<?php
namespace SmoothPhp\CommandBus;

use SmoothPhp\Contracts\CommandBus\Command;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\CommandBus\CommandTranslator;
use SmoothPhp\Contracts\CommandBus\CommandHandlerResolver;

/**
 * Class PlainCommandBus
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class SimpleCommandBus implements CommandBus
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
     * @return void
     */
    public function execute(Command $command)
    {
        $handler = $this->commandTranslator->toCommandHandler($command);

        $this->handlerResolver->make($handler)->handle($command);
    }
}