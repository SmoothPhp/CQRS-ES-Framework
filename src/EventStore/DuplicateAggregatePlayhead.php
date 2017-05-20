<?php declare (strict_types = 1);
namespace SmoothPhp\EventStore;

/**
 * Class DuplicateAggregatePlayhead
 * @package SmoothPhp\EventStore
 * @author Simon Bennett <simon@pixelatedcrow.com>
 */
final class DuplicateAggregatePlayhead extends \Exception
{
    /**
     * DuplicateAggregatePlayhead constructor.
     * @param $aggregateId
     * @param $playHead
     */
    public function __construct($aggregateId, $playHead)
    {
        $this->message  = "Duplicate Aggregate Playhead ({$aggregateId}-{$playHead})";
    }
}
