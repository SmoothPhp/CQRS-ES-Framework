<?php
namespace SmoothPhp\CommandBus;

/**
 * Class PlainCommandBus
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class PlainCommandBus implements CommandBus
{
    /** @var CommandTranslator */
    private $commandTranslator;

    /** @var HandlerResolver */
    private $handlerResolver;

    /**
     * @param CommandTranslator $commandTranslator
     * @param HandlerResolver $handlerResolver
     */
    public function __construct(CommandTranslator $commandTranslator, HandlerResolver $handlerResolver)
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