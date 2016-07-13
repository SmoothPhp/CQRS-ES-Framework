<?php
namespace SmoothPhp\Contracts\Projections;
/**
 * Interface ProjectionServiceProvider
 * @author Simon Bennett <simon@bennett.im>
 */
interface ProjectionServiceProvider
{
    /**
     * @return string
     */
    public function up();

    /**
     * @return string
     */
    public function down();

    /**
     * @return string[]
     */
    public function getProjections();
}
