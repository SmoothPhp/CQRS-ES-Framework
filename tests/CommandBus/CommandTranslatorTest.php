<?php
namespace SmoothPhp\Test\CommandBus;

use PHPUnit\Framework\TestCase;
use SmoothPhp\CommandBus\SimpleCommandTranslator;

/**
 * Class CommandTranslatorTest
 * @package SmoothPhp\CommandBus\Test
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class CommandTranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function translate_command()
    {
        $commandTranslate = new SimpleCommandTranslator();

        $handlerName = $commandTranslate->toCommandHandler(new TestCommand());

        $this->assertSame('SmoothPhp\Test\CommandBus\TestCommandHandler', $handlerName);
    }
}