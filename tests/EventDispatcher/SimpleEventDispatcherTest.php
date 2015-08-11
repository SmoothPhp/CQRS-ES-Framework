<?php
namespace SmoothPhp\Tests\EventDispatcher;

use ReflectionProperty;
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

    /**
     * @test
     */
    public function check_dispatcher_does_not_run()
    {
        $dispatcher = new SimpleEventDispatcher();

        $runCount = 0;
        $dispatcher->addListener('test',function()use(&$runCount)
        {
            $runCount ++;
        });
        $dispatcher->dispatch('test_does_not_run',[]);

        $this->assertEquals(0,$runCount);
    }

    /**
     * @test
     */
    public function check_dispatcher_takes_callables()
    {
        $dispatcher = new SimpleEventDispatcher;
        $refl = new ReflectionProperty(SimpleEventDispatcher::class, 'listeners');
        $refl->setAccessible(true);

        $this->assertEquals(0, count($refl->getValue($dispatcher)));

        $dispatcher->addListener('foo.bar', [$this, 'fooBar']);

        $this->assertEquals(1, count($refl->getValue($dispatcher)));
    }

    public function fooBar()
    {
    }
}