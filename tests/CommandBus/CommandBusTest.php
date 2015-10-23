<?php
namespace SmoothPhp\Test\CommandBus;

use SmoothPhp\CommandBus\Exception\HandlerNotFound;
use SmoothPhp\CommandBus\SimpleCommandBus;
use SmoothPhp\CommandBus\SimpleCommandTranslator;
use SmoothPhp\CommandBus\SimpleCommandHandlerResolver;
use SmoothPhp\Test\CommandBus\Helpers\TestCommandWithoutHandler;

/**
 * Class CommandBusTest
 * @package SmoothPhp\CommandBus\Test
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleCommandBus
     */
    private $commandBus;

    public function setup()
    {
        $this->commandBus = new SimpleCommandBus(new SimpleCommandTranslator(), new SimpleCommandHandlerResolver());
    }

    /**
     * @test
     */
    public function executing_simple_command()
    {
        $command = new TestCommand();

        $this->commandBus->execute($command);
    }

    /**
     * @test
     */
    public function exception_on_missing_handler()
    {
        $command = new TestCommandWithoutHandler();

        $this->setExpectedException(HandlerNotFound::class,'Handler for command [SmoothPhp\Test\CommandBus\Helpers\TestCommandWithoutHandler] not found');
        $this->commandBus->execute($command);
    }
}
