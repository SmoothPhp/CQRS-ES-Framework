<?php
namespace SmoothPhp\Contracts\EventBus;

use SmoothPhp\Contracts\Domain\DomainMessage;

/**
 * Interface EventSubscribed
 * @package SmoothPhp\Contracts\EventBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface EventListener
{
    /**
     * @param DomainMessage $domainMessage
     * @return void
     */
    public function handle(DomainMessage $domainMessage);
}