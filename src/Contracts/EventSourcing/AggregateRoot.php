<?php
namespace SmoothPhp\Contracts\EventSourcing;

use SmoothPhp\Contracts\Domain\DomainMessage;


/**
 * Interface AggregateRoot
 * @package SmoothPhp\Contracts\EventSourcing
 * @author Simon Bennett <simon@smoothphp.im>
 */
interface AggregateRoot
{

    /**
     * @return string
     */
    public function getAggregateRootId();

    /**
     * @return DomainMessage[]
     */
    public function getUncommittedEvents();
}