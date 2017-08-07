<?php
namespace SmoothPhp\Domain;

use DateTime;
use SmoothPhp\Contracts\Domain\DomainMessage as DomainMessageInterface;

/**
 * Class DomainMessage
 * @package SmoothPhp\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
final class DomainMessage implements DomainMessageInterface
{
    /**
     * @var int
     */
    private $playHead;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $recordedOn;

    /**
     * @param string $id
     * @param int $playHead
     * @param Metadata $metadata
     * @param mixed $payload
     * @param DateTime $recordedOn
     */
    public function __construct($id, $playHead, Metadata $metadata, $payload, DateTime $recordedOn)
    {
        $this->id = $id;
        $this->playHead = $playHead;
        $this->metadata = $metadata;
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
    }

    /**
     * @param string   $id
     * @param int      $playHead
     * @param Metadata $metadata
     * @param mixed    $payload
     *
     * @return DomainMessage
     */
    public static function recordNow($id, $playHead, Metadata $metadata, $payload)
    {
        return new DomainMessage($id, $playHead, $metadata, $payload, new DateTime);
    }

    /**
     * @return int
     */
    public function getPlayHead()
    {
        return $this->playHead;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getRecordedOn()
    {
        return $this->recordedOn;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return strtr(get_class($this->payload), '\\', '.');
    }
}