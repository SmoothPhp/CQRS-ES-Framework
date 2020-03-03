<?php

namespace SmoothPhp\Test\CommandBus;

use PHPUnit\Framework\TestCase;
use SmoothPhp\CommandBus\CommandBus;
use SmoothPhp\CommandBus\CommandHandlerMiddleWare;
use SmoothPhp\CommandBus\SimpleCommandHandlerResolver;
use SmoothPhp\CommandBus\SimpleCommandTranslator;
use SmoothPhp\Test\CommandBus\Helpers\DummyMiddleware;
use SmoothPhp\Test\CommandBus\Helpers\TestCommandWithoutHandler;

/**
 * Class CommandBusTest
 * @package SmoothPhp\CommandBus\Test
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class CommandBusTest extends TestCase
{
    /**
     * @var CommandHandlerMiddleWare
     */
    private $commandBus;

    public function setup() : void
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
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function exception_on_missing_handler()
    {
        $this->expectException(\SmoothPhp\CommandBus\Exception\HandlerNotFound::class);
        $command = new TestCommandWithoutHandler();

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
