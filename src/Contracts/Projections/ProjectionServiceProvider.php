<?php

namespace SmoothPhp\Contracts\Projections;

/**
 * Interface ProjectionServiceProvider
 * @author Simon Bennett <simon@bennett.im>
 */
interface ProjectionServiceProvider
{
    /**
     * @return string|null
     */
    public function up() : ?string;

    /**
     * @return string|null
     */
    public function down() : ?string;

    /**
     * @return string[]
     */
    public function getProjections() : array;
}
