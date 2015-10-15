<?php
namespace SmoothPhp\Contracts\Domain;

use SmoothPhp\Domain\DateTime;

/**
 * Interface DomainMessage
 * @package SmoothPhp\Contracts\Domain
 * @author Simon Bennett <simon@bennett.im>
 */
interface DomainMessage
{
    /**
     * @return int
     */
    public function getPlayHead();

    /**
     * @return Metadata
     */
    public function getMetadata();

    /**
     * @return mixed
     */
    public function getPayload();

    /**
     * @return string
     */
    public function getId();

    /**
     * @return DateTime
     */
    public function getRecordedOn();

    /**
     * @return string
     */
    public function getType();
}