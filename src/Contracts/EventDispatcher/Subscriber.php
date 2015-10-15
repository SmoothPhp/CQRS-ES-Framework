<?php
namespace SmoothPhp\Contracts\EventDispatcher;

/**
 * Interface Subscriber
 * @package SmoothPhp\Contracts\EventDispatcher
 * @author Simon Bennett <simon@bennett.im>
 */
interface Subscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents();
}