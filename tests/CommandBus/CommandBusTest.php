<?php
namespace SmoothPhp\Test\CommandBus;

use SmoothPhp\CommandBus\CommandBus;
use SmoothPhp\CommandBus\PlainCommandBus;
use SmoothPhp\CommandBus\SimpleCommandTranslator;
use SmoothPhp\CommandBus\SimpleContainer;

/**
 * Class CommandBusTest
 * @package SmoothPhp\CommandBus\Test
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function setup()
    {
        $this->commandBus = new PlainCommandBus(new SimpleCommandTranslator(), new SimpleContainer());
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
