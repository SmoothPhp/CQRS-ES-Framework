<?php
namespace SmoothPhp\Tests\EventDispatcher;

use SmoothPhp\EventDispatcher\SimpleEventDispatcher;


/**
 * Class SimpleEventDispatcherTest
 * @package SmoothPhp\Tests\EventDispatcher
 * @author Simon Bennett <simon@smoothphp.com>
 */
final class SimpleEventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function check_dispatcher_runs()
    {
        $dispatcher = new SimpleEventDispatcher();

        $runCount = 0;
        $dispatcher->addListener('test',function()use(&$runCount)
        {
            $runCount ++;
        });

        $this->assertEquals(0,$runCount);

        $dispatcher->dispatch('test',[]);

        $this->assertEquals(1,$runCount);
    }
}