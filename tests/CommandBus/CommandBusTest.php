<?php
namespace SmoothPhp\Test\CommandBus;

use SmoothPhp\CommandBus\CommandBus;
use SmoothPhp\CommandBus\CommandHandlerMiddleWare;
use SmoothPhp\CommandBus\Exception\HandlerNotFound;
use SmoothPhp\CommandBus\SimpleCommandHandlerResolver;
use SmoothPhp\CommandBus\SimpleCommandTranslator;
use SmoothPhp\Test\CommandBus\Helpers\DummyMiddleware;
use SmoothPhp\Test\CommandBus\Helpers\TestCommandWithoutHandler;

/**
 * Class CommandBusTest
 * @package SmoothPhp\CommandBus\Test
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandHandlerMiddleWare
     */
    private $commandBus;

    public function setup()
    {
        $commandBusHandler = new CommandHandlerMiddleWare(
            new SimpleCommandTranslator(),
            new SimpleCommandHandlerResolver()
        );
        $this->commandBus = new  CommandBus([$commandBusHandler]);
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

        $this->setExpectedException(
            HandlerNotFound::class,
            'Handler for command [SmoothPhp\Test\CommandBus\Helpers\TestCommandWithoutHandler] not found'
        );
        $this->commandBus->execute($command);
    }

    /**
     * @test
     */
    public function check_middle_war()
    {
        $commandBusHandler = new CommandHandlerMiddleWare(
            new SimpleCommandTranslator(),
            new SimpleCommandHandlerResolver()
        );
        $beforeRunCount = 0;
        $afterRunCount = 0;
        $dummyMiddleware = new DummyMiddleware(
            function () use (&$beforeRunCount) {
                $beforeRunCount++;
            },
            function () use (&$afterRunCount) {
                $afterRunCount++;
            }
        );

        $commandBus = new  CommandBus([$dummyMiddleware, $commandBusHandler]);


        $command = new TestCommand();

        $this->assertEquals(0, $beforeRunCount);
        $this->assertEquals(0, $afterRunCount);
        $commandBus->execute($command);
        $this->assertEquals(1, $beforeRunCount);
        $this->assertEquals(1, $afterRunCount);
    }
}
