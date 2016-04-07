<?php
namespace SmoothPhp\Test\CommandBus\Helpers;

use SmoothPhp\Contracts\CommandBus\Command;
use SmoothPhp\Contracts\CommandBus\CommandBusMiddleware;

/**
 * Class DummyMiddleware
 * @package SmoothPhp\Test\CommandBus\Helpers
 * @author Simon Bennett <simon@bennett.im>
 */
final class DummyMiddleware implements CommandBusMiddleware
{
    /** @var callable */
    private $runBefore;

    /** @var callable */
    private $runAfter;


    /**
     * DummyMiddleware constructor.
     * @param callable $runBefore
     * @param callable $runAfter
     */
    public function __construct(callable  $runBefore, callable $runAfter)
    {
        $this->runBefore = $runBefore;
        $this->runAfter = $runAfter;
    }

    /**
     * @param $command
     * @param callable $next
     * @return mixed
     */
    public function execute(Command $command, callable $next)
    {
        call_user_func($this->runBefore);
        $returnValue = $next($command);
        call_user_func($this->runAfter);

        return $returnValue;

    }
}
