<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenBySportTrait
{
    /**
     * @param int $sportId
     *
     * @return static
     */
    public static function listenBySport($sportId)
    {
        return new static('sport.'.$sportId);
    }
}
