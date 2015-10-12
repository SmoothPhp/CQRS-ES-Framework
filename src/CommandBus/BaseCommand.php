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
    public $commandId;

    /**
     * Give the command a Uuid, Used to logging and auditing
     */
    public function __construct()
    {
        $this->commandId = (string)Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . ':' . $this->commandId;
    }
}