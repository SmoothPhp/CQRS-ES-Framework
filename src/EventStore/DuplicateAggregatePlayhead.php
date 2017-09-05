<?php declare (strict_types=1);

namespace SmoothPhp\EventStore;

use Throwable;

/**
 * Class DuplicateAggregatePlayhead
 * @package SmoothPhp\EventStore
 * @author Simon Bennett <simon@bennett.im>
 */
final class DuplicateAggregatePlayhead extends \Exception
{
    /**
     * DuplicateAggregatePlayhead constructor.
     * @param string $aggregateId
     * @param int $playHead
     * @param Throwable|null $previous
     */
    public function __construct(string $aggregateId, int $playHead, Throwable $previous = null)
    {
        parent::__construct("Duplicate Aggregate Playhead ({$aggregateId}-{$playHead})", 0, $previous);
    }
}
