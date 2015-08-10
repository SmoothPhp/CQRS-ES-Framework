<?php
namespace SmoothPhp\CommandBus;

use SmoothPhp\Contracts\CommandBus\HandlerResolver;

/**
 * Class SimpleContainer
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
final class SimpleContainer implements HandlerResolver
{
    /**
     * @param $className class to be built
     * @return mixed instance of the class
     */
    public function make($className)
    {
        return new $className;
    }
}