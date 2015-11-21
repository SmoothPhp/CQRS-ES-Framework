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
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents();
}