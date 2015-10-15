<?php
namespace SmoothPhp\Tests\EventDispatcher;

use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;
use SmoothPhp\EventDispatcher\ProjectEnabledDispatcher;

/**
 * Class ProjectEnabledDispatcherTest
 * @package SmoothPhp\Tests\EventDispatcher
 * @author Simon Bennett <simon@bennett.im>
 */
final class ProjectEnabledDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function check_dispatcher_runs()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $runCount = 0;
        $dispatcher->addListener('test',
            function () use (&$runCount) {
                $runCount++;
            });

        $this->assertEquals(0, $runCount);

        $dispatcher->dispatch('test', []);

        $this->assertEquals(1, $runCount);
    }

    /**
     * @test
     */
    public function check_dispatcher_runs_two_handlers_on_event()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $runCount = 0;
        $dispatcher->addListener('test',
            function () use (&$runCount) {
                $runCount++;
            });

        $dispatcher->addListener('test',
            function () use (&$runCount) {
                $runCount++;
            });

        $this->assertEquals(0, $runCount);

        $dispatcher->dispatch('test', []);

        $this->assertEquals(2, $runCount);
    }

    /**
     * @test
     */
    public function check_dispatcher_does_not_run()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $runCount = 0;
        $dispatcher->addListener('test',
            function () use (&$runCount) {
                $runCount++;
            });
        $dispatcher->dispatch('test_does_not_run', []);

        $this->assertEquals(0, $runCount);
    }

    /**
     * @test
     */
    public function check_dispatcher_only_fires_projectable_listeners()
    {
        $dispatcher = new ProjectEnabledDispatcher(true);


        $projectionListener = new ProjectionOnlyListener;
        $noneProjectionListener = new NoneProjectionOnlyListener();

        $dispatcher->addListener('test', [$projectionListener, 'handleEvent']);
        $dispatcher->addListener('test', [$noneProjectionListener, 'handleEvent']);

        $this->assertEquals(0, $projectionListener->runCount);
        $this->assertEquals(0, $noneProjectionListener->runCount);

        $dispatcher->dispatch('test', []);

        $this->assertEquals(1, $projectionListener->runCount);
        $this->assertEquals(0, $noneProjectionListener->runCount);


    }

    /**
     * @test
     */
    public function check_projection_dispatcher_subscribe()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $testListener = new  SubscriberTest();

        $dispatcher->addSubscriber($testListener);

        $dispatcher->dispatch('test', []);

        $this->assertEquals(1, $testListener->runCount);
    }


}

final class ProjectionOnlyListener implements Projection
{
    public $runCount = 0;

    public function handleEvent()
    {
        $this->runCount++;
    }
}

final class NoneProjectionOnlyListener
{
    public $runCount = 0;

    public function handleEvent()
    {
        $this->runCount++;
    }
}

final class SubscriberTest implements Subscriber
{
    public $runCount = 0;

    public function run()
    {
        $this->runCount++;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['test' => ['run']];
    }
}