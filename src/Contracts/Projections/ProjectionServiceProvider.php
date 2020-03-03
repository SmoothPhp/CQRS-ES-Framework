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
    public function up();

    /**
     * @return string|null
     */
    public function down();

    /**
     * @return string[]
     */
    public function getProjections() : array;
}
