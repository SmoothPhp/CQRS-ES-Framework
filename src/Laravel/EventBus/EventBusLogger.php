<?php
namespace SmoothPhp\Laravel\EventBus;

use Illuminate\Log\Writer;
use SmoothPhp\Contracts\Domain\DomainMessage;
use SmoothPhp\Contracts\EventBus\EventListener;

/**
 * Class EventBusLogger
 * @package SmoothPhp\Laravel\EventBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class EventBusLogger implements EventListener
{
    /**
     * @var Writer
     */
    private $writer;

    /**
     * @param Writer $writer
     */
    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
    }
    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage)
    {
        $name = explode('.',$domainMessage->getType());

        $name = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', end($name));
        $this->writer->debug(trim(ucwords($name)) . " ({$domainMessage->getType()})");
    }
}