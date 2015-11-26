<?php
namespace SmoothPhp\CommandBus;

use Ramsey\Uuid\Uuid;
use SmoothPhp\Contracts\CommandBus\Command;

/**
 * Class Command
 * @package SmoothPhp\CommandBus
 * @author Simon Bennett <simon.bennett@smoothphp.com>
 */
abstract class BaseCommand implements Command
{
    /**
     * @var string
     */
    private $commandId;

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . ':' . $this->getCommandId();
    }

    /**
     * @return string
     */
    public function getCommandId()
    {
        return $this->commandId ?: $this->commandId = (string) Uuid::uuid4();
    }
}
