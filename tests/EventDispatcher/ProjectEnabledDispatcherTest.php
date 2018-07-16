<?php
namespace SmoothPhp\Tests\EventDispatcher;

use PHPUnit\Framework\TestCase;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;
use SmoothPhp\EventDispatcher\ProjectEnabledDispatcher;

/**
 * Class ProjectEnabledDispatcherTest
 * @package SmoothPhp\Tests\EventDispatcher
 * @author Simon Bennett <simon@bennett.im>
 */
final class ProjectEnabledDispatcherTest extends TestCase
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
        $dispatcher = new ProjectEnabledDispatcher();


        $projectionListener = new ProjectionOnlyListener;
        $noneProjectionListener = new NoneProjectionOnlyListener();

        $dispatcher->addListener('test', [$projectionListener, 'handleEvent']);
        $dispatcher->addListener('test', [$noneProjectionListener, 'handleEvent']);

        $this->assertEquals(0, $projectionListener->runCount);
        $this->assertEquals(0, $noneProjectionListener->runCount);

        $dispatcher->dispatch('test', [], true);

        $this->assertEquals(1, $projectionListener->runCount);
        $this->assertEquals(1, $noneProjectionListener->runCount);

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

    /**
     * @test
     */
    public function check_dispatcher_ordering_with_listeners()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $didIRunFirst = false;

        $dispatcher->addListener('foo',
            function () use (&$didIRunFirst) {
                $didIRunFirst = true;
            },
                                 0);

        $dispatcher->addListener('foo',
            function () use (&$didIRunFirst) {
                $this->assertFalse($didIRunFirst);
            },
                                 1);

        $dispatcher->dispatch('foo', []);


    }

    /**
     * @test
     */
    public function check_dispatcher_ordering_with_subscribers()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $invoked = [];

        $testListenerRunLast = new  SubscriberTestLast($invoked);
        $testListenerRunFirst = new  SubscriberTestFirst($invoked);
        $testListenerRunMiddle = new  SubscriberTestMiddle($invoked);

        $testListenerRunFirst->setCallBack(function () use (&$invoked) {
            $invoked[] = 1;
        });
        $testListenerRunMiddle->setCallBack(function () use (&$invoked) {
            $invoked[] = 2;
        });
        $testListenerRunLast->setCallBack(function () use (&$invoked) {
            $invoked[] = 3;
        });

        $dispatcher->addSubscriber($testListenerRunLast);
        $dispatcher->addSubscriber($testListenerRunFirst);
        $dispatcher->addSubscriber($testListenerRunMiddle);

        $dispatcher->dispatch('test', []);
        $this->assertEquals(array('1', '2', '3'), $invoked);

    }

    public function test_event_dot_notation()
    {
        $dispatcher = new ProjectEnabledDispatcher();

        $invoked = false;
        $dispatcher->addListener('test\\test',
            function () use (&$invoked) {
                $invoked = true;
            });

        $dispatcher->dispatch('test.test',[]);
        $this->assertTrue($invoked);

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

final class SubscriberTestFirst implements Subscriber
{
    /**
     * @param $callback
     */
    public function setCallBack($callback)
    {
        $this->callback = $callback;
    }

    public function run()
    {
        return call_user_func_array($this->callback, []);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['test' => ['run', 10]];
    }
}

final class SubscriberTestMiddle implements Subscriber
{
    /**
     * @param $callback
     */
    public function setCallBack($callback)
    {
        $this->callback = $callback;
    }

    public function run()
    {
        return call_user_func_array($this->callback, []);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'test' => 'run'
        ];
    }
}

final class SubscriberTestLast implements Subscriber
{
    /**
     * @param $callback
     */
    public function setCallBack($callback)
    {
        $this->callback = $callback;
    }

    public function run()
    {
        return call_user_func_array($this->callback, []);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'test' => [
                ['run', -10]
            ]
        ];
    }
}