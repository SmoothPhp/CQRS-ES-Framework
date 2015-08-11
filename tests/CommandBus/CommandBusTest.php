<?php
namespace SmoothPhp\Test\CommandBus;

use SmoothPhp\CommandBus\SimpleCommandBus;
use SmoothPhp\CommandBus\SimpleCommandTranslator;
use SmoothPhp\CommandBus\SimpleCommandHandlerResolver;

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
}
