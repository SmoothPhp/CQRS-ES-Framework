<?php
namespace SmoothPhp\Test\CommandBus;

/**
 * Class CommandTest
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function build_command_test()
    {
        $command = new TestCommand();

        $this->assertContains('SmoothPhp\Test\CommandBus\TestCommand:', (string)$command);
    }
}

